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
 * @author      Ward Pieters <ward@wardpieters.nl>
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

namespace psm\Txtmsg;

class Inetworx extends Core {
	
	/**
	* Send sms using the Inetworx API
	*
	* @var string $message
	* @var string $this->password
	* @var array $this->recipients
	* @var array $this->originator
	*
	* @var resource $curl
	* @var string $err
	* @Var string $recipient
	* @var int $success
	* @var string $error
	*
	* @return int or string
	*/
	
	public function sendSMS($message) {
		$error = "";
		$success = 1;
		
		if(empty($this->recipients)) return false;
		
		foreach($this-recipients as $recipient) {
			$curl = curl_init();
			
			curl_setopt_array($curl, array(
				CURLOPT_URL => "https://sms.inetworx.ch/smsapp/sendsms.php",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => http_build_query(
					array(
						"user" => $this->username,
						"pass" => $this->password,
						"sender" => $this->originator,
						"rcpt" => $recipient,
						"msgbody" => $message,
					)
				),
				CURLOPT_HTTPHEADER => array(
					"authorization: Basic " . base64_encode("inetworxag:conn2smsapp"),
					"content-type: application/x-www-form-urlencoded"
				),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);

			if($err) {
				$success = 0;
				$error = "cURL Error";
			}
			elseif(1 ==1) {
				//Inetworx logic (I can't access their API or their documentation, nor was this ever used somewhere)
			}
		}
		
		if($success) return 1;
		return $error;
	}
}