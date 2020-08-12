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
use Norgul\Xmpp\Options;
use psm\Service\Database;

class StatusNotifier
{

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
     * Send Discord notification?
     * @var boolean $send_discord
     */
    protected $send_discord = false;

    /**
     * Send Pushover notification?
     * @var boolean $send_pushover
     */
    protected $send_pushover = false;

    /**
     * Send webhook notification?
     * @var boolean $send_webhook
     */
    protected $send_webhook = false;

    /**
     * Send telegram?
     * @var boolean $send_telegram
     */
    protected $send_telegram = false;

    /**
     * Send Jabber?
     * @var bool
     */
    protected $send_jabber = false;

    /**
     * Save log records?
     * @var boolean $save_log
     */
    protected $save_logs = false;

    /**
     * Send multiple notifications as one?
     * @var boolean $combine
     */
    public $combine = false;

    /**
     * Notification list
     * @var array $combiNotification
     */
    protected $combiNotification = array(
        'count' => array(),
        'users' => array(),
        'notifications' => array(),
        'userNotifications' => array()
    );

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

    public function __construct(Database $db)
    {
        $this->db = $db;

        $this->send_emails = (bool)psm_get_conf('email_status');
        $this->send_sms = (bool)psm_get_conf('sms_status');
        $this->send_discord = (bool)psm_get_conf('discord_status');
        $this->send_webhook = (bool)psm_get_conf('webhook_status');
        $this->send_pushover = (bool)psm_get_conf('pushover_status');
        $this->send_telegram = (bool)psm_get_conf('telegram_status');
        $this->send_jabber = (bool)psm_get_conf('jabber_status');
        $this->save_logs = (bool)psm_get_conf('log_status');
        $this->combine = (bool)psm_get_conf('combine_notifications');
    }

    /**
     * This function initializes the sending (text msg, email, Pushover and Telegram) and logging
     *
     * @param int $server_id
     * @param boolean $status_old
     * @param boolean $status_new
     * @return boolean
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function notify($server_id, $status_old, $status_new)
    {
        if (
            !$this->send_emails &&
            !$this->send_sms &&
            !$this->send_discord &&
            !$this->send_webhook &&
            !$this->send_pushover &&
            !$this->send_telegram &&
            !$this->send_jabber &&
            !$this->save_logs
        ) {
            // seems like we have nothing to do. skip the rest
            return false;
        }

        $this->server_id = $server_id;
        $this->status_old = $status_old;
        $this->status_new = $status_new;

        // get server info from db
        // only get info that will be put into the notification
        // or is needed to check if a notification need to be send
        $this->server = $this->db->selectRow(PSM_DB_PREFIX . 'servers', array(
            'server_id' => $server_id,
        ), array(
            'server_id',
            'ip',
            'port',
            'label',
            'error',
            'email',
            'sms',
            'discord',
            'webhook',
            'pushover',
            'telegram',
            'jabber',
            'last_online',
            'last_offline',
            'last_offline_duration',
        ));
        if (empty($this->server)) {
            return false;
        }

        $notify = false;

        // check which type of alert the user wants
        switch (psm_get_conf('alert_type')) {
            case 'always':
                if ($status_new == false) {
                    // server is offline. we are in error state.
                    $notify = true;
                }
                break;
            case 'offline':
                // only send a notification if the server goes down for the first time!
                if ($status_new == false && $status_old == true) {
                    $notify = true;
                }
                break;
            case 'status':
                if ($status_new != $status_old) {
                    // status has been changed!
                    $notify = true;
                }
                break;
        }

        if (!$notify) {
            return false;
        }

        // first add to log (we use the same text as the SMS message because its short..)
        if ($this->save_logs) {
            psm_add_log(
                $this->server_id,
                'status',
                psm_parse_msg($status_new, 'sms', $this->server)
            );
        }

        $users = $this->getUsers($this->server_id);

        if (empty($users)) {
            return $notify;
        }

        if ($this->combine) {
            $this->setCombi('init', $users);
        }

        // check if email is enabled for this server
        if ($this->send_emails && $this->server['email'] == 'yes') {
            // send email
            $this->combine ? $this->setCombi('email') : $this->notifyByEmail($users);
        }

        // check if sms is enabled for this server
        if ($this->send_sms && $this->server['sms'] == 'yes') {
            // sms will not be send combined as some gateways don't support long sms / charge extra
            // yay lets wake those nerds up!
            $this->notifyByTxtMsg($users);
        }

        // check if discord is enabled for this server
        if ($this->send_discord && $this->server['discord'] == 'yes') {
            // yay lets wake those nerds up!
            $this->combine ? $this->setCombi('discord') : $this->notifyByDiscord($users);
        }

        // check if webhook is enabled for this server
        if ($this->send_webhook && $this->server['webhook'] == 'yes') {
            // yay lets wake those nerds up!
            $this->combine ? $this->setCombi('webhook') : $this->notifyByWebhook($users);
        }

        // check if pushover is enabled for this server
        if ($this->send_pushover && $this->server['pushover'] == 'yes') {
            // yay lets wake those nerds up!
            $this->combine ? $this->setCombi('pushover') : $this->notifyByPushover($users);
        }

        // check if telegram is enabled for this server
        if ($this->send_telegram && $this->server['telegram'] == 'yes') {
            $this->combine ? $this->setCombi('telegram') : $this->notifyByTelegram($users);
        }

        if ($this->send_jabber && $this->server['jaber'] == 'yes') {
            $this->combine ? $this->setCombi('jabber') : $this->notifyByJabber($users);
        }

        return $notify;
    }

    /**
     * This functions collects all of the notifications
     *
     * @param string $method notification method
     * @param array $users Users
     * @return void
     */
    public function setCombi($method, $users = array())
    {
        $status = $this->status_new ? 'on' : 'off';

        if ($method == 'init' && !empty($users)) {
            foreach ($users as $user) {
                if (!isset($this->combiNotification['count'][$user['user_id']])) {
                    $this->combiNotification['count'][$user['user_id']] = array('on' => 0, 'off' => 0);
                }
                $this->combiNotification['userNotifications'][$user['user_id']][] = $this->server_id;
                $this->combiNotification['users'][$user['user_id']] = $user;
                $this->combiNotification['count'][$user['user_id']][$status] += 1;
            }
            return;
        }
        
        $this->combiNotification['notifications'][$method][$status][$this->server_id] =
            psm_parse_msg($this->status_new, $method . '_message', $this->server, true);
    }

    /**
     * This functions returns the subject for a combined notification
     *
     * @return void
     */
    public function notifyCombined()
    {
        if (empty($this->combiNotification['userNotifications'])) {
            return;
        }
        // Get the servers the user will get notified of
        $this->status_new = true;
        foreach ($this->combiNotification['userNotifications'] as $user => $servers) {
            $notifications = array();
            // Combine all of the messages belonging to the server the user will get notification of
            foreach ($servers as $server) {
                foreach ($this->combiNotification['notifications'] as $method => $status) {
                    foreach ($status as $the_status => $value) {
                        if (!key_exists($method, $notifications)) {
                            $notifications[$method] = array('on' => '', 'off' => '');
                        }
                        if (key_exists($server, $status[$the_status])) {
                            $notifications[$method][$the_status] .= $status[$the_status][$server];
                        }
                        // Set $this->status_new to false if a server is down.
                        // This is used by Pushover to determine the priority.
                        if (!empty($notifications[$method]['off'])) {
                            $this->status_new = false;
                        }
                    }
                }
            }
            // Send combined notification per user
            foreach ($notifications as $method => $notification) {
                $finalNotification['message'] = $this->createCombiMessage($method, $notification);
                $subject = $this->createCombiSubject($method, $user);
                if (!is_null($subject)) {
                    $finalNotification['subject'] = $subject;
                }
                $this->{'notifyBy' . ucwords($method)}(
                    array($this->combiNotification['users'][$user]),
                    $finalNotification
                );
            }
        }
        unset($notifications);
    }

    /**
     * This functions returns the message for a combined notification
     *
     * @param string $method Notification method
     * @param array $notification Notification
     * @return string
     */
    protected function createCombiMessage($method, $notification)
    {
        if (empty($notification['off'])) {
            $notification['off'] = "<ul><li>" . psm_get_lang('system', 'none') . "</li></ul>";
        }
        if (empty($notification['on'])) {
            $notification['on'] = "<ul><li>" . psm_get_lang('system', 'none') . "</li></ul>";
        }
        $vars = array('DOWN_SERVERS' => $notification['off'], 'UP_SERVERS' => $notification['on']);
        return psm_parse_msg(null, $method . '_message', $vars, true);
    }

    /**
     * This functions returns the subject for a combined notification
     *
     * @param string $method Notification method
     * @param integer $user_id User id
     * @return string|null
     */
    protected function createCombiSubject($method, $user_id)
    {
        $vars = array(
            'DOWN' => $this->combiNotification['count'][$user_id]['off'],
            'UP' => $this->combiNotification['count'][$user_id]['on']
        );
        $translation =  isset($GLOBALS['sm_lang_default']['notifications']['combi_' . $method . '_subject']) ?
        psm_parse_msg(null, $method . '_subject', $vars, true) :
        null;
        return $translation;
    }

    /**
     * This functions performs the email notifications
     *
     * @param \PDOStatement $users
     * @param array $combi contains message and subject (optional)
     * @return void
     * @throws \PHPMailer\PHPMailer\Exception
     */
    protected function notifyByEmail($users, $combi = array())
    {
        // build mail object with some default values
        $mail = psm_build_mail();
        $mail->Subject = key_exists('subject', $combi) ?
            $combi['subject'] :
            psm_parse_msg($this->status_new, 'email_subject', $this->server);
        $mail->Priority = 1;

        $body = key_exists('message', $combi) ?
            $combi['message'] :
            psm_parse_msg($this->status_new, 'email_body', $this->server);
        $mail->Body = $body;
        $mail->AltBody = str_replace('<br/>', "\n", $body);

        if (psm_get_conf('log_email')) {
            $log_id = psm_add_log($this->server_id, 'email', $body);
        }

        // go through empl
        foreach ($users as $user) {
            if (!empty($log_id)) {
                psm_add_log_user($log_id, $user['user_id']);
            }

            // we sent a separate email to every single user.
            $mail->AddAddress($user['email'], $user['name']);
            $mail->Send();
            $mail->ClearAddresses();
        }
    }


    /**
     * This functions performs the discord notifications
     *
     * @param \PDOStatement $users
     * @param array $combi contains message and subject (optional)
     * @return void
     */
    protected function notifyByDiscord($users, $combi = array())
    {

        $message_log = key_exists('message', $combi) ?
            $combi['message'] :
            psm_parse_msg($this->status_new, 'discord_message', $this->server);


        // Remove users that have no Discord webhook
        foreach ($users as $k => $user) {
            if (trim($user['discord']) == '') {
                unset($users[$k]);
            }
        }

        // Validation
        if (empty($users)) {
            return;
        }

        // fix message for Discord viewing
        $message = str_replace(array('<b>', '</b>'), array('**', '**'), $message_log);
        $message = str_replace(array('<ul>', '</ul>'), array('', ''), $message);
        $message = str_replace(array('<br>', '</li>'), array("\n", "\n"), $message);
        $message = str_replace('<li>', " * ", $message);


        $json = json_decode(
            '{"content":""}',
            true
        );
        $json['content'] = $message;

        // Log
        if (psm_get_conf('log_discord')) {
            $log_id = psm_add_log($this->server_id, 'discord', $message_log);
        }

        foreach ($users as $user) {
            // Log
            if (!empty($log_id)) {
                psm_add_log_user($log_id, $user['user_id']);
            }

            // set discord webhook and send
            try {
                $msg = "payload_json=" . urlencode(json_encode($json));
                $curl = curl_init(trim($user['discord']));
                if(isset($curl)) {
                    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $msg);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    $result = curl_exec($curl);
                    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                    $err = curl_errno($curl);

                    if ($err != 0 || $httpcode != 204) {
                        // $result = ($result == '') ? 'Wrong input, please check if all values are correct!' : $result;
                        $error = "HTTP_code: " . $httpcode . ".\ncURL error (" . $err . "): " .
                            curl_strerror($err) . ". \nResult: " . $result;
                        $log_id = psm_add_log($this->server_id, 'discord', $error);
                    }
                    curl_close($curl);
                }
            } catch (Exception $e) {
                $log_id = psm_add_log($this->server_id, 'discord', $e->getMessage());
            }
        }
    }


    /**
     * This functions performs the pushover notifications
     *
     * @param \PDOStatement $users
     * @param array $combi contains message and subject (optional)
     * @return void
     */
    protected function notifyByPushover($users, $combi = array())
    {
        // Remove users that have no pushover_key
        foreach ($users as $k => $user) {
            if (trim($user['pushover_key']) == '') {
                unset($users[$k]);
            }
        }

        // Validation
        if (empty($users)) {
            return;
        }

        // Pushover
        $message = key_exists('message', $combi) ?
            $combi['message'] :
            psm_parse_msg($this->status_new, 'pushover_message', $this->server);

        $pushover = psm_build_pushover();
        if ($this->status_new === true) {
            $pushover->setPriority(0);
        } else {
            $pushover->setPriority(2);
            //Used with Priority = 2; Pushover will resend the notification every 60 seconds until the user accepts.
            $pushover->setRetry(300);
            // Used with Priority = 2; Pushover will resend the notification every 60 seconds for 3600 seconds.
            // After that point, it stops sending notifications.
            $pushover->setExpire(3600);
        }
        $title = key_exists('subject', $combi) ?
            $combi['subject'] :
            psm_parse_msg($this->status_new, 'pushover_title', $this->server);
        $pushover->setHtml(1);
        $pushover->setTitle($title);
        $pushover->setMessage(str_replace('<br/>', "\n", $message));
        $pushover->setUrl(psm_build_url());
        $pushover->setUrlTitle(psm_get_conf('site_title', psm_get_lang('system', 'title')));

        // Log
        if (psm_get_conf('log_pushover')) {
            $log_id = psm_add_log($this->server_id, 'pushover', $message);
        }

        foreach ($users as $user) {
            // Log
            if (!empty($log_id)) {
                psm_add_log_user($log_id, $user['user_id']);
            }

            // Set recipient + send
            $pushover->setUser($user['pushover_key']);
            if ($user['pushover_device'] != '') {
                $pushover->setDevice($user['pushover_device']);
            }
            $pushover->send();
        }
    }
    /**
     * This functions performs the webhook notifications
     *
     * @param \PDOStatement $users
     * @param array $combi contains message and subject (optional)
     * @return void
     */
    protected function notifyByWebhook($users, $combi = array())
    {
        foreach ($users as $k => $user) {
            if (trim($user['webhook_url']) == '') {
                unset($users[$k]);
            }
        }
        $webhook = psm_build_webhook();


        $message = key_exists('message', $combi) ?
            $combi['message'] :
            psm_parse_msg($this->status_new, 'webhook_message', $this->server);
        $message = str_replace('<br/>', "\n", $message);
        $message = str_replace('<br>', "\n", $message);
        $title = key_exists('subject', $combi) ?
            $combi['subject'] :
            psm_parse_msg($this->status_new, 'webhook_title', $this->server);

        // Log
        if (psm_get_conf('log_webhook')) {
            $log_id = psm_add_log($this->server_id, 'webhook', $message);
        }

        // send notifications to all users
        foreach ($users as $user) {
            // Log
            if (!empty($log_id)) {
                psm_add_log_user($log_id, $user['user_id']);
            }
            $webhook->setUrl($user['webhook_url']);
            $webhook->setJson($user['webhook_json']);
            $webhook->sendWebhook($message);
        }
    }
    /**
     * This functions performs the text message notifications
     *
     * @param \PDOStatement $users
     * @return boolean
     */
    protected function notifyByTxtMsg($users)
    {
        $sms = psm_build_sms();
        if (!$sms) {
            return false;
        }

        $message = psm_parse_msg($this->status_new, 'sms', $this->server);

        // Log
        if (psm_get_conf('log_sms')) {
            $log_id = psm_add_log($this->server_id, 'sms', $message);
        }

        // add all users to the recipients list
        foreach ($users as $user) {
            // Log
            if (!empty($log_id)) {
                psm_add_log_user($log_id, $user['user_id']);
            }

            $sms->addRecipients($user['mobile']);
        }

        // Send sms
        $result = $sms->sendSMS($message);

        return $result;
    }

    /**
     * This functions performs the telegram notifications
     *
     * @param \PDOStatement $users
     * @param array $combi contains message and subject (optional)
     * @return void
     */
    protected function notifyByTelegram($users, $combi = array())
    {
        // Remove users that have no telegram_id
        foreach ($users as $k => $user) {
            if (trim($user['telegram_id']) == '') {
                unset($users[$k]);
            }
        }

        // Validation
        if (empty($users)) {
            return;
        }

        // Telegram
        $message = key_exists('message', $combi) ?
            $combi['message'] :
            psm_parse_msg($this->status_new, 'telegram_message', $this->server);
        $telegram = psm_build_telegram();
        $telegram->setMessage($message);
        
        // Log
        if (psm_get_conf('log_telegram')) {
            $log_id = psm_add_log($this->server_id, 'telegram', $message);
        }
        
        foreach ($users as $user) {
            // Log
            if (!empty($log_id)) {
                psm_add_log_user($log_id, $user['user_id']);
            }
            $telegram->setUser($user['telegram_id']);
            $telegram->send();
        }
    }

    /**
     * @param array $users
     * @param array $combi
     */
    protected function notifyByJabber($users, $combi = [])
    {
        // Remove users that have no jabber
        foreach ($users as $k => $user) {
            if (trim($user['jabber']) === '') {
                unset($users[$k]);
            }
        }

        // Validation
        if (empty($users)) {
            return;
        }

        // Message
        $message = key_exists('message', $combi) ?
            $combi['message'] :
            psm_parse_msg($this->status_new, 'jabber_message', $this->server);

        // Log
        if (psm_get_conf('log_jabber')) {
            $log_id = psm_add_log($this->server_id, 'jabber', $message);
        }

        $usersJabber = [];
        foreach ($users as $user) {
            // Log
            if (!empty($log_id)) {
                psm_add_log_user($log_id, $user['user_id']);
            }
            $usersJabber[] = $user['jabber'];
        }
        // Jabber
        psm_jabber_send_message(
            psm_get_conf('jabber_host'),
            psm_get_conf('jabber_username'),
            psm_password_decrypt(psm_get_conf('password_encrypt_key'), psm_get_conf('jabber_password')),
            $usersJabber,
            $message,
            (trim(psm_get_conf('jabber_port')) !== '' ? (int)psm_get_conf('jabber_port') : null),
            (trim(psm_get_conf('jabber_domain')) !== '' ? psm_get_conf('jabber_domain') : null)
        );
    }

    /**
     * Get all users for the provided server id
     * @param int $server_id
     * @return \PDOStatement array
     */
    public function getUsers($server_id)
    {
        // find all the users with this server listed
        $users = $this->db->query('
            SELECT `u`.`user_id`, `u`.`name`,`u`.`email`, `u`.`mobile`, `u`.`pushover_key`, `u`.`discord`, `u`.`webhook_url`,`u`.`webhook_json`,
                `u`.`pushover_device`, `u`.`telegram_id`, 
                `u`.`jabber`
            FROM `' . PSM_DB_PREFIX . 'users` AS `u`
            JOIN `' . PSM_DB_PREFIX . "users_servers` AS `us` ON (
                `us`.`user_id`=`u`.`user_id`
                AND `us`.`server_id` = {$server_id}
            )
        ");
        return $users;
    }
}
