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
 * @author      Erik Shupingahua  <erikrs92@gmail.com>
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 * @since       phpservermon 3.5
 **/

namespace psm\Txtmsg;

class LabsMobile extends Core
{

    /**
     * Send sms using the Smsglobal API
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
        
        //$recipients = join(',', $this->recipients); Remove this
        
        $from = substr($this->originator, 0, 15); // Max 15 Characters
        $message = substr(rawurlencode($message), 0, 153);
        
        $curl = curl_init();

        //PREPARE RECIPIENTS:
        $recipients=$this->recipients;
        $recipentsWorked;
        foreach ($recipients as & $row){
            $recipentsWorked.='{"msisdn":"'.$row.'"}'; 
        }
        $auth_basic = base64_encode($this->username.":".$this->password);
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.labsmobile.com/json/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => '{"message":"'.$message.'", "tpoa":"Sender","recipient":['.$recipentsWorked.']}',
            CURLOPT_HTTPHEADER => array(
              "Authorization: Basic ".$auth_basic,
              "Cache-Control: no-cache",
              "Content-Type: application/json"
            ),
          ));
          
        $result = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);
        curl_close($curl); 
        
        //Error code: https://apidocs.labsmobile.com/#results-and-errors
        $jsonresponse=(json_decode($result, true));   
        $msgjson =$jsonresponse["message"];
        $codejson=$jsonresponse["code"];
        if ( in_array($codejson, range(21,41)) || $codejson==52   || $codejson==400   || $codejson==401   || $codejson==403  || $codejson==500  ) {
          $success = 0;
          $result =$codejson.':'. $msgjson;
          $error = "HTTP_code: " . $httpcode . ".\ncURL error (" . $result . "): " .
          curl_strerror($err) . ". \nResult: " . $result;
        }  
        if ($err) { 
          $success = 0;
          $result = ($result == '') ? 'Wrong input, please check if all values are correct!' : $result;
          $error = "HTTP_code: " . $httpcode . ".\ncURL error (" . $err . "): " .
          curl_strerror($err) . ". \nResult: " . $result;
           
        } if ( $codejson==0) {
            return 1;
        }
        return $error;
    }
}
