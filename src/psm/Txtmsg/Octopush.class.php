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
 * @author      Alexis Urien
 * @copyright   Copyright (c) 2016 Alexis Urien <alexis.urien@free.fr>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 * @since       phpservermon 2.1
 **/

namespace psm\Txtmsg;

class Octopush extends Core {
    // =========================================================================
    // [ Fields ]
    // =========================================================================
    public $gateway = 1;
    public $resultcode = null;
    public $resultmessage = null;
    public $success = false;
    public $successcount = 0;

    public function sendSMS($message) {
        // Octopush exemple url
        // french documentation can be found here: http://www.octopush-dm.com/public/docs/envoyer-des-sms-avec-octopush.pdf (need to be logged in)
        //'http://www.octopush-dm.com/api/sms/?user_login=*****%40******.com&api_key=****************&sms_text=un+exemple+de+texte&sms_recipients=0033601010101&sms_type=FR&sms_sender=UnSender'
        if(count($this->recipients) == 0)
            return false;

       $testMode = false;
       $highPriority = true;

       if ($highPriority) {
           $sms_type = 'FR';
           $sms_sender = 'phpServerMon';
           $sms_more = ' STOP au XXXXX';
       }
       else {
           $sms_type = 'XXX';
           $sms_more = '';
       }


        $recipients = urlencode(implode(',', $this->recipients));
        $octopush_url = "https://www.octopush-dm.com/api/sms/";
        $octopush_data = urlencode( $message . $sms_more );

        $URL = $octopush_url. "?" .
            "user_login=" . $this->username .
            "&api_key=" . $this->password .
            "&sms_recipients=" . $recipients .
            "&sms_type=" . $sms_type .
            ($testMode ? '&request_mode=simu' : '') .
            (isset($sms_sender) ? '&sms_sender='.$sms_sender : '') .
            "&sms_text=" . $octopush_data;

        $result = file_get_contents( $URL );
        $xmlResults = simplexml_load_string($result);
        if ($xmlResults === false)
            return false;

        if ($xmlResults->error_code == '000')
            return true;
        return false;
    }

}
