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
	// =========================================================================
	// [ Fields ]
	// =========================================================================
	public $gateway = 1;
	public $resultcode = null;
	public $resultmessage = null;
	public $success = false;
	public $successcount = 0;

	/**
	 * Send the SMS message
	 * @param string $message
	 * @return boolean (true = message was sent successfully, false = there was a problem sending the message)
	 */
	public function sendSMS($message) {
		$recipients = join(',', $this->recipients);

		if(count($recipients) == 0) {
			return false;
		}
		/**
		 * Documentation is here: http://www.smsglobal.com/http-api/
		 * Recipient numbers should be in the MSIDSN format (eg. 61400111222). The '+' sign should not be included before the country code.
		 */

		$from = urlencode(substr($this->originator,0 , 11)); // Max 11 Char.

		$url = 'http://www.smsglobal.com/http-api.php' .
			'?action=sendsms' .
			'&user=' . $this->username .
			'&password=' . $this->password .
			'&from=' . $from .
			'&to=' . rawurlencode($recipients) .
			'&clientcharset=ISO-8859-1' .
			'&text=' . substr(rawurlencode($message), 0, 153);

		$returnedData = file_get_contents($url);
		$isOk = strpos($returnedData, 'OK: 0') !== false;

		$this->success = $isOk;
		$this->resultmessage = $returnedData;

		if(!$isOk) {
			error_log($this->resultmessage, E_USER_NOTICE);
		}

		return $isOk;
	}
}
