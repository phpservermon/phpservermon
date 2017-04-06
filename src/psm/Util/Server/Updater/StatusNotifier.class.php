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
 * @author      Pepijn Over <pep@neanderthal-technology.com>
 * @copyright   Copyright (c) 2008-2014 Pepijn Over <pep@neanderthal-technology.com>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: v3.1.1
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
	 * Send pushover?
	 * @var boolean $send_pushover
	 */
	protected $send_pushover = false;
	
	/**
	 * Send pushsafer?
	 * @var boolean $send_pushsafer
	 */
	protected $send_pushsafer = false;	

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
		$this->send_pushsafer = psm_get_conf('pushsafer_status');
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
			'server_id', 'ip', 'port', 'label', 'type', 'pattern', 'status', 'error', 'active', 'email', 'sms', 'pushover', 'pushsafer',
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
		
		// check if pushsafer is enabled for this server
		if($this->send_pushsafer && $this->server['pushsafer'] == 'yes') {
			// yay lets wake those nerds up!
			$this->notifyByPushsafer($users);
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
		$userlist = array();

		// build mail object with some default values
		$mail = psm_build_mail();
		$mail->Subject	= psm_parse_msg($this->status_new, 'email_subject', $this->server);
		$mail->Priority	= 1;

		$body = psm_parse_msg($this->status_new, 'email_body', $this->server);
		$mail->Body		= $body;
		$mail->AltBody	= str_replace('<br/>', "\n", $body);

		// go through empl
	    foreach ($users as $user) {
	    	// we sent a seperate email to every single user.
	    	$userlist[] = $user['user_id'];
	    	$mail->AddAddress($user['email'], $user['name']);
	    	$mail->Send();
	    	$mail->ClearAddresses();
	    }

	    if(psm_get_conf('log_email')) {
	    	// save to log
	    	psm_add_log($this->server_id, 'email', $body, implode(',', $userlist));
	    }
	}

	/**
	 * This functions performs the pushover notifications
	 *
	 * @param array $users
	 * @return boolean
	 */
	protected function notifyByPushover($users) {
		$userlist = array();
		$pushover = psm_build_pushover();

		if($this->status_new === true) {
			$pushover->setPriority(0);
		} else {
			$pushover->setPriority(2);
			$pushover->setRetry(300); //Used with Priority = 2; Pushover will resend the notification every 60 seconds until the user accepts.
			$pushover->setExpire(3600); //Used with Priority = 2; Pushover will resend the notification every 60 seconds for 3600 seconds. After that point, it stops sending notifications.
		}
		$message = psm_parse_msg($this->status_new, 'pushover_message', $this->server);

		$pushover->setTitle(psm_parse_msg($this->status_new, 'pushover_title', $this->server));
		$pushover->setMessage(str_replace('<br/>', "\n", $message));
		$pushover->setUrl(psm_build_url());
		$pushover->setUrlTitle(psm_get_lang('system', 'title'));

	    foreach($users as $user) {
			if(trim($user['pushover_key']) == '') {
				continue;
			}
			$userlist[] = $user['user_id'];
			$pushover->setUser($user['pushover_key']);
			if($user['pushover_device'] != '') {
				$pushover->setDevice($user['pushover_device']);
			}
			$pushover->send();
	    }

	    if(psm_get_conf('log_pushover')) {
	    	psm_add_log($this->server_id, 'pushover', $message, implode(',', $userlist));
	    }
	}
	
	/**
	 * This functions performs the pushsafer chart generation
	 */
	protected function PushsaferChart($values) {
		$img_width=900;
		$img_height=600; 
		$margins=30;

		# ---- Find the size of graph by substracting the size of borders
		$graph_width=$img_width - $margins * 2;
		$graph_height=$img_height - $margins * 2; 
		$img=imagecreate($img_width,$img_height);

		$bar_width=20;
		$total_bars=count($values);
		$gap= ($graph_width- $total_bars * $bar_width ) / ($total_bars +1);

		# -------  Define Colors ----------------
		$bar_color=imagecolorallocate($img,0,64,128);
		$background_color=imagecolorallocate($img,240,240,255);
		$border_color=imagecolorallocate($img,200,200,200);
		$line_color=imagecolorallocate($img,220,220,220);

		# ------ Create the border around the graph ------

		imagefilledrectangle($img,1,1,$img_width-2,$img_height-2,$border_color);
		imagefilledrectangle($img,$margins,$margins,$img_width-1-$margins,$img_height-1-$margins,$background_color);


		# ------- Max value is required to adjust the scale -------
		$max_value=max($values);
		$ratio= $graph_height/$max_value;


		# -------- Create scale and draw horizontal lines  --------
		$horizontal_lines=20;
		$horizontal_gap=$graph_height/$horizontal_lines;

		for($i=1;$i<=$horizontal_lines;$i++){
			if ($i % 2 != 0) {
				$y=$img_height - $margins - $horizontal_gap * $i ;
				imageline($img,$margins,$y,$img_width-$margins,$y,$line_color);
				$v=number_format($horizontal_gap * $i /$ratio,2);
				imagestring($img,1,5,$y-5,$v,$bar_color);
			}
		}

		# ----------- Draw the bars here ------
		imagestring($img,3,5,10,"LATENCY",$bar_color);
		for($i=0;$i< $total_bars; $i++){ 
			# ------ Extract key and value pair from the current pointer position
			list($key,$value)=each($values); 
			$x1= $margins + $gap + $i * ($gap+$bar_width) ;
			$x2= $x1 + $bar_width; 
			$y1=$margins +$graph_height- intval($value * $ratio) ;
			$y2=$img_height-$margins;
			$value=number_format($value,2);
			$key=explode(' ',$key);
			imagestring($img,0,$x1+1,$y1-10,$value,$bar_color);
			imagestring($img,0,$x1-15,$img_height-25,$key[0],$bar_color);
			imagestring($img,0,$x1-11,$img_height-15,$key[1],$bar_color);
			imagefilledrectangle($img,$x1,$y1,$x2,$y2,$bar_color);
		}

		ob_start();
		imagejpeg($img);
		$contents = ob_get_contents();
		ob_end_clean();
		return "data:image/jpeg;base64," . base64_encode($contents);
	}	 
	 
	protected function notifyByPushsafer($users) {
		$userlist = array();

		$message = str_replace('<br/>', "\n", psm_parse_msg($this->status_new, 'pushsafer_message', $this->server));
		$title = psm_parse_msg($this->status_new, 'pushover_title', $this->server);
		$url = psm_build_url();
		$urltitle = psm_get_lang('system', 'title');
		
		if($this->status_new === true) {
			$icon = psm_get_conf('pushsafer_icon_on');
			$sound = psm_get_conf('pushsafer_sound_on');
			$vibration = psm_get_conf('pushsafer_vibration_on');
		} else {
			$icon = psm_get_conf('pushsafer_icon_off');
			$sound = psm_get_conf('pushsafer_sound_off');
			$vibration = psm_get_conf('pushsafer_vibration_off');
		}
			
		// GET Latency and generte Chart as png image
		if (extension_loaded('gd') && function_exists('gd_info')) {
			$now = new \DateTime();
			$last_week = new \DateTime('-1 week 0:0:0');
			$records = $this->db->execute(
				'SELECT *
					FROM `' . PSM_DB_PREFIX . 'servers_uptime`
					WHERE `server_id` = :server_id AND `date` BETWEEN :start_time AND :end_time ORDER BY `date` ASC LIMIT 15',
				array(
					'server_id' => $this->server_id,
					'start_time' => $last_week->format('Y-m-d H:i:s'),
					'end_time' => $now->format('Y-m-d H:i:s'),
				)
			);
				
			$chartvalues = array();
			foreach ($records as $uptime) {
				$chartvalues[$uptime['date']] = $uptime['latency'];
			}
			$picture = $this->PushsaferChart($chartvalues);
		}
		
	    foreach($users as $user) {
			$userlist[] = $user['user_id'];
			if(empty($user['pushsafer_key'])) {
				$this->addMessage(psm_get_lang('config', 'pushsafer_error_nokey'), 'error');
				psm_add_log($this->server_id, 'pushsafer', psm_get_lang('config', 'pushsafer_error_nokey'), $user['user_id']);
			} else {
				$apiurl = 'https://www.pushsafer.com/api';
				$data = array(
					't' => urldecode($title),
					'm' => urldecode($message),
					's' => $sound,
					'i' => $icon,
					'v' => $vibration,
					'l' => psm_get_conf('pushsafer_time2live'),
					'd' => $user['pushsafer_device'],
					'u' => urldecode($url),
					'ut' => urldecode($urltitle),
					'p' => $picture,
					'k' => $user['pushsafer_key']
				);
				$options = array(
					'http' => array(
						'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
						'method'  => 'POST',
						'content' => http_build_query($data)
					)
				);
				$context  = stream_context_create($options);
				$result = json_decode(file_get_contents($apiurl, false, $context), true);
		
				if(isset($result['status']) && $result['status'] == 1) {
					psm_add_log($this->server_id, 'pushsafer', psm_get_lang('config', 'pushsafer_sent'), $user['user_id']);
				} else {
					psm_add_log($this->server_id, 'pushsafer', psm_get_lang('config', 'pushsafer_error'), $user['user_id']);					
				}
			}
	    }

	    if(psm_get_conf('log_pushsafer')) {
	    	psm_add_log($this->server_id, 'pushsafer', $message, implode(',', $userlist));
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

		// we have to build an userlist for the log table..
		$userlist = array();

		// add all users to the recipients list
		foreach ($users as $user) {
			$userlist[] = $user['user_id'];
			$sms->addRecipients($user['mobile']);
		}

		$message = psm_parse_msg($this->status_new, 'sms', $this->server);

		// Send sms
		$result = $sms->sendSMS($message);

		if(psm_get_conf('log_sms')) {
			// save to log
			psm_add_log($this->server_id, 'sms', $message, implode(',', $userlist));
		}
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
			SELECT `u`.`user_id`, `u`.`name`,`u`.`email`, `u`.`mobile`, `u`.`pushover_key`, `u`.`pushover_device`, `u`.`pushsafer_key`, `u`.`pushsafer_device`
			FROM `".PSM_DB_PREFIX."users` AS `u`
			JOIN `".PSM_DB_PREFIX."users_servers` AS `us` ON (
				`us`.`user_id`=`u`.`user_id`
				AND `us`.`server_id` = {$server_id}
			)
		");
		return $users;
	}
}