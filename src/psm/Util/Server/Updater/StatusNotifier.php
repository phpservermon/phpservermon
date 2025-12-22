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
            'last_error',
            'last_error_output',
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
        $summary_source = $status_new ? $this->server['last_error'] : $this->server['error'];
        $this->server['summary'] = $this->buildErrorSummary(
            $summary_source,
            isset($this->server['last_error_output']) ? $this->server['last_error_output'] : null
        );
        if (empty($this->server['summary'])) {
            $this->server['summary'] = $this->server['protocol_label'] . '/' . $this->server['port'];
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
     * @param string|null $errorOutput
     * @return string
     */
    protected function buildErrorSummary($error, $errorOutput = null)
    {
        $summaries = array(
            400 => array(
                'title' => '400 Bad Request',
                'summary' => 'The server rejected the request because it was malformed or invalid. This usually means the request syntax, headers, query parameters, or body payload did not meet expected formatting rules. Common triggers include invalid JSON, missing required fields, incorrect parameter types, or badly encoded characters. Check the client request construction, including Content-Type and any URL encoding. Reviewing application/API logs typically reveals which field or header caused the validation failure.',
            ),
            401 => array(
                'title' => '401 Unauthorized',
                'summary' => 'The request failed because authentication was missing, invalid, or expired. The server requires credentials (token, API key, session, or basic auth) and did not accept what was provided. This can happen due to expired tokens, incorrect secrets, missing Authorization headers, or clock skew affecting token validity. Confirm the authentication method required by the service and verify the correct credentials are being used. Check auth provider logs (IdP/API gateway) to see why the credentials were rejected.',
            ),
            403 => array(
                'title' => '403 Forbidden',
                'summary' => 'The edge/CDN could not reach the origin server on 443/TCP, so the client request could not be completed. This commonly indicates origin downtime, routing problems, or access restrictions preventing the edge from connecting to the origin over HTTPS. It can also be caused by a DNS/origin IP mismatch or the origin being moved without updating CDN configuration. Confirm the origin is up, reachable on port 443, and that inbound connections from the CDN/edge IP ranges are allowed at the firewall/ACL level. Review CDN logs and origin firewall rules to pinpoint whether the failure occurs during connect, routing, or policy enforcement.',
            ),
            443 => array(
                'title' => '443 HTTPS Connection Failed',
                'summary' => 'The edge/CDN could not reach the origin server on 443/TCP, so the client request could not be completed. This commonly indicates origin downtime, routing problems, or access restrictions preventing the edge from connecting to the origin over HTTPS. It can also be caused by a DNS/origin IP mismatch or the origin being moved without updating CDN configuration. Confirm the origin is up, reachable on port 443, and that inbound connections from the CDN/edge IP ranges are allowed at the firewall/ACL level. Review CDN logs and origin firewall rules to pinpoint whether the failure occurs during connect, routing, or policy enforcement.',
            ),
            404 => array(
                'title' => '404 Not Found',
                'summary' => 'The requested resource was not found at the specified URL/path. This usually means the route does not exist, the resource identifier is wrong, or the item has been removed or never deployed. It can also happen when a reverse proxy is pointing to the wrong upstream or when a base URL/version prefix is incorrect. Confirm the endpoint path, API version, hostname, and routing configuration. If this is unexpected, check deployment status and service routing tables for mismatches.',
            ),
            405 => array(
                'title' => '405 Method Not Allowed',
                'summary' => 'The endpoint exists, but the HTTP method used (GET/POST/PUT/DELETE, etc.) is not allowed. This often happens when a client uses the wrong method for an endpoint or when server routing is configured to accept only specific methods. Some proxies or frameworks will return 405 when an OPTIONS/CORS preflight isn’t handled correctly. Verify the API contract for allowed methods and confirm the client is using the correct one. Review server route definitions and gateway policy for method restrictions.',
            ),
            408 => array(
                'title' => '408 Request Timeout',
                'summary' => 'The server timed out waiting for the request to complete. This can be caused by slow client uploads, unstable network conditions, or server-side timeouts that are set too aggressively. If the timeout occurs before the request is fully received, large payloads or slow connections are common contributors. Check client-side timeout settings and compare them to proxy/load balancer/application timeouts. Server and edge logs can show whether the timeout occurred while reading the request or waiting on processing.',
            ),
            409 => array(
                'title' => '409 Conflict',
                'summary' => 'The request could not be completed because it conflicts with the current state of the resource. This is common in APIs that enforce uniqueness, versioning, optimistic locking, or concurrency controls. For example, creating a resource that already exists or updating with an outdated version/ETag can trigger 409. Resolve by fetching the latest state and retrying with correct preconditions or by handling duplicates gracefully. Application logs typically indicate what condition triggered the conflict.',
            ),
            410 => array(
                'title' => '410 Gone',
                'summary' => 'The requested resource is no longer available and has been permanently removed. Unlike 404, 410 explicitly signals that the removal is intentional and not expected to return. This can occur when an API deprecates an endpoint or content is deleted as part of lifecycle policies. Update clients to stop calling the removed resource and use the documented replacement if one exists. Check release notes or service documentation for deprecation timelines and migration paths.',
            ),
            413 => array(
                'title' => '413 Payload Too Large',
                'summary' => 'The server rejected the request because the request body exceeded configured size limits. This limit may be enforced at multiple layers, such as CDN/WAF, load balancer, reverse proxy, or the application itself. Large uploads, oversized JSON payloads, or unexpectedly large headers (sometimes cookies) can trigger this. Reduce payload size, compress data, split uploads, or move large uploads to object storage with signed URLs. If the payload is valid and expected, increase limits consistently across all proxy and application layers.',
            ),
            414 => array(
                'title' => '414 URI Too Long',
                'summary' => 'The server rejected the request because the URL (including query string) exceeded length limits. This often happens when clients include large encoded data or many parameters in the query string. Some proxies and browsers have strict URI limits that differ between environments, so issues can appear only in certain paths. Move large parameters into the request body (e.g., POST) or reduce query size by using shorter identifiers. Check proxy/web server configuration for URI and header size limits if adjustments are required.',
            ),
            415 => array(
                'title' => '415 Unsupported Media Type',
                'summary' => 'The server refused the request because the Content-Type is not supported for this endpoint. This commonly occurs when JSON is sent as text/plain, when form data is expected but JSON is provided, or when character encoding is incorrect. Some services also require explicit Accept headers for response format negotiation. Ensure the client sets the correct Content-Type and that the payload matches that format. Server logs usually highlight the mismatch and the accepted media types.',
            ),
            422 => array(
                'title' => '422 Unprocessable Entity',
                'summary' => 'The server understood the request structure but rejected it due to semantic validation errors. This usually indicates required fields are missing, values are out of range, formats are invalid, or business rules were violated. Unlike 400, the issue is typically with the meaning of the data rather than basic parsing. Check the response body for validation messages and map them back to the payload fields. Fix the input data and retry after ensuring it meets API validation requirements.',
            ),
            429 => array(
                'title' => '429 Too Many Requests',
                'summary' => 'The request was rate-limited because too many requests were sent in a short period. This can be enforced per IP, per user, per token, or per endpoint, depending on the service policy. It may also occur due to traffic spikes, retry storms, or poorly bounded concurrency in clients. Honor Retry-After headers if present and implement exponential backoff with jitter. If this is expected workload, request higher quotas or adjust the client’s request patterns.',
            ),
            431 => array(
                'title' => '431 Request Header Fields Too Large',
                'summary' => 'The server rejected the request because the headers were too large. This is often caused by oversized cookies, very large authorization tokens, or too many custom headers. It can also appear when headers grow over time due to accumulating cookies across redirects. Reduce cookie bloat, trim unnecessary headers, or shorten tokens where possible. If the headers are legitimate, raise header size limits on the proxy/server while confirming upstream components support the same limits.',
            ),
            500 => array(
                'title' => '500 Internal Server Error',
                'summary' => 'The server encountered an unexpected condition and failed to complete the request. This typically indicates an unhandled exception, misconfiguration, or runtime failure in the application. It may be triggered by specific inputs or by environmental issues such as missing dependencies or failing downstream services. Check application logs around the timestamp to identify stack traces or error messages. Recent deployments, config changes, or dependency outages are common starting points for investigation.',
            ),
            501 => array(
                'title' => '501 Not Implemented',
                'summary' => 'The server does not support the functionality required to fulfill the request. This commonly occurs when a method is not implemented, an endpoint is incomplete, or a feature is disabled. In some cases, a gateway or proxy returns 501 if it cannot route to a handler that supports the request. Confirm the API documentation and verify the endpoint and method are intended to exist. Review server routing and feature flags to ensure the capability is enabled and deployed.',
            ),
            502 => array(
                'title' => '502 Bad Gateway',
                'summary' => 'A gateway or proxy received an invalid response from an upstream server. This often indicates the upstream crashed, returned malformed HTTP, closed the connection early, or failed TLS negotiation. It can also be caused by incorrect upstream routing, DNS issues, or misconfigured load balancer pools. Check upstream health, application logs, and gateway error logs to determine what response was considered invalid. If the issue is intermittent, correlate with upstream restarts, deploys, or resource saturation.',
            ),
            503 => array(
                'title' => '503 Service Unavailable',
                'summary' => 'The service is temporarily unavailable and cannot handle the request. This typically happens when the service is overloaded, in maintenance mode, failing health checks, or intentionally shedding load. It can be generated by the application itself or by load balancers when no healthy upstream instances are available. Check service health dashboards, autoscaling status, and recent deployments or maintenance windows. If overload is the cause, capacity increases or traffic shaping may be required.',
            ),
            504 => array(
                'title' => '504 Gateway Timeout',
                'summary' => 'A gateway or proxy timed out waiting for a response from the upstream server. This usually means the upstream is slow, hung, overloaded, or unreachable beyond a certain point in the request lifecycle. It can also occur when timeout settings between components are mismatched (e.g., proxy timeout shorter than application processing time). Review upstream latency metrics, request traces, and resource usage during the incident window. Adjust timeouts only after confirming the upstream can reliably respond within the expected SLA.',
            ),
            507 => array(
                'title' => '507 Insufficient Storage',
                'summary' => 'The server could not complete the request because it lacks sufficient storage capacity. This may be due to full disks, exceeded quotas, or an underlying storage backend that is out of space. It can also appear if logs, temp files, or uploads consume space unexpectedly. Check filesystem usage, storage quotas, and object storage/backend capacity. Free space, rotate logs, or expand storage, then retry operations after confirming stability.',
            ),
            508 => array(
                'title' => '508 Loop Detected',
                'summary' => 'The server detected an infinite loop while processing the request and stopped to prevent runaway behavior. This is often caused by misconfigured redirects, rewrite rules, or proxy routing that sends traffic back to itself. It can also occur with recursive application logic or dependency calls that form a cycle. Inspect routing rules, redirect chains, and reverse proxy configuration for loops. Tracing headers and request logs can reveal the repeated path or host causing the loop.',
            ),
            511 => array(
                'title' => '511 Network Authentication Required',
                'summary' => 'The request was blocked because network-level authentication is required before accessing the resource. This commonly occurs on captive portals, managed guest networks, or enterprise networks requiring login/acceptance of terms. The server is signaling that the client must authenticate to the network, not necessarily to the application. Check whether the client environment is behind a captive portal or policy gateway. Once network authentication is completed, the request should succeed without application changes.',
            ),
            520 => array(
                'title' => '520 Web Server Returned an Unknown Error',
                'summary' => 'The edge/CDN received an unexpected or unclassified error from the origin server. This can happen when the origin returns an invalid HTTP response, resets the connection, or fails in a way the edge cannot map to a standard status. It may also indicate intermittent origin crashes or network instability between edge and origin. Check origin web server and application logs for resets, malformed responses, or abrupt terminations. Edge logs can help identify whether the failure occurred during connect, TLS handshake, or response read.',
            ),
            521 => array(
                'title' => '521 Web Server Is Down',
                'summary' => 'The edge/CDN could not establish a connection because the origin refused the connection. This usually indicates the origin service is down, not listening on the expected port, or blocking edge IP ranges at the firewall. It can also occur if the origin IP has changed and the edge is still targeting an old address. Verify origin availability, service listeners, and firewall/ACL rules for inbound traffic from the edge. Confirm DNS/origin configuration in the CDN matches the active origin address.',
            ),
            522 => array(
                'title' => '522 Connection Timed Out',
                'summary' => 'The edge/CDN attempted to connect to the origin but the connection timed out. This often indicates routing issues, packet drops, overloaded origin networking, or firewall rules silently dropping traffic. It differs from 524 in that the timeout is typically during connection establishment rather than waiting for a response. Check network paths, firewall logs, and origin host load to identify why connects are not completing. Validate that the origin is reachable from the internet and that the CDN’s IP ranges are allowed.',
            ),
            523 => array(
                'title' => '523 Origin Is Unreachable',
                'summary' => 'The edge/CDN could not reach the origin server, so the client request could not be completed. This commonly indicates origin downtime, routing problems, or access restrictions preventing the edge from connecting. It can also be caused by DNS/origin IP mismatch or the origin being moved without updating CDN configuration. Confirm the origin is up, reachable on port 443, and allows inbound connections from the CDN/edge IP ranges. Review CDN logs and origin firewall rules to pinpoint the exact block or path failure.',
            ),
            524 => array(
                'title' => '524 A Timeout Occurred',
                'summary' => 'The edge/CDN successfully connected to the origin, but the origin did not respond within the allowed time. This typically indicates slow application processing, overloaded backend dependencies, or long-running requests exceeding edge timeout limits. It can also occur during peak load when request queues grow and response times degrade. Check origin latency metrics, traces, and dependency health to find what is delaying responses. Mitigate by optimizing slow endpoints, scaling capacity, or adjusting timeouts only if the workload is expected and safe.',
            ),
            525 => array(
                'title' => '525 SSL Handshake Failed',
                'summary' => 'The edge/CDN could not complete a TLS handshake with the origin server. This is usually caused by TLS misconfiguration, incompatible cipher suites, missing intermediate certificates, or SNI/certificate selection issues. It can also occur if the origin presents an unexpected certificate or blocks handshake attempts. Validate the origin’s TLS configuration, certificate chain, and SNI behavior using standard TLS checks. Compare CDN TLS requirements with the origin’s supported versions and ciphers.',
            ),
            526 => array(
                'title' => '526 Invalid SSL Certificate',
                'summary' => 'The edge/CDN rejected the origin’s TLS certificate as invalid. Common causes include expired certificates, hostname mismatch, self-signed certificates, or an incomplete/untrusted certificate chain. This prevents secure communication between the edge and origin, so requests fail even if the origin is otherwise reachable. Check the origin certificate validity dates, SAN/hostname coverage, and full chain (including intermediates). Replace or fix the certificate chain, then re-test connectivity through the CDN.',
            ),
        );

        $code = null;

        if (is_string($error) && trim($error) !== '' && preg_match('/\b(\d{3})\b/', $error, $matches)) {
            $matchedCode = (int) $matches[1];
            if (isset($summaries[$matchedCode])) {
                $code = $matchedCode;
            }
        }

        if ($code === null && is_string($errorOutput) && trim($errorOutput) !== '') {
            $codeMatches = array();
            preg_match_all(
                "/[A-Z]{2,5}\/\d(\.\d)?\s(\d{3})\s?(.*)/",
                $errorOutput,
                $codeMatches
            );
            if (!empty($codeMatches[2])) {
                $lastIndex = count($codeMatches[2]) - 1;
                $matchedCode = (int) $codeMatches[2][$lastIndex];
                if (isset($summaries[$matchedCode])) {
                    $code = $matchedCode;
                }
            }
        }

        if ($code === null) {
            return '';
        }

        if (!isset($summaries[$code])) {
            return '';
        }

        return $summaries[$code]['title'] . ': ' . $summaries[$code]['summary'];
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
