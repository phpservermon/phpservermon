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

// this script creates all the database tables required for server monitor
error_reporting(0x0ffffff);

require 'config.inc.php';

if(!function_exists('curl_init')) {
	die('PHP is installed without the cURL module. Please install cURL first.');
}

$tpl = new smTemplate();
$tpl->addCSS('monitor.css', 'install');

$tpl->newTemplate('install', 'install.tpl.html');


if(!is_resource($db->getLink())) {
	// no valid db info
	$tpl->addTemplatedata(
		'install',
		array('error' => 'Couldn\'t connect to database!')
	);
	echo $tpl->display('install');
	die();
}

$tables = array(
	'users' =>
		array(
			0 => "CREATE TABLE `" . SM_DB_PREFIX . "users` (
				  `user_id` int(11) NOT NULL auto_increment,
				  `server_id` varchar(255) NOT NULL,
		  		  `name` varchar(255) NOT NULL,
		  		  `mobile` varchar(15) NOT NULL,
		  		  `email` varchar(255) NOT NULL,
		  		  PRIMARY KEY  (`user_id`)
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8;",
			1 => "INSERT INTO `" . SM_DB_PREFIX . "users` (`server_id`, `name`, `mobile`, `email`) VALUES ('1,2', 'example_user', '0123456789', 'user@example.com')"
		),
	'log' =>
		array(
			0 => "CREATE TABLE `" . SM_DB_PREFIX . "log` (
				  `log_id` int(11) NOT NULL auto_increment,
				  `server_id` int(11) NOT NULL,
				  `type` enum('status','email','sms') NOT NULL,
				  `message` varchar(255) NOT NULL,
				  `datetime` timestamp NOT NULL default CURRENT_TIMESTAMP,
				  `user_id` varchar(255) NOT NULL,
				  PRIMARY KEY  (`log_id`)
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8;",
		),
	'servers' =>
		array(
			0 => "CREATE TABLE `" . SM_DB_PREFIX . "servers` (
				  `server_id` int(11) NOT NULL auto_increment,
				  `ip` varchar(100) NOT NULL,
				  `port` int(5) NOT NULL,
				  `label` varchar(255) NOT NULL,
				  `type` enum('service','website') NOT NULL default 'service',
				  `status` enum('on','off') NOT NULL default 'on',
				  `error` varchar(255) NOT NULL,
				   `rtime` FLOAT(9, 7) NOT NULL,
				  `last_online` datetime NOT NULL,
				  `last_check` datetime NOT NULL,
				  `active` enum('yes','no') NOT NULL default 'yes',
				  `email` enum('yes','no') NOT NULL default 'yes',
				  `sms` enum('yes','no') NOT NULL default 'no',
				  PRIMARY KEY  (`server_id`)
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8;",
			1 => "INSERT INTO `" . SM_DB_PREFIX . "servers` (`ip`, `port`, `label`, `type`, `status`, `error`, `rtime`, `last_online`, `last_check`, `active`, `email`, `sms`) VALUES ('http://sourceforge.net/index.php', 80, 'SourceForge', 'website', 'on', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'yes', 'yes', 'yes'), ('smtp.gmail.com', 465, 'Gmail SMTP', 'service', 'on', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'yes', 'yes', 'yes')",
		),
	'config' =>
		array(
			0 => "CREATE TABLE `" . SM_DB_PREFIX . "config` (
					`config_id` int(11) NOT NULL AUTO_INCREMENT,
					`key` varchar(255) NOT NULL,
					`value` varchar(255) NOT NULL,
					PRIMARY KEY (`config_id`),
  					KEY `key` (`key`(50))
				) ENGINE=MyISAM DEFAULT CHARSET=utf8;",
			1 => "INSERT INTO `" . SM_DB_PREFIX . "config` (`config_id`, `key`, `value`) VALUES
					(null, 'language', 'en'),
					(null, 'email_status', '1'),
					(null, 'email_from_email', 'monitor@example.org'),
					(null, 'email_from_name', 'Server Monitor'),
					(null, 'sms_status', '1'),
					(null, 'sms_gateway', 'mollie'),
					(null, 'sms_gateway_username', 'username'),
					(null, 'sms_gateway_password', 'password'),
					(null, 'sms_from', '1234567890'),
					(null, 'alert_type', 'status'),
					(null, 'log_status', '1'),
					(null, 'log_email', '1'),
					(null, 'log_sms', '1'),
					(null, 'version', '200'),
					(null, 'auto_refresh_servers', '0'),
					(null, 'show_update', '1'),
					(null, 'last_update_check', '0');",
		)
);

$result = array();

foreach($tables as $name => $queries) {
	$if_table_exists = $db->query('SHOW TABLES LIKE \'' . SM_DB_PREFIX . $name.'\'');

	if(!empty($if_table_exists)) {
		$message = 'Table ' . SM_DB_PREFIX . $name . ' already exists in your database!';
	} else {
		$message = '';

		foreach($queries as $query) {
			$message .= 'Executing ' . $query . '<br/><br/>';
			$db->query($query);
		}
	}

	$result[] = array(
		'name' => $name,
		'result' => $message,
	);
}
$tpl->addTemplateDataRepeat('install', 'tables', $result);

echo $tpl->display('install');
?>