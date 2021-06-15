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

class Tele2 extends Core
{
    
    /**
     * Send sms using the Tele2 Messaging API based on Infobip
     * The username can be blank, password is the API key
     * 
     *
     * @var string $message
     * @var string $this->baseurl
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
        $error = "";

        /**
         * Creates a curl object, loops through participants to add them to the same message and makes a single API call to send to all
         */
        $ch = curl_init("https://api.tele2messaging.com/sms/2/text/advanced");
        
        /**
         * To Do: Add validation/formatting for message to format [countrycode][number_without_0] e.g. 4571234567 instead of +451234567/00451234567/01234567
         */
        $recipients = [];

        foreach ($this->recipients as $recipient) {
             $recipients[] = [
                'to' => "$recipient"
             ];
        }

        $postfields = [
            'messages' => [
                [
                    'from' => $this->originator,
                    'destinations' => $recipients,
                    'text' => "$message"
                ]
            ]
        ];

        curl_setopt_array($ch, [
            CURLOPT_POST => 1,
            CURLOPT_RETURNTRANSFER 	=> false,
            CURLOPT_MAXREDIRS 		=> 10,
            CURLOPT_TIMEOUT 		=> 0,
            CURLOPT_FOLLOWLOCATION 	=> true,
            CURLOPT_HTTP_VERSION 	=> CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST 	=> 'POST',
            CURLOPT_POSTFIELDS 		=> json_encode($postfields),
            CURLOPT_HTTPHEADER => [
                'AUTHORIZATION: App '.$this->password,
                'Content-Type: application/json',
                'Accept: application/json'
            ],
        ]);
                   
        $result = curl_exec($ch);
        $returncode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);

        if ($returncode !== 200) {
            $success = 0;
        }
        else {
            $error = $result;
        }

        return ($success === 1 ? 1 : $error);
    }   
}

