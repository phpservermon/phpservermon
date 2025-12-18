<?php

/**
 * PHP Server Monitor
 * Monitor your servers and websites.
 *
 * This file is part of PHP Server Monitor.
 * PHP Server Monitor is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * PHP Server Monitor is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with PHP Server Monitor.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package     phpservermon
 * @author      GPT-5.1-Codex-Max
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 */

namespace psm\Module\Server\Controller;

use DateTime;
use PHPMailer\PHPMailer\Exception as PHPMailerException;
use psm\Service\Database;
use psm\Util\Server\HistoryGraph;

class DiagnosticController extends AbstractServerController
{
    /** @var HistoryGraph */
    protected $history;

    public function __construct(Database $db, \Twig\Environment $twig)
    {
        parent::__construct($db, $twig);

        $this->history = new HistoryGraph($db, $twig);
        $this->setCSRFKey('diagnostic');
        $this->setActions(array('index', 'sendReport'), 'index');
    }

    /**
     * Display uptime and latency overview for all hosts.
     */
    protected function executeIndex()
    {
        $this->twig->addGlobal('subtitle', psm_get_lang('menu', 'server_diagnostic'));

        $range_key = psm_GET('range', 'week');
        $end_time = new DateTime();

        return $this->twig->render('module/server/diagnostic.tpl.html', $this->buildTemplateData($range_key, $end_time));
    }

    /**
     * Email diagnostics for the selected range to the current user.
     */
    protected function executeSendReport()
    {
        $this->twig->addGlobal('subtitle', psm_get_lang('menu', 'server_diagnostic'));

        $range_key = psm_POST('range', psm_GET('range', 'week'));
        $end_time = new DateTime();
        list($ranges, $range_key, $servers) = $this->buildRangeData($range_key, $end_time);
        $this->logDiagnosticEvent('request', sprintf('range=%s recipient=%s', $range_key, $this->getRecipientEmail()));

        $report_ranges = array(
            $range_key => array(
                'label' => $ranges[$range_key]['label'],
                'servers' => $servers,
            ),
        );

        $user = $this->getUser()->getUser();
        $recipient_email = $user && isset($user->email) ? trim($user->email) : '';

        if ($recipient_email === '') {
            $this->addMessage(psm_get_lang('diagnostic', 'send_email_missing'), 'error');
            $this->logDiagnosticEvent('request', 'blocked missing_recipient');

            return $this->twig->render(
                'module/server/diagnostic.tpl.html',
                $this->buildTemplateData($range_key, $end_time, $ranges, $servers)
            );
        }

        $template_data = $this->buildTemplateData($range_key, $end_time, $ranges, $servers);
        $send_callback = function () use ($recipient_email, $user, $report_ranges, $range_key) {
            $start_time = microtime(true);

            try {
                $send_result = $this->sendDiagnosticEmail($recipient_email, $user, $report_ranges);
                $this->logDiagnosticEvent(
                    'email',
                    sprintf('range=%s result=%s duration_ms=%d', $range_key, $send_result['type'], (int) round((microtime(true) - $start_time) * 1000))
                );

                return $send_result;
            } catch (\Throwable $exception) {
                $this->logDiagnosticEmailAttempt($recipient_email, $range_key, false, $exception->getMessage());
                $this->logDiagnosticEvent(
                    'email',
                    sprintf('range=%s result=exception error=%s', $range_key, $exception->getMessage())
                );

                return array(
                    'type' => 'error',
                    'message' => psm_get_lang('diagnostic', 'send_email_error') . ' ' . $exception->getMessage(),
                );
            }
        };

        if ($this->shouldSendAsynchronously()) {
            $this->addMessage(psm_get_lang('diagnostic', 'send_email_processing'), 'info');
            $response = $this->twig->render('module/server/diagnostic.tpl.html', $template_data);
            $this->finishRequestEarly($response);

            $this->applySocketTimeout(function () use ($send_callback) {
                $send_callback();
            });

            return '';
        }

        $send_result = $this->applySocketTimeout($send_callback);
        if (is_array($send_result)) {
            $this->addMessage($send_result['message'], $send_result['type']);
        }

        return $this->twig->render('module/server/diagnostic.tpl.html', $template_data);
    }

    /**
     * Send the diagnostics report using PHPMailer.
     *
     * @param string $recipient_email
     * @param object|null $user
     * @param array $report_ranges
     * @return array{type:string,message:string}
     */
    protected function sendDiagnosticEmail($recipient_email, $user, array $report_ranges)
    {
        $mailer = $this->buildMailer();
        $range_key = array_key_first($report_ranges) ?? 'unknown';

        try {
            $mailer->isHTML(true);
            $mailer->Subject = psm_get_lang('diagnostic', 'send_email_subject');
            $mailer->Body = $this->buildHtmlReport($report_ranges);
            $mailer->AltBody = $this->buildTextReport($report_ranges);
            $mailer->addAddress($recipient_email, $user->name ?? $user->user_name ?? '');

            $mailer->send();

            psm_log_email_attempt($mailer, true, array(
                'context' => 'diagnostic_report',
                'range' => $range_key,
            ));
            $this->logDiagnosticEmailAttempt($recipient_email, $range_key, true, '');

            return array(
                'type' => 'success',
                'message' => psm_get_lang('diagnostic', 'send_email_success'),
            );
        } catch (PHPMailerException $exception) {
            $error_info = trim($exception->getMessage());
            error_log('Diagnostic email failed: ' . $error_info);
            $this->logDiagnosticEmailAttempt($recipient_email, $range_key, false, $error_info);

            psm_log_email_attempt($mailer, false, array(
                'context' => 'diagnostic_report',
                'range' => $range_key,
                'error' => $error_info,
            ));

            $message = psm_get_lang('diagnostic', 'send_email_error');
            if ($error_info !== '') {
                $message .= ' ' . $error_info;
            }

            return array(
                'type' => 'error',
                'message' => $message,
            );
        }
    }

    /**
     * Configure a PHPMailer instance for sending diagnostics.
     *
     * @return PHPMailer
     */
    protected function buildMailer()
    {
        return psm_build_mail(null, null, true);
    }

    /**
     * Execute an operation with a reduced socket timeout to prevent long HTTP responses.
     *
     * @param callable $callback
     * @return mixed
     */
    protected function applySocketTimeout(callable $callback)
    {
        $original_timeout = ini_get('default_socket_timeout');
        @ini_set('default_socket_timeout', '15');

        try {
            return $callback();
        } finally {
            if ($original_timeout !== false) {
                @ini_set('default_socket_timeout', (string) $original_timeout);
            }
        }
    }

    /**
     * Log diagnostic events to the shared application log.
     *
     * @param string $context
     * @param string $message
     * @return void
     */
    protected function logDiagnosticEvent($context, $message)
    {
        psm_log_event('diagnostic_' . $context, $message);
    }

    /**
     * Determine whether the environment can complete the request before sending the email.
     *
     * @return bool
     */
    protected function shouldSendAsynchronously()
    {
        return PHP_SAPI !== 'cli' && function_exists('fastcgi_finish_request');
    }

    /**
     * Flush the current response to the client before executing slow operations.
     *
     * @param string $content
     * @return void
     */
    protected function finishRequestEarly($content)
    {
        ignore_user_abort(true);
        echo $content;

        if (function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        } else {
            flush();
        }
    }

    /**
     * Resolve the email address for the authenticated user.
     *
     * @return string
     */
    protected function getRecipientEmail()
    {
        $user = $this->getUser()->getUser();

        return $user && isset($user->email) ? trim($user->email) : '';
    }

    /**
     * Log diagnostic email delivery attempts to the root logs directory.
     *
     * @param string $recipient_email
     * @param string $range_key
     * @param bool $sent
     * @param string $error_info
     * @return void
     */
    protected function logDiagnosticEmailAttempt($recipient_email, $range_key, $sent, $error_info)
    {
        $log_dir = psm_get_logs_directory();
        if ($log_dir === null) {
            return;
        }

        $status = $sent ? 'sent' : 'failed';
        $timestamp = (new DateTime())->format(DateTime::ATOM);
        $log_entry = sprintf(
            "[%s] diagnostic_email %s range=%s recipient=%s%s\n",
            $timestamp,
            $status,
            $range_key,
            $recipient_email === '' ? 'unknown' : $recipient_email,
            $sent ? '' : ' error=' . trim($error_info)
        );

        $log_file = rtrim($log_dir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'diagnostic-emails.log';
        if (false === @file_put_contents($log_file, $log_entry, FILE_APPEND)) {
            error_log('Unable to write diagnostic email log entry to ' . $log_file);
        }
    }

    /**
     * Prepare range metadata.
     *
     * @param string  $active_range
     * @param DateTime $end_time
     * @return array
     */
    protected function buildRanges($active_range, DateTime $end_time)
    {
        $ranges = array(
            'day' => array(
                'label' => psm_get_lang('servers', 'day'),
                'start' => (clone $end_time)->modify('-1 day'),
            ),
            'week' => array(
                'label' => psm_get_lang('servers', 'week'),
                'start' => (clone $end_time)->modify('-1 week'),
            ),
            'month' => array(
                'label' => psm_get_lang('servers', 'month'),
                'start' => (clone $end_time)->modify('-1 month'),
            ),
            'year' => array(
                'label' => psm_get_lang('servers', 'year'),
                'start' => (clone $end_time)->modify('-1 year'),
            ),
        );

        foreach ($ranges as $key => &$range) {
            $range['active'] = ($key === $active_range);
            $range['url'] = psm_build_url(array('mod' => 'server_diagnostic', 'range' => $key));
        }

        return $ranges;
    }

    /**
     * Prepare the template data shared between actions.
     *
     * @param string $range_key
     * @param DateTime $end_time
     * @param array|null $ranges    Optional precomputed ranges to avoid recalculation
     * @param array|null $servers   Optional precomputed server statistics to avoid recalculation
     * @return array
     */
    protected function buildTemplateData($range_key, DateTime $end_time, array $ranges = null, array $servers = null)
    {
        if ($ranges === null || $servers === null) {
            list($ranges, $range_key, $servers) = $this->buildRangeData($range_key, $end_time);
        } else {
            if (!isset($ranges[$range_key])) {
                $range_key = 'week';
                $ranges = $this->buildRanges($range_key, $end_time);
                $servers = $this->collectServersForRange($ranges[$range_key]['start'], $end_time);
            }
        }

        $user = $this->getUser()->getUser();
        $recipient_email = $user && isset($user->email) ? trim($user->email) : '';
        $can_send_email = $recipient_email !== '';
        $recipient_hint = '';

        if ($can_send_email) {
            $recipient_hint = sprintf(psm_get_lang('diagnostic', 'send_email_recipient'), $recipient_email);
        }

        return array(
            'ranges' => $ranges,
            'range_key' => $range_key,
            'form_action' => psm_build_url(array('mod' => 'server_diagnostic', 'action' => 'sendReport', 'range' => $range_key)),
            'range_label' => $ranges[$range_key]['label'],
            'servers' => $servers,
            'recipient_email' => $recipient_email,
            'recipient_hint' => $recipient_hint,
            'can_send_email' => $can_send_email,
            'label_table_hint' => psm_get_lang('diagnostic', 'table_hint'),
            'label_latency_note' => psm_get_lang('diagnostic', 'latency_note'),
            'label_no_data' => psm_get_lang('diagnostic', 'no_data'),
            'label_uptime' => psm_get_lang('servers', 'uptime'),
            'label_latency' => psm_get_lang('servers', 'latency'),
            'label_host' => psm_get_lang('servers', 'server'),
            'label_send_email' => psm_get_lang('diagnostic', 'send_email'),
            'label_send_email_help' => psm_get_lang('diagnostic', 'send_email_help'),
            'label_send_email_missing' => psm_get_lang('diagnostic', 'send_email_missing'),
            'label_send_email_recipient' => $recipient_hint,
            'label_range_hint' => psm_get_lang('diagnostic', 'range_hint'),
        );
    }

    /**
     * Validate range and collect data for the selected period.
     *
     * @param string $range_key
     * @param DateTime $end_time
     * @return array
     */
    protected function buildRangeData($range_key, DateTime $end_time)
    {
        $ranges = $this->buildRanges($range_key, $end_time);

        if (!isset($ranges[$range_key])) {
            $range_key = 'week';
            $ranges = $this->buildRanges($range_key, $end_time);
        }

        $servers = $this->collectServersForRange($ranges[$range_key]['start'], $end_time);

        return array($ranges, $range_key, $servers);
    }

    /**
     * Collect performance statistics for all servers within a time window.
     *
     * @param DateTime $start_time
     * @param DateTime $end_time
     * @return array
     */
    protected function collectServersForRange(DateTime $start_time, DateTime $end_time)
    {
        $servers = array();

        foreach ($this->getServers() as $server) {
            if ($server['active'] !== 'yes') {
                continue;
            }

            $performance = $this->history->getPerformanceStatistics($server['server_id'], clone $start_time, clone $end_time);
            $uptime = $performance['uptime'] ?? null;
            $latency = $performance['latency'] ?? null;

            $servers[] = array(
                'label' => $server['label'],
                'address' => $this->formatAddress($server),
                'uptime' => $uptime,
                'uptime_display' => $this->formatUptime($uptime),
                'uptime_sort' => $uptime === null ? '' : $uptime,
                'latency_display' => $this->formatLatency($latency),
                'latency_sort' => $latency === null ? '' : $latency['average'],
            );
        }

        usort($servers, array($this, 'sortByUptime'));

        return $servers;
    }

    /**
     * Build the HTML version of the diagnostics email.
     *
     * @param array $ranges
     * @return string
     */
    protected function buildHtmlReport(array $ranges)
    {
        $table_style = 'border-collapse:collapse;width:100%;';
        $head_style = 'text-align:left;background:#f2f2f2;';
        $cell_style = 'vertical-align:top;';
        $label_style = 'color:#198754;font-weight:600;';
        $muted_style = 'color:#6c757d;';

        $html = '<p>' . psm_get_lang('diagnostic', 'send_email_intro') . '</p>';

        foreach ($ranges as $range) {
            $html .= '<h3 style="margin-bottom:8px;">' . htmlspecialchars($range['label']) . '</h3>';

            if (empty($range['servers'])) {
                $html .= '<p>' . psm_get_lang('diagnostic', 'no_data') . '</p>';
                continue;
            }

            $html .= '<table cellpadding="6" cellspacing="0" border="1" style="' . $table_style . '">';
            $html .= '<thead><tr>';
            $html .= '<th style="' . $head_style . '">' . psm_get_lang('servers', 'server') . '</th>';
            $html .= '<th style="' . $head_style . '">' . psm_get_lang('servers', 'uptime') . '</th>';
            $html .= '<th style="' . $head_style . '">' . psm_get_lang('servers', 'latency') . '</th>';
            $html .= '</tr></thead><tbody>';

            foreach ($range['servers'] as $server) {
                $html .= '<tr>';
                $html .= '<td style="' . $cell_style . $label_style . '">' . htmlspecialchars($server['label']) . '<br />'
                    . '<small style="' . $muted_style . '">(' . htmlspecialchars($server['address']) . ')</small></td>';
                $html .= '<td style="' . $cell_style . '">' . htmlspecialchars($server['uptime_display']) . '</td>';
                $html .= '<td style="' . $cell_style . '">' . htmlspecialchars($server['latency_display']) . '</td>';
                $html .= '</tr>';
            }

            $html .= '</tbody></table>';
        }

        return $html;
    }

    /**
     * Build the text-only version of the diagnostics email.
     *
     * @param array $ranges
     * @return string
     */
    protected function buildTextReport(array $ranges)
    {
        $lines = array(psm_get_lang('diagnostic', 'send_email_intro'));

        foreach ($ranges as $range) {
            $lines[] = $range['label'];
            $lines[] = str_repeat('-', strlen($range['label']));

            if (empty($range['servers'])) {
                $lines[] = psm_get_lang('diagnostic', 'no_data');
                $lines[] = '';
                continue;
            }

            foreach ($range['servers'] as $server) {
                $lines[] = $server['label'] . ' (' . $server['address'] . ')';
                $lines[] = ' - ' . psm_get_lang('servers', 'uptime') . ': ' . $server['uptime_display'];
                $lines[] = ' - ' . psm_get_lang('servers', 'latency') . ': ' . $server['latency_display'];
                $lines[] = '';
            }
        }

        return implode(PHP_EOL, $lines);
    }

    /**
     * Format uptime percentage for display.
     *
     * @param float|null $uptime
     * @return string
     */
    protected function formatUptime($uptime)
    {
        if ($uptime === null) {
            return 'n/a';
        }

        return sprintf('%0.3f%%', $uptime);
    }

    /**
     * Format latency data for display.
     *
     * @param array|null $latency
     * @return string
     */
    protected function formatLatency($latency)
    {
        if ($latency === null) {
            return 'n/a';
        }

        $avg = $latency['average'] * 1000;
        $min = $latency['min'] * 1000;
        $max = $latency['max'] * 1000;

        return sprintf('%0.2f ms (min %0.2f / max %0.2f)', $avg, $min, $max);
    }

    /**
     * Sort helper to order servers by uptime then label.
     *
     * @param array $a
     * @param array $b
     * @return int
     */
    protected function sortByUptime($a, $b)
    {
        $a_val = $a['uptime'];
        $b_val = $b['uptime'];

        if ($a_val === $b_val) {
            return strcasecmp($a['label'], $b['label']);
        }

        if ($a_val === null) {
            return 1;
        }
        if ($b_val === null) {
            return -1;
        }

        return ($a_val < $b_val) ? 1 : -1;
    }

    /**
     * Convert server details to a readable address.
     *
     * @param array $server
     * @return string
     */
    protected function formatAddress(array $server)
    {
        if ($server['type'] === 'website') {
            return $server['ip'];
        }

        $protocol = empty($server['protocol']) ? 'tcp' : $server['protocol'];
        $port = empty($server['port']) ? '' : ':' . $server['port'];

        return $protocol . '://' . $server['ip'] . $port;
    }
}
