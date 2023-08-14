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
 * @author      Alexis Urien <Alexis.urien@free.fr>
 * @author      Tim Zandbergen <Tim@Xervion.nl>
 * @author      Ward Pieters <ward@wardpieters.nl>
 * @author      Marc Farré <contact@marc.fun>
 * @copyright   Copyright (c) 2016 Alexis Urien <alexis.urien@free.fr>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: v3.5.2
 * @link        http://www.phpservermonitor.org/
 * @since       phpservermon 2.1
 **/

namespace psm\Txtmsg;

class Octopush extends Core
{
    
    /**
     * Send sms using the Octopush API
     * @var string $message
     * @var string $this->username
     * @var string $this->password
     * @var array $this->recipients
     * @var array $this->originator
     *
     * @var resource $ch
     * @var SimpleXMLElement $xmlResults
     * @var string $err
     * @var string $recipient
     * @var string $smsType
     * @var mixed $result
     *
     * @return bool|string
     */
    
    public function sendSMS($message)
    {
        $smsType = "sms_premium"; // Or "sms_low_cost"

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.octopush.com/v1/public/sms-campaign/send');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'api-login: '.$this->username,
            'api-key: '.$this->password,
            'cache-control: no-cache',
        ]);
        $recipients = [];
        foreach ($this->recipients as $recipient) {
            $recipients[] = ['phone_number' => ((substr($recipient, 0, 1) != '+') ? '+' : '').(string)$recipient];
        }

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            'recipients' => $recipients,
            'text' => $message.(($smsType === "sms_premium") ? ' STOP au XXXXX' : ''),
            'type' => $smsType,
            'purpose' => 'alert',
            'with_replies' => false,
            'sender' => substr($this->originator, 0, 15),
        ]));

        $response = curl_exec($ch);

        $result = json_decode(curl_exec($ch), true);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_errno($ch);
        curl_close($ch);

        if ($err != 0 || ($httpcode != 201 && $httpcode != 200)) {
            return $result['code'] . " - " . $result['message'];
        }

        return 1;
    }
}
