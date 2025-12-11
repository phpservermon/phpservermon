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
 * The status class is for checking the status of a server.
 *
 * @see \psm\Util\Server\Updater\StatusNotifier
 * @see \psm\Util\Server\Updater\Autorun
 */
namespace psm\Util\Server\Updater;
use psm\Service\Database;

class StatusUpdater
{
    public $error = '';

    public $header = '';

    public $curl_info = '';

    public $rtime = 0;

    public $status_new = false;

    /**
     * Database service
     * @var \psm\Service\Database $db
     */
    protected $db;

    /**
     * Server id to check
     * @var int $server_id
     */
    protected $server_id;

    /**
     * Server information
     * @var array $server
     */
    protected $server;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    /**
     * The function its all about. This one checks whether the given ip and port are up and running!
     * If the server check fails it will try one more time, depending on the $max_runs.
     *
     * Please note: if the server is down but has not met the warning threshold, this will return true
     * to avoid any "we are down" events.
     *
     * @todo Get last_output when there is a HTTP 50x error.
     *
     * @param int $server_id
     * @param int $max_runs how many times should the script recheck the server if unavailable. default is 2
     * @return boolean TRUE if server is up, FALSE otherwise
     */
    public function update($server_id, $max_runs = 2)
    {
        $this->server_id = $server_id;
        $this->error = '';
        $this->header = '';
        $this->curl_info = '';
        $this->rtime = 0;

        // get server info from db
        $this->server = $this->db->selectRow(PSM_DB_PREFIX . 'servers', array(
            'server_id' => $server_id,
        ), array(
            'server_id', 'ip', 'port', 'protocol', 'request_method', 'label',
            'type', 'pattern', 'pattern_online', 'post_field',
            'allow_http_status', 'redirect_check', 'header_name',
            'header_value', 'status', 'active', 'warning_threshold',
            'warning_threshold_counter', 'ssl_cert_expiry_days', 'ssl_cert_expired_time', 'timeout', 'website_username',
            'website_password', 'last_offline', 'custom_header'
        ));
        if (empty($this->server)) {
            return false;
        }

        switch ($this->server['type']) {
            case 'ping':
                $this->status_new = $this->updatePing($max_runs);
                break;
            case 'service':
                $this->status_new = $this->updateService($max_runs);
                break;
            case 'website':
                $this->status_new = $this->updateWebsite($max_runs);
                break;
        }

        // update server status
        $save = array(
            'last_check' => date('Y-m-d H:i:s'),
            'error' => $this->error,
            'rtime' => $this->rtime
        );
        if (!empty($this->error)) {
            $save['last_error'] = $this->error;
        }

        // log the uptime before checking the warning threshold,
        // so that the warnings can still be reviewed in the server history.
        psm_log_uptime($this->server_id, (int) $this->status_new, $this->rtime);

        if ($this->status_new == true) {
            // if the server is on, add the last_online value and reset the error threshold counter
            $save['status'] = 'on';
            $save['last_online'] = date('Y-m-d H:i:s');
            $save['last_output'] = substr($this->header, 0, 5000);
            $save['warning_threshold_counter'] = 0;
            if ($this->server['status'] == 'off') {
                $online_date = new \DateTime($save['last_online']);
                $offline_date = new \DateTime($this->server['last_offline']);
                $difference = $online_date->diff($offline_date);
                $save['last_offline_duration'] = trim(psm_format_interval($difference));
            }
        } else {
            // server is offline, increase the error counter and set last offline
            $save['warning_threshold_counter'] = $this->server['warning_threshold_counter'] + 1;
            $save['last_error_output'] = empty($this->header) ?
                "Could not get headers. probably HTTP 50x error." : $this->header;

            if ($save['warning_threshold_counter'] < $this->server['warning_threshold']) {
                // the server is offline but the error threshold has not been met yet.
                // so we are going to leave the status "on" for now while we are in a sort of warning state..
                $save['status'] = 'on';
                $this->status_new = true;
            } else {
                $save['status'] = 'off';
                if ($this->server['status'] == 'on') {
                    $save['last_offline'] = $save['last_check'];
                }
            }
        }
        $this->db->save(PSM_DB_PREFIX . 'servers', $save, array('server_id' => $this->server_id));

        return $this->status_new;
    }

    /**
     * Check the current servers ping status
     * @param int $max_runs
     * @param int $run
     * @return boolean
     */
    protected function updatePing($max_runs, $run = 1)
    {
        // Settings
        $max_runs = ($max_runs == null || $max_runs > 1) ? 1 : $max_runs;
        $server_ip = escapeshellcmd($this->server['ip']);
        $os_is_windows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';

        $status = $os_is_windows ?
            $this->pingFromWindowsMachine($server_ip, $max_runs) :
            $this->pingFromNonWindowsMachine($server_ip, $max_runs);

        // check if server is available and rerun if asked.
        if (!$status && $run < $max_runs) {
            return $this->updatePing($max_runs, $run + 1);
        }
        return $status;
    }

    /**
     * Check the current server as a service
     * @param int $max_runs
     * @param int $run
     * @return boolean
     */
    protected function updateService($max_runs, $run = 1)
    {
        $timeout = ($this->server['timeout'] === null || $this->server['timeout'] <= 0) ?
            PSM_CURL_TIMEOUT : intval($this->server['timeout']);
        $errno = 0;
        // save response time
        $starttime = microtime(true);

        $serverIp = $this->server['ip'];
        if (filter_var($serverIp, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false) {
            $serverIp = "[$serverIp]";
        }

        $isUdp = ($this->server['protocol'] === 'udp');
        $protocol = $isUdp ? 'udp://' : 'tcp://';
        $fp = @stream_socket_client(
            $protocol . $serverIp . ':' . $this->server['port'],
            $errno,
            $this->error,
            $timeout
        );

        $status = ($fp !== false);

        if ($status && $isUdp && (int) $this->server['port'] === 53) {
            $status = $this->checkDnsPort($fp, $timeout);
            if (!$status && empty($this->error)) {
                $this->error = 'No DNS response received on UDP port 53.';
            }
        } elseif (!$status && empty($this->error)) {
            $this->error = 'Could not connect to service port.';
        }

        $this->rtime = (microtime(true) - $starttime);

        if (is_resource($fp)) {
            fclose($fp);
        }

        // check if server is available and rerun if asked.
        if (!$status && $run < $max_runs) {
            return $this->updateService($max_runs, $run + 1);
        }

        return $status;
    }

    /**
     * Check the current server as a website
     * @param int $max_runs
     * @param int $run
     * @return boolean
     */
    protected function updateWebsite($max_runs, $run = 1)
    {
        $starttime = microtime(true);

        $has_auth_credentials =
            !empty($this->server['website_username']) || !empty($this->server['website_password']);

        $authentication_succeeded = false;
        $authentication_note_added = false;

        // We're only interested in the header, because that should tell us plenty!
        // unless we have a pattern to search for!
        $website_password = psm_password_decrypt(
            $this->server['server_id'] . psm_get_conf('password_encrypt_key'),
            $this->server['website_password']
        );

        $requestedUrl = $this->replaceAuthPlaceholders($this->server['ip'], $website_password);

        $curl_result = psm_curl_get(
            $requestedUrl,
            true,
            ($this->server['pattern'] == '' ? false : true),
            $this->server['timeout'],
            true,
            $this->server['website_username'],
            $website_password,
            $this->server['request_method'],
            $this->replaceAuthPlaceholders($this->server['post_field'], $website_password),
            $this->replaceAuthPlaceholders($this->server['custom_header'], $website_password),
            true
        );
        $this->header = $curl_result['exec'];
        $this->curl_info = $curl_result['info'];

        $this->rtime = (microtime(true) - $starttime);

        // Capture all HTTP status lines so we can evaluate the final one even when redirects occurred.
        $code_matches = array();
        preg_match_all(
            "/[A-Z]{2,5}\/\d(\.\d)?\s(\d{3})\s?(.*)/",
            $curl_result['exec'],
            $code_matches
        );

        $result = null;
        $allow_http_status = explode("|", $this->server['allow_http_status']);

        $http_code = isset($curl_result['info']['http_code']) ? (int) $curl_result['info']['http_code'] : 0;
        $msg = '';

        if (!empty($code_matches[0])) {
            // Use the last matched status line because CURLOPT_FOLLOWLOCATION keeps previous responses in the header.
            $lastIndex = count($code_matches[0]) - 1;
            $http_code = (int) $code_matches[2][$lastIndex];
            $msg = $code_matches[3][$lastIndex];
        }

        if ($http_code === 0) {
            // somehow we dont have a proper response.
            $this->error = 'TIMEOUT ERROR: no response from server';
            $result = false;
        }

        $code = $http_code;

        if ($result !== false) {
            // Authentication failures should always mark the website as offline
            if ($http_code === 401 || $http_code === 403) {
                $status_details = $code . ($msg ? ' ' . $msg : '');
                if ($has_auth_credentials) {
                    $this->error = "LOGIN ERROR: Authentication failed for provided credentials ({$status_details}).";
                    $this->appendHeaderAuthenticationNote(
                        "Authentication failed for configured credentials ({$status_details})."
                    );
                    $authentication_note_added = true;
                } else {
                    $this->error = "LOGIN ERROR: Authentication required ({$status_details}). No credentials configured.";
                    $this->appendHeaderAuthenticationNote(
                        "Authentication required ({$status_details}). Configure website credentials to allow monitoring."
                    );
                }
                $result = false;
            }

            // All status codes starting with a 4 or higher mean trouble!
            if ($result !== false) {
                if ($http_code >= 400 && !in_array($code, $allow_http_status)) {
                    $this->error = "HTTP STATUS ERROR: " . $code . ' ' . $msg;
                    $result = false;
                } else {
                    $result = true;

                    if ($has_auth_credentials) {
                        $authentication_succeeded = true;
                    }

                    if (
                        $has_auth_credentials &&
                        $this->redirectedToLogin($requestedUrl, $curl_result)
                    ) {
                        $this->error =
                            'LOGIN ERROR: Request redirected to a login page despite configured credentials.';
                        $this->appendHeaderAuthenticationNote(
                            'Request redirected to a login page; configured credentials may be invalid.'
                        );
                        $authentication_note_added = true;
                        $result = false;
                    }

                    // Okay, the HTTP status is good : 2xx or 3xx. Now we have to test the pattern if it's set up
                    if ($this->server['pattern'] != '') {
                        // Check to see if the body should not contain specified pattern
                        // Check to see if the pattern was [not] found.
                        if (
                            ($this->server['pattern_online'] == 'yes') ==
                            !preg_match(
                                "/{$this->server['pattern']}/i",
                                $curl_result['exec']
                            )
                        ) {
                            $this->error = "TEXT ERROR : Pattern '{$this->server['pattern']}' " .
                                ($this->server['pattern_online'] == 'yes' ? 'not' : 'was') .
                                ' found.';
                            $result = false;
                        }
                    }

                    // Check if the website redirects to another domain
                    if ($this->server['redirect_check'] == 'bad') {
                        $location_matches = array();
                        preg_match(
                            '/([Ll]ocation: )(https*:\/\/)(www.)?([a-zA-Z.:0-9]*)([\/][[:alnum:][:punct:]]*)/',
                            $curl_result['exec'],
                            $location_matches
                        );
                        if (!empty($location_matches)) {
                            $ip_matches = array();
                            preg_match(
                                '/(https*:\/\/)(www.)?([a-zA-Z.:0-9]*)([\/][[:alnum:][:punct:]]*)?/',
                                $this->server['ip'],
                                $ip_matches
                            );
                            if (strtolower($location_matches[4]) !== strtolower($ip_matches[3])) {
                                $this->error = "The IP/URL redirects to another domain.";
                                $result = false;
                            }
                        }
                    }

                    // Should we check a header ?
                    if ($this->server['header_name'] != '' && $this->server['header_value'] != '') {
                        $header_flag = false;
                        // Only get the header text if the result also includes the body
                        $header_text = substr($curl_result['exec'], 0, strpos($curl_result['exec'], "\r\n\r\n"));
                        foreach (explode("\r\n", $header_text) as $i => $line) {
                            if ($i === 0 || strpos($line, ':') == false) {
                                // We skip the status code & other non-header lines. Needed for proxy or redirects
                                continue;
                            }

                            list ($key, $value) = explode(': ', $line);
                            // Header found (case-insensitive)
                            if (strcasecmp($key, $this->server['header_name']) == 0) {
                                // The value matches what we need, everything is fine
                                if (preg_match("/{$this->server['header_value']}/i", $value)) {
                                    $header_flag = true;
                                    break; // The correct header is found, we leave the loop
                                }
                            }
                        }

                        if (!$header_flag) {
                            // Header was not present, set error message and $result variable
                            $this->error = 'HEADER ERROR : Header "' . $this->server['header_name'] .
                                '" not found or does not match "/' . $this->server['header_value'] . '/i".';
                            $result = false;
                        }
                    }
                }
            }
        }

        // Check ssl cert just when other error is not already in...
        if ($result !== false) {
            $this->checkSsl($this->server, $this->error, $result);
        }

        if ($has_auth_credentials && !$authentication_note_added) {
            $this->appendHeaderAuthenticationNote(
                $authentication_succeeded
                    ? 'Authentication succeeded using configured website credentials.'
                    : 'Authentication credentials were sent with the request.'
            );
        }

        // check if server is available and rerun if asked.
        if (!$result && $run < $max_runs) {
            return $this->updateWebsite($max_runs, $run + 1);
        }

        return $result;
    }

    /**
     * Append an authentication note to the stored header output so logs include login context.
     *
     * @param string $message
     */
    protected function appendHeaderAuthenticationNote($message)
    {
        $message = trim($message);

        if ($message === '') {
            return;
        }

        $note = '[phpservermon] ' . $message;

        if ($this->header === '') {
            $this->header = $note;

            return;
        }

        $separator = (substr($this->header, -2) === "\r\n") ? "\r\n" : "\r\n\r\n";
        $this->header .= $separator . $note;
    }

    /**
     * Replace credential placeholders in request data so form-based logins can reuse stored credentials.
     *
     * Supported placeholders (case-insensitive):
     *  - %username% : raw username
     *  - %password% : raw password
     *  - %username_url% : URL-encoded username
     *  - %password_url% : URL-encoded password
     *
     * @param string|null $value
     * @param string $website_password
     * @return string|null
     */
    private function replaceAuthPlaceholders($value, $website_password)
    {
        if ($value === null || $value === '') {
            return $value;
        }

        $username = (string) $this->server['website_username'];
        $password = (string) $website_password;

        $replacements = array(
            '%username%' => $username,
            '%password%' => $password,
            '%username_url%' => rawurlencode($username),
            '%password_url%' => rawurlencode($password),
        );

        return str_ireplace(array_keys($replacements), array_values($replacements), $value);
    }

    /**
     * Detect whether the response chain ended up on a login page even though credentials were supplied.
     *
     * @param string|null $requestedUrl
     * @param array $curl_result
     * @return bool
     */
    private function redirectedToLogin($requestedUrl, array $curl_result)
    {
        $effectiveUrl = isset($curl_result['info']['url']) ? $curl_result['info']['url'] : '';

        $targets = $this->extractLocationTargets($curl_result['exec']);
        if ($effectiveUrl !== '') {
            $targets[] = $effectiveUrl;
        }

        foreach ($targets as $target) {
            if ($this->looksLikeLoginUrl($target) && $this->redirectedAwayFrom($requestedUrl, $target)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Pull all Location headers from the raw response.
     *
     * @param string $rawResponse
     * @return array
     */
    private function extractLocationTargets($rawResponse)
    {
        $location_matches = array();
        preg_match_all('/^location:\s*(.+)$/im', $rawResponse, $location_matches);

        return isset($location_matches[1]) ? $location_matches[1] : array();
    }

    /**
     * Determine whether a URL resembles a login endpoint.
     *
     * @param string $url
     * @return bool
     */
    private function looksLikeLoginUrl($url)
    {
        if ($url === '') {
            return false;
        }

        $parsed = parse_url($url);
        $path = isset($parsed['path']) ? strtolower($parsed['path']) : '';

        $loginKeywords = array('login', 'signin', 'logon', 'auth');
        foreach ($loginKeywords as $keyword) {
            if (strpos($path, $keyword) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Decide whether the response landed somewhere other than the originally requested URL.
     *
     * @param string|null $requestedUrl
     * @param string $targetUrl
     * @return bool
     */
    private function redirectedAwayFrom($requestedUrl, $targetUrl)
    {
        if ($requestedUrl === null || $requestedUrl === '' || $targetUrl === '') {
            return false;
        }

        $requested = parse_url($requestedUrl);
        $target = parse_url($targetUrl);

        if (!isset($requested['host'], $target['host'])) {
            return true;
        }

        // If the host changed, we were redirected away.
        if (strcasecmp($requested['host'], $target['host']) !== 0) {
            return true;
        }

        $requestedPath = isset($requested['path']) ? rtrim($requested['path'], '/') : '';
        $targetPath = isset($target['path']) ? rtrim($target['path'], '/') : '';

        return strcasecmp($requestedPath, $targetPath) !== 0;
    }

    /**
     * Get the error returned by the update function
     *
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Get the response time of the server
     *
     * @return string
     */
    public function getRtime()
    {
        return $this->rtime;
    }

    /**
     *  Check if a server speaks SSL and if the certificate is not expired.
     * @param string $error
     * @param bool $result
     */
    private function checkSsl($server, &$error, &$result)
    {
        if (version_compare(PHP_VERSION, '7.1', '<')) {
            $error = "The server you're running PSM on must use PHP 7.1 or higher to test the SSL expiration.";
            return;
        }
        if (
            !empty($this->curl_info['certinfo']) &&
            $server['ssl_cert_expiry_days'] > 0
        ) {
            $certinfo = reset($this->curl_info['certinfo']);
            $certinfo = openssl_x509_parse($certinfo['Cert']);
            $cert_expiration_date = $certinfo['validTo_time_t'];
            $expiration_time =
                round((int)($cert_expiration_date - time()) / 86400);
            $latest_time = time() + (86400 * $server['ssl_cert_expiry_days']);

            if ($expiration_time - $server['ssl_cert_expiry_days'] < 0) {
                // Cert is not expired, but date is withing user set range
                $this->header = psm_get_lang('servers', 'ssl_cert_expiring') . " " .
                    psm_date($this->curl_info['certinfo'][0]['Expire date']) .
                    "\n\n" . $this->header;
                $save['ssl_cert_expired_time'] = $expiration_time - $server['ssl_cert_expiry_days'];
            } elseif ($expiration_time >= 0) {
                // Cert is not expired
                $save['ssl_cert_expired_time'] = null;
            } else {
                // Cert is expired
                $error = psm_get_lang('servers', 'ssl_cert_expired') . " " .
                    psm_timespan($cert_expiration_date) . ".\n\n" .
                    $error;
                $save['ssl_cert_expired_time'] = $expiration_time;
            }
            $this->db->save(PSM_DB_PREFIX . 'servers', $save, array('server_id' => $this->server_id));
        }
    }

    /**
     * Perform a lightweight DNS query to confirm UDP port 53 responds.
     *
     * @param resource $socket
     * @param int $timeout
     * @return bool
     */
    private function checkDnsPort($socket, $timeout)
    {
        if (!is_resource($socket)) {
            return false;
        }

        $transactionId = random_int(0, 0xffff);
        $flags = 0x0100; // standard query
        $questionCount = 1;
        $header = pack('nnnnnn', $transactionId, $flags, $questionCount, 0, 0, 0);

        $queryName = '';
        foreach (explode('.', 'example.com') as $label) {
            $queryName .= chr(strlen($label)) . $label;
        }
        $queryName .= "\0"; // terminator
        $query = $queryName . pack('nn', 1, 1); // type A, class IN

        $packet = $header . $query;

        stream_set_timeout($socket, $timeout);
        fwrite($socket, $packet);

        $read = array($socket);
        $write = null;
        $except = null;
        $selected = stream_select($read, $write, $except, $timeout);

        if ($selected === false || $selected === 0) {
            return false;
        }

        $response = fread($socket, 512);
        if ($response === false || strlen($response) < 2) {
            return false;
        }

        $responseId = unpack('n', substr($response, 0, 2));

        return isset($responseId[1]) && $responseId[1] === $transactionId;
    }

    /**
     *  Ping from a Windows Machine
     * @param string $server_id
     * @param int $max_runs
     * @return boolean
     */
    private function pingFromWindowsMachine($server_ip, $max_runs)
    {
        // Windows / Linux variant: use socket on Windows, commandline on Linux
        // socket ping - Code from http://stackoverflow.com/a/20467492
        // save response time
        $starttime = microtime(true);

        // set ping payload
        $package = "\x08\x00\x7d\x4b\x00\x00\x00\x00PingHost";

        $socket = socket_create(AF_INET, SOCK_RAW, 1);
        socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array('sec' => 10, 'usec' => 0));
        socket_connect($socket, $server_ip, null);
        socket_send($socket, $package, strLen($package), 0);
        // socket_read returns a string or false
        $status = socket_read($socket, 255) !== false ? true : false;

        if ($status) {
            $this->header = "Success.";
        } else {
            $this->error = "Couldn't create socket [" . $errorcode . "]: " . socket_strerror(socket_last_error());
        }

        $this->rtime = microtime(true) - $starttime;
        socket_close($socket);

        return $status;
    }

    /**
     *  Ping from a non Windows Machine
     * @param string $server_id
     * @param int $max_runs
     * @param string $ping_command
     * @return boolean
     */
    private function pingFromNonWindowsMachine($server_ip, $max_runs)
    {

        // Choose right ping version, ping6 for IPV6, ping for IPV4
        $ping_command = filter_var($server_ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false ? 'ping6' : 'ping';

        // execute PING
        exec($ping_command . " -c " . $max_runs . " " . $server_ip . " 2>&1", $output);

        // Check if output is PING and if transmitted packets is equal to received packets.
        preg_match(
            '/^(\d{1,3}) packets transmitted, (\d{1,3}).*$/',
            $output[count($output) - 2],
            $output_package_loss
        );

        if (
            substr($output[0], 0, 4) == 'PING' &&
            !empty($output_package_loss) &&
            $output_package_loss[1] === $output_package_loss[2]
        ) {
            // Gets avg from 'round-trip min/avg/max/stddev = 7.109/7.109/7.109/0.000 ms'
            preg_match_all("/(\d+\.\d+)/", $output[count($output) - 1], $result);
            // Converted to milliseconds
            $this->rtime = floatval($result[0][1]) / 1000;

            $this->header = "";
            foreach ($output as $key => $value) {
                $this->header .= $value . "\n";
            }
            return true;
        }

        $this->header = "-";
        foreach ($output as $key => $value) {
            $this->header .= $value . "\n";
        }
        $this->error = $output[count($output) - 2];
        return false;
    }
}
