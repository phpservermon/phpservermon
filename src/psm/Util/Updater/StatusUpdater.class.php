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
	 * Please note: if the server is down but has not met the warning threshold, this will return true
	 * to avoid any "we are down" events.
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
			'server_id', 'ip', 'port', 'label', 'type', 'pattern', 'status', 'rtime', 'active', 'warning_threshold', 'warning_threshold_counter',
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
			case 'ping':
				$this->status_new = $this->updatePing($max_runs);
				break;
		}

		// update server status
		$save = array(
			'last_check' => date('Y-m-d H:i:s'),
			'error' => $this->error,
			'rtime' => $this->rtime,
		);

		// log the uptime before checking the warning threshold,
		// so that the warnings can still be reviewed in the server history.
		psm_log_uptime($this->server_id, (int) $this->status_new, $this->rtime);

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
				$this->status_new = true;
			} else {
				$save['status'] = 'off';
			}
		}

		$this->db->save(PSM_DB_PREFIX . 'servers', $save, array('server_id' => $this->server_id));

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
		
		// Parse a URL and return its components
		$url = parse_url($this->server['ip']);
		
		// Build url
		$this->server['ip'] = $url['scheme'] . '://' . (psm_validate_ipv6($url['host']) ? '['. $url['host'] .']' : $url['host']) . ':'.$this->server['port'] . (isset($url['path']) ? $url['path'] : '') . (isset($url['query']) ? '?'.$url['query'] : '');
		
		/**
		 *
		 * Need php_http.dll extensions but might be a better tool for the job
		 * http://stackoverflow.com/questions/14056977/function-http-build-url
		 
		$this->server['ip'] = http_build_url($this->server['ip'],
			array(
				"scheme" 	=> $url['scheme'],
				"host" 		=> (psm_validate_ipv6($url['host']) ? '['. $url['host'] .']' : $url['host']),
				"port" 		=> $this->server['port'],
				"path" 		=> (isset($url['path']) ? $url['path'] : ''),
				"query" 	=> (isset($url['query']) ? '?'.$url['query'] : '')
			), HTTP_URL_STRIP_AUTH | HTTP_URL_JOIN_PATH | HTTP_URL_JOIN_QUERY | HTTP_URL_STRIP_FRAGMENT);
		*/
		
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
			$this->error = 'No response from server.';
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
	 * Check the current server with a ping and hope to get a pong
	 * @param int $max_runs
	 * @param int $run
	 * @return boolean
	 */
	protected function updatePing($max_runs, $run = 1) {
		$errno		= 0;
		$timeout	= 1;
		$package	= "\x08\x00\x7d\x4b\x00\x00\x00\x00PingHost"; /* ICMP ping packet with a pre-calculated checksum */
		
		// save response time
		$starttime 	= microtime(true);
		
		/** 
		 * Only run if is cron
		 * socket_create() need to run as root :(
		 * ugly cli hack i know
		 * might be a better way still have not found a solution when updating true website
		 */
		if(psm_is_cli()) {		

			// if ipv6 we have to use AF_INET6
			if (psm_validate_ipv6($this->server['ip'])) {
				// Need to remove [] on ipv6 address
				$this->server['ip'] = trim($this->server['ip'], '[]');
				$socket  = socket_create(AF_INET6, SOCK_RAW, 1);
			} else {
				$socket  = socket_create(AF_INET, SOCK_RAW, 1);
			}
			
			socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array('sec' => $timeout, 'usec' => 0));
			socket_connect($socket, $this->server['ip'], null);
			socket_send($socket, $package, strLen($package), 0);
			
			// if ping fails it returns false
			$status = (socket_read($socket, 255)) ? true : false;
			$this->rtime = (microtime(true) - $starttime);
			
			socket_close($socket);
	
			// check if server is available and rerun if asked.
			if(!$status && $run < $max_runs) {
				return $this->updatePing($max_runs, $run + 1);
			}
	
			return $status;
		// If state on last update was 'on' and the update request is comming from the website
		} elseif ($this->server['status'] == 'on') {
			// need to set rtime to the value from last update, if not the latency will be 0
			$this->rtime = $this->server['rtime'];
			$this->error = 'Update skipped, must run from cron script.';
			return true;
		} else {
			return false;
		}
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
