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
 * @since       phpservermon 3.2
 **/

namespace psm\Txtmsg;

class ClickSend extends Core
{
    
    /**
     * Send sms using the SMSgw.NET API
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
        $error = "";
        $success = 1;
        
        if (empty($this->recipients)) {
            return false;
        }
        
        $data = array('messages' => array());
        foreach ($this->recipients as $recipient) {
            $data['messages'][] = array(
                'source' => 'phpservermon',
                'from' => substr($this->originator, 0, 15),
                'to' => $recipient,
                'body' => $message,
            );
        }
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://rest.clicksend.com/v3/sms/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                "authorization: Basic " . base64_encode($this->username . ":" . $this->password),
                "content-type: application/json"
            ),
        ));
        
        $result = json_decode(curl_exec($curl), true);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_errno($curl);
        
        if (
            $err != 0 ||
            ($httpcode != '200' && $httpcode != '201' && $httpcode != '202' && $result['response_code'] != "SUCCESS")
        ) {
            $success = 0;
            $error = "HTTP_code: " . $httpcode . ".\ncURL error (" . $err . "): " .
                curl_strerror($err) . ". Result: " . $result . "";
        }
        curl_close($curl);
        
        if ($success) {
            return 1;
        }
        return $error;
    }
}
