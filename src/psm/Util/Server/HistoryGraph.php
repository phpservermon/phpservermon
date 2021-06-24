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
use Twig_Environment;

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

    public function __construct(Database $db, Twig_Environment $twig)
    {
        $this->db = $db;
        $this->twig = $twig;
    }

    /**
     * Prepare the HTML for the graph
     * @param string $server_id ID of server to fetch data for
     * @return string Created HTML
     * @throws Error On twig error
     */
    public function createHTML($server_id)
    {
        // Archive all records for this server to make sure we have up-to-date stats
        $archive = new ArchiveManager($this->db);
        $archive->archive($server_id);

        $now = new DateTime();
        $last_week = new DateTime('-1 week 0:0:0');
        $last_year = new DateTime('-1 year -1 week 0:0:0');

        $graphs = array(
            0 => $this->generateGraphUptime($server_id, $last_week, $now),
            1 => $this->generateGraphHistory($server_id, $last_year, $last_week),
        );
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
        return $this->twig->render('module/server/history.tpl.html', $tpl_data);
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

        $lines = array(
            'latency' => array(),
        );

        $hour = new DateTime('-1 hour');
        $day = new DateTime('-1 day');
        $week = new DateTime('-1 week');
        
        $records = $this->getRecords('uptime', $server_id, $start_time, $end_time);

        $data = $this->generateGraphLines($records, $lines, 'latency', $hour, $end_time, true);

        $data['title'] = psm_get_lang('servers', 'chart_last_week');
        $data['id'] = 'history_short';
        $data['unit'] = 'minute';
        $data['buttons'] = array();
        $data['button_name'] = 'timeframe_short';
        $data['buttons'][] = array(
            'unit' => 'minute',
            'time' => $hour->getTimestamp() * 1000,
            'label' => psm_get_lang('servers', 'hour'),
            'class_active' => 'active'
        );
        $data['buttons'][] = array(
            'unit' => 'hour',
            'time' => $day->getTimestamp() * 1000,
            'label' => psm_get_lang('servers', 'day')
        );
        $data['buttons'][] = array(
            'unit' => 'day',
            'time' => $week->getTimestamp() * 1000,
            'label' => psm_get_lang('servers', 'week')
        );

        return $data;
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

        /** @noinspection SqlNoDataSourceInspection */
        /** @noinspection SqlResolve */
        /** @noinspection PhpUndefinedConstantInspection */
        return $this->db->execute(
            "SELECT *, UNIX_TIMESTAMP(CONVERT_TZ(`date`, '+00:00', @@session.time_zone)) AS date_ts
				FROM `" . PSM_DB_PREFIX . "servers_$type`
				WHERE `server_id` = :server_id AND `date` BETWEEN :start_time AND :end_time ORDER BY `date`",
            array(
                'server_id' => $server_id,
                'start_time' => $start_time->format('Y-m-d H:i:s'),
                'end_time' => $end_time->format('Y-m-d H:i:s'),
            )
        );
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

        // PLEASE NOTE: all times are in microseconds! because of javascript.
        $latency_avg = 0;

        /** @var array $prev Previous record */
        $prev = reset($records);

        // Timestamp from last offline record. 0 when last record is up.
        $prev_downtime = 0;
        // Total downtime
        $downtime = 0;

        // The keys of the lines iterated
        $line_keys = array_keys($lines);
        // Determine whether to process data for the short history graph
        $is_short_graph = count($line_keys) === 1 && $line_keys[0] === 'latency';

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
                    $lines['offline'][] = ['x' => $time_ms, 'y' => $highest_latency];

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
                            : ['x' => $time_ms, 'y' => $highest_latency];
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
            $data['uptime'] = 100 - ($downtime / ($end_time->getTimestamp() - $start_time->getTimestamp()));
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
