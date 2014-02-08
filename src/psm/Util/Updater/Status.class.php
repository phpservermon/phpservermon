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
 * @link        http://phpservermon.neanderthal-technology.com/
 **/

namespace psm\Util\Updater;

class Status {
	public $error;
	public $notify;
	public $rtime = 0;
	public $server;
	public $status_org = false;
	public $status_new = false;

	public $db;

	function __construct() {
		// add database handler
		$this->db = $GLOBALS['db'];
	}

	/**
	 * Set a new server
	 *
	 * @param array $server
	 * @param string $status_org either 'on' or 'off'
	 */
	public function setServer($server, $status_org) {
		$this->clearResults();

		$this->server = $server;
		$this->status_org = $status_org;
	}

	/**
	 * Get the new status of the selected server. If the update has not been performed yet it will do so first
	 *
	 * @return string
	 */
	public function getStatus() {
		if(!$this->server) {
			return false;
		}
		if(!$this->status_new) {
			$this->update();
		}
		return $this->status_new;
	}

	/**
	 * The function its all about. This one checks whether the given ip and port are up and running!
	 * If the server check fails it will try one more time
	 *
	 * @param int $max_runs how many times should the script recheck the server if unavailable. default is 2
	 * @return string new status
	 */
	public function update($max_runs = 2) {
		switch($this->server['type']) {
			case 'service':
				$result = $this->updateService($max_runs);
				break;
			case 'website':
				$result = $this->updateWebsite($max_runs);
				break;
		}
		return $result;

	}

	protected function updateService($max_runs, $run = 1) {
		// save response time
		$time = explode(' ', microtime());
		$starttime = $time[1] + $time[0];

		@$fp = fsockopen ($this->server['ip'], $this->server['port'], $errno, $errstr, 10);

		$time = explode(" ", microtime());
		$endtime = $time[1] + $time[0];
		$this->rtime = ($endtime - $starttime);


		$this->status_new = ($fp === false) ? 'off' : 'on';
		$this->error = $errstr;
		// add the error to the server array for when parsing the messages
		$this->server['error'] = $this->error;

		@fclose($fp);

		// check if server is available and rerun if asked.
		if($this->status_new == 'off' && $run < $max_runs) {
			return $this->updateService($max_runs, $run + 1);
		}

		return $this->status_new;
	}

	protected function updateWebsite($max_runs, $run = 1) {
		// save response time
		$time = explode(' ', microtime());
		$starttime = $time[1] + $time[0];

		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_URL, $this->server['ip']);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt ($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt ($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.11) Gecko/20071127 Firefox/2.0.0.11');

		// We're only interested in the header, because that should tell us plenty!
		// unless we have a pattern to search for!
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_NOBODY, ($this->server['pattern'] != '' ? false : true));

		$curl_result = curl_exec ($ch);
		curl_close ($ch);

		$time = explode(" ", microtime());
		$endtime = $time[1] + $time[0];
		$this->rtime = ($endtime - $starttime);

		// the first line would be the status code..
		$status_code = strtok($curl_result, "\r\n");
		// keep it general
		// $code[1][0] = status code
		// $code[2][0] = name of status code
		preg_match_all("/[A-Z]{2,5}\/\d\.\d\s(\d{3})\s(.*)/", $status_code, $code_matches);

		if(empty($code_matches[0])) {
			// somehow we dont have a proper response.
			$this->server['error'] = $this->error = 'no response from server';
			$this->status_new = 'off';
		} else {
			$code = $code_matches[1][0];
			$msg = $code_matches[2][0];

			// All status codes starting with a 4 or higher mean trouble!
			if(substr($code, 0, 1) >= '4') {
				$this->server['error'] = $this->error = $code . ' ' . $msg;
				$this->status_new = 'off';
			} else {
				$this->status_new = 'on';
			}
		}
		if($this->server['pattern'] != '') {
			// Check to see if the pattern was found.
			if(!preg_match("/{$this->server['pattern']}/i", $curl_result)) {
				$this->server['error'] = $this->error = 'Pattern not found.';
				$this->status_new = 'off';
			}
		}

		// check if server is available and rerun if asked.
		if($this->status_new == 'off' && $run < $max_runs) {
			return $this->updateWebsite($max_runs, $run + 1);
		}

		return $this->status_new;
	}

	/**
	 * This function initializes the sending (text msg & email) and logging
	 *
	 */
	public function notify() {
		if(psm_get_conf('email_status') == false && psm_get_conf('sms_status') == false && psm_get_conf('log_status') == false) {
			// seems like we have nothing to do. skip the rest
			return false;
		}
		$notify = false;

		// check which type of alert the user wants
		switch(psm_get_conf('alert_type')) {
			case 'always':
				if($this->status_new == 'off') {
					// server is offline. we are in error state.
					$notify = true;
				}
				break;
			case 'offline':
				// only send a notification if the server goes down for the first time!
				if($this->status_new == 'off' && $this->status_org == 'on') {
					$notify = true;
				}
				break;
			case 'status':
				if($this->status_new != $this->status_org) {
					// status has been changed!
					$notify = true;
				}
				break;
		}

		// first add to log (we use the same text as the SMS message because its short..)
		if(psm_get_conf('log_status')) {
			psm_add_log(
				$this->server['server_id'],
				'status',
				psm_parse_msg($this->status_new, 'sms', $this->server)
			);
		}

		if(!$notify) {
			return false;
		}

		// check if email is enabled for this server
		if(psm_get_conf('email_status') && $this->server['email'] == 'yes') {
			// send email
			$this->notifyByEmail();
		}

		// check if sms is enabled for this server
		if(psm_get_conf('sms_status') && $this->server['sms'] == 'yes') {
			// yay lets wake those nerds up!
			$this->notifyByTxtMsg();
		}
		return true;
	}

	/**
	 * This functions performs the email notifications
	 *
	 * @return boolean
	 */
	protected function notifyByEmail() {
		$userlist = array();

		// find all the users with this server listed
		$users = $this->db->select(
			PSM_DB_PREFIX . 'users',
			'FIND_IN_SET(\''.$this->server['server_id'].'\', `server_id`) AND `email` != \'\'',
			array('user_id', 'name', 'email')
		);

		if (empty($users)) {
			return false;
		}

		// build mail object with some default values
		$mail = new \phpmailer();

		$mail->From		= psm_get_conf('email_from_email');
		$mail->FromName	= psm_get_conf('email_from_name');
		$mail->Subject	= psm_parse_msg($this->status_new, 'email_subject', $this->server);
		$mail->Priority	= 1;

		$body = psm_parse_msg($this->status_new, 'email_body', $this->server);
		$mail->Body		= $body;
		$mail->AltBody	= str_replace('<br/>', "\n", $body);

		// go through empl
	    foreach ($users as $user) {
	    	// we sent a seperate email to every single user.
	    	$userlist[] = $user['user_id'];
	    	$mail->AddAddress($user['email'], $user['name']);
	    	$mail->Send();
	    	$mail->ClearAddresses();
	    }

	    if(psm_get_conf('log_email')) {
	    	// save to log
	    	psm_add_log($this->server['server_id'], 'email', $body, implode(',', $userlist));
	    }
	}

	/**
	 * This functions performs the text message notifications
	 *
	 * @return unknown
	 */
	protected function notifyByTxtMsg() {
		// send sms to all users for this server using defined gateway
		$users = $this->db->select(
			PSM_DB_PREFIX . 'users',
			'FIND_IN_SET(\''.$this->server['server_id'].'\', `server_id`) AND `mobile` != \'\'',
			array('user_id', 'name', 'mobile')
		);

		if (empty($users)) {
			return false;
		}

		// we have to build an userlist for the log table..
		$userlist = array();

		// open the right class
		// not making this any more dynamic, because perhaps some gateways need custom settings (like Mollie)
		switch(strtolower(psm_get_conf('sms_gateway'))) {
			case 'mosms':
				$sms = new \psm\Txtmsg\Mosms();
				break;
			case 'inetworx':
				$sms = new \psm\Txtmsg\Inetworx();
				break;
			case 'mollie':
				$sms = new \psm\Txtmsg\Mollie();
				$sms->setGateway(1);
				break;
			case 'spryng':
				$sms = new \psm\Txtmsg\Spryng();
				break;
			case 'clickatell':
				$sms = new \psm\Txtmsg\Clickatell();
				break;
            case 'textmarketer':
                $sms = new \psm\Txtmsg\Textmarketer();
                break;
		}

		// copy login information from the config file
		$sms->setLogin(psm_get_conf('sms_gateway_username'), psm_get_conf('sms_gateway_password'));
		$sms->setOriginator(psm_get_conf('sms_from'));

		// add all users to the recipients list
		foreach ($users as $user) {
			$userlist[] = $user['user_id'];
			$sms->addRecipients($user['mobile']);
		}

		$message = psm_parse_msg($this->status_new, 'sms', $this->server);

		// Send sms
		$result = $sms->sendSMS($message);

		if(psm_get_conf('log_sms')) {
			// save to log
			psm_add_log($this->server['server_id'], 'sms', $message, implode(',', $userlist));
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

	/**
	 * Clear all the results that are left from the previous run
	 *
	 */
	protected function clearResults() {
		$this->error = '';
		$this->status_org = false;
		$this->status_new = false;
	}
}

?>