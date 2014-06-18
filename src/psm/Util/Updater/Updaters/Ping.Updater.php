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


class PingUpdater extends AbstractUpdater
{

    /**
     * Check the current server as a ping
     * @param array $server
     * @return boolean
     */
    public function Update($server) {
        /**
         * Only run if is cron
         * socket_create() need to run as root :(
         * ugly cli hack i know
         * might be a better way still have not found a solution when updating true website
         */
        if(psm_is_cli()) {


            $this->StartRun();

            // if ipv6 we have to use AF_INET6
            if (psm_validate_ipv6($server['ip'])) {
                // Need to remove [] on ipv6 address
                $server['ip'] = trim($server['ip'], '[]');
                $socket  = socket_create(AF_INET6, SOCK_RAW, 1);
            } else {
                $socket  = socket_create(AF_INET, SOCK_RAW, 1);
            }

            $timeout	= 1;
            $package	= "\x08\x00\x7d\x4b\x00\x00\x00\x00PingHost"; /* ICMP ping packet with a pre-calculated checksum */

            socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array('sec' => $timeout, 'usec' => 0));
            socket_connect($socket, $server['ip'], null);
            socket_send($socket, $package, strLen($package), 0);

            // if ping fails it returns false
            $status = (socket_read($socket, 255)) ? true : false;

            $this->StopRun();

            socket_close($socket);

            return $status;


            // If state on last update was 'on' and the update request is comming from the website
        } elseif ($server['status'] == 'on') {
            // need to set rtime to the value from last update, if not the latency will be 0
            $this->rtime = $server['rtime'];
            $this->SetError( 'Update skipped, status will be updated on next cron script run.');
            return true;
        } else {
            return false;
        }
    }
}