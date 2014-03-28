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
 * @copyright   Copyright (c) 2008-2014 Pepijn Over <pep@neanderthal-technology.com>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

/**
 * The status class is for checking the status of a server.
 *
 * @see \psm\Util\Updater\StatusNotifier
 * @see \psm\Util\Updater\Autorun
 */
namespace psm\Util\Updater;
use psm\Service\Database;

class StatusUpdater {
	public $error = '';

	public $rtime = 0;

	public $status_new = false;

	/**
	 * Database service
	 * @var \psm\Service\Database $db
	 */
	protected $db;

	/**
	 * Server id to check
	 * @var int $server_id
	 */
	protected $server_id;

	/**
	 * Server information
	 * @var array $server
	 */
	protected $server;

	function __construct(Database $db) {
		$this->db = $db;
	}

	/**
	 * The function its all about. This one checks whether the given ip and port are up and running!
	 * If the server check fails it will try one more time, depending on the $max_runs.
	 *
	 * @param int $server_id
	 * @param int $max_runs how many times should the script recheck the server if unavailable. default is 2
	 * @return boolean TRUE if server is up, FALSE otherwise
	 */
	public function update($server_id, $max_runs = 2) {
		$this->server_id = $server_id;
		$this->error = '';
		$this->rtime = '';

		// get server info from db
		$this->server = $this->db->selectRow(PSM_DB_PREFIX . 'servers', array(
			'server_id' => $server_id,
		), array(
			'server_id', 'ip', 'port', 'label', 'type', 'pattern', 'status', 'active', 'warning_threshold', 'warning_threshold_counter',
		));
		if(empty($this->server)) {
			return false;
		}

		switch($this->server['type']) {
			case 'service':
				$this->status_new = $this->updateService($max_runs);
				break;
			case 'website':
				$this->status_new = $this->updateWebsite($max_runs);
				break;
		}

		// update server status
		$save = array(
			'last_check' => date('Y-m-d H:i:s'),
			'error' => $this->error,
			'rtime' => $this->rtime,
		);

		if($this->status_new == true) {
			// if the server is on, add the last_online value and reset the error threshold counter
			$save['status'] = 'on';
			$save['last_online'] = date('Y-m-d H:i:s');
			$save['warning_threshold_counter'] = 0;
		} else {
			// server is offline, increase the error counter
			$save['warning_threshold_counter'] = $this->server['warning_threshold_counter'] + 1;

			if($save['warning_threshold_counter'] < $this->server['warning_threshold']) {
				// the server is offline but the error threshold has not been met yet.
				// so we are going to leave the status "on" for now while we are in a sort of warning state..
				$save['status'] = 'on';
			} else {
				$save['status'] = 'off';
			}
		}

		$this->db->save(PSM_DB_PREFIX . 'servers', $save, array('server_id' => $this->server_id));
		psm_log_uptime($this->server_id, (int) $this->status_new, $this->rtime);

		return $this->status_new;

	}

	/**
	 * Check the current server as a service
	 * @param int $max_runs
	 * @param int $run
	 * @return boolean
	 */
	protected function updateService($max_runs, $run = 1) {
		$errno = 0;
		// save response time
		$starttime = microtime(true);

		$fp = fsockopen ($this->server['ip'], $this->server['port'], $errno, $this->error, 10);

		$status = ($fp === false) ? false : true;
		$this->rtime = (microtime(true) - $starttime);

		fclose($fp);

		// check if server is available and rerun if asked.
		if(!$status && $run < $max_runs) {
			return $this->updateService($max_runs, $run + 1);
		}

		return $status;
	}

	/**
	 * Check the current server as a website
	 * @param int $max_runs
	 * @param int $run
	 * @return boolean
	 */
	protected function updateWebsite($max_runs, $run = 1) {
		$starttime = microtime(true);

		// We're only interested in the header, because that should tell us plenty!
		// unless we have a pattern to search for!
		$curl_result = psm_curl_get(
			$this->server['ip'],
			true,
			($this->server['pattern'] == '' ? false : true)
		);

		$this->rtime = (microtime(true) - $starttime);

		// the first line would be the status code..
		$status_code = strtok($curl_result, "\r\n");
		// keep it general
		// $code[1][0] = status code
		// $code[2][0] = name of status code
		$code_matches = array();
		preg_match_all("/[A-Z]{2,5}\/\d\.\d\s(\d{3})\s(.*)/", $status_code, $code_matches);

		if(empty($code_matches[0])) {
			// somehow we dont have a proper response.
			$this->error = 'no response from server';
			$result = false;
		} else {
			$code = $code_matches[1][0];
			$msg = $code_matches[2][0];

			// All status codes starting with a 4 or higher mean trouble!
			if(substr($code, 0, 1) >= '4') {
				$this->error = $code . ' ' . $msg;
				$result = false;
			} else {
				$result = true;
			}
		}
		if($this->server['pattern'] != '') {
			// Check to see if the pattern was found.
			if(!preg_match("/{$this->server['pattern']}/i", $curl_result)) {
				$this->error = 'Pattern not found.';
				$result = false;
			}
		}

		// check if server is available and rerun if asked.
		if(!$result && $run < $max_runs) {
			return $this->updateWebsite($max_runs, $run + 1);
		}

		return $result;
	}

	/**
	 * Get the error returned by the update function
	 *
	 * @return string
	 */
	public function getError() {
		return $this->error;
	}

	/**
	 * Get the response time of the server
	 *
	 * @return string
	 */
	public function getRtime() {
		return $this->rtime;
	}
}
