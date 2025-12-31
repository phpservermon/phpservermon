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

namespace psm\Util\Server;

use DateTime;
use psm\Service\Database;
use Twig\Environment;

class PerformanceReporter
{
    /**
     * Database connection.
     *
     * @var Database
     */
    protected $db;

    /**
     * History/uptime helper.
     *
     * @var HistoryGraph
     */
    protected $history;

    public function __construct(Database $db, Environment $twig)
    {
        $this->db = $db;
        $this->history = new HistoryGraph($db, $twig);
    }

    /**
     * Send the weekly performance report if it is time to do so.
     *
     * @return bool
     */
    public function maybeSendWeeklyReport()
    {
        if (!psm_get_conf('email_status')) {
            return false;
        }

        list($week_start, $week_end) = $this->getCurrentWeekWindow();

        if (!$this->shouldSendReport($week_start)) {
            return false;
        }

        $recipients = $this->getRecipients();
        if (empty($recipients)) {
            return false;
        }

        $servers = $this->collectServerStatistics($week_start, $week_end);
        $servers = $this->sortServersByUptime($servers);
        if (empty($servers)) {
            return false;
        }

        $mail = psm_build_mail();
        $mail->isHTML(true);
        $mail->Subject = 'Weekly performance report';
        $mail->Body = $this->buildHtmlBody($week_start, $week_end, $servers);
        $mail->AltBody = $this->buildTextBody($week_start, $week_end, $servers);

        foreach ($recipients as $recipient) {
            $mail->addAddress($recipient['email'], $recipient['name']);
        }

        $mailSendResult = $mail->send();
        psm_log_email_attempt($mail, $mailSendResult, array(
            'context' => 'weekly_performance_report',
        ));

        if (!$mailSendResult) {
            $errorInfo = property_exists($mail, 'ErrorInfo') ? $mail->ErrorInfo : 'unknown reason';
            error_log(sprintf('Weekly performance report email failed to send: %s', $errorInfo));

            return false;
        }

        psm_update_conf('weekly_report_last_sent', $week_end->getTimestamp());

        return true;
    }

    /**
     * Determine start/end of the current week.
     *
     * @return array{0: DateTime, 1: DateTime}
     */
    protected function getCurrentWeekWindow()
    {
        $end = new DateTime();
        $start = (clone $end)->modify('monday this week')->setTime(0, 0, 0);

        if ((int) $end->format('N') === 7) {
            $start->modify('-7 days');
        }

        return array($start, $end);
    }

    /**
     * Decide whether the report should be sent now.
     *
     * @param DateTime $week_start
     * @return bool
     */
    protected function shouldSendReport(DateTime $week_start)
    {
        $last_sent = (int) psm_get_conf('weekly_report_last_sent', 0);

        $dispatch_after = (clone $week_start)->modify('friday this week')->setTime(15, 0, 0);

        if (new DateTime() < $dispatch_after) {
            return false;
        }

        return $last_sent < $week_start->getTimestamp();
    }

    /**
     * Fetch list of users to notify.
     *
     * @return array<int, array<string, string>>
     */
    protected function getRecipients()
    {
        return $this->db->query('SELECT `name`, `email` FROM `' . PSM_DB_PREFIX . 'users` WHERE `email` <> ""');
    }

    /**
     * Gather server performance statistics.
     *
     * @param DateTime $start
     * @param DateTime $end
     * @return array
     */
    protected function collectServerStatistics(DateTime $start, DateTime $end)
    {
        $servers = $this->db->query('SELECT `server_id`, `label`, `ip`, `port`, `protocol`, `type`, `last_offline`, `last_offline_duration` FROM `' . PSM_DB_PREFIX . 'servers` WHERE `active` = "yes"');

        $results = array();

        foreach ($servers as $server) {
            $performance = $this->history->getPerformanceStatistics($server['server_id'], $start, $end);

            if ($performance === null) {
                continue;
            }

            $results[] = array_merge($server, $performance);
        }

        return $results;
    }

    /**
     * Build the HTML version of the weekly email.
     *
     * @param DateTime $start
     * @param DateTime $end
     * @param array $servers
     * @return string
     */
    protected function buildHtmlBody(DateTime $start, DateTime $end, array $servers)
    {
        $period = $this->formatPeriod($start, $end);

        $rows = '';
        $cellStyle = ' style="background:#1b7a1b;color:#ffffff;border:1px solid #0f5d0f;padding:6px 10px;"';
        $headerStyle = ' style="background:#146414;color:#ffffff;border:1px solid #0f5d0f;padding:6px 10px;font-weight:bold;"';

        foreach ($servers as $server) {
            $rows .= '<tr>' .
                '<td' . $cellStyle . '>' . htmlspecialchars($server['label']) . '</td>' .
                '<td' . $cellStyle . '>' . htmlspecialchars($this->formatAddress($server)) . '</td>' .
                '<td' . $cellStyle . '>' . htmlspecialchars($this->formatUptime($server['uptime'])) . '</td>' .
                '<td' . $cellStyle . '>' . htmlspecialchars($this->formatLastOffline($server['last_offline'], $server['last_offline_duration'])) . '</td>' .
                '</tr>';
        }

        return '<p>Weekly performance summary (' . $period . ')</p>' .
            '<table border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse;background:#1b7a1b;color:#ffffff;">' .
            '<thead><tr>' .
            '<th' . $headerStyle . '>Host</th>' .
            '<th' . $headerStyle . '>Address</th>' .
            '<th' . $headerStyle . '>Uptime</th>' .
            '<th' . $headerStyle . '>Last offline</th>' .
            '</tr></thead>' .
            '<tbody>' . $rows . '</tbody>' .
            '</table>';
    }

    /**
     * Build text-only fallback body.
     *
     * @param DateTime $start
     * @param DateTime $end
     * @param array $servers
     * @return string
     */
    protected function buildTextBody(DateTime $start, DateTime $end, array $servers)
    {
        $lines = array('Weekly performance summary (' . $this->formatPeriod($start, $end) . ')');

        foreach ($servers as $server) {
            $lines[] = implode(' | ', array(
                $server['label'],
                $this->formatAddress($server),
                $this->formatUptime($server['uptime']),
                $this->formatLastOffline($server['last_offline'], $server['last_offline_duration']),
            ));
        }

        return implode("\n", $lines);
    }

    /**
     * Format reporting window.
     *
     * @param DateTime $start
     * @param DateTime $end
     * @return string
     */
    protected function formatPeriod(DateTime $start, DateTime $end)
    {
        return $start->format('Y-m-d H:i') . ' - ' . $end->format('Y-m-d H:i');
    }

    /**
     * Format uptime percentage.
     *
     * @param float|null $uptime
     * @return string
     */
    protected function formatUptime($uptime)
    {
        return $uptime === null ? 'n/a' : sprintf('%0.3f%%', $uptime);
    }

    /**
     * Format latency statistics.
     *
     * @param array|null $latency
     * @return string
     */
    protected function formatLatency($latency)
    {
        if ($latency === null) {
            return 'n/a';
        }

        return sprintf(
            '%s (min %s / max %s)',
            $this->formatLatencyValue($latency['average']),
            $this->formatLatencyValue($latency['min']),
            $this->formatLatencyValue($latency['max'])
        );
    }

    /**
     * Convert a latency value in seconds to a human readable string.
     *
     * @param float $seconds
     * @return string
     */
    protected function formatLatencyValue($seconds)
    {
        return sprintf('%0.2f s', $seconds);
    }

    /**
     * Format last offline information.
     *
     * @param string|null $lastOffline
     * @param string|null $duration
     * @return string
     */
    protected function formatLastOffline($lastOffline, $duration)
    {
        if (empty($lastOffline)) {
            return psm_get_lang('system', 'never');
        }

        $timestamp = strtotime($lastOffline);
        if ($timestamp === false) {
            return psm_get_lang('system', 'never');
        }

        $timespan = psm_timespan($timestamp);
        if ($timespan === psm_get_lang('system', 'never')) {
            return $timespan;
        }

        return $duration ? $timespan . ' (' . $duration . ')' : $timespan;
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

        return $server['protocol'] . '://' . $server['ip'] . ':' . $server['port'];
    }

    /**
     * Sort servers by uptime (descending, nulls last).
     *
     * @param array<int, array<string, mixed>> $servers
     * @return array<int, array<string, mixed>>
     */
    protected function sortServersByUptime(array $servers)
    {
        usort($servers, function ($a, $b) {
            $uptimeA = array_key_exists('uptime', $a) ? (float) $a['uptime'] : null;
            $uptimeB = array_key_exists('uptime', $b) ? (float) $b['uptime'] : null;

            if ($uptimeA === $uptimeB) {
                return 0;
            }

            if ($uptimeA === null) {
                return 1;
            }

            if ($uptimeB === null) {
                return -1;
            }

            return $uptimeA > $uptimeB ? -1 : 1;
        });

        return $servers;
    }
}
