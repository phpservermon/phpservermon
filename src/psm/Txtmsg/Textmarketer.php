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
 * @author      Perri Vardy-Mason
 * @author      Tim Zandbergen <Tim@Xervion.nl>
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 * @since       phpservermon 2.1
 **/

namespace psm\Txtmsg;

class Textmarketer extends Core
{

    /**
     * Send sms using the Textmarketer API
     * @var string $message
     * @var array $this->recipients
     * @var string $recipient
     * @var string $this->username
     * @var string $this->password
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
        $success = 1;
        $error = '';
        foreach ($this->recipients as $recipient) {
            $ch = curl_init();
            curl_setopt(
                $ch,
                CURLOPT_URL,
                "https://api.textmarketer.co.uk/gateway/?username=" . $this->username .
                    "&password=" . $this->password .
                    "&to=" . $recipient .
                    "&message=" . urlencode($message) .
                    "&orig=SERVERALERT"
            );
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $headers = array();
            $headers[] = "Content-Type: application/x-www-form-urlencoded";
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result = curl_exec($ch);
            curl_close($ch);

            // Check on error
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
