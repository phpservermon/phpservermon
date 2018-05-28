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
 * @author      Perri Vardy-Mason
 * @author      Tim Zandbergen <Tim@Xervion.nl>
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 * @since       phpservermon 2.1
 **/

namespace psm\Txtmsg;

class GatewayAPI extends Core {

	/**
	* Send sms using the GatewayAPI API
	*
	* @var string $message
	* @var string $this->password
	* @var array $this->recipients
	* @var array $this->originator
	* @Var string $recipient
	*
	* @var resource $curl
	* @var string $err
	* @var int $success
	* @var string $error
	*
	* @return int or string
	*/
	
	public function sendSMS($message) {
		$error = "";
		$success = 1;
		
		if(empty($this->recipients)) return false;
		
		$json = [
			'sender' => isset($this->originator) ? $this->originator : "PHPServerMon",
			'message' => $message,
			'recipients' => [],
		];
		
		foreach($this->recipients as $recipient) {
			$json['recipients'][] = ['msisdn' => $recipient];
		}
		
		$curl = curl_init();
		curl_setopt($curl,CURLOPT_URL, "https://gatewayapi.com/rest/mtsms");
		curl_setopt($curl,CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
		curl_setopt($curl,CURLOPT_USERPWD, $this->password . ":");
		curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($json));
		curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
		
		$result = json_decode(curl_exec($curl),true);
		$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		$err = curl_error($curl);
		curl_close($curl);
		
		if($err) {
			$success = 0;
			$error = "cURL Error";
		}
		elseif($httpcode != 200) {
			$success = 0;
			$error = $result['code']." - ".$result['message'];
		}
		
		if($success) return 1;
		return $error;
	}
}
