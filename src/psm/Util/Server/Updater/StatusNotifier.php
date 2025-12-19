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
            'protocol',
            'label',
            'type',
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

        $this->server['protocol_label'] = $this->formatProtocolLabel($this->server);
        $this->server['monitor_url'] = PSM_BASE_URL . '/public.php';
        $this->server['summary'] = $status_new ? '' : $this->buildErrorSummary($this->server['error']);

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

        if ($this->send_jabber && $this->server['jabber'] == 'yes') {
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
     * Derive a human-readable protocol label for notification subjects.
     *
     * @param array $server
     * @return string
     */
    protected function formatProtocolLabel(array $server)
    {
        $protocol = isset($server['protocol']) ? strtoupper($server['protocol']) : '';
        $type = isset($server['type']) ? $server['type'] : null;
        $address = isset($server['ip']) ? $server['ip'] : '';

        if ($type === 'website') {
            $parsed = @parse_url($address);
            if ($parsed !== false && isset($parsed['scheme'])) {
                return strtoupper($parsed['scheme']);
            }

            return 'HTTP';
        }

        if ($protocol !== '') {
            return $protocol;
        }

        return 'TCP';
    }

    /**
     * Build a summary message based on an HTTP status/error code.
     *
     * @param string|null $error
     * @return string
     */
    protected function buildErrorSummary($error)
    {
        if (!is_string($error) || trim($error) === '') {
            return '';
        }

        if (!preg_match('/\b(\d{3})\b/', $error, $matches)) {
            return '';
        }

        $code = (int) $matches[1];
        $summaries = array(
            400 => array(
                'impact' => 'Request rejected because it was malformed or invalid.',
                'notes' => 'Often caused by invalid syntax, headers, query parameters, or payload formatting.',
            ),
            401 => array(
                'impact' => 'Request blocked because authentication is missing or invalid.',
                'notes' => 'Check auth headers/tokens, expiry, and the authentication method required by the service.',
            ),
            402 => array(
                'impact' => 'Request denied due to account/billing requirement.',
                'notes' => 'Typically used by APIs/SaaS for quota/billing enforcement.',
            ),
            403 => array(
                'impact' => 'Request understood but refused due to insufficient permissions.',
                'notes' => 'Check access policy, ACLs, IP allowlists, WAF rules, and required roles/scopes.',
            ),
            404 => array(
                'impact' => 'Requested resource does not exist at the given path/URL.',
                'notes' => 'Verify path, routing, base URL, and whether the resource was removed or never deployed.',
            ),
            405 => array(
                'impact' => 'Endpoint exists, but HTTP method (GET/POST/PUT/…) is not permitted.',
                'notes' => 'Confirm allowed methods and client behavior (e.g., POST vs GET).',
            ),
            406 => array(
                'impact' => 'Server can’t produce a response matching the client’s Accept headers.',
                'notes' => 'Check Accept / content negotiation settings (e.g., JSON vs XML).',
            ),
            407 => array(
                'impact' => 'Proxy refused the request because proxy authentication is required.',
                'notes' => 'Usually indicates corporate proxy settings or missing proxy credentials.',
            ),
            408 => array(
                'impact' => 'Request timed out before completion.',
                'notes' => 'Often due to slow network/client, overloaded server, or aggressive timeout settings.',
            ),
            409 => array(
                'impact' => 'Request conflicts with current server state.',
                'notes' => 'Common with versioning/ETags, duplicate resources, or concurrent updates.',
            ),
            410 => array(
                'impact' => 'Resource previously existed but has been permanently removed.',
                'notes' => 'Update references; unlike 404, removal is intentional/permanent.',
            ),
            411 => array(
                'impact' => 'Server requires Content-Length but it wasn’t provided.',
                'notes' => 'Ensure client sets Content-Length or uses chunked transfer correctly.',
            ),
            412 => array(
                'impact' => 'Preconditions (e.g., If-Match/If-Unmodified-Since) were not met.',
                'notes' => 'Common with optimistic locking; refresh ETag/version and retry.',
            ),
            413 => array(
                'impact' => 'Request body exceeded server limits.',
                'notes' => 'Increase limits (proxy/app) or reduce payload (compress/split/upload differently).',
            ),
            414 => array(
                'impact' => 'URL length exceeded server limits.',
                'notes' => 'Move large query data into body (POST) or shorten parameters.',
            ),
            415 => array(
                'impact' => 'Server rejected request due to unsupported Content-Type.',
                'notes' => 'Set correct Content-Type (e.g., application/json) and encoding.',
            ),
            416 => array(
                'impact' => 'Invalid byte-range requested for resource.',
                'notes' => 'Client range request doesn’t match resource size/availability.',
            ),
            418 => array(
                'impact' => 'Request intentionally refused by server logic.',
                'notes' => 'Usually custom behavior; check service docs or routing rules.',
            ),
            421 => array(
                'impact' => 'Request routed to the wrong server/virtual host.',
                'notes' => 'Common with TLS/SNI or reverse-proxy routing misconfiguration.',
            ),
            422 => array(
                'impact' => 'Request is syntactically valid but fails semantic validation.',
                'notes' => 'Check required fields, formats, and business validation rules.',
            ),
            423 => array(
                'impact' => 'Resource is locked and cannot be modified.',
                'notes' => 'Often WebDAV or application-level locking.',
            ),
            424 => array(
                'impact' => 'Request failed because a dependent operation/service failed.',
                'notes' => 'Identify upstream dependency failures.',
            ),
            425 => array(
                'impact' => 'Server refused to process due to replay risk (early data).',
                'notes' => 'Seen with TLS early data; client/server config may need adjustment.',
            ),
            426 => array(
                'impact' => 'Server requires protocol upgrade (e.g., to HTTPS or newer HTTP version).',
                'notes' => 'Update client to required protocol / TLS settings.',
            ),
            428 => array(
                'impact' => 'Server requires conditional request (e.g., If-Match) to prevent lost updates.',
                'notes' => 'Fetch current ETag/version and retry with preconditions.',
            ),
            429 => array(
                'impact' => 'Rate limit triggered; requests temporarily blocked.',
                'notes' => 'Apply backoff/retry-after, reduce request rate, or increase quota.',
            ),
            431 => array(
                'impact' => 'Request headers exceeded size limits.',
                'notes' => 'Reduce cookies/headers, trim auth tokens, or raise proxy limits.',
            ),
            451 => array(
                'impact' => 'Content blocked due to legal restrictions.',
                'notes' => 'Often geo/legal policy; verify compliance and distribution rules.',
            ),
            500 => array(
                'impact' => 'Server encountered an unexpected error and could not complete request.',
                'notes' => 'Check application logs, unhandled exceptions, and recent deployments.',
            ),
            501 => array(
                'impact' => 'Server does not support the requested method/feature.',
                'notes' => 'Endpoint may be incomplete or disabled; verify service capabilities.',
            ),
            502 => array(
                'impact' => 'Gateway/proxy received an invalid response from upstream server.',
                'notes' => 'Often upstream crash, misrouting, TLS issues, or bad upstream response formatting.',
            ),
            503 => array(
                'impact' => 'Service temporarily unavailable (overloaded, down, or in maintenance).',
                'notes' => 'Check health checks, capacity, autoscaling, maintenance windows.',
            ),
            504 => array(
                'impact' => 'Gateway/proxy timed out waiting for upstream server response.',
                'notes' => 'Upstream slow/hung, network issues, or timeout too low at proxy/load balancer.',
            ),
            505 => array(
                'impact' => 'Server doesn’t support the HTTP protocol version used by client.',
                'notes' => 'Adjust client/proxy to supported HTTP version.',
            ),
            507 => array(
                'impact' => 'Server cannot store representation needed to complete request.',
                'notes' => 'Disk full, quota exceeded, or storage backend issues.',
            ),
            508 => array(
                'impact' => 'Server detected an infinite loop while processing request.',
                'notes' => 'Often misconfigured rewrite/proxy rules or recursive dependencies.',
            ),
            510 => array(
                'impact' => 'Server requires additional extensions to fulfill request.',
                'notes' => 'Rare; usually indicates nonstandard/legacy extension requirements.',
            ),
            511 => array(
                'impact' => 'Access blocked until network authentication is completed.',
                'notes' => 'Common in captive portals / network-level access control.',
            ),
            520 => array(
                'impact' => 'Edge/CDN received an unexpected/unknown response from origin.',
                'notes' => 'Often origin returned something invalid or connection was reset; check origin logs and edge/origin connectivity.',
            ),
            521 => array(
                'impact' => 'Edge/CDN could not connect to origin because origin refused connections.',
                'notes' => 'Origin may be down, firewall blocking, or origin not listening on required port.',
            ),
            522 => array(
                'impact' => 'Edge/CDN could connect to origin but timed out waiting for response.',
                'notes' => 'Origin overloaded/slow, routing issues, or timeouts too strict.',
            ),
            523 => array(
                'impact' => 'Client could not establish a successful connection to the origin behind the endpoint.',
                'notes' => 'Commonly indicates edge/CDN cannot reach origin (origin down, routing/firewall restrictions, DNS/origin IP mismatch, blocked edge IP ranges).',
            ),
            524 => array(
                'impact' => 'Edge/CDN connected to origin, but origin did not respond in time.',
                'notes' => 'Long-running requests, overloaded origin, or insufficient upstream timeouts.',
            ),
            525 => array(
                'impact' => 'Edge/CDN failed to complete TLS handshake with origin.',
                'notes' => 'Origin TLS misconfig, incompatible ciphers, missing intermediates, or SNI/cert issues.',
            ),
            526 => array(
                'impact' => 'Edge/CDN rejected origin TLS certificate as invalid.',
                'notes' => 'Expired/self-signed/wrong hostname/untrusted chain; fix origin certificate/chain.',
            ),
            527 => array(
                'impact' => 'Edge feature failed communicating with origin acceleration component.',
                'notes' => 'Feature misconfig/outage; bypass/disable feature or check related services.',
            ),
            530 => array(
                'impact' => 'Request blocked by edge/service policy or configuration.',
                'notes' => 'Often WAF/rules/billing/feature gating; check provider dashboard/logs.',
            ),
        );

        if (!isset($summaries[$code])) {
            return '';
        }

        return 'Impact: ' . $summaries[$code]['impact'] . ' Notes: ' . $summaries[$code]['notes'];
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

        $publicUrl = PSM_BASE_URL.'/public.php';

        $body = key_exists('message', $combi) ?
            $combi['message'] :
            psm_parse_msg($this->status_new, 'email_body', $this->server);
        if ((bool)psm_get_conf('email_add_url')) {
            $body .= '<br><br>Monitored URL: <a href="' . $publicUrl . '">' . $publicUrl . '</a>';
        }
        $mail->Body = $body;
        $mail->AltBody = str_replace(array('<br/>', '<br>', '<br />'), "\n", $body);

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
            $result = psm_send_and_log_mail($mail, array(
                'context' => 'status_notification',
                'server_id' => $this->server_id,
                'user_id' => $user['user_id'],
            ));
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

        $subject = key_exists('subject', $combi) ? $combi['subject'] : psm_parse_msg($this->status_new, 'email_subject', $this->server);

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
            $webhook->sendWebhook([
                '#message' => $message,
                '#server_ip' => $this->server['ip'],
                '#server_label' => $this->server['label'],
                '#server_error' => $this->server['error'],
                '#server_last_offline_duration' => $this->status_new ? $this->server['last_offline_duration'] : '',
                '#status' => $this->status_new ? 'online' : 'offline',
                '#subject' => $subject
            ]);
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

        if ((bool)psm_get_conf('telegram_add_url')) {
            $message .= '<br>' . psm_build_url();
        }
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
