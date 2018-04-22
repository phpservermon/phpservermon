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
 * @author      Pepijn Over <pep@mailbox.org>
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

namespace psm\Txtmsg;

class Clickatell extends Core {
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
		//$message MUST BE urlencode or it will send only part message (first word in most cases)
		$recipients = implode(',', $this->recipients);
		//example: https://api.clickatell.com/http/sendmsg?user=XXXXXX&password=PASSWORD&api_id=111111&to=11111111&text=Message
		//YOU MUST MANUALLY CHANGE THE VALUE OF 'api_id' EX: '&api_id=' . '1234567'
		$result = $this->_auth_https_post('api.clickatell.com', '/http/sendmsg',
			'?user=' . $this->username .
			'&password=' . $this->password .
			'&to=' . $recipients .
			'&api_id=' . 'XXXXXX' .
			'&text=' . substr(urlencode($message), 0, 153)
		);
		return $result;
	}

	protected function _auth_https_post($host, $path, $data) {
		$url = $host . $path . $data;
		return psm_curl_get($url);
	}
}
