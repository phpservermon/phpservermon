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
 * @author      Samuel Denis-D'Ortun <sam@sddproductions.com>
 * @copyright   Copyright (c) 2014 Samuel Denis-D'Ortun <sam@sddproductions.com>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/
namespace psm\Util\Updater\Types;


require_once 'AbstractUpdater.php';

use psm\Service\Database;
use psm\Util\Updater;


class WebsiteUpdater extends AbstractUpdater
{

    public function GetIcon(){
        return 'icon-globe';
    }

    public function PrepareIP($ip){
        // make sure websites start with http://
        if(substr($ip, 0, 4) != 'http') {
            $ip = 'http://' . $ip;
        }
        return $ip;
    }
    public function ValidateIP($ip)
    {
        if(!filter_var($ip, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException('server_ip_bad_website');
        }
    }




    /**
     * Check the current server as a website
     * @param array $server
     * @return boolean
     */
    public function Update($server) {

        $this->StartRun();
        // We're only interested in the header, because that should tell us plenty!
        // unless we have a pattern to search for!
        $curl_result = psm_curl_get(
            $server['ip'],
            true,
            ($server['pattern'] == '' ? false : true)
        );

        $this->StopRun();


        $result = $this->CheckResponseCode($curl_result );

        if($result != false && $server['pattern'] != '') {
            // Check to see if the pattern was found.
            if(!preg_match("/{$server['pattern']}/i", $curl_result)) {
                $this->SetError('Pattern not found.');
                $result = false;
            }
        }
        return $result;
    }


    private function CheckResponseCode($curl_result){

        // the first line would be the status code..
        $status_code = strtok($curl_result, "\r\n");
        // keep it general
        // $code[1][0] = status code
        // $code[2][0] = name of status code
        $code_matches = array();
        preg_match_all("/[A-Z]{2,5}\/\d\.\d\s(\d{3})\s(.*)/", $status_code, $code_matches);


        if(empty($code_matches[0])) {
            // somehow we dont have a proper response.
            $this->SetError( 'no response from server');
            return  false;
        } else {
            $code = $code_matches[1][0];
            $msg = $code_matches[2][0];

            // All status codes starting with a 4 or higher mean trouble!
            if(substr($code, 0, 1) >= '4') {
                $this->SetError( $code . ' ' . $msg);
                return false;
            } else {
                return true;
            }
        }
    }
}
