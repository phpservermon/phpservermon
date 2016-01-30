<?php
/**
 * Mobile Carrier SMS gateway Add-On for PHP Server Monitor
 *
 * This file is an Add-On for PHP Server Monitor.
 * http://www.phpservermonitor.org/
 *
 * This Add-On is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This Add-On is is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You review a copy of the GNU General Public License here:
 * <http://www.gnu.org/licenses/>.
 *
 * Determining your mobile device email address:
 * 	1.  Send a text message from your mobile device to an email account.
 * 			The "From" address in the email should be your device's gateway email address.
 *
 * 	2.	A well maintained "Email-To-SMS Database" of mobile carrier gateways is
 * 			available at "http://avtech.com/Support/Email/index.htm"
 *
 * @author      Glen Arason
 * @copyright   Copyright (c) 2015 ITIStudios
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: v2.0.0
 * @link        http://www.canadiandomainregistry.ca
 *
 */

namespace psm\Txtmsg;

class CarrierSMS extends Core {
	// =========================================================================
	// [ Fields ]
	// =========================================================================
	public $gateway = 0;
	public $resultcode = 0;
	public $resultmessage = "";
	public $success = false;
	public $successcount = 0;

	public function sendSMS($status,$server='') {
		// Create new mail object
		$mailObj = psm_build_mail();

		// Set some email headers
		$mailObj->XMailer  = "SMS";
		$mailObj->AltBody  = null;    // if not null a multi-part message is created.

		// Check and assign From address.
		// "$this->originator" is any valid email address entered in the SMS "Sender's phone number"
		// field and can be used as the "From:" email address for the sms text message.
		// Rem: phpmailer ValidateAddress() is buggy so I'm using php's filter_var() instead.
		$from = filter_var(strtolower($this->originator), FILTER_VALIDATE_EMAIL);
		if( $from === false ) { // Get "Email From" address
			$from = filter_var(strtolower(psm_get_conf('email_from_email')), FILTER_VALIDATE_EMAIL);
		}

		if(is_bool($status) && is_array($server)){ // If Not a "Test" message.
			$br = array('<br />','<br/>'); $nl = "\n";
			// Available message length = +/- 155 minus (from email address length) minus (subject length)
			$Body    = psm_parse_msg($status, "carrier", $server);
			$Subject = psm_parse_msg($status, "carrier_subject", $server);

			// The txt message must have new lines not line breaks.
			$Body    = str_replace($br,$nl, $Body);
			$Subject = str_replace($br,$nl, $Subject);

			// User configureable log entries
			$logMsg = psm_parse_msg($status, "carrier_log", $server);
			$this->resultmessage = $logMsg;

			$mailObj->Body = $Body;
			$mailObj->Subject = $Subject;

			foreach($this->recipients as $value) {
				$to = filter_var(strtolower($value), FILTER_VALIDATE_EMAIL);
				// XOR result codes for potential future use.
				if(!$from)       $this->resultcode = 1;
				if(!$to)         $this->resultcode = 2;
				if($from == $to) $this->resultcode = 4;

				if(!$this->resultcode) {
					if( !$mailObj->SetFrom($from,"",false) ){ $this->resultcode = 8; }
					else if( !$mailObj->AddAddress($to) ){ $this->resultcode = 16; }
					else{
						if(!$mailObj->Send()){ $this->resultcode = 32; }
						$mailObj->ClearAddresses();
					}
				}
				switch ($this->resultcode) {
					case 0: $this->success = true; $this->successcount +=1; break;
					case 1:
					case 8: $this->resultmessage = psm_get_lang('users', 'error_carriersms_from_email_invalid')               . $logMsg; break;
					case 2: $this->resultmessage = psm_get_lang('users', 'error_carriersms_to_email_invalid') . " ($to) "     . $logMsg; break;
					case 4: $this->resultmessage = psm_get_lang('users', 'error_carriersms_not_unique') . " ($to) = ($from) " . $logMsg; break;
					case 16: $this->resultmessage = psm_get_lang('users', 'error_carriersms_to_email_invalid') . " ($to) "    . $logMsg; break;
					case 32: $this->resultmessage = psm_get_lang('config', 'sms_error') . " : " . $mailObj->ErrorInfo         . $logMsg; break;
					default: break;
				}
			}
		}else{ // A test message is being sent/tested
			$mailObj->Body = $status;
			if($from !== false){
				$mailObj->SetFrom($from,"",false);
				$mailObj->AddAddress($this->recipients[0]);
				$this->success = $mailObj->Send();
				if(!$this->success && $mailObj->ErrorInfo != ""){
					$GLOBALS['sm_lang']['config']['sms_error']=$mailObj->ErrorInfo;
				}
			}
		}
		return $this->success;
	}
}
