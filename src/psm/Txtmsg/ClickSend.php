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

class ClickSend extends Core {
    // =========================================================================
    // [ Fields ]
    // =========================================================================
    public $gateway         = 1;
    public $resultcode      = null;
    public $resultmessage   = null;
    public $success         = false;
    public $successcount    = 0;

    public function sendSMS($message) {
        // Documentation: http://docs.clicksend.apiary.io/#reference/sms/send-an-sms/send-an-sms
        // https://rest.clicksend.com/v3/sms/send
        // Use your API KEY as the password ($this->password)
        $apiurl     = "https://rest.clicksend.com/v3/sms/send";
        $from       = substr($this->originator,0,11); // Max 11 Char.

        $request = array('messages' => array());
        foreach($this->recipients as $phone) {
            $request['messages'][] = array(
                'source' => 'phpservermon',
                'from' => $from,
                'to' => $phone,
                'body' => $message
            );
        }

        $data_string = json_encode($request);
        $ch = curl_init($apiurl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $this->username . ':' . $this->password);
        $result = curl_exec($ch);

        $response = json_decode($result);
        $this->success = $response->data->response_code == 'SUCCESS';
        $this->successcount = $response->data->total_count;

        return $response;
    }

}
