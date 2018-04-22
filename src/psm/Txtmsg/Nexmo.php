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
 * @author      Andreas Ek
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 * @since       phpservermon 3.1.1
 **/

namespace psm\Txtmsg;

class Nexmo extends Core {
        // =========================================================================
        // [ Fields ]
        // =========================================================================
        public $gateway = 1;
        public $resultcode = null;
        public $resultmessage = null;
        public $success = false;
        public $successcount = 0;

        public function sendSMS($message) {
                $nexmo_url = "https://rest.nexmo.com/sms/json";
                $nexmo_data = rawurlencode( $message );

                foreach( $this->recipients as $phone ){
                        $result = file_get_contents( $nexmo_url . 
                                                      "?api_key=" . $this->username .
                                                      "&api_secret=" . $this->password . 
                                                      "&from=" . $this->originator  . 
                                                      "&to=" . $phone . 
                                                      "&type=text" .
                                                      "&text=" . $nexmo_data 
                        );
                }

                return $result;
        }
}
