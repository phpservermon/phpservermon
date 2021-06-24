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
 * @author      Victor Macko
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 * @since       phpservermon 3.6.0
 **/

namespace psm\Txtmsg;

class Infobip extends Core
{
    
    /**
     * Send sms using the infobip.com API
     *
     * @var string $message
     * @var string $this->password
     * @var array $this->recipients
     * @var array $this->originator
     * @var string $recipients
     *
     * @var resource $curl
     * @var string $err
     * @var mixed $result
     *
     * @var int $success
     * @var string $error
     *
     * @return bool|string
     */

 
					
    public function sendSMS($message)
    {
        $success = 1;
        $error = '';
        foreach ($this->recipients as $recipient) {
            $ch = curl_init();
            curl_setopt(
                $ch,
                CURLOPT_URL,
                "https://api.infobip.com/sms/1/text/query?username=" . $this->username .
                    "&password=" . $this->password .
                    "&to=" . $recipient .
                    "&text=" . urlencode($message) .
                    //add your sender id here
                    "&from="
            );
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $headers = array();
            $headers[] = "Content-Type: application/x-www-form-urlencoded";
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result = curl_exec($ch);
            curl_close($ch);

            // Check for errors
            if (is_numeric(strpos($result, "FAILED"))) {
                $error = $result;
                $success = 0;
            }
        }
        if ($success == 1) {
            return 1;
        }
        return $error;
    }
}

