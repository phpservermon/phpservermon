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
        $this->setActions(array('index'), 'index');
    }

    /**
     * Display uptime and latency overview for all hosts.
     */
    protected function executeIndex()
    {
        $this->twig->addGlobal('subtitle', psm_get_lang('menu', 'server_diagnostic'));

        $range_key = psm_GET('range', 'week');
        $end_time = new DateTime();
        $ranges = $this->buildRanges($range_key, $end_time);

        if (!isset($ranges[$range_key])) {
            $range_key = 'week';
            $ranges = $this->buildRanges($range_key, $end_time);
        }
        $start_time = $ranges[$range_key]['start'];

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

        $tpl_data = array(
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
        );

        return $this->twig->render('module/server/diagnostic.tpl.html', $tpl_data);
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
