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
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

namespace psm\Txtmsg;

class Plivo extends Core {
	// =========================================================================
	// [ Fields ]
	// =========================================================================
	public $gateway = 1;
	public $resultcode = null;
	public $resultmessage = null;
	public $success = false;
	public $successcount = 0;

	// =========================================================================
	// [ Methods ]
	// =========================================================================
	public function setGateway($gateway) {
		$this->gateway = $gateway;
	}

	public function sendSMS($message) {
		$authId		= $this->username;
		$authToken	= $this->password;
		
		$client				= new \Plivo\RestClient($authId, $authToken);
		/* @var $message_created \Plivo\Resources\Message\MessageCreateResponse */
		$message_created	= $client->messages->create(
			$this->originator,
			$this->recipients,
			$message
		);
		
		if($message_created && count($message_created->getMessageUuid()) ) {
			return 1;
		} else {
			return $message_created->getMessage();
		}
	}
}
