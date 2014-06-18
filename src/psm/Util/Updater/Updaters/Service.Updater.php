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


class ServiceUpdater extends AbstractUpdater
{

    public function PrepareIP($ip){
        // make sure websites start with http://

        return $ip;
    }
    public function ValidateIP($ip)
    {
      /*  if(!filter_var($ip, FILTER_VALIDATE_IP)) {
            throw new \InvalidArgumentException('server_ip_bad_service');
        }*/
    }


    /**
     * Check the current server as a service
     * @param array $server
     * @return boolean
     */
    public function Update($server) {
        $errno = 0;
        $error = '';

        $this->StartRun();

        $fp = fsockopen ($server['ip'], $server['port'], $errno, $error, 10);

        $this->StopRun();



        $status = ($fp === false) ? false : true;

        if($status == false && !empty ($error))
            $this->SetError($error);

        fclose($fp);

        return $status;
    }

}
