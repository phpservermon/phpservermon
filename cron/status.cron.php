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
 * @link        http://phpservermon.neanderthal-technology.com/
 **/

// include main configuration and functionality
require_once dirname(__FILE__) . '/../src/bootstrap.php';

// prevent cron from running twice at the same time
// however if the cron has been running for 10 mins, we'll assume it died and run anyway
$time = time();
if(psm_get_conf('cron_running') == 1 && ($time - psm_get_conf('cron_running_time') < 600)) {
   die('Cron is already running. Exiting.');
}
psm_update_conf('cron_running', 1);
psm_update_conf('cron_running_time', $time);

// get the active servers from database
$servers = $db->select(
	PSM_DB_PREFIX.'servers',
	array('active' => 'yes'),
	array('server_id', 'ip', 'port', 'label', 'type', 'pattern', 'status', 'active', 'email', 'sms')
);

$updater = new \psm\Util\Updater\Status();

foreach ($servers as $server) {
	$status_org = $server['status'];
	// remove the old status from the array to avoid confusion between the new and old status
	unset($server['status']);

	$updater->setServer($server, $status_org);

	// check server status
	// it returns the new status, and performs the update check automatically.
	$status_new = $updater->getStatus();
	// notify the nerds if applicable
	$updater->notify();

	// update server status
	$save = array(
		'last_check' => date('Y-m-d H:i:s'),
		'status' => $status_new,
		'error' => $updater->getError(),
		'rtime' => $updater->getRtime(),
	);

	// if the server is on, add the last_online value
	if($save['status'] == 'on') {
		$save['last_online'] = date('Y-m-d H:i:s');
	}

	$db->save(
		PSM_DB_PREFIX . 'servers',
		$save,
		array('server_id' => $server['server_id'])
	);
}

psm_update_conf('cron_running', 0);

?>