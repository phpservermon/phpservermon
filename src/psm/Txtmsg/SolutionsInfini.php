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
 * @author      Ward Pieters <ward@wardpieters.nl>
 * @author      Tim Zandbergen <Tim@Xervion.nl>
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 * @since       phpservermon 3.3.0
 **/

namespace psm\Txtmsg;

class SolutionsInfini extends Core
{

    /**
     * Send sms using the SolutionsInfini API
     *
     * @var string $message
     * @var string $this->password
     * @var array $this->recipients
     * @var string $recipients
     * @var array $this->originator (Max 11 characters)
     *
     * @var resource $curl
     * @var string $err
     *
     * @var int $success
     * @var string $error
     *
     * @return bool|string
     */
    
    public function sendSMS($message)
    {
        $error = "";
        $success = 1;

        $message = urlencode($message);

        $recipients = join(',', $this->recipients);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://api-alerts.solutionsinfini.com/v4/?" . http_build_query(
            array(
                    "api_key" => $this->password,
                    "method" => "sms",
                    "to" => $recipients,
                    "sender" => substr($this->originator, 0, 15),
                    "message" => $message,
                )
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);


        $result = json_decode(curl_exec($curl), true);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_errno($curl);

        if ($err != 0 || $httpcode != 200 || $result['status'] != "OK") {
            $success = 0;
            $error = "HTTP_code: " . $httpcode . ".\ncURL error (" . $err . "): " .
                curl_strerror($err) . ". Result: " . $result['status'] . " - " . $result['message'] . ".";
        }
        curl_close($curl);
        if ($success) {
            return 1;
        }
        return $error;
    }
}
