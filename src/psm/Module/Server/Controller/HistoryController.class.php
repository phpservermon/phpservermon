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
 * @author      Pepijn Over <pep@neanderthal-technology.com>
 *				History module : Jérôme Cabanis <http://lauraly.com>
 * @copyright   Copyright (c) 2008-2014 Pepijn Over <pep@neanderthal-technology.com>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

namespace psm\Module\Server\Controller;
use psm\Service\Database;
use psm\Service\Template;

/**
 * History module. Create the page to view server history
 */
class HistoryController extends AbstractServerController {

	function __construct(Database $db, Template $tpl) {
		parent::__construct($db, $tpl);

		$this->setActions('index', 'index');
	}

	/**
	 * Prepare the template with a list of all log entries
	 */
	protected function executeIndex() {
		$this->setTemplateId('history_list', 'history.tpl.html');
		
		// get the active servers from database
		$servers = $this->getServers();

		$data = array();
		foreach ($servers as $server) {
			if($server['active'] == 'no') {
				continue;
			}
			
			$server_id = $server['server_id'];
			$uptimes = $this->getServerUptime($server_id);
			$last_date = 0;
			$last_status = 0;
			// Create the list of points and server down zones
			$line = array();
			$lines = array();
			$down = array();
			foreach ($uptimes as $uptime) {
				$time = strtotime($uptime['date']) * 1000;
				if($uptime['status']) {
					// The server is up
					$line[] = '[' . $time . ',' . round((float)$uptime['latency'], 3) . ']';
					if($last_date) {		
						// Was down before.
						// Record the first and last date as a string in the down array
						$down[] = '[' . $last_date . ',' . $time . ']';
						$last_date = 0;
					}
					$last_status = 1;
				}
				else {
					// The server is down
					if($last_status) {
						// If was up before, record la line as string in the lines array
						$lines[] = '[' . implode(',', $line) . ']';
						$line = array();
						$last_status = 0;
					}
					if(!$last_date) {
						$last_date = $time;
					}
				}
			}
			if($last_status) {
				$lines[] = '[' . implode(',', $line) . ']';
			}
			if($last_date) {
				$down[] = '[' . $last_date . ',0]';
			}
			$data[] = array(
				'server_id'		=> $server_id,
				'server_name'	=> $server['label'],
				'server_lines'	=> sizeof($lines) ? '[' . implode(',', $lines) . ']' : '',
				'server_down'	=> sizeof($down) ? '[' . implode(',', $down) . ']' : '',
				'server_online'	=> $server['last_online'],
				'server_rtime'	=> round((float)$server['rtime'], 3),
			);
		}

		$this->tpl->addTemplateDataRepeat($this->getTemplateId(), 'servers', $data);
	}
	
	
	// override parent::createHTMLLabels()
	protected function createHTMLLabels() {
		$this->tpl->addTemplateData(
			$this->getTemplateId(),
			array(
				'subtitle' => psm_get_lang('menu', 'server_history'),
				'label_server' => psm_get_lang('servers', 'server'),
				'label_last_online' => psm_get_lang('servers', 'last_online'),
				'label_rtime' => psm_get_lang('servers', 'rtime'),
				'label_month' => psm_get_lang('servers', 'month'),
				'label_week' => psm_get_lang('servers', 'week'),
				'label_day' => psm_get_lang('servers', 'day'),
				'label_hour' => psm_get_lang('servers', 'hour'),
			)
		);

		return parent::createHTMLLabels();
	}
}