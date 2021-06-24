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
     * Formats the number to e.g. 45701234567 instead of +45701234567/00451234567
     * Error if the number begins with a single 0, indicates no country code has been provided. 
     * Will still attempt to send to this and other numbers, but return an error message.
     * Also remove spaces, braces and other special characters
     */
    private function formatNumber( $number ) : string 
    {
        $number = str_replace(['-', ' ', '(', ')'], '', $number);
		
        if (substr($number, 0, 1) === '+') {
            return substr($number, 1);
        }
        elseif (substr($number, 0, 2) === '00') {
            return substr($number, 2);
        }
        elseif (substr($number, 0, 1) === '0') {
            return null;
        }
		else return $number;

    }


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
        $error = '';

        /**
         * Creates a curl object, loops through participants to add them to the same message and makes a single API call to send to all
         */
        $ch = curl_init("https://api.tele2messaging.com/sms/2/text/advanced");
        
        
        
        $recipients = [];

        foreach ($this->recipients as $recipient) {
            $format = $this->formatNumber($recipient);
            if (!$format) {
                $error = "ERROR: Incorrect format, needs to include country code (e.g. 45123456789 instead of 0123456789/450123456789/+45123456789/0045123456789)";
            }
            $recipients[] = [
               'to' => $format ?? $recipient
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

        if ($returncode !== 200 || $error !== '') {
            $success = 0;
            $error .= $result;
        }
        
        return ($success === 1 ? 1 : $error);
    }   
}

