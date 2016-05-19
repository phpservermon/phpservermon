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


class ImapUpdater extends AbstractUpdater
{

    public function GetIcon(){
        return 'icon-globe';
    }


    public function ValidateIP($ip)
    {
        // make sure websites start with http://
        if(substr($ip, 0, 7) != 'imap://') {
            throw new \InvalidArgumentException('server_ip_bad_imap');
        }
        if(!filter_var($ip, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException('server_ip_bad_imap');
        }
    }

    /**
     * Check the current server as a IMAP Server
     *
     * Allow to open connections to IMAP server.
     *
     * IP must be provided in a URL encoded string (See PHP imap_open())
     * - imap://user:pass@domain.com/OPTIONS
     *
     * When host require full email address, replace the @ with %40 in the user field.
     * - imap://mailbox%40domain.com:mypassword@domain.com/novalidate-cert
     *
     * @param array $server
     * @return boolean
     */
    public function Update($server) {

        $this->StartRun();

        $url = parse_url($server['ip']);

        imap_errors(); // clean error list

        $stream = @imap_open( '{' .  $url['host'] . $url['path'] . '}' ,urldecode( $url['user'] ) ,urldecode($url['pass']) , OP_HALFOPEN );

        if($stream === false)
        {
            $errors = @imap_errors() ;

            $this->SetError( implode(" ; " , $errors));
        }
        else
            imap_close($stream);

        $result  = ($stream !== false) ? true: false;

        $this->StopRun();

        return $result;
    }
}
