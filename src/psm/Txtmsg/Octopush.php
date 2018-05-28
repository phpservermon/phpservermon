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
 * @package		phpservermon
 * @author		Alexis Urien
 * @author		Ward Pieters <ward@wardpieters.nl>
 * @copyright	Copyright (c) 2016 Alexis Urien <alexis.urien@free.fr>
 * @license		http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version		Release: @package_version@
 * @link		http://www.phpservermonitor.org/
 * @since		phpservermon 2.1
 **/

namespace psm\Txtmsg;

class Octopush extends Core {
	
	/**
	* Send sms using the Octopush API
	* @var string $message
	* @var string $this->password
	* @var array $this->recipients
	* @var array $this->originator
	*
	* @var resource $curl
	* @var SimpleXMLElement $xmlResults
	* @var string $err
	* @var string $recipient
	* @var boolean $premium_sms
	* @var string $sms_type
	* @var string $result
	* @var int $success
	* @var string $error
	*
	* @return int or string
	*/
	
	public function sendSMS($message) {
		$error = "";
		$success = 1;
		
		if(empty($this->recipients)) return false;
		$recipients = join(',', $this->recipients);
		
		$premium_sms = false;
		//FR = premium, WWW = world, XXX = Low cost
		
		$message = urlencode($message);
		
		if($premium_sms) {
			$sms_type = "FR";
			$message.= PHP_EOL . "STOP au XXXXX";
		}
		else $sms_type = "XXX";
		
		$curl = curl_init();
		curl_setopt($curl,CURLOPT_URL, "http://www.octopush-dm.com/api/sms/?" . http_build_query(
				array(
					"user_login" => $this->username,
					"api_key" => $this->password,
					"sms_recipients" => $recipients,
					"sms_type" => $sms_type,
					"sms_sender" => substr($this->originator, 0, 11),
					"sms_text" => $message,
				)
			)
		);
		curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
		
		$result = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		
		if($err) {
			$success = 0;
			$error = "cURL Error";
		}
		else {
			$xmlResults = simplexml_load_string($result);
			if($xmlResults === false) $success = 0;
			if($xmlResults->error_code != '000') $error = $xmlResults->error_code;
		}
		
		if($success) return 1;
		return $error;
	}
}