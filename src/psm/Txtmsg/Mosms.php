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

class Mosms extends Core {

	/**
	* Send sms using the GatewayAPI API
	* @var string $message
	* @var array $this->username
	* @var string $this->password
	* @var array $this->recipients
	* @var array $this->originator (Max 11 characters)
	* @var int $success
	* @var string $error
	* @return int or string
	*/
	public function sendSMS($message) {
		$error = "";
		$success = 0;
		
		$API_URL = "https://www.mosms.com/se/sms-send.php";
		$message = rawurlencode($message);
		
		foreach($this->recipients as $phone) {
			$result = file_get_contents($API_URL . "?username=" . $this->username . "&password=" . $this->password . "&customsender=" . $this->originator . "nr=" . $phone . "&type=text&data=" . $message);
			if($result != "0") $error = $result;
			else $success = 1;
		}
		
		if($success) return true;
		else return $error;
	}
}
