<?php

/**
 * REMITK MONITORING
 * Monitor your servers and websites.
 *
 * This file is part of REMITK MONITORING.
 * REMITK MONITORING is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * REMITK MONITORING is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with REMITK MONITORING.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package     phpservermon
 * @author      Pepijn Over <pep@mailbox.org>
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

namespace {
// include main configuration and functionality
    use psm\Router;
    use psm\Util\Server\DiagnosticReporter;
    use psm\Util\Server\PerformanceReporter;
    use psm\Util\Server\UpdateManager;

    require_once __DIR__ . '/../src/bootstrap.php';

    $logDirectory = __DIR__ . '/../logs';
    if (!is_dir($logDirectory)) {
        @mkdir($logDirectory, 0777, true);
    }

    $logFile = $logDirectory . '/cron-' . date('Y-m-d_H-i-s') . '.log';
    $log = function ($message) use ($logFile) {
        $line = sprintf('[%s] %s%s', date('c'), $message, PHP_EOL);

        if (false === @file_put_contents($logFile, $line, FILE_APPEND)) {
            error_log($line);
        }
    };

    if (!psm_is_cli()) {
        // check if it's an allowed host
        if (!isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $_SERVER["HTTP_X_FORWARDED_FOR"] = "";
        }

        // define won't accept array before php 7.0.0
        // check if data is serialized (not needed when using php 7.0.0 and higher)
        $data = (defined('PHP_MAJOR_VERSION') && PHP_MAJOR_VERSION >= 7) ? false : @unserialize(PSM_CRON_ALLOW);
        $allow = $data === false ? PSM_CRON_ALLOW : $data;

        $ipWhitelistEnabled = PSM_WEBCRON_ENABLE_IP_WHITELIST;
        $ipWhitelistCheckPassed = in_array($_SERVER['REMOTE_ADDR'], $allow)
            && in_array($_SERVER["HTTP_X_FORWARDED_FOR"], $allow)
            && $ipWhitelistEnabled;

        $webCronKeyProvided = array_key_exists("webcron_key", $_GET) && (PSM_WEBCRON_KEY != "");
        $webCronKeyCheckPassed = $webCronKeyProvided && $_GET["webcron_key"] == PSM_WEBCRON_KEY;

        $log(sprintf(
            'Web cron authentication attempt from %s (forwarded: %s); whitelist=%s (enabled=%s), key=%s (provided=%s)',
            $_SERVER['REMOTE_ADDR'],
            $_SERVER['HTTP_X_FORWARDED_FOR'],
            $ipWhitelistCheckPassed ? 'passed' : 'failed',
            $ipWhitelistEnabled ? 'yes' : 'no',
            $webCronKeyCheckPassed ? 'passed' : 'failed',
            $webCronKeyProvided ? 'yes' : 'no'
        ));

        if (!$ipWhitelistCheckPassed && !$webCronKeyCheckPassed) {
            $failureReasons = [];
            if (!$ipWhitelistCheckPassed) {
                $failureReasons[] = $ipWhitelistEnabled
                    ? 'IP not in whitelist'
                    : 'IP whitelist disabled';
            }
            if (!$webCronKeyCheckPassed) {
                $failureReasons[] = $webCronKeyProvided ? 'invalid webcron key' : 'webcron key not provided';
            }

            $log(sprintf(
                'Cron web authentication failed (REMOTE_ADDR=%s, X-Forwarded-For=%s); reasons: %s.',
                $_SERVER['REMOTE_ADDR'],
                $_SERVER['HTTP_X_FORWARDED_FOR'],
                implode(', ', $failureReasons)
            ));
            header('HTTP/1.0 403 Forbidden');
            $log('Web cron request rejected: authentication failed.');
            die('
        <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN"><html>
            <head><title>403 Forbidden</title></head>
            <body>
                <h1>Forbidden</h1><p>IP address not allowed. See the
                <a href="http://docs.phpservermonitor.org/en/latest/install.html#cronjob-over-web">documentation</a>
                for more info.</p>
            </body>
        </html>');
        }

        $authMethod = $ipWhitelistCheckPassed ? 'IP whitelist' : 'webcron key';
        $log(sprintf(
            'Cron web authentication successful via %s (REMOTE_ADDR=%s, X-Forwarded-For=%s).',
            $authMethod,
            $_SERVER['REMOTE_ADDR'],
            $_SERVER['HTTP_X_FORWARDED_FOR']
        ));
        echo "OK";
        if (function_exists('fastcgi_finish_request')) {
            if (function_exists('session_write_close')) {
                @session_write_close();
            }
            fastcgi_finish_request();
        } else {
            @flush();
        }
    }

    $cron_timeout = PSM_CRON_TIMEOUT;
    $forceRun = false;
        // parse a couple of arguments
    if (!empty($_SERVER['argv'])) {
        foreach ($_SERVER['argv'] as $argv) {
            $arg = ltrim($argv, '-');

            if ($arg === 'force' || $arg === 'unlock') {
                $forceRun = true;
                continue;
            }

            $argi = explode('=', ltrim($argv, '--'), 2);
            if (count($argi) !== 2) {
                continue;
            }
            switch ($argi[0]) {
                case 'uri':
                    if (!defined('PSM_BASE_URL')) {
                        define('PSM_BASE_URL', $argi[1]);
                    }
                    break;
                case 'timeout':
                    $cron_timeout = intval($argi[1]);
                    break;
            }
        }
    }

	// prevent cron from running twice at the same time
	// however if the cron has been running for X mins, we'll assume it died and run anyway
	// if you want to change PSM_CRON_TIMEOUT, have a look in src/includes/psmconfig.inc.php.
	// or you can provide the --timeout=x argument

    $status = null;
    if (PHP_SAPI === 'cli') {
        $shortOptions = 's:'; // status

        $longOptions = [
            'status:'
        ];

        $options = getopt($shortOptions, $longOptions);

        $possibleValues = [
            'on' => 'on',
            '1' => 'on',
            'up' => 'on',
            'off' => 'off',
            '0' => 'off',
            'down' => 'off'
        ];

        if (
            true === array_key_exists('status', $options) &&
            true === array_key_exists(strtolower($options['status']), $possibleValues)
        ) {
            $status = $possibleValues[$options['status']];
        } elseif (
            true === array_key_exists('s', $options) &&
            true === array_key_exists(strtolower($options['s']), $possibleValues)
        ) {
            $status = $possibleValues[$options['s']];
        }
    }

    $log(sprintf('Cron invoked (status="%s", force=%s, timeout=%d, argv="%s")',
        $status ?? 'auto',
        $forceRun ? 'true' : 'false',
        $cron_timeout,
        isset($_SERVER['argv']) ? implode(' ', $_SERVER['argv']) : ''
    ));

    if ($status === 'off') {
        $confPrefix = 'cron_off_';
    } else {
        $confPrefix = 'cron_';
    }

    $cronRunningKey = $confPrefix . 'running';
    $cronRunningTimeKey = $confPrefix . 'running_time';

    $time = time();
    $runningSince = psm_get_conf($cronRunningTimeKey);
    if (
        !$forceRun
        && psm_get_conf($cronRunningKey) == 1
        && $cron_timeout > 0
        && ($time - $runningSince < $cron_timeout)
    ) {
        $remaining = $cron_timeout - ($time - $runningSince);
        $log(sprintf(
            'Cron already running (started %s, %d seconds remaining). Exiting.',
            date('c', $runningSince),
            $remaining
        ));
        die(sprintf(
            'Cron is already running (started %s, %d seconds remaining). Exiting.',
            date('c', $runningSince),
            $remaining
        ));
    }

    $lockReleased = false;
    $unlockCron = function () use ($cronRunningKey, $log, &$lockReleased) {
        if (!defined('PSM_DEBUG') || !PSM_DEBUG) {
            psm_update_conf($cronRunningKey, 0);
            $log('Cron lock released.');
        }

        $lockReleased = true;
    };

    if (!defined('PSM_DEBUG') || !PSM_DEBUG) {
        psm_update_conf($cronRunningKey, 1);
        $log('Cron lock acquired.');
    }
    psm_update_conf($cronRunningTimeKey, $time);

    register_shutdown_function($unlockCron);

    /** @var Router $router */
    /** @var UpdateManager $autorun */
    $autorun = $router->getService('util.server.updatemanager');
    /** @var PerformanceReporter $reporter */
    $reporter = $router->getService('util.server.performance_reporter');
    /** @var DiagnosticReporter $diagnosticReporter */
    $diagnosticReporter = $router->getService('util.server.diagnostic_reporter');

    try {
        if ($status !== 'off') {
            $log('Running server updates.');
            $autorun->run(true, $status);
        } else {
            set_time_limit(60);
            if (false === defined('CRON_DOWN_INTERVAL')) {
                define('CRON_DOWN_INTERVAL', 5); // every 5 second call update
            }
            $start = time();
            $i = 0;
            while ($i < 59) {
                $log(sprintf('Running server updates (down mode) at +%d seconds.', $i));
                $autorun->run(true, $status);
                if ($i < (59 - CRON_DOWN_INTERVAL)) {
                    time_sleep_until($start + $i + CRON_DOWN_INTERVAL);
                }
                $i += CRON_DOWN_INTERVAL;
            }
        }

        $reporter->maybeSendWeeklyReport();
        $log('Weekly performance report check completed.');
        $diagnosticReporter->maybeSendDailyReport();
        $log('Daily diagnostic report check completed.');

        $log('Cron completed successfully.');
    } catch (\Throwable $exception) {
        $log(sprintf(
            'Cron failed: %s in %s on line %d',
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine()
        ));
        throw $exception;
    } finally {
        $unlockCron();
    }
}
