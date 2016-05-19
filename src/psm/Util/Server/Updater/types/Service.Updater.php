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

    const SOCK_OPEN_TIMEOUT = 3;

    public function GetIcon()
    {
        return 'icon-globe';
    }

    public function PrepareIP($ip)
    {
        // make sure websites start with http://
        if (substr($ip, 0, 4) != 'http')
        {
            $ip = 'http://' . $ip;
        }

        return $ip;
    }

    public function ValidateIP($ip)
    {
        if (
            !filter_var($ip, FILTER_VALIDATE_IP)
            // domain regex as per http://stackoverflow.com/questions/106179/regular-expression-to-match-hostname-or-ip-address :
            && !preg_match("/^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])/", $ip)
        )
        {
            throw new \InvalidArgumentException('server_ip_bad_service');
        }
    }


    /**
     * Check the current server as a website
     *
     * @param array $server
     *
     * @return boolean
     */
    public function Update($server)
    {
        $this->StartRun();
        $errorStr = '';
        $errno    = 0;
        $fp       = @fsockopen($server['ip'], $server['port'], $errno, $errorStr, self::SOCK_OPEN_TIMEOUT);

        if ( !empty( $errorStr ))
        {
            $this->SetError($errorStr);
        }

        $result = ( $fp === false ) ? false : true;

        if (is_resource($fp))
        {
            fclose($fp);
        }
        $this->StopRun();


        return $result;
    }


}
