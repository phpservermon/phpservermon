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
 * @author      Pepijn Over <pep@mailbox.org>
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

// include main configuration and functionality
require_once __DIR__ . '/../src/bootstrap.php';

if(!psm_is_cli()) {
	// check if it's an allowed host
	$allow = PSM_CRON_ALLOW;
	if(!in_array($_SERVER['REMOTE_ADDR'], $allow) && !in_array($_SERVER["HTTP_X_FORWARDED_FOR"], $allow)) {
		header('HTTP/1.0 404 Not Found');
		die('<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN"><html><head><title>404 Not Found</title></head><body><h1>Not Found</h1><p>The requested URL /cron/status.cron.php was not found on this server.</p></body></html>');
	}
}

$cron_timeout = PSM_CRON_TIMEOUT;
// parse a couple of arguments
if(!empty($_SERVER['argv'])) {
    foreach ($_SERVER['argv'] as $argv) {
		$argi = explode('=', ltrim($argv, '--'));
		if(count($argi) !== 2) {
			continue;
		}
		switch($argi[0]) {
			case 'uri':
				define('PSM_BASE_URL', $argi[1]);
				break;
			case 'timeout':
				$cron_timeout = intval($argi[1]);
				break;
		}
	}
}

// prevent cron from running twice at the same time
// however if the cron has been running for X mins, we'll assume it died and run anyway
// if you want to change PSM_CRON_TIMEOUT, have a look in src/includes/psmconfig.inc.php.
// or you can provide the --timeout=x argument
$time = time();
if(
	psm_get_conf('cron_running') == 1
	&& $cron_timeout > 0
	&& ($time - psm_get_conf('cron_running_time') < $cron_timeout)
) {
   die('Cron is already running. Exiting.');
}
if(!defined('PSM_DEBUG') || !PSM_DEBUG) {
	psm_update_conf('cron_running', 1);
}
psm_update_conf('cron_running_time', $time);

$autorun = $router->getService('util.server.updatemanager');
$autorun->run(true);

psm_update_conf('cron_running', 0);
