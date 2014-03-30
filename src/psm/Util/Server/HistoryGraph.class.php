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
 *              Pepijn Over <pep@neanderthal-technology.com>
 * @copyright   Copyright (c) 2008-2014 Pepijn Over <pep@neanderthal-technology.com>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

namespace psm\Util\Server;
use psm\Service\Database;
use psm\Service\Template;

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
	 * Template service
	 * @var \psm\Service\Template $tpl
	 */
	protected $tpl;

	function __construct(Database $db, Template $tpl) {
		$this->db = $db;
		$this->tpl = $tpl;
	}

	/**
	 * Prepare the HTML for the graph
	 * @return string
	 */
	public function createHTML($server_id) {
		$tpl_id = 'server_history';
		$this->tpl->newTemplate($tpl_id, 'server/history.tpl.html');

		$graphs = array(
			0 => $this->generateGraphUptime($server_id),
			1 => $this->generateGraphHistory($server_id),
		);
		$this->tpl->addTemplateDataRepeat($tpl_id, 'graphs', $graphs);

		$this->tpl->addTemplateData(
			$tpl_id,
			array(
				'label_server' => psm_get_lang('servers', 'server'),
				'label_latency_avg' => psm_get_lang('servers', 'latency_avg'),
				'day_format' => psm_get_lang('servers', 'chart_day_format'),
				'long_date_format' => psm_get_lang('servers', 'chart_long_date_format'),
				'short_date_format' => psm_get_lang('servers', 'chart_short_date_format'),
				'short_time_format' => psm_get_lang('servers', 'chart_short_time_format'),
			)
		);

		return $this->tpl->getTemplate($tpl_id);
	}

	/**
	 * Generate data for uptime graph
	 * @param int $server_id
	 * @return array
	 */
	protected function generateGraphUptime($server_id) {
		$uptimes = $this->db->select(PSM_DB_PREFIX.'servers_uptime' , array('server_id' => $server_id), null, '', 'date');
		$last_date = 0;
		$latency_avg = 0;
		// Create the list of points and server down zones
		$line = array();
		$lines = array();
		$down = array();
		foreach ($uptimes as $uptime) {
			$latency_avg += (float) $uptime['latency'];

			$time = strtotime($uptime['date']) * 1000;
			if($uptime['status']) {
				// The server is up
				$line[] = '[' . $time . ',' . round((float)$uptime['latency'], 4) . ']';
				if($last_date) {
					// Was down before.
					// Record the first and last date as a string in the down array
					$down[] = '[' . $last_date . ',' . $time . ']';
					$last_date = 0;
				}
			}
			else {
				if(!$last_date) {
					$last_date = $time;
				}
			}
		}
		if(!empty($line)) {
			$lines[] = '[' . implode(',', $line) . ']';
		}
		if($last_date) {
			$down[] = '[' . $last_date . ',0]';
		}
		$buttons = array();
		$buttons[] = array('mode' => 'hour', 'label' => psm_get_lang('servers', 'hour'), 'class_active' => 'btn-info');
		$buttons[] = array('mode' => 'day', 'label' => psm_get_lang('servers', 'day'));
		$buttons[] = array('mode' => 'week', 'label' => psm_get_lang('servers', 'week'));

		$data = array(
			'title'	=> psm_get_lang('servers', 'chart_last_week'),
			'latency_avg' => count($uptimes) > 0 ? round(($latency_avg / count($uptimes)), 4) : 0,
			'server_lines'	=> sizeof($lines) ? '[' . implode(',', $lines) . ']' : '',
			'server_down'	=> sizeof($down) ? '[' . implode(',', $down) . ']' : '',
			'series' => "[{label: '".psm_get_lang('servers', 'latency')."', lineWidth: 1}]",
			'plotmode' => 'hour',
			'buttons' => $buttons,
			'chart_id' => $server_id . '_uptime',
		);
		return $data;
	}

	/**
	 * Generate data for history graph
	 * @param int $server_id
	 * @return array
	 */
	protected function generateGraphHistory($server_id) {
		$uptimes = $this->db->select(PSM_DB_PREFIX.'servers_history' , array('server_id' => $server_id), null, '', 'date');

		$last_date = 0;
		// Create the list of points and server down zones
		$lines = array(
			'latency_avg' => array(),
			'latency_max' => array(),
			'latency_min' => array(),
		);
		$latency_avg = 0;
		$series = array();
		$time_end = 0;

		$down = array();
		foreach ($uptimes as $uptime) {
			$time = strtotime($uptime['date']) * 1000;
			// keep track of highest timestamp to use as end-date for graphs
			if($time > $time_end) {
				$time_end = $time;
			}
			$latency_avg += (float) $uptime['latency_avg'];

			if($uptime['checks_failed'] == 0) {
				// The server is up
				foreach($lines as $key => &$value) {
					// add the value for each of the different lines
					if(isset($uptime[$key])) {
						$value[] = '[' . $time . ',' . round((float)$uptime[$key], 4) . ']';
					}
				}
				if($last_date) {
					// Was down before.
					// Record the first and last date as a string in the down array
					$down[] = '[' . $last_date . ',' . $time . ']';
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
			if(empty($value)) {
				continue;
			}
			$lines_merged[] = '[' . implode(',', $line_value) . ']';
			$series[] = "{label: '".psm_get_lang('servers', $line_key)."', lineWidth: 1}";
		}
		if($last_date) {
			$down[] = '[' . $last_date . ',0]';
		}
		$buttons = array();
		$buttons[] = array('mode' => 'week', 'label' => psm_get_lang('servers', 'week'));
		$buttons[] = array('mode' => 'month', 'label' => psm_get_lang('servers', 'month'), 'class_active' => 'btn-info');
		$buttons[] = array('mode' => 'year', 'label' => psm_get_lang('servers', 'year'));

		$data = array(
			'title'	=> psm_get_lang('servers', 'chart_history'),
			'latency_avg' => count($uptimes) > 0 ? round(($latency_avg / count($uptimes)), 4) : 0,
			'server_lines'	=> sizeof($lines_merged) ? '[' . implode(',', $lines_merged) . ']' : '',
			'server_down'	=> sizeof($down) ? '[' . implode(',', $down) . ']' : '',
			'series' => sizeof($series) ? '[' . implode(',', $series) . ']' : '',
			'plotmode' => 'month',
			'end_timestamp' => $time_end,
			'buttons' => $buttons,
			// make sure to add chart id after buttons so its added to those tmeplates as well
			'chart_id' => $server_id . '_history',
		);
		return $data;
	}
}