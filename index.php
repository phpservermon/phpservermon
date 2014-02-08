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

require 'src/bootstrap.php';

psm_no_cache();

if(isset($_GET['action']) && $_GET['action'] == 'check') {
	require 'cron/status.cron.php';
	header('Location: index.php');
}

$type = (!isset($_GET['type'])) ? 'servers' : $_GET['type'];
$allowed_types = array('servers', 'users', 'log', 'config', 'status');

// make sure user selected a valid type. if so, include the file and add to template
if(!in_array($type, $allowed_types)) {
	$type = $allowed_types[0];
}
$tpl = new \psm\Service\Template();

eval('$mod = new psm\Module\\'.ucfirst($type).'($db, $tpl);');
// let the module prepare it's HTML code
$mod->initialize();

?>