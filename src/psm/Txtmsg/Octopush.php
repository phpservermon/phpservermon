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
		
		$recipients = join(',', $this->recipients);
		
		$message = urlencode($message);
		
		$curl = curl_init();
		curl_setopt($curl,CURLOPT_URL, "http://www.octopush-dm.com/api/sms/?" . http_build_query(
				array(
					"user_login" => $this->username,
					"api_key" => $this->password,
					"sms_recipients" => $recipients,
					"sms_type" => "XXX", //FR = premium, WWW = world, XXX = Low cost
					"sms_sender" => substr($this->originator, 0, 11),
					"sms_text" => $message,
				)
			)
		);
		curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
		
		$result = curl_exec($curl);
		$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		$xmlResults = simplexml_load_string($result);

		if($err = curl_errno($curl) || $httpcode != 200 || $xmlResults === false || $xmlResults->error_code != '000') {
			$success = 0;
			$error = "HTTP_code: ".$httpcode.".\ncURL error (".$err."): ".curl_strerror($err).". \nResult: ".$xmlResults->error_code.". Look at http://www.octopush-dm.com/en/errors for the error description.";
		}
		curl_close($curl);
		
		if($success) return 1;
		return $error;
	}
}
