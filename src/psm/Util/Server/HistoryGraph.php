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
 * @author      Jérôme Cabanis <http://lauraly.com>
 * @author      Pepijn Over <pep@mailbox.org>
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

namespace psm\Util\Server;

use DateTime;
use psm\Service\Database;
use Twig\Error\Error;
use Twig\Environment;

/**
 * History util, create HTML for server graphs
 */
class HistoryGraph
{

    /**
     * Database service
     * @var Database $db;
     */
    protected $db;

    /**
     * Twig environment
     * @var Twig_Environment $twig
     */
    protected $twig;

    public function __construct(Database $db, \Twig\Environment $twig)
    {
        $this->db = $db;
        $this->twig = $twig;
    }

    /**
     * Calculate uptime and latency statistics for a given period.
     *
     * @param int $server_id
     * @param DateTime $start_time
     * @param DateTime $end_time
     * @return array|null
     */
    public function getPerformanceStatistics($server_id, DateTime $start_time, DateTime $end_time)
    {
        $cache_ttl = defined('PSM_PERFORMANCE_STATS_CACHE_TTL') ? (int) PSM_PERFORMANCE_STATS_CACHE_TTL : 0;
        $cache_key = 'performance_stats_' . (int) $server_id;
        $cache_time_key = $cache_key . '_time';

        if ($cache_ttl > 0) {
            $cache_time = (int) psm_get_conf($cache_time_key, 0);
            if ($cache_time > 0 && (time() - $cache_time) < $cache_ttl) {
                $cached = psm_get_conf($cache_key);
                if (!empty($cached)) {
                    $cached_stats = json_decode($cached, true);
                    if (is_array($cached_stats)) {
                        if (array_key_exists('empty', $cached_stats)) {
                            return null;
                        }
                        return $cached_stats;
                    }
                }
            }
        }

        $uptime_records = $this->getRecords('uptime', $server_id, $start_time, $end_time);
        $history_records = null;

        $uptime = $this->calculateUptime($server_id, $start_time, $end_time, $uptime_records, $history_records);
        $latency = $this->calculateLatencyStats($server_id, $start_time, $end_time, $uptime_records, $history_records);

        if ($uptime === null && $latency === null) {
            if ($cache_ttl > 0) {
                psm_update_conf($cache_key, json_encode(array('empty' => true)));
                psm_update_conf($cache_time_key, time());
            }
            return null;
        }

        $stats = array(
            'uptime' => $uptime,
            'latency' => $latency,
        );

        if ($cache_ttl > 0) {
            psm_update_conf($cache_key, json_encode($stats));
            psm_update_conf($cache_time_key, time());
        }

        return $stats;
    }

    /**
     * Calculate uptime percentages for multiple servers using aggregated data.
     *
     * @param int[] $server_ids
     * @param DateTime $start_time
     * @param DateTime $end_time
     * @return array<int, float|null>
     */
    public function getUptimePercentages(array $server_ids, DateTime $start_time, DateTime $end_time)
    {
        $server_ids = array_values(array_unique(array_map('intval', $server_ids)));
        if (empty($server_ids)) {
            return array();
        }

        $placeholders = array();
        $parameters = array(
            'start_time' => $start_time->format('Y-m-d H:i:s'),
            'end_time' => $end_time->format('Y-m-d H:i:s'),
        );

        foreach ($server_ids as $index => $server_id) {
            $key = 'server_id_' . $index;
            $placeholders[] = ':' . $key;
            $parameters[$key] = $server_id;
        }

        $in_clause = implode(', ', $placeholders);

        $records = $this->db->execute(
            "SELECT `server_id`, SUM(`status`) AS `uptime_count`, COUNT(*) AS `total_count`
                FROM `" . PSM_DB_PREFIX . "servers_uptime`
                WHERE `server_id` IN (" . $in_clause . ")
                    AND `date` BETWEEN :start_time AND :end_time
                GROUP BY `server_id`",
            $parameters
        );

        $uptime_stats = array();
        $missing_ids = array_fill_keys($server_ids, true);

        foreach ($records as $record) {
            $server_id = (int) $record['server_id'];
            $total = (int) $record['total_count'];
            $uptime = null;

            if ($total > 0) {
                $uptime_count = (int) $record['uptime_count'];
                $uptime = 100 - (($total - $uptime_count) / $total) * 100;
            }

            $uptime_stats[$server_id] = $uptime;
            unset($missing_ids[$server_id]);
        }

        if (!empty($missing_ids)) {
            $history_placeholders = array();
            $history_parameters = array(
                'start_date' => $start_time->format('Y-m-d'),
                'end_date' => $end_time->format('Y-m-d'),
            );

            foreach (array_keys($missing_ids) as $index => $server_id) {
                $key = 'history_server_id_' . $index;
                $history_placeholders[] = ':' . $key;
                $history_parameters[$key] = $server_id;
            }

            $history_in_clause = implode(', ', $history_placeholders);
            $history_records = $this->db->execute(
                "SELECT `server_id`, SUM(`checks_total`) AS `total_count`, SUM(`checks_failed`) AS `failed_count`
                    FROM `" . PSM_DB_PREFIX . "servers_history`
                    WHERE `server_id` IN (" . $history_in_clause . ")
                        AND `date` BETWEEN :start_date AND :end_date
                    GROUP BY `server_id`",
                $history_parameters
            );

            foreach ($history_records as $record) {
                $server_id = (int) $record['server_id'];
                $total = (int) $record['total_count'];
                $uptime = null;

                if ($total > 0) {
                    $failed = (int) $record['failed_count'];
                    $uptime = 100 - (($failed / $total) * 100);
                }

                $uptime_stats[$server_id] = $uptime;
            }
        }

        return $uptime_stats;
    }

    /**
     * Prepare the HTML for the graph
     * @param string $server_id ID of server to fetch data for
     * @return string Created HTML
     * @throws Error On twig error
     */
    public function createHTML($server_id)
    {
        $server_id = (int) $server_id;
        $cache_ttl = defined('PSM_HISTORY_GRAPH_CACHE_TTL') ? (int) PSM_HISTORY_GRAPH_CACHE_TTL : 60;
        $cache_key = 'history_graph_html_' . $server_id;
        $cache_time_key = $cache_key . '_time';

        if ($cache_ttl > 0) {
            $cache_time = (int) psm_get_conf($cache_time_key, 0);
            if ($cache_time > 0 && (time() - $cache_time) < $cache_ttl) {
                $cached = psm_get_conf($cache_key, '');
                if ($cached !== '') {
                    return $cached;
                }
            }
        }

        // Archive all records for this server to make sure we have up-to-date stats
        $archive = new ArchiveManager($this->db);
        $archive->archive($server_id);

        $now = new DateTime();

		if(PSM_UPTIME_ARCHIVE == 'quarterly'){
			$start_date = new DateTime('-3 month 0:0:0');
		}else if(PSM_UPTIME_ARCHIVE == 'monthly'){
			$start_date = new DateTime('-1 month 0:0:0');
		}else{
			$start_date = new DateTime('-1 week 0:0:0');
		}

        $last_week = new DateTime('-1 week 0:0:0');
        $last_month = new DateTime('-1 month 0:0:0');
        $last_year = new DateTime('-1 year -1 week 0:0:0');

        $graphs = array(
            0 => $this->generateGraphUptime($server_id, $start_date, $now),
            1 => $this->generateGraphHistory($server_id, $last_year, $last_week),
        );

        $uptime_summary = $this->calculateUptimeSummary($server_id, $now);
        if (!empty($uptime_summary)) {
            $graphs[0]['uptime_summary'] = $uptime_summary;
        }
        $info_fields = array(
            'latency_avg' => '%01.5f',
            'uptime' => '%01.3f%%',
        );

        foreach ($graphs as $i => &$graph) {
            // add subarray for info fields
            $graph['info'] = array();

            foreach ($info_fields as $field => $format) {
                if (!isset($graph[$field])) {
                    continue;
                }
                $graph['info'][] = array(
                    'label' => psm_get_lang('servers', $field),
                    'value' => sprintf($format, $graph[$field]),
                );
            }
        }
        $tpl_data = array(
            'graphs' => $graphs,
        );
        $html = $this->twig->render('module/server/history.tpl.html', $tpl_data);

        if ($cache_ttl > 0) {
            psm_update_conf($cache_key, $html);
            psm_update_conf($cache_time_key, time());
        }

        return $html;
    }

    /**
     * Calculate uptime percentages for common time ranges.
     *
     * @param int $server_id
     * @param DateTime $end_time
     * @return array
     */
    protected function calculateUptimeSummary($server_id, DateTime $end_time)
    {
        $periods = array(
            'day' => (clone $end_time)->modify('-1 day'),
            'week' => (clone $end_time)->modify('-1 week'),
            'month' => (clone $end_time)->modify('-1 month'),
            'year' => (clone $end_time)->modify('-1 year'),
        );

        $summary = array();

        foreach ($periods as $period => $start_time) {
            $uptime = $this->calculateUptime($server_id, $start_time, $end_time);
            if ($uptime === null) {
                continue;
            }

            $summary[] = array(
                'label' => psm_get_lang('servers', $period),
                'value' => $uptime,
            );
        }

        return $summary;
    }

    /**
     * Calculate uptime percentage for a specific window.
     *
     * @param int $server_id
     * @param DateTime $start_time
     * @param DateTime $end_time
     * @param array|null $uptime_records Preloaded uptime rows to avoid duplicate queries
     * @param array|null $history_records Preloaded history rows to avoid duplicate queries (passed by reference)
     * @return float|null
     */
    protected function calculateUptime(
        $server_id,
        DateTime $start_time,
        DateTime $end_time,
        ?array $uptime_records = null,
        ?array &$history_records = null
    ) {
        if ($uptime_records === null) {
            $uptime_records = $this->getRecords('uptime', $server_id, $start_time, $end_time);
        }

        $previous_record = $this->getPreviousUptimeRecord($server_id, $start_time);

        if (!empty($uptime_records) || $previous_record !== null) {
            $timeframe = $this->calculateDowntimeFromUptimeRecords(
                $uptime_records,
                $previous_record,
                $start_time,
                $end_time
            );

            if ($timeframe === null) {
                return null;
            }

            list($downtime, $covered_time) = $timeframe;

            return $covered_time > 0 ? 100 - (($downtime / $covered_time) * 100) : null;
        }

        if ($history_records === null) {
            $history_records = $this->getRecords('history', $server_id, $start_time, $end_time);
        }

        if (empty($history_records)) {
            return null;
        }

        list($downtime, $covered_time) = $this->calculateDowntimeFromHistoryRecords(
            $history_records,
            $start_time,
            $end_time
        );

        return $covered_time > 0 ? 100 - (($downtime / $covered_time) * 100) : null;
    }

    /**
     * Calculate latency statistics (average, min, max) for a specific window.
     *
     * @param int $server_id
     * @param DateTime $start_time
     * @param DateTime $end_time
     * @param array|null $uptime_records Preloaded uptime rows to avoid duplicate queries
     * @param array|null $history_records Preloaded history rows to avoid duplicate queries (passed by reference)
     * @return array|null
     */
    protected function calculateLatencyStats(
        $server_id,
        DateTime $start_time,
        DateTime $end_time,
        ?array $uptime_records = null,
        ?array &$history_records = null
    ) {
        $latency_sum = 0;
        $latency_min = null;
        $latency_max = null;
        $latency_count = 0;

        if ($uptime_records === null) {
            $uptime_records = $this->getRecords('uptime', $server_id, $start_time, $end_time);
        }

        foreach ($uptime_records as $record) {
            if ($record['latency'] === null) {
                continue;
            }

            $latency = (float) $record['latency'];
            $latency_sum += $latency;
            $latency_min = $latency_min === null ? $latency : min($latency_min, $latency);
            $latency_max = $latency_max === null ? $latency : max($latency_max, $latency);
            $latency_count++;
        }

        if ($latency_count === 0) {
            if ($history_records === null) {
                $history_records = $this->getRecords('history', $server_id, $start_time, $end_time);
            }

            foreach ($history_records as $record) {
                $latency_sum += (float) $record['latency_avg'];
                $latency_min = $latency_min === null
                    ? (float) $record['latency_min']
                    : min($latency_min, (float) $record['latency_min']);
                $latency_max = $latency_max === null
                    ? (float) $record['latency_max']
                    : max($latency_max, (float) $record['latency_max']);
                $latency_count++;
            }
        }

        if ($latency_count === 0) {
            return null;
        }

        return array(
            'average' => $latency_sum / $latency_count,
            'min' => $latency_min,
            'max' => $latency_max,
        );
    }

    /**
     * Calculate downtime in seconds using raw uptime records.
     *
     * @param array $uptime_records
     * @param array|null $previous_record
     * @param DateTime $start_time
     * @param DateTime $end_time
     * @return array{int,int}|null [downtime seconds, covered timeframe seconds]
     */
    protected function calculateDowntimeFromUptimeRecords(array $uptime_records, $previous_record, DateTime $start_time, DateTime $end_time)
    {
        $downtime = 0;
        $window_start = $start_time->getTimestamp();
        $window_end = $end_time->getTimestamp();

        if (empty($uptime_records) && $previous_record === null) {
            return null;
        }

        $coverage_start = $window_start;

        // Default to "up" when we have no prior status so unmonitored time counts as covered
        // but does not contribute downtime. This keeps longer ranges from producing lower
        // percentages than their contained shorter windows when downtime is localized.
        $previous_status = $previous_record !== null ? (bool) $previous_record['status'] : true;

        $previous_time = $coverage_start;

        foreach ($uptime_records as $record) {
            $current_time = (int) $record['date_ts'];

            if ($current_time < $coverage_start) {
                // outside the window
                $previous_status = (bool) $record['status'];
                continue;
            }

            if ($current_time > $window_end) {
                break;
            }

            if (!$previous_status) {
                $downtime += ($current_time - $previous_time);
            }

            $previous_status = (bool) $record['status'];
            $previous_time = $current_time;
        }

        if (!$previous_status && $previous_time < $window_end) {
            $downtime += ($window_end - $previous_time);
        }

        $covered_time = max(0, $window_end - $coverage_start);

        return array($downtime, $covered_time);
    }

    /**
     * Calculate downtime in seconds using archived history records.
     *
     * @param array $history_records
     * @param DateTime $start_time
     * @param DateTime $end_time
     * @return array{int,int} [downtime seconds, covered timeframe seconds]
     */
    protected function calculateDowntimeFromHistoryRecords(array $history_records, DateTime $start_time, DateTime $end_time)
    {
        $downtime = 0;
        $window_start = $start_time->getTimestamp();
        $window_end = $end_time->getTimestamp();
        $covered_time = max(0, $window_end - $window_start);

        foreach ($history_records as $record) {
            $checks_total = (int) $record['checks_total'];

            if ($checks_total === 0) {
                continue;
            }

            $date = new DateTime($record['date']);
            $day_start = $date->getTimestamp();
            $day_end = $day_start + 86400; // one day later

            $period_start = max($day_start, $window_start);
            $period_end = min($day_end, $window_end);

            if ($period_end <= $period_start) {
                continue;
            }

            $failed_ratio = ((int) $record['checks_failed']) / $checks_total;
            $downtime += ($period_end - $period_start) * $failed_ratio;
        }

        // Treat unmonitored time as up while still counting it as part of the requested range
        // so wider windows cannot report lower uptime percentages than contained ranges when
        // downtime only affected a subset of the period.
        return array($downtime, $covered_time);
    }

    /**
     * Fetch the most recent uptime record prior to the requested window start.
     *
     * @param int $server_id
     * @param DateTime $start_time
     * @return array|null
     */
    protected function getPreviousUptimeRecord($server_id, DateTime $start_time)
    {
        $records = $this->db->execute(
            "SELECT *, UNIX_TIMESTAMP(CONVERT_TZ(`date`, '+00:00', @@session.time_zone)) AS date_ts
                        FROM `" . PSM_DB_PREFIX . "servers_uptime`
                        WHERE `server_id` = :server_id AND `date` < :start_time
                        ORDER BY `date` DESC
                        LIMIT 1",
            array(
                'server_id' => $server_id,
                'start_time' => $start_time->format('Y-m-d H:i:s'),
            )
        );

        if (empty($records)) {
            return null;
        }

        return $records[0];
    }

    /**
     * Generate data for uptime graph
     * @param int $server_id
     * @param DateTime $start_time Lowest DateTime of the graph
     * @param DateTime $end_time Highest DateTime of the graph
     * @return array
     */
    public function generateGraphUptime($server_id, $start_time, $end_time)
    {

        $records = $this->getRecords('uptime', $server_id, $start_time, $end_time);

        $lines = array(
            'latency' => array(),
        );

        $hour = new DateTime('-1 hour');
        $day = new DateTime('-1 day');
        $week = new DateTime('-1 week');
        $month = new DateTime('-1 month');
        $year = new DateTime('-1 year');
        // Use the supplied $start_time to ensure the graph can be scaled to the
        // earliest timeframe that was archived for this server.
        $data = $this->generateGraphLines($records, $lines, 'latency', $start_time, $end_time, true);

        $data['title'] = psm_get_lang('servers', 'chart_last_week');
        $data['id'] = 'history_short';
        $data['unit'] = 'minute';
        $data['buttons'] = array();
        $data['button_name'] = 'timeframe_short';
        $data['buttons'][] = array(
            'unit' => 'minute',
            'range' => 'hour',
            'time' => $hour->getTimestamp() * 1000,
            'label' => psm_get_lang('servers', 'hour'),
            'class_active' => 'active'
        );
        $data['buttons'][] = array(
            'unit' => 'hour',
            'range' => 'day',
            'time' => $day->getTimestamp() * 1000,
            'label' => psm_get_lang('servers', 'day')
        );
        $data['buttons'][] = array(
            'unit' => 'day',
            'range' => 'week',
            'time' => $week->getTimestamp() * 1000,
            'label' => psm_get_lang('servers', 'week')
        );
        $data['buttons'][] = array(
            'unit' => 'week',
            'range' => 'month',
            'time' => $month->getTimestamp() * 1000,
            'label' => psm_get_lang('servers', 'month')
        );
        $data['buttons'][] = array(
            'unit' => 'year',
            'range' => 'year',
            'time' => $year->getTimestamp() * 1000,
            'label' => psm_get_lang('servers', 'year')
        );

        $data['uptime_ranges'] = $this->calculateUptimeRanges($server_id, $end_time);

        return $data;
    }

    /**
     * Calculate uptime percentages that match the available timeframe buttons.
     *
     * @param int $server_id
     * @param DateTime $end_time
     * @return array
     */
    protected function calculateUptimeRanges($server_id, DateTime $end_time)
    {
        $ranges = array(
            'hour' => (clone $end_time)->modify('-1 hour'),
            'day' => (clone $end_time)->modify('-1 day'),
            'week' => (clone $end_time)->modify('-1 week'),
            'month' => (clone $end_time)->modify('-1 month'),
            'year' => (clone $end_time)->modify('-1 year'),
        );

        $uptime_ranges = array();

        foreach ($ranges as $key => $start_time) {
            $uptime = $this->calculateUptime($server_id, $start_time, $end_time);
            if ($uptime === null) {
                continue;
            }

            $uptime_ranges[$key] = $uptime;
        }

        return $uptime_ranges;
    }

    /**
     * Generate data for history graph
     * @param int $server_id
     * @param DateTime $start_time Lowest DateTime of the graph
     * @param DateTime $end_time Highest DateTime of the graph
     * @return array
     */
    public function generateGraphHistory($server_id, $start_time, $end_time)
    {
        $lines = array(
            'latency_min' => array(),
            'latency_avg' => array(),
            'latency_max' => array(),
        );

        $week = new DateTime('-2 week 0:0:0');
        $month = new DateTime('-1 month -1 week 0:0:0');
        $year = new DateTime('-1 year -1 week 0:0:0');

        $records = $this->getRecords('history', $server_id, $year, $end_time);

        // dont add uptime for now because we have no way to calculate accurate uptimes for archived records
        $data = $this->generateGraphLines($records, $lines, 'latency_avg', $start_time, $end_time, false);
        $data['title'] = psm_get_lang('servers', 'chart_history');
        $data['id'] = 'history_long';
        $data['unit'] = 'week';
        $data['buttons'] = array();
        $data['button_name'] = 'timeframe_long';
        $data['buttons'][] = array(
            'unit' => 'day',
            'time' => $week->getTimestamp() * 1000,
            'label' => psm_get_lang('servers', 'week')
        );
        $data['buttons'][] = array(
            'unit' => 'week',
            'time' => $month->getTimestamp() * 1000,
            'label' => psm_get_lang('servers', 'month'),
            'class_active' => 'active'
        );
        $data['buttons'][] = array(
            'unit' => 'month',
            'time' => $year->getTimestamp() * 1000,
            'label' => psm_get_lang('servers', 'year')
        );

        return $data;
    }

    /**
     * Get all uptime/history records for a server
     * @param string $type
     * @param int $server_id
     * @param DateTime $start_time Lowest DateTime of the graph
     * @param DateTime $end_time Highest DateTime of the graph
     * @return array
     */
    protected function getRecords($type, $server_id, $start_time, $end_time)
    {
        if (!in_array($type, array('history', 'uptime'))) {
            return array();
        }

        $max_records = defined('PSM_MAX_GRAPH_RECORDS') ? (int) PSM_MAX_GRAPH_RECORDS : 5000;

        /** @noinspection SqlNoDataSourceInspection */
        /** @noinspection SqlResolve */
        /** @noinspection PhpUndefinedConstantInspection */
        $records = $this->db->execute(
            "SELECT *, UNIX_TIMESTAMP(CONVERT_TZ(`date`, '+00:00', @@session.time_zone)) AS date_ts
                                FROM `" . PSM_DB_PREFIX . "servers_$type`
                                WHERE `server_id` = :server_id AND `date` BETWEEN :start_time AND :end_time
                                ORDER BY `date` DESC" . ($max_records > 0 ? ' LIMIT ' . $max_records : ''),
            array(
                'server_id' => $server_id,
                'start_time' => $start_time->format('Y-m-d H:i:s'),
                'end_time' => $end_time->format('Y-m-d H:i:s'),
            )
        );

        return array_reverse($records);
    }

    /**
     * Generate data arrays for graphs
     * @param array $records All uptime records to parse, MUST BE SORTED BY DATE IN ASCENDING ORDER
     * @param array $lines Array with keys as line ids to prepare (key must be available in uptime records)
     * @param string $latency_avg_key which key from uptime records to use for calculating averages
     * @param DateTime $start_time Lowest DateTime of the graph
     * @param DateTime $end_time Highest DateTime of the graph
     * @param boolean $add_uptime Add uptime calculation?
     * @return array
     */
    protected function generateGraphLines(
        $records,
        $lines,
        $latency_avg_key,
        $start_time,
        $end_time,
        $add_uptime = false
    ) {
        $now = new DateTime();
        $data = array();

        // The keys of the lines iterated
        $line_keys = array_keys($lines);
        $is_short_graph = count($line_keys) === 1 && $line_keys[0] === 'latency';

        if (empty($records)) {
            if ($is_short_graph) {
                $lines['online'] = array();
                $lines['offline'] = array();
            }

            $data['latency_avg'] = 0;
            $data['lines'] = array();

            foreach (array_keys($lines) as $key) {
                $data['lines'][$key]['value'] = json_encode(array());
                $data['lines'][$key]['name'] = psm_get_lang('servers', $key);
            }

            if ($add_uptime) {
                $data['uptime'] = null;
            }

            $data['end_timestamp'] = number_format($end_time->getTimestamp(), 0, '', '') * 1000;
            $data['start_timestamp'] = number_format($start_time->getTimestamp(), 0, '', '') * 1000;

            return $data;
        }

        // PLEASE NOTE: all times are in microseconds! because of javascript.
        $latency_avg = 0;

        /** @var array $prev Previous record */
        $prev = reset($records);

        // Timestamp from last offline record. 0 when last record is up.
        $prev_downtime = 0;
        // Total downtime
        $downtime = 0;
        // Determine whether to process data for the short history graph

        // get highest latency record for offline height
        $highest_latency = 0.0;
        if ($is_short_graph) {
            foreach ($records as $record) {
                $latency = (float) $record['latency'];
                if ($latency > $highest_latency) {
                    $highest_latency = $latency;
                }
            }
            // to ms
            $highest_latency = round($highest_latency * 1000);
        }

        // Create the list of points and server down zones
        foreach ($records as $record) {
            // use the first line to calculate average latency
            $latency_avg += (float) $record[$latency_avg_key];

            if ($is_short_graph) {
                $time = (int) $record['date_ts'];
                // Timestamp in milliseconds
                $time_ms = $time * 1000;
                if (!$record['status']) {
                    // down
                    $lines['online'][] = $prev['status']
                        // Previous datapoint was online
                            ? ['x' => $time_ms, 'y' => round($prev['latency'] * 1000, 3)]
                        // Previous datapoint was offline
                            : ['x' => $time_ms, 'y' => null];
                    // new outage start
                    $lines['offline'][] = ['x' => $time_ms, 'y' => 0];

                    if ($prev_downtime === 0) {
                        $prev_downtime = $time;
                    }
                } else {
                    // up
                    // outage ends
                    $lines['offline'][] = $prev['status']
                        // Previous datapoint was online
                            ? ['x' => $time_ms, 'y' => null]
                        // Previous datapoint was offline
                            : ['x' => $time_ms, 'y' => 0];
                    $lines['online'][] = ['x' => $time_ms, 'y' => round($record['latency'] * 1000, 3)];

                    if ($prev_downtime !== 0) {
                        $downtime += ($time - $prev_downtime);
                    }
                    $prev_downtime = 0;
                }
            } else {
                foreach ($line_keys as $key) {
                    // add the value for each of the different lines
                    $lines[$key][] = ['x' => $record['date'], 'y' => $record[$key] * 1000];
                }
            }
            $prev = $record;
        }
        // Was down before.
        // Record the first and last date as a string in the down array
        $prev_downtime == 0 ?: $downtime += ($now->getTimestamp() - $prev_downtime);
        if ($add_uptime) {
            if (!$prev['status']) {
                $lines['offline'][] = ['x' => $now->getTimestamp() * 1000, 'y' => $highest_latency];
            }

            $timeframe = $end_time->getTimestamp() - $start_time->getTimestamp();
            if ($timeframe > 0) {
                $data['uptime'] = 100 - (($downtime / $timeframe) * 100);
            }
        }

        $lines_merged = array();
        foreach ($lines as $line_key => $line_value) {
            if (empty($line_value)) {
                continue;
            }
            $lines_merged[$line_key]['value'] = json_encode($line_value);
            $lines_merged[$line_key]['name'] = psm_get_lang('servers', $line_key);
        }

        $n_records = count($records);
        $data['latency_avg'] = $n_records > 0 ? ($latency_avg / $n_records) : 0;
        $data['lines'] = sizeof($lines_merged) ? $lines_merged : '';
        $data['end_timestamp'] = number_format($end_time->getTimestamp(), 0, '', '') * 1000;
        $data['start_timestamp'] = number_format($start_time->getTimestamp(), 0, '', '') * 1000;
        return $data;
    }
}
