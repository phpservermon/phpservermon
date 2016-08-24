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

/**
 * The status updater is for sending notifications to the users.
 *
 * @see \psm\Util\Server\Updater\StatusUpdater
 * @see \psm\Util\Server\Updater\Autorun
 */
namespace psm\Util\Server\Updater;
use psm\Service\Database;

class StatusNotifier {

	/**
	 * Database service
	 * @var \psm\Service\Database $db
	 */
	protected $db;

	/**
	 * Send emails?
	 * @var boolean $send_emails
	 */
	protected $send_emails = false;

	/**
	 * Send sms?
	 * @var boolean $send_sms
	 */
	protected $send_sms = false;

	/**
	 * Send sms?
	 * @var boolean $send_pushover
	 */
	protected $send_pushover = false;

	/**
	 * Save log records?
	 * @var boolean $save_log
	 */
	protected $save_logs = false;

	/**
	 * Server id
	 * @var int $server_id
	 */
	protected $server_id;

	/**
	 * Server information
	 * @var array $server
	 */
	protected $server;

	/**
	 * Old status
	 * @var boolean $status_old
	 */
	protected $status_old;

	/**
	 * New status
	 * @var boolean $status_new
	 */
	protected $status_new;

	function __construct(Database $db) {
		$this->db = $db;

		$this->send_emails = psm_get_conf('email_status');
		$this->send_sms = psm_get_conf('sms_status');
		$this->send_pushover = psm_get_conf('pushover_status');
		$this->save_logs = psm_get_conf('log_status');
	}

	/**
	 * This function initializes the sending (text msg & email) and logging
	 *
	 * @param int $server_id
	 * @param boolean $status_old
	 * @param boolean $status_new
	 * @return boolean
	 */
	public function notify($server_id, $status_old, $status_new) {
		if(!$this->send_emails && !$this->send_sms && !$this->save_logs) {
			// seems like we have nothing to do. skip the rest
			return false;
		}

		$this->server_id = $server_id;
		$this->status_old = $status_old;
		$this->status_new = $status_new;

		// get server info from db
		$this->server = $this->db->selectRow(PSM_DB_PREFIX . 'servers', array(
			'server_id' => $server_id,
		), array(
			'server_id', 'ip', 'port', 'label', 'type', 'pattern', 'status', 'header_name', 'header_value', 'error', 'active', 'email', 'sms', 'pushover',
		));
		if(empty($this->server)) {
			return false;
		}

		$notify = false;

		// check which type of alert the user wants
		switch(psm_get_conf('alert_type')) {
			case 'always':
				if($status_new == false) {
					// server is offline. we are in error state.
					$notify = true;
				}
				break;
			case 'offline':
				// only send a notification if the server goes down for the first time!
				if($status_new == false && $status_old == true) {
					$notify = true;
				}
				break;
			case 'status':
				if($status_new != $status_old) {
					// status has been changed!
					$notify = true;
				}
				break;
		}

		if(!$notify) {
			return false;
		}

		// first add to log (we use the same text as the SMS message because its short..)
		if($this->save_logs) {
			psm_add_log(
				$this->server_id,
				'status',
				psm_parse_msg($status_new, 'sms', $this->server)
			);
		}

		$users = $this->getUsers($this->server_id);

		if(empty($users)) {
			return $notify;
		}

		// check if email is enabled for this server
		if($this->send_emails && $this->server['email'] == 'yes') {
			// send email
			$this->notifyByEmail($users);
		}

		// check if sms is enabled for this server
		if($this->send_sms && $this->server['sms'] == 'yes') {
			// yay lets wake those nerds up!
			$this->notifyByTxtMsg($users);
		}

		// check if pushover is enabled for this server
		if($this->send_pushover && $this->server['pushover'] == 'yes') {
			// yay lets wake those nerds up!
			$this->notifyByPushover($users);
		}

		return $notify;
	}

	/**
	 * This functions performs the email notifications
	 *
	 * @param array $users
	 * @return boolean
	 */
	protected function notifyByEmail($users) {
		// build mail object with some default values
		$mail = psm_build_mail();
		$mail->Subject	= utf8_decode(psm_parse_msg($this->status_new, 'email_subject', $this->server));
		$mail->Priority	= 1;

		$body = psm_parse_msg($this->status_new, 'email_body', $this->server);
		$mail->Body		= utf8_decode($body);
		$mail->AltBody	= str_replace('<br/>', "\n", $body);

        if(psm_get_conf('log_email')) {
            $log_id = psm_add_log($this->server_id, 'email', $body);
   	    }

		// go through empl
	    foreach ($users as $user) {
            if(!empty($log_id)) {
       	    	psm_add_log_user($log_id, $user['user_id']);
       	    }

	    	// we sent a seperate email to every single user.
	    	$mail->AddAddress($user['email'], $user['name']);
	    	$mail->Send();
	    	$mail->ClearAddresses();
	    }
	}

	/**
	 * This functions performs the pushover notifications
	 *
	 * @param array $users
	 * @return boolean
	 */
	protected function notifyByPushover($users) {
        // Remove users that have no pushover_key
        foreach($users as $k => $user) {
            if (trim($user['pushover_key']) == '') {
                unset($users[$k]);
            }
        }

        // Validation
        if (empty($users)) {
            return;
        }

        // Pushover
        $message = psm_parse_msg($this->status_new, 'pushover_message', $this->server);
        $pushover = psm_build_pushover();
        if($this->status_new === true) {
            $pushover->setPriority(0);
        } else {
            $pushover->setPriority(2);
            $pushover->setRetry(300); //Used with Priority = 2; Pushover will resend the notification every 60 seconds until the user accepts.
            $pushover->setExpire(3600); //Used with Priority = 2; Pushover will resend the notification every 60 seconds for 3600 seconds. After that point, it stops sending notifications.
        }
		$pushover->setTitle(psm_parse_msg($this->status_new, 'pushover_title', $this->server));
		$pushover->setMessage(str_replace('<br/>', "\n", $message));
		$pushover->setUrl(psm_build_url());
		$pushover->setUrlTitle(psm_get_lang('system', 'title'));

        // Log
        if(psm_get_conf('log_pushover')) {
            $log_id = psm_add_log($this->server_id, 'pushover', $message);
   	    }

	    foreach($users as $user) {
            // Log
            if(!empty($log_id)) {
       	    	psm_add_log_user($log_id, $user['user_id']);
       	    }

            // Set recipient + send
			$pushover->setUser($user['pushover_key']);
			if($user['pushover_device'] != '') {
				$pushover->setDevice($user['pushover_device']);
			}
			$pushover->send();
        }
	}

	/**
	 * This functions performs the text message notifications
	 *
	 * @param array $users
	 * @return boolean
	 */
	protected function notifyByTxtMsg($users) {
		$sms = psm_build_sms();
		if(!$sms) {
			return false;
		}

        $message = psm_parse_msg($this->status_new, 'sms', $this->server);

        // Log
        if(psm_get_conf('log_sms')) {
            $log_id = psm_add_log($this->server_id, 'sms', $message);
		}

		// add all users to the recipients list
		foreach ($users as $user) {
            // Log
            if(!empty($log_id)) {
       	    	psm_add_log_user($log_id, $user['user_id']);
       	    }

			$sms->addRecipients($user['mobile']);
		}

		// Send sms
		$result = $sms->sendSMS($message);

		return $result;
	}

	/**
	 * Get all users for the provided server id
	 * @param int $server_id
	 * @return array
	 */
	public function getUsers($server_id) {
		// find all the users with this server listed
		$users = $this->db->query("
			SELECT `u`.`user_id`, `u`.`name`,`u`.`email`, `u`.`mobile`, `u`.`pushover_key`, `u`.`pushover_device`
			FROM `".PSM_DB_PREFIX."users` AS `u`
			JOIN `".PSM_DB_PREFIX."users_servers` AS `us` ON (
				`us`.`user_id`=`u`.`user_id`
				AND `us`.`server_id` = {$server_id}
			)
		");
		return $users;
	}
}