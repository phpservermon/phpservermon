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
 * @author      GPT-5.1-Codex-Max
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 */

namespace psm\Util\Server;

use DateTime;
use psm\Service\Database;
use Twig\Environment;

class DiagnosticReporter
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
     * Send the last-24-hours diagnostic report if it is time to do so.
     *
     * @return bool
     */
    public function maybeSendDailyReport()
    {
        if (!psm_get_conf('email_status')) {
            return false;
        }

        $now = new DateTime();
        if (!$this->isFriday($now)) {
            return false;
        }

        if (!$this->isWithinDispatchWindow($now)) {
            return false;
        }

        if ($this->hasSentToday($now)) {
            return false;
        }

        $recipients = $this->getRecipients();
        if (empty($recipients)) {
            return false;
        }

        $start = (clone $now)->modify('-24 hours');
        $end = clone $now;
        $servers = $this->collectServerStatistics($start, $end);
        if (empty($servers)) {
            return false;
        }

        $label = sprintf(
            '%s (%s)',
            psm_get_lang('servers', 'day'),
            $this->formatPeriod($start, $end)
        );

        $mail = psm_build_mail();
        $mail->isHTML(true);
        $mail->Subject = sprintf(
            '%s - %s',
            psm_get_lang('diagnostic', 'send_email_subject'),
            $label
        );
        $mail->Body = $this->buildHtmlReport($label, $servers);
        $mail->AltBody = $this->buildTextReport($label, $servers);

        foreach ($recipients as $recipient) {
            $mail->addAddress($recipient['email'], $recipient['name']);
        }

        $mailSendResult = $mail->send();
        psm_log_email_attempt($mail, $mailSendResult, array(
            'context' => 'daily_diagnostic_report',
            'range' => $label,
        ));

        if (!$mailSendResult) {
            $errorInfo = property_exists($mail, 'ErrorInfo') ? $mail->ErrorInfo : 'unknown reason';
            error_log(sprintf('Daily diagnostic report email failed to send: %s', $errorInfo));

            return false;
        }

        psm_update_conf('diagnostic_report_last_sent', $now->getTimestamp());

        return true;
    }

    /**
     * Check if today is Friday.
     *
     * @param DateTime $now
     * @return bool
     */
    protected function isFriday(DateTime $now)
    {
        return (int) $now->format('N') === 5;
    }

    /**
     * Check if the current time is within the 13:00-13:59 window.
     *
     * @param DateTime $now
     * @return bool
     */
    protected function isWithinDispatchWindow(DateTime $now)
    {
        $windowStart = (clone $now)->setTime(13, 0, 0);
        $windowEnd = (clone $windowStart)->modify('+1 hour');

        return $now >= $windowStart && $now < $windowEnd;
    }

    /**
     * Determine whether the report has already been sent today.
     *
     * @param DateTime $now
     * @return bool
     */
    protected function hasSentToday(DateTime $now)
    {
        $lastSent = (int) psm_get_conf('diagnostic_report_last_sent', 0);
        $todayStart = (clone $now)->setTime(0, 0, 0);

        return $lastSent >= $todayStart->getTimestamp();
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
     * @return array<int, array<string, mixed>>
     */
    protected function collectServerStatistics(DateTime $start, DateTime $end)
    {
        $servers = array();

        foreach ($this->getActiveServers() as $server) {
            $performance = $this->history->getPerformanceStatistics($server['server_id'], clone $start, clone $end);
            $uptime = $performance['uptime'] ?? null;
            $latency = $performance['latency'] ?? null;

            $servers[] = array(
                'label' => $server['label'],
                'address' => $this->formatAddress($server),
                'uptime' => $uptime,
                'uptime_display' => $this->formatUptime($uptime),
                'uptime_sort' => $uptime === null ? '' : $uptime,
                'latency' => $latency,
                'latency_display' => $this->formatLatency($latency),
                'latency_sort' => $latency === null ? '' : $latency['average'],
            );
        }

        usort($servers, array($this, 'sortByUptime'));

        return $servers;
    }

    /**
     * Fetch active server list.
     *
     * @return array<int, array<string, string>>
     */
    protected function getActiveServers()
    {
        return $this->db->query('SELECT `server_id`, `label`, `ip`, `port`, `protocol`, `type` FROM `' . PSM_DB_PREFIX . 'servers` WHERE `active` = "yes"');
    }

    /**
     * Build the HTML version of the diagnostics email.
     *
     * @param string $label
     * @param array  $servers
     * @return string
     */
    protected function buildHtmlReport($label, array $servers)
    {
        $base_style = 'margin:0;padding:24px;font-family:Helvetica,Arial,sans-serif;color:#212529;background:#f1f3f5;';
        $container_style = 'max-width:720px;margin:0 auto;';
        $card_style = 'background:#ffffff;border:1px solid #e9ecef;border-radius:10px;margin-bottom:16px;overflow:hidden;';
        $header_style = 'padding:16px 20px;border-bottom:1px solid #e9ecef;background:#ffffff;';
        $table_style = 'border-collapse:collapse;width:100%;';
        $head_style = 'padding:12px 14px;background:#f8f9fa;color:#495057;font-weight:700;font-size:12px;border-bottom:1px solid #e9ecef;text-align:left;text-transform:uppercase;letter-spacing:0.02em;';
        $cell_style = 'padding:12px 14px;border-bottom:1px solid #e9ecef;font-size:13px;vertical-align:top;';
        $label_style = 'color:#1b6f8a;font-weight:700;font-size:14px;';
        $muted_style = 'color:#6c757d;font-size:12px;';
        $meta_style = 'color:#6c757d;font-size:12px;margin:6px 0 0 0;';

        $html = '<div style="' . $base_style . '"><div style="' . $container_style . '">';
        $html .= '<div style="' . $card_style . '">';
        $html .= '<div style="' . $header_style . '">';
        $html .= '<h2 style="margin:0;font-size:18px;color:#212529;">' . psm_get_lang('diagnostic', 'send_email_subject') . '</h2>';
        $html .= '<p style="margin:6px 0 0 0;font-size:14px;color:#495057;">' . psm_get_lang('diagnostic', 'send_email_intro') . '</p>';
        $html .= '<p style="' . $meta_style . '">Uptime status: <span style="color:#0f5132;font-weight:700;">100%</span> = green, '
            . '<span style="color:#664d03;font-weight:700;">90-99.999%</span> = orange, '
            . '<span style="color:#842029;font-weight:700;">&lt; 90%</span> = red.</p>';
        $html .= '</div></div>';
        $html .= '<div style="' . $card_style . '">';
        $html .= '<div style="padding:14px 16px 0 16px;"><h3 style="margin:0 0 12px 0;font-size:16px;color:#212529;">' . htmlspecialchars($label) . '</h3></div>';

        if (empty($servers)) {
            $html .= '<p style="margin:0 16px 16px 16px;font-size:14px;color:#6c757d;">' . psm_get_lang('diagnostic', 'no_data') . '</p>';
            $html .= '</div></div></div>';

            return $html;
        }

        $html .= '<table cellpadding="0" cellspacing="0" border="0" style="' . $table_style . '">';
        $html .= '<thead><tr>';
        $html .= '<th style="' . $head_style . '">' . psm_get_lang('servers', 'server') . '</th>';
        $html .= '<th style="' . $head_style . '">' . psm_get_lang('servers', 'uptime') . '</th>';
        $html .= '<th style="' . $head_style . '">' . psm_get_lang('servers', 'latency') . '</th>';
        $html .= '</tr></thead><tbody>';

        $alternate_row = false;

        foreach ($servers as $server) {
            $row_background = $alternate_row ? 'background-color:#f8f9fa;' : '';
            $alternate_row = !$alternate_row;

            $html .= '<tr>';
            $html .= '<td style="' . $cell_style . $row_background . '"><div style="' . $label_style . '">' . htmlspecialchars($server['label']) . '</div>'
                . '<div style="' . $muted_style . '">' . htmlspecialchars($server['address']) . '</div></td>';
            $html .= '<td style="' . $cell_style . $row_background . 'text-align:right;">' . $this->formatUptimeBadge($server['uptime'], $server['uptime_display']) . '</td>';
            $html .= '<td style="' . $cell_style . $row_background . 'text-align:right;">' . $this->formatLatencyBadge($server['latency_display'], $server['latency']) . '</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody></table></div></div></div>';

        return $html;
    }

    /**
     * Build the text-only version of the diagnostics email.
     *
     * @param string $label
     * @param array  $servers
     * @return string
     */
    protected function buildTextReport($label, array $servers)
    {
        $lines = array(psm_get_lang('diagnostic', 'send_email_intro'));
        $lines[] = $label;
        $lines[] = str_repeat('-', strlen($label));

        if (empty($servers)) {
            $lines[] = psm_get_lang('diagnostic', 'no_data');

            return implode(PHP_EOL, $lines);
        }

        foreach ($servers as $server) {
            $lines[] = $server['label'] . ' (' . $server['address'] . ')';
            $lines[] = ' - ' . psm_get_lang('servers', 'uptime') . ': ' . $server['uptime_display'];
            $lines[] = ' - ' . psm_get_lang('servers', 'latency') . ': ' . $server['latency_display'];
            $lines[] = '';
        }

        return implode(PHP_EOL, $lines);
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

        $avg = $latency['average'];
        $min = $latency['min'];
        $max = $latency['max'];

        return sprintf('%0.2f s (min %0.2f / max %0.2f)', $avg, $min, $max);
    }

    /**
     * Format uptime as a colored badge for HTML emails.
     *
     * @param float|null $uptime
     * @param string     $display
     * @return string
     */
    protected function formatUptimeBadge($uptime, $display)
    {
        if ($uptime === null) {
            return $this->buildBadge($display, '#e9ecef', '#495057');
        }

        if ($uptime >= 100) {
            return $this->buildBadge($display, '#d1e7dd', '#0f5132');
        }

        if ($uptime >= 90) {
            return $this->buildBadge($display, '#fff3cd', '#664d03');
        }

        return $this->buildBadge($display, '#f8d7da', '#842029');
    }

    /**
     * Format latency as a colored badge for HTML emails.
     *
     * @param string     $display
     * @param array|null $latency
     * @return string
     */
    protected function formatLatencyBadge($display, $latency)
    {
        if ($latency === null || !isset($latency['average'])) {
            return $this->buildBadge($display, '#e9ecef', '#495057');
        }

        $average_seconds = $latency['average'];

        if ($average_seconds <= 0.5) {
            return $this->buildBadge($display, '#d1e7dd', '#0f5132');
        }

        if ($average_seconds <= 1.5) {
            return $this->buildBadge($display, '#fff3cd', '#664d03');
        }

        return $this->buildBadge($display, '#f8d7da', '#842029');
    }

    /**
     * Build a pill-style badge for HTML emails.
     *
     * @param string $text
     * @param string $background
     * @param string $color
     * @return string
     */
    protected function buildBadge($text, $background, $color)
    {
        $badge_style = 'display:inline-block;padding:6px 10px;border-radius:999px;font-weight:700;font-size:12px;'
            . 'background:' . $background . ';color:' . $color . ';';

        return '<span style="' . $badge_style . '">' . htmlspecialchars($text) . '</span>';
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
