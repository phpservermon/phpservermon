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
 * @author      Perri Vardy-Mason
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 * @since       phpservermon 2.1
 **/

namespace psm\Txtmsg;

class Textmarketer extends Core {
    // =========================================================================
    // [ Fields ]
    // =========================================================================
    public $gateway = 1;
    public $resultcode = null;
    public $resultmessage = null;
    public $success = false;
    public $successcount = 0;

    public function sendSMS($message) {

        $textmarketer_url = "https://api.textmarketer.co.uk/gateway/";
        $textmarketer_data = urlencode( $message );
        $textmarketer_origin = urlencode( 'SERVERALERT' );


        foreach( $this->recipients as $phone ){

            $URL = $textmarketer_url."?username=" . $this->username . "&password=" . $this->password . "&to=" . $phone . "&message=" . $textmarketer_data . "&orig=" . $textmarketer_origin;

            $result = file_get_contents( $URL );

        }

        return $result;
    }

}
