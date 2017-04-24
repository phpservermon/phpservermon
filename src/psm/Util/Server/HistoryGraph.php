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
use psm\Service\Database;

/**
 * History util, create HTML for server graphs
 */
class HistoryGraph {

	/**
	 * Database service
	 * @var \psm\Service\Database $db;
	 */
	protected $db;

	/**
	 * Twig environment
	 * @var \Twig_Environment $twig
	 */
	protected $twig;

	function __construct(Database $db, \Twig_Environment $twig) {
		$this->db = $db;
		$this->twig = $twig;
	}

	/**
	 * Prepare the HTML for the graph
	 * @return string
	 */
	public function createHTML($server_id) {
		// Archive all records for this server to make sure we have up-to-date stats
		$archive = new ArchiveManager($this->db);
		$archive->archive($server_id);

		$now = new \DateTime();
		$last_week = new \DateTime('-1 week 0:0:0');
		$last_year = new \DateTime('-1 year -1 week 0:0:0');

		$graphs = array(
			0 => $this->generateGraphUptime($server_id, $last_week, $now),
			1 => $this->generateGraphHistory($server_id, $last_year, $last_week),
		);
		$info_fields = array(
			'latency_avg' => '%01.4f',
			'uptime' => '%01.3f%%',
		);

		foreach($graphs as $i => &$graph) {
			// add subarray for info fields
			$graph['info'] = array();

			foreach($info_fields as $field => $format) {
				if(!isset($graph[$field])) {
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
			'label_server' => psm_get_lang('servers', 'server'),
			'day_format' => psm_get_lang('servers', 'chart_day_format'),
			'long_date_format' => psm_get_lang('servers', 'chart_long_date_format'),
			'short_date_format' => psm_get_lang('servers', 'chart_short_date_format'),
			'short_time_format' => psm_get_lang('servers', 'chart_short_time_format'),
		);

		return $this->twig->render('module/server/history.tpl.html', $tpl_data);
	}

	/**
	 * Generate data for uptime graph
	 * @param int $server_id
	 * @param \DateTime $start_time Lowest DateTime of the graph
	 * @param \DateTime $end_time Highest DateTime of the graph
	 * @return array
	 */
	public function generateGraphUptime($server_id, $start_time, $end_time) {
		$lines = array(
			'latency' => array(),
		);
		$cb_if_up = function($uptime_record) {
			return ($uptime_record['status'] == 1);
		};
		$records = $this->getRecords('uptime', $server_id, $start_time, $end_time);

		$data = $this->generateGraphLines($records, $lines, $cb_if_up, 'latency', $start_time, $end_time, true);

		$data['title'] = psm_get_lang('servers', 'chart_last_week');
		$data['plotmode'] = 'hour';
		$data['buttons'] = array();
		$data['buttons'][] = array('mode' => 'hour', 'label' => psm_get_lang('servers', 'hour'), 'class_active' => 'btn-info');
		$data['buttons'][] = array('mode' => 'day', 'label' => psm_get_lang('servers', 'day'));
		$data['buttons'][] = array('mode' => 'week', 'label' => psm_get_lang('servers', 'week'));
		// make sure to add chart id after buttons so its added to those tmeplates as well
		$data['chart_id'] = $server_id . '_uptime';

		return $data;
	}

	/**
	 * Generate data for history graph
	 * @param int $server_id
	 * @param \DateTime $start_time Lowest DateTime of the graph
	 * @param \DateTime $end_time Highest DateTime of the graph
	 * @return array
	 */
	public function generateGraphHistory($server_id, $start_time, $end_time) {
		$lines = array(
			'latency_avg' => array(),
			'latency_max' => array(),
			'latency_min' => array(),
		);
		$server = $this->db->selectRow(PSM_DB_PREFIX.'servers', array('server_id' => $server_id), array('warning_threshold'));

		$cb_if_up = function($uptime_record) use($server) {
			return ($uptime_record['checks_failed'] < $server['warning_threshold']);
		};
		$records = $this->getRecords('history', $server_id, $start_time, $end_time);

		// dont add uptime for now because we have no way to calculate accurate uptimes for archived records
		$data = $this->generateGraphLines($records, $lines, $cb_if_up, 'latency_avg', $start_time, $end_time, false);

		$data['title'] = psm_get_lang('servers', 'chart_history');
		$data['plotmode'] = 'month';
		$data['buttons'] = array();
		$data['buttons'][] = array('mode' => 'week2', 'label' => psm_get_lang('servers', 'week'));
		$data['buttons'][] = array('mode' => 'month', 'label' => psm_get_lang('servers', 'month'), 'class_active' => 'btn-info');
		$data['buttons'][] = array('mode' => 'year', 'label' => psm_get_lang('servers', 'year'));
		// make sure to add chart id after buttons so its added to those tmeplates as well
		$data['chart_id'] = $server_id . '_history';

		return $data;
	}

	/**
	 * Get all uptime/history records for a server
	 * @param string $type
	 * @param int $server_id
	 * @param \DateTime $start_time Lowest DateTime of the graph
	 * @param \DateTime $end_time Highest DateTime of the graph
	 * @return array
	 */
	protected function getRecords($type, $server_id, $start_time, $end_time) {
		if(!in_array($type, array('history', 'uptime'))) {
			return array();
		}

		$records = $this->db->execute(
			'SELECT *
				FROM `' . PSM_DB_PREFIX . "servers_$type`
				WHERE `server_id` = :server_id AND `date` BETWEEN :start_time AND :end_time ORDER BY `date` ASC",
			array(
				'server_id' => $server_id,
				'start_time' => $start_time->format('Y-m-d H:i:s'),
				'end_time' => $end_time->format('Y-m-d H:i:s'),
			));
		return $records;
	}

	/**
	 * Generate data arrays for graphs
	 * @param array $records all uptime records to parse, MUST BE SORTED BY DATE IN ASCENDING ORDER
	 * @param array $lines array with keys as line ids to prepare (key must be available in uptime records)
	 * @param callable $cb_if_up function to check if the server is up or down
	 * @param string $latency_avg_key which key from uptime records to use for calculating averages
	 * @param \DateTime $start_time Lowest DateTime of the graph
	 * @param \DateTime $end_time Highest DateTime of the graph
	 * @param boolean $add_uptime add uptime calculation?
	 * @return array
	 */
	protected function generateGraphLines($records, $lines, $cb_if_up, $latency_avg_key, $start_time, $end_time, $add_uptime = false) {
		$data = array();

		// PLEASE NOTE: all times are in microseconds! because of javascript.
		$last_date = 0;
		$latency_avg = 0;
		$series = array();
		// number of microseconds of downtime
		$time_down = 0;

		$down = array();

		// Create the list of points and server down zones
		foreach ($records as $uptime) {
			$time = strtotime($uptime['date']) * 1000;

			// use the first line to calculate average latency
			$latency_avg += (float) $uptime[$latency_avg_key];

			if($cb_if_up($uptime)) {
				// The server is up
				foreach($lines as $key => $value) {
					// add the value for each of the different lines
					if(isset($uptime[$key])) {
						$lines[$key][] = '[' . number_format($time, 0, '', '') . ',' . round((float) $uptime[$key], 4) . ']';
					}
				}
				if($last_date) {
					// Was down before.
					// Record the first and last date as a string in the down array
					$down[] = '[' . number_format($last_date, 0, '', '') . ',' . number_format($time, 0, '', '') . ']';
					// add the number of microseconds of downtime to counter for %
					$time_down += ($time - $last_date);
					$last_date = 0;
				}
			} else {
				// The server is down
				if(!$last_date) {
					$last_date = $time;
				}
			}
		}
		$lines_merged = array();

		foreach($lines as $line_key => $line_value) {
			if(empty($line_value)) {
				continue;
			}
			$lines_merged[] = '[' . implode(',', $line_value) . ']';
			$series[] = "{label: '".psm_get_lang('servers', $line_key)."'}";
		}
		if($last_date) {
			// if last_date is still set, the last check was "down" and we are still in down mode
			$down[] = '[' . number_format($last_date, 0, '', '') . ',0]';
			$time_down += (($end_time->getTimestamp() * 1000) - $last_date);
		}

		if($add_uptime) {
			$data['uptime'] = 100 - (($time_down / ($end_time->getTimestamp() - $start_time->getTimestamp())) / 10);
		}

		$data['latency_avg'] = count($records) > 0 ? ($latency_avg / count($records)) : 0;
		$data['server_lines'] = sizeof($lines_merged) ? '[' . implode(',', $lines_merged) . ']' : '';
		$data['server_down'] = sizeof($down) ? '[' . implode(',', $down) . ']' : '';
		$data['series'] = sizeof($series) ? '[' . implode(',', $series) . ']' : '';
		$data['end_timestamp'] = number_format($end_time->getTimestamp() * 1000, 0, '', '');

		return $data;
	}
}
