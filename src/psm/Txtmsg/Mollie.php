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

class Mollie extends Core {
	// =========================================================================
	// [ Fields ]
	// =========================================================================
	public $gateway	  	= 1;
	public $success	  	= false;
	public $reference    = '';

	// =========================================================================
	// [ Methods ]
	// =========================================================================
	/**
	 * Select the gateway to use
	 *
	 * @param unknown_type $gateway
	 */
	public function setGateway($gateway) {
		$this->gateway = $gateway;
	}

	public function setReference ($reference) {
	  $this->reference = $reference;
	}

	/**
	 * Send a text message to one or more recipients
	 *
	 * @param string $subject
	 * @param string $body
	 * @return boolean
	 */
	public function sendSMS($message) {
		$recipients = implode(',', $this->recipients);

		$result = $this->_auth_https_post('api.messagebird.com', '/xml/sms/',
							 		'gateway='.urlencode($this->gateway).
							 		'&username='.urlencode($this->username).
							 		'&password='.urlencode($this->password).
							 		'&originator='.urlencode($this->originator).
							 		'&recipients='.urlencode($recipients).
							 		'&message='.urlencode($message) .
							 		(($this->reference != '') ? '&reference='.$this->reference : '')
							 		);

		$this->recipients = array();

		list($headers, $xml) = preg_split("/(\r?\n){2}/", $result, 2);
		$data = simplexml_load_string($xml);

		$this->success = ($data->item->success == 'true');
		return $this->success;
	}

	protected function _auth_https_post($host, $path, $data) {
		$fp  = @fsockopen($host,80);
		$buf = '';
		if ($fp) {
			@fputs($fp, "POST $path HTTP/1.0\n");
			@fputs($fp, "Host: $host\n");
			@fputs($fp, "Content-type: application/x-www-form-urlencoded\n");
			@fputs($fp, "Content-length: " . strlen($data) . "\n");
			@fputs($fp, "Connection: close\n\n");
			@fputs($fp, $data);
			while (!feof($fp)) {
			  $buf .= fgets($fp,128);
			}
			fclose($fp);
		}
		return $buf;
	}
}
