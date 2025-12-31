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
 * @since       phpservermon 2.1.0
 **/

namespace {
    // Include paths
    define('PSM_PATH_SRC', __DIR__ . DIRECTORY_SEPARATOR);
    define('PSM_PATH_CONFIG', PSM_PATH_SRC . 'config' . DIRECTORY_SEPARATOR);
    define('PSM_PATH_LANG', PSM_PATH_SRC . 'lang' . DIRECTORY_SEPARATOR);
    define('PSM_PATH_SMS_GATEWAY', PSM_PATH_SRC . 'psm' . DIRECTORY_SEPARATOR . 'Txtmsg' . DIRECTORY_SEPARATOR);

    // user levels
    define('PSM_USER_ADMIN', 10);
    define('PSM_USER_USER', 20);
    define('PSM_USER_ANONYMOUS', 30);

    if (function_exists('date_default_timezone_set') && function_exists('date_default_timezone_get')) {
        date_default_timezone_set(@date_default_timezone_get());
    }

    // find config file
    $path_conf = PSM_PATH_SRC . '../config.php';
    if (file_exists($path_conf)) {
        include_once $path_conf;
    }
    // check for a debug var
    if (!defined('PSM_DEBUG')) {
        define('PSM_DEBUG', false);
    }

    // Debug enabled: report everything
    // Debug disabled: report error only to logs so the UI stays clean
    $displayErrors = PSM_DEBUG ? '1' : '0';
    ini_set('display_errors', $displayErrors);
    ini_set('display_startup_errors', $displayErrors);
    PSM_DEBUG ? error_reporting(E_ALL) : error_reporting(E_USER_ERROR);

    /**
     * Convert PHP errors into exceptions so we can capture a debug log instead of a white page.
     */
    set_error_handler(function ($severity, $message, $file, $line) {
        if (!(error_reporting() & $severity)) {
            // Respect the current error_reporting level
            return false;
        }

        throw new \ErrorException($message, 0, $severity, $file, $line);
    });

    /**
     * Provide a consistent debug output for uncaught exceptions.
     */
    set_exception_handler(function ($exception) {
        http_response_code(500);

        $details = sprintf(
            "Unhandled exception: %s in %s on line %d\nStack trace:\n%s",
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine(),
            $exception->getTraceAsString()
        );

        error_log($details);

        if (PSM_DEBUG) {
            header('Content-Type: text/plain');
            echo $details;
        } else {
            echo 'An unexpected error occurred. Please check the application logs for more details.';
        }
    });

    /**
     * Capture fatal errors that bypass the normal exception handler.
     */
    register_shutdown_function(function () {
        $error = error_get_last();
        if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR], true)) {
            $exception = new \ErrorException(
                $error['message'],
                0,
                $error['type'],
                $error['file'],
                $error['line']
            );

            // Re-use the exception handler to output details or log the issue
            $handler = set_exception_handler(null);
            if (is_callable($handler)) {
                // Restore the handler after retrieving it
                set_exception_handler($handler);
                $handler($exception);
            } else {
                // Fallback if the exception handler was removed unexpectedly
                http_response_code(500);
                error_log($exception);
                if (PSM_DEBUG) {
                    header('Content-Type: text/plain');
                    echo $exception;
                } else {
                    echo 'A fatal error occurred. Please check the application logs for more details.';
                }
            }
        }
    });

    // check for a cron allowed ip array
    if (!defined('PSM_CRON_ALLOW')) {
    //serialize for php version lower than 7.0.0
        define('PSM_CRON_ALLOW', serialize(array()));
    }

    $vendor_autoload = PSM_PATH_SRC . '..' . DIRECTORY_SEPARATOR . 'vendor' .
    DIRECTORY_SEPARATOR . 'autoload.php';
    if (!file_exists($vendor_autoload)) {
        trigger_error(
            "No dependencies found in vendor dir. Did you install the dependencies?
                Please run \"php composer.phar install\".",
            E_USER_ERROR
        );
    }
    require_once $vendor_autoload;

    $router = new psm\Router();
    // this may seem insignificant, but right now lots of functions
    // depend on the following global var definition:
    $db = $router->getService('db');

    // sanity check!
    if (!defined('PSM_INSTALL') || !PSM_INSTALL) {
        if ($db->getDbHost() === null) {
            // no config file has been loaded, redirect the user to the install
            header('Location: install.php');
            die();
        }
        // config file has been loaded, check if we have a connection
        if (!$db->status()) {
            trigger_error("Unable to establish database connection...", E_USER_ERROR);
        }
        // attempt to load configuration from database
        if (!psm_load_conf()) {
            // unable to load from config table
            header('Location: install.php');
            die();
        }
        // config load OK, make sure database version is up to date
        $installer = new \psm\Util\Install\Installer($db);
        if ($installer->isUpgradeRequired()) {
            // Redirect to the installer so the upgrade can be completed without throwing a fatal error
            header('Location: install.php');
            die();
        }
    }

    // check for a public page var
    // This should be defined in the config
    if (!defined('PSM_PUBLIC')) {
        define('PSM_PUBLIC', false);
    }

    // check for a public page
    // This variable is for internal use
    // and should not be changed by the user manualy
    if (!defined('PSM_PUBLIC_PAGE')) {
        define('PSM_PUBLIC_PAGE', false);
    }

    // check for a uptime archive
    // This should be defined in the config
    if (!defined('PSM_UPTIME_ARCHIVE')) {
        define('PSM_UPTIME_ARCHIVE', 'monthly');
    }

    $lang = psm_get_conf('language', 'en_US');
    psm_load_lang($lang);
}
