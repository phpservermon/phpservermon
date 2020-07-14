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
            'server_id', 'ip', 'port', 'request_method', 'label',
            'type', 'pattern', 'pattern_online', 'post_field',
            'allow_http_status', 'redirect_check', 'header_name',
            'header_value', 'status', 'active', 'warning_threshold',
            'warning_threshold_counter', 'ssl_cert_expiry_days', 'ssl_cert_expired_time', 'timeout', 'website_username',
            'website_password', 'last_offline'
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
        $timeout = ($this->server['timeout'] === null || $this->server['timeout'] > 0) ?
            PSM_CURL_TIMEOUT : intval($this->server['timeout']);
        $errno = 0;
        // save response time
        $starttime = microtime(true);

        $serverIp = $this->server['ip'];
        if (filter_var($serverIp, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false) {
            $serverIp = "[$serverIp]";
        }
        $fp = @fsockopen($serverIp, $this->server['port'], $errno, $this->error, $timeout);

        $status = ($fp === false) ? false : true;
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

        // We're only interested in the header, because that should tell us plenty!
        // unless we have a pattern to search for!
        $curl_result = psm_curl_get(
            $this->server['ip'],
            true,
            ($this->server['pattern'] == '' ? false : true),
            $this->server['timeout'],
            true,
            $this->server['website_username'],
            psm_password_decrypt($this->server['server_id'] .
                psm_get_conf('password_encrypt_key'), $this->server['website_password']),
            $this->server['request_method'],
            $this->server['post_field']
        );
        $this->header = $curl_result['exec'];
        $this->curl_info = $curl_result['info'];

        $this->rtime = (microtime(true) - $starttime);

        // the first line would be the status code..
        $status_code = strtok($curl_result['exec'], "\r\n");
        // keep it general
        // $code[2][0] = status code
        // $code[3][0] = name of status code
        $code_matches = array();
        preg_match_all("/[A-Z]{2,5}\/\d(\.\d)?\s(\d{3})\s?(.*)/", $status_code, $code_matches);

        if (empty($code_matches[0])) {
            // somehow we dont have a proper response.
            $this->error = 'TIMEOUT ERROR: no response from server';
            $result = false;
        } else {
            $code = $code_matches[2][0];
            $msg = $code_matches[3][0];

            $allow_http_status = explode("|", $this->server['allow_http_status']);
            // All status codes starting with a 4 or higher mean trouble!
            if (substr($code, 0, 1) >= '4' && !in_array($code, $allow_http_status)) {
                $this->error = "HTTP STATUS ERROR: " . $code . ' ' . $msg;
                $result = false;
            } else {
                $result = true;

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
                            continue; // We skip the status code & other non-header lines. Needed for proxy or redirects
                        } else {
                            list ($key, $value) = explode(': ', $line);
                            // Header found (case-insensitive)
                            if (strcasecmp($key, $this->server['header_name']) == 0) {
                                // The value doesn't match what we needed
                                if (!preg_match("/{$this->server['header_value']}/i", $value)) {
                                    $result = false;
                                } else {
                                    $header_flag = true;
                                    break; // No need to go further
                                }
                            }
                        }
                    }

                    if (!$header_flag) {
                        // Header was not present
                        $result = false;
                    }
                }
            }
        }

        // Check ssl cert just when other error is not already in...
        if ($result !== false) {
            $this->checkSsl($this->server, $this->error, $result);
        }

        // check if server is available and rerun if asked.
        if (!$result && $run < $max_runs) {
            return $this->updateWebsite($max_runs, $run + 1);
        }

        return $result;
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
