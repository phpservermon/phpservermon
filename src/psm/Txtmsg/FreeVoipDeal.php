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
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 * @since       phpservermon 3.1
 **/

namespace psm\Txtmsg;

class FreeVoipDeal extends Core
{
    
    /**
     * Send sms using the FreeVoipDeal API
     * @var string $message
     * @var string $this->password
     * @var array $this->recipients
     * @var array $this->originator
     *
     * @var resource $curl
     * @var string $err
     * @var string $recipient
     * @var string $from
     * @var mixed $result
     * @var int $success
     * @var string $error
     *
     * @return bool|string
     */
    
    public function sendSMS($message)
    {
        $error = "";
        $success = 1;
        
        $message = rawurlencode($message);
        
        foreach ($this->recipients as $recipient) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, "https://www.freevoipdeal.com/myaccount/sendsms.php?" . http_build_query(
                array(
                        "username" => $this->username,
                        "password" => $this->password,
                        "from" => substr($this->originator, 0, 15),
                        "to" => $recipient,
                        "text" => $message,
                    )
            ));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            
            $result = curl_exec($curl);
            $err = curl_errno($curl);
            curl_close($curl);
            
            if ($err != 0 || is_numeric(strpos($result, "failure"))) {
                $success = 0;
                $error = $result;
            }
        }
        
        if ($success) {
            return 1;
        }
        return $error;
    }
}
