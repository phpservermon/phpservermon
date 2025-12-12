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
     * Email diagnostics for all ranges to the current user.
     */
    protected function executeSendReport()
    {
        $this->twig->addGlobal('subtitle', psm_get_lang('menu', 'server_diagnostic'));

        $range_key = psm_POST('range', psm_GET('range', 'week'));
        $end_time = new DateTime();
        $ranges = $this->buildRanges($range_key, $end_time);

        if (!isset($ranges[$range_key])) {
            $range_key = 'week';
            $ranges = $this->buildRanges($range_key, $end_time);
        }

        $user = $this->getUser()->getUser();
        $recipient_email = $user && isset($user->email) ? trim($user->email) : '';

        if ($recipient_email === '') {
            $this->addMessage(psm_get_lang('diagnostic', 'send_email_missing'), 'error');

            return $this->twig->render('module/server/diagnostic.tpl.html', $this->buildTemplateData($range_key, $end_time));
        }

        $report_ranges = $this->collectReportsForRanges($ranges, $end_time);

        try {
            $mail = psm_build_mail();
            $mail->isHTML(true);
            $mail->Subject = psm_get_lang('diagnostic', 'send_email_subject');
            $mail->Body = $this->buildHtmlReport($report_ranges);
            $mail->AltBody = $this->buildTextReport($report_ranges);
            $mail->addAddress($recipient_email, $user->name ?? $user->user_name ?? '');

            $mail->send();

            $this->addMessage(psm_get_lang('diagnostic', 'send_email_success'), 'success');
        } catch (\Throwable $exception) {
            $this->addMessage(psm_get_lang('diagnostic', 'send_email_error'), 'error');
        }

        return $this->twig->render('module/server/diagnostic.tpl.html', $this->buildTemplateData($range_key, $end_time));
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
     * @return array
     */
    protected function buildTemplateData($range_key, DateTime $end_time)
    {
        list($ranges, $range_key, $servers) = $this->buildRangeData($range_key, $end_time);

        return array(
            'ranges' => $ranges,
            'range_key' => $range_key,
            'range_label' => $ranges[$range_key]['label'],
            'servers' => $servers,
            'label_table_hint' => psm_get_lang('diagnostic', 'table_hint'),
            'label_latency_note' => psm_get_lang('diagnostic', 'latency_note'),
            'label_no_data' => psm_get_lang('diagnostic', 'no_data'),
            'label_uptime' => psm_get_lang('servers', 'uptime'),
            'label_latency' => psm_get_lang('servers', 'latency'),
            'label_host' => psm_get_lang('servers', 'server'),
            'label_send_email' => psm_get_lang('diagnostic', 'send_email'),
            'label_send_email_help' => psm_get_lang('diagnostic', 'send_email_help'),
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
     * Gather report data for each available range.
     *
     * @param array $ranges
     * @param DateTime $end_time
     * @return array<string, array>
     */
    protected function collectReportsForRanges(array $ranges, DateTime $end_time)
    {
        $report = array();

        foreach ($ranges as $key => $range) {
            $report[$key] = array(
                'label' => $range['label'],
                'servers' => $this->collectServersForRange(clone $range['start'], clone $end_time),
            );
        }

        return $report;
    }

    /**
     * Build the HTML version of the diagnostics email.
     *
     * @param array $ranges
     * @return string
     */
    protected function buildHtmlReport(array $ranges)
    {
        $html = '<p>' . psm_get_lang('diagnostic', 'send_email_intro') . '</p>';

        foreach ($ranges as $range) {
            $html .= '<h3 style="margin-bottom:8px;">' . htmlspecialchars($range['label']) . '</h3>';

            if (empty($range['servers'])) {
                $html .= '<p>' . psm_get_lang('diagnostic', 'no_data') . '</p>';
                continue;
            }

            $html .= '<table cellpadding="6" cellspacing="0" border="1" style="border-collapse:collapse;">';
            $html .= '<thead><tr>';
            $html .= '<th>' . psm_get_lang('servers', 'server') . '</th>';
            $html .= '<th>' . psm_get_lang('servers', 'uptime') . '</th>';
            $html .= '<th>' . psm_get_lang('servers', 'latency') . '</th>';
            $html .= '</tr></thead><tbody>';

            foreach ($range['servers'] as $server) {
                $html .= '<tr>';
                $html .= '<td>' . htmlspecialchars($server['label']) . ' <small>(' . htmlspecialchars($server['address']) . ')</small></td>';
                $html .= '<td>' . htmlspecialchars($server['uptime_display']) . '</td>';
                $html .= '<td>' . htmlspecialchars($server['latency_display']) . '</td>';
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
