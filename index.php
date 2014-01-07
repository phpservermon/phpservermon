<?php

/*
 * PHP Server Monitor v2.0.1
 * Monitor your servers with error notification
 * http://phpservermon.sourceforge.net/
 *
 * Copyright (c) 2008-2011 Pepijn Over (ipdope@users.sourceforge.net)
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
 */

if(!file_exists('config.inc.php')) {
	die('Failed to locate config file. Please read docs/README for more information on how to setup PHP Server Monitor.');
}
require_once 'config.inc.php';

sm_no_cache();

if(isset($_GET['action']) && $_GET['action'] == 'check') {
	require 'cron/status.cron.php';
	header('Location: index.php');
}

$type = (!isset($_GET['type'])) ? 'servers' : $_GET['type'];
$allowed_types = array('servers', 'users', 'log', 'config');

// make sure user selected a valid type. if so, include the file and add to template
if(!in_array($type, $allowed_types)) {
	$type = $allowed_types[0];
}

eval('$mod = new mod'.ucfirst($type).'();');
// let the module prepare it's HTML code
$mod->createHTML();

?>