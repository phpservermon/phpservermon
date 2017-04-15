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

class Inetworx extends Core {
	// =========================================================================
	// [ Fields ]
	// =========================================================================

	// =========================================================================
	// [ Methods ]
	// =========================================================================

	/**
	 * Send a text message to one or more recipients
	 *
	 * @param string $subject
	 * @param string $body
	 * @return boolean
	 */
	public function sendSMS($message) {

		if(empty($this->recipients)) {
			return false;
		}

		$errors = 0;

		foreach($this->recipients as $receiver) {
			if(!$this->executeSend($message, $receiver, $this->originator)) {
				$errors++;
			}
		}
		$this->recipients = array();

		return ($errors > 0) ? false : true;
	}

	/**
	 * Performs the actual send operation
	 *
	 * @param string $subject
	 * @param string $body
	 * @param string $receiver
	 * @param string $sender
	 * @return unknown
	 */
	protected function executeSend($message, $receiver, $sender) {
		$con_https[0] = 'sms.inetworx.ch';
		$con_https[1] = '443';
		$con_https[2] = 'inetworxag:conn2smsapp';
		$posturl      = "/smsapp/sendsms.php";

		if(!empty($receiver)) {
			$postvars = 'user=' . urlencode($this->username) .
						'&pass=' . urlencode($this->password) .
						'&sender=' . urldecode($sender) .
						'&rcpt=' . urlencode($receiver) .
						'&msgbody=' . urlencode($message)
			;
			//if enabled, it sends a flash-message (not stored in Inbox!!)
			//$postvars .= "&mclass=1";

			$rtnval = $this->_auth_https_post(array($con_https[0], $con_https[1], $con_https[2], $posturl, $postvars));

			return $rtnval;
			//echo "SMS-Send-Result: $rtnval";
		} else {
			return false;
		}
	}

	protected function _auth_https_post($inarray) {
		// AUTH_HTTPS_POST: Request POST URL using basic authentication and SSL.
		// Input: inarray[0]: host name
		//        inarray[1]: service port
		//        inarray[2]: user/password
		//        inarray[3]: URL request
		//        inarray[4]: POST variables
		// Output: Message returned by server.

		// Build the header.
		$header = "POST ".$inarray[3]." HTTP/1.0\r\n";
		$header .= "Authorization: Basic ".base64_encode("$inarray[2]")."\r\n";
		$header .= "Host: ".$inarray[0]."\r\n";
		$header .= "Content-type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-length: ".strlen($inarray[4])."\r\n\r\n";
		// Connect to the server.
		$connection = fsockopen("ssl://".$inarray[0], $inarray[1], $errnum, $errdesc, 10);
		$msg = "";
		if (! $connection){
		  $msg = $errdesc." (".$errnum.")";
		}
		else
		{
			socket_set_blocking($connection,false);
			fputs($connection,$header.$inarray[4]);
			while (! feof($connection))
			{
				$newline = fgets($connection,128);
				switch ($newline)
				{
					// Skip http headers.
					case (strstr($newline, 'Content-')): break;
					case (strstr($newline, 'HTTP/1')): break;
					case (strstr($newline, 'Date:')): break;
					case (strstr($newline, 'Server:')): break;
					case (strstr($newline, 'X-Powered-By:')): break;
					case (strstr($newline, 'Connection:')): break;
					case "": break;
					case "\r\n": break;
					default: $msg .= $newline;
			   } //end switch
			} //end while
		  fclose($connection);
		} //end else
		return $msg;
	} //end function auth_https_post

}
