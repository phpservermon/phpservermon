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
 * @author      Victor Macko
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 * @since       phpservermon 3.1
 **/

namespace psm\Txtmsg;

class Smsglobal extends Core {

	/**
	 * Send the SMS message
	 * @param string $message
	 * @return boolean (true = message was sent successfully, false = there was a problem sending the message)
	 */
	public function sendSMS($message) {
		$success = 0;
		$error = "";
		
		if(count($recipients) == 0) return false;
		$recipients = join(',', $this->recipients);
		
		$from = urlencode(substr($this->originator,0 , 11)); // Max 11 Char.
		
		$url = 'https://www.smsglobal.com/http-api.php' .
			'?action=sendsms' .
			'&user=' . $this->username .
			'&password=' . $this->password .
			'&from=' . $from .
			'&to=' . rawurlencode($recipients) .
			'&clientcharset=ISO-8859-1' .
			'&text=' . substr(rawurlencode($message), 0, 153);

		$returnedData = file_get_contents($url);
		if($returnedData == "OK: 0") $success = 1;
		else $error = $returnedData;
		
		if($success) return true;
		else return $error;
	}
}
