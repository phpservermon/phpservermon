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

namespace psm\Txtmsg;

class Spryng extends Core
{

    /**
     * Send sms using the Spryngsms API
     * @var string $message
     * @var array $this->recipients
     * @var string $this->username
     * @var string $this->password
     * @var string $this->originator
     * @var mixed $result
     * @var array $headers
     *
     * @var int $success
     * @var string $error
     *
     * @return bool|string
     */
    
    public function sendSMS($message)
    {
        $recipients = implode(",", $this->recipients);

        $ch = curl_init();
        curl_setopt(
            $ch,
            CURLOPT_URL,
            "https://api.spryngsms.com/api/send.php?OPERATION=send&USERNAME=" .
                urlencode($this->username) .
                "&PASSWORD=" . urlencode($this->password) .
                "&DESTINATION=" . urlencode($recipients) .
                "&SENDER=" . urlencode($this->originator) .
                "&BODY=" . urlencode($message) . "&SMSTYPE=BUSINESS"
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $headers = array();
        $headers[] = "Content-Type: application/x-www-form-urlencoded";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        curl_close($ch);

        // Check on error
        if ($result != 1) {
            return "Error " . $result . ": see http://www.spryng.nl/en/developers/http-api/ for the description.";
        }
        return 1;
    }
}
