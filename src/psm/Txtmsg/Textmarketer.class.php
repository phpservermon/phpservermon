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
 * @copyright   Copyright (c) 2008-2015 Pepijn Over <pep@peplab.net>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 * @since       phpservermon 2.1
 **/

namespace psm\Txtmsg;

class Textmarketer extends Core {
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

        $containsLetter  = preg_match('/[a-zA-Z]/', $this->originator);
        $containsSpecial = preg_match('/[^a-zA-Z\d]/', $this->originator);

        if ($containsLetter || $containsSpecial) {  // 11 Alphanumeric, 16 for just numbers
            $from = urlencode(substr($this->originator, 0, 11));
        }
        else {
            $from = urlencode(substr($this->originator, 0, 16));
        }

        $url = "https://api.textmarketer.co.uk/gateway/" . 
               "?username=" . $this->username . 
               "&password=" . $this->password . 
               "&to=" . rawurlencode($recipients) . 
               "&message=" . urlencode( $message ) . 
               "&orig=" . $from;
        $result = file_get_contents( $url );
        $isOk = strpos($result, 'SUCCESS') !== false;
        if(!$isOk) {
            $result = trim(str_replace("\n", " ", str_replace("\r", " ", $result)));
            error_log("SMS API Error: '".$result."'", E_USER_NOTICE);
        }
        return $isOk;
    }
}
