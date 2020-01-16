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
        $this->rtime = '';

        // get server info from db
        $this->server = $this->db->selectRow(PSM_DB_PREFIX . 'servers', array(
            'server_id' => $server_id,
        ), array(
            'server_id', 'ip', 'port', 'request_method', 'label',
            'type', 'pattern', 'pattern_online', 'post_field',
            'allow_http_status', 'redirect_check', 'header_name',
            'header_value', 'status', 'active', 'warning_threshold',
            'warning_threshold_counter', 'timeout', 'website_username',
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
        if ($max_runs == null || $max_runs > 1) {
            $max_runs = 1;
        }
        $result = null;
        // Execute ping
        $txt = exec("ping -c " . $max_runs . " " . $this->server['ip'] . " 2>&1", $output);
        // Non-greedy match on filler
        $re1 = '.*?';
        // Uninteresting: float
        $re2 = '[+-]?\\d*\\.\\d+(?![-+0-9\\.])';
        // Non-greedy match on filler
        $re3 = '.*?';
        // Float 1
        $re4 = '([+-]?\\d*\\.\\d+)(?![-+0-9\\.])';
        if (preg_match_all("/" . $re1 . $re2 . $re3 . $re4 . "/is", $txt, $matches)) {
            $result = $matches[1][0];
        }

        if (!is_null($result)) {
            $this->header = $output[0];
            $status = true;
        } else {
            $this->header = "-";
            $this->error = $output[0];
            $status = false;
        }
        //Divide by a thousand to convert to milliseconds
        $this->rtime =  $result / 1000;

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

        $fp = @fsockopen($this->server['ip'], $this->server['port'], $errno, $this->error, $timeout);

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

        $this->header = $curl_result["result"];
        $code = $curl_result["info"]["http_code"];
        $redirectUrl = $curl_result["info"]["redirect_url"];

        $this->rtime = (microtime(true) - $starttime);
        
        if (empty($code)) {
            // somehow we dont have a proper response.
            $this->error = 'TIMEOUT ERROR: no response from server';
            $result = false;
        } else {
            $allow_http_status = explode("|", $this->server['allow_http_status']);
            // All status codes starting with a 4 or higher mean trouble!
            if (substr($code, 0, 1) >= '4' && !in_array($code, $allow_http_status)) {
                $this->error = "HTTP STATUS ERROR: " . $code;
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
                            $this->header
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
                    if (!empty($redirectUrl)) {
                        $redirectPieces = parse_url($redirectUrl);
                        $ipPieces = parse_url($this->server['ip']);

                        if (strtolower($redirectPieces['host']) !== strtolower($ipPieces['host'])) {
                            $this->error = "The IP/URL redirects to another domain.";
                            $result = false;
                        }
                    }
                }

                // Should we check a header ?
                if ($this->server['header_name'] != '' && $this->server['header_value'] != '') {
                    $header_flag = false;
                    // Only get the header text if the result also includes the body
                    $header_text = substr($this->header, 0, strpos($this->header, "\r\n\r\n"));
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
}
