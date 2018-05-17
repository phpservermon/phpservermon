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
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

namespace psm\Txtmsg;

class Callr extends Core {
	// =========================================================================
	// [ Fields ]
	// =========================================================================
	public $gateway = 1;
	public $resultcode = null;
	public $resultmessage = null;
	public $success = false;
	public $successcount = 0;

	// =========================================================================
	// [ Methods ]
	// =========================================================================
	public function setGateway($gateway) {
		$this->gateway = $gateway;
	}

	public function sendSMS($message) {
		//api stuff here
		$api		= new \CALLR\API\Client;
		$api->setAuth(new CALLR\API\Authentication\LoginPasswordAuth($this->username, $this->password));

		$options					= new stdClass;
		$options->force_encoding	= 'GSM';
		$options->nature			= 'ALERTING';
		$options->flash_message		= false;//set to true if you don't want the SMS to be stored on the phone

		try {
			foreach($this->recipients as $recipient) {
				$api->call('sms.send', [$this->originator, $recipient, $message, $options]);
			}			
			return 1;
		} catch(Exception $e){			
			if($e->getCode() == 22){
				return "Exception: Authentication failure\r\n";
			} else {
				return $e->getMessage();
			}
		}
	}
}
