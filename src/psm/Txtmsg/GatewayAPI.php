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
 * @author      Ward Pieters <ward@wardpieters.nl>
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

namespace psm\Txtmsg;

class GatewayAPI extends Core {
	
	/**
	* Send sms using GatewayAPI
	* @var string $message
	* @var array $this->recipients
	* @var string $recipient
	* @var string $this->password
	* @var string $this->originator
	* @var int $success
	* @var string $error
	* @return int or string
	*/

	public function sendSMS($message) {
		$sender = $this->originator;
		$apikey = $this->password;
		$userref = $this->userref;
		$destaddr = $this->destaddr;
		$recipients = $this->recipients;
		
		$errors = array();
		
		if(is_null($destaddr)) $destaddr = 'MOBILE';
		if(is_null($userref)) $userref = '';
		
		
		foreach($recipients as $recipient) {
			$json = [
				'sender' => $sender,
				'message' => $message,
				'recipients' => [],
				'destaddr' => $destaddr,
				'userref' => $userref,
			];
			
			$json['recipients'][] = ['msisdn' => $recipient];
			
			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL, "https://gatewayapi.com/rest/mtsms");
			curl_setopt($ch,CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
			curl_setopt($ch,CURLOPT_USERPWD, $apikey.":");
			curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($json));
			curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
			
			$result = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			
			$result = json_decode($result,true);
			$addidtional_information = array();
			foreach($result as $key => $value) { if($key != 'ids') $addidtional_information[$key] = $value; }
			
			if($httpcode == 200) {
				// SMS is gelukt
				$output = array('success' => true, 'ids' => $result['ids'], 'addidtional_information' => $addidtional_information);
			}
			else {
				// SMS is niet gelukt
				$output = array('success' => false, 'code' => $result['code'], 'message' => $result['message'], 'variables' => $result['variables']);
				array_push($errors, $output);
			}
		}
		if(!empty($errors)) return false;
		else return true;
	}
}
