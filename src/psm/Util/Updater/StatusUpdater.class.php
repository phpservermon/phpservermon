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
 * @author      Pepijn Over <pep@neanderthal-technology.com>
 * @copyright   Copyright (c) 2008-2014 Pepijn Over <pep@neanderthal-technology.com>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

/**
 * The status class is for checking the status of a server.
 *
 * @see \psm\Util\Updater\StatusNotifier
 * @see \psm\Util\Updater\Autorun
 */
namespace psm\Util\Updater;

use psm\Service\Database;
use psm\Util\Updater\Types;




class StatusUpdater {
	/**
	 * Database service
	 * @var \psm\Service\Database $db
	 */
	protected $db;

	/**
	 * Server id to check
	 * @var int $server_id
	 */
	protected $server_id;

	/**
	 * Server information
	 * @var array $server
	 */
	protected $server;

    protected $handlers = array();
	function __construct(Database $db) {
		$this->db = $db;

        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        $this->LoadHandlers();
	}



    private function LoadHandlers(){

        foreach(glob(dirname(__FILE__ ) . DIRECTORY_SEPARATOR . 'Updaters' . DIRECTORY_SEPARATOR . '*.Updater.php') as $path)
        {
            $filename = basename($path);

            if(!preg_match('/(?P<name>[a-zA-Z0-9]+).Updater.php$/',$filename , $matches))
                continue;

            if($matches === NULL || empty($matches['name']))
                continue;

            $name = $matches['name'];
            if(array_key_exists($name , $this->handlers))
                continue;

            include_once $path;

            $class_name = 'psm\\Util\\Updater\\Types\\' . $name . 'Updater';

            if(!class_exists($class_name))
                continue;

            $this->handlers[strtolower( $name) ] = new $class_name($this->db);
        }
    }


    public function GetHandlers(){
        return $this->handlers;
    }

    public function GetHandler($name){

        if(!array_key_exists($name , $this->handlers))
            throw new \InvalidArgumentException('server_type_invalid');

        return $this->handlers[strtolower( $name) ];
    }

	/**
	 * The function its all about. This one checks whether the given ip and port are up and running!
	 * If the server check fails it will try one more time, depending on the $max_runs.
	 *
	 * Please note: if the server is down but has not met the warning threshold, this will return true
	 * to avoid any "we are down" events.
	 * @param int $server_id
	 * @param int $max_runs how many times should the script recheck the server if unavailable. default is 2
	 * @return boolean TRUE if server is up, FALSE otherwise
	 */
	public function update($server_id, $max_runs = 2) {
		$this->server_id = $server_id;
		$this->error = '';
		$this->rtime = '';

		// get server info from db
		$this->server = $this->db->selectRow(PSM_DB_PREFIX . 'servers', array(
			'server_id' => $server_id,
		), array(
			'server_id', 'ip', 'port', 'label', 'type', 'pattern', 'status', 'active', 'warning_threshold', 'warning_threshold_counter',
		));


		if(empty($this->server)) {
			return false;
		}


        $cur_run = 1;

        $handler = $this->GetHandler($this->server['type']);


        $status_new = true;
        do{


            $status_new  = $handler->Update($this->server);

        }while( $status_new  == false && $cur_run++ <= $max_runs ) ;


		// update server status
		$save = array(
			'last_check' => date('Y-m-d H:i:s'),
			'error' => $handler->GetError(),
			'rtime' => $handler->GetRunTime(),
		);

		// log the uptime before checking the warning threshold,
		// so that the warnings can still be reviewed in the server history.
		psm_log_uptime($this->server_id, (int) $status_new , $handler->GetRunTime());

		if($status_new  == true) {
			// if the server is on, add the last_online value and reset the error threshold counter
			$save['status'] = 'on';
			$save['last_online'] = date('Y-m-d H:i:s');
			$save['warning_threshold_counter'] = 0;
		} else {
			// server is offline, increase the error counter
			$save['warning_threshold_counter'] = $this->server['warning_threshold_counter'] + 1;

			if($save['warning_threshold_counter'] < $this->server['warning_threshold']) {
				// the server is offline but the error threshold has not been met yet.
				// so we are going to leave the status "on" for now while we are in a sort of warning state..
				$save['status'] = 'on';
                $status_new  = true;
			} else {
				$save['status'] = 'off';
			}
		}

		$this->db->save(PSM_DB_PREFIX . 'servers', $save, array('server_id' => $this->server_id));

		return $status_new ;

	}
}
