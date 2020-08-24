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
 * @Author      Tim Zandbergen <Tim@Xervion.nl>
 * @author      Ward Pieters <ward@wardpieters.nl>
 * @author      Alexandre ZANELLI <alexandre@les-z.org>
 * @copyright   Copyright (c) 2016 Alexis Urien <alexis.urien@free.fr>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 * @since       phpservermon 3.5
 **/

namespace psm\Txtmsg;

class OVHsms extends Core {
    
    /**
     * Send sms using the OVH http2sms gateway
     * Online documentation :https://docs.ovh.com/fr/sms/envoyer_des_sms_depuis_une_url_-_http2sms/
     * Ovh need Account and Login, then use format login@account in username field.
     * 
     * @var string $message
     * @var string $this->username
     * @var string $this->password
     * @var array $this->recipients
     * @var array $this->originator
     *
     * @var resource $curl
     * @var SimpleXMLElement $xmlResults
     * @var string $err
     * @var string $recipient
     * @var mixed $result
     *
     * @var int $success
     * @var string $error
     *
     * @return bool|string
     */
     
    
    public function sendSMS($message) {
        $error = "";
        $success = 1;

        $account_login = explode('@',$this->username); 
        
        $recipients = join(',', $this->recipients);
        

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://www.ovh.com/cgi-bin/sms/http2sms.cgi?".http_build_query(
                array(
                    "account" => $account_login[1],
                    "login" => $account_login[0],
                    "password" => $this->password,
                    "from" => str_replace('+', '00', $this->originator),
                    "to" => $recipients,
                    "message" => $message,
                    "contentType" => "text/xml",
                    "noStop" => 1,
                )
            )
        );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        $result = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $xmlResults = simplexml_load_string($result);
        $err = curl_errno($curl);

        if ($err != 0 || $httpcode != 200 || $xmlResults === false ||($xmlResults->status != '100' && $xmlResults->status != '101')) {
            $success = 0;
            $error = "HTTP_code: ".$httpcode.".\ncURL error (".$err."): ".curl_strerror($err).". \nResult: ".$xmlResults->status." \n".$xmlResults->Message;
        }
        curl_close($curl);
        
        if ($success) {
            return 1;
        }
        return $error;
    }
}
