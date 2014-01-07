<?php

/*
 * PHP Server Monitor v2.0.0
 * Monitor your servers with error notification
 * http://phpservermon.sourceforge.net/
 *
 * Copyright (c) 2008-2009 Pepijn Over (ipdope@users.sourceforge.net)
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

require_once 'config.inc.php';

sm_no_cache();

if(isset($_GET['action']) && $_GET['action'] == 'check') {
	require 'cron/status.cron.php';
	header('Location: index.php');
}

$tpl = new smTemplate();

$tpl->addJS('monitor.js');
$tpl->addCSS('monitor.css');

// check for updates?
if(sm_get_conf('show_update')) {
	$last_update = sm_get_conf('last_update_check');

	if((time() - (7 * 24 * 60 * 60)) > $last_update) {
		// been more than a week since update, lets go
		$need_upd = sm_check_updates();
		// update "update-date"
		$db->save(SM_DB_PREFIX . 'config', array('value' => time()), array('key' => 'last_update_check'));

		if($need_upd) {
			// yay, new update available =D
			$tpl->addTemplateData(
				'main',
				array(
					'update_available' => '<div id="update">'.sm_get_lang('system', 'update_available').'</div>',
				)
			);
		}
	}
}


$type = (!isset($_GET['type'])) ? 'servers' : $_GET['type'];
$allowed_types = array('servers', 'users', 'log', 'config');

// add some default vars
$tpl->addTemplateData(
	'main',
	array(
		'title' => strtoupper(sm_get_lang('system', 'title')),
		'subtitle' => sm_get_lang('system', $type),
		'label_servers' => sm_get_lang('system', 'servers'),
		'label_users' => sm_get_lang('system', 'users'),
		'label_log' => sm_get_lang('system', 'log'),
		'label_config' => sm_get_lang('system', 'config'),
		'label_update' => sm_get_lang('system', 'update'),
		'label_help' => sm_get_lang('system', 'help'),
		'active_' . $type => 'active',
	)
);

// make sure user selected a valid type. if so, include the file and add to template
if(in_array($type, $allowed_types)) {
	eval('$mod = new mod'.ucfirst($type).'();');

	$html = $mod->createHTML();

	$tpl->addTemplatedata(
		'main',
		array(
			'content' => $html,
		)
	);
}

echo $tpl->display('main');

?>