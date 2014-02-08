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
 * @since		phpservermon 2.1.0
 **/

namespace psm\Util\Install;

/**
 * Query class provides al queries required for installing/upgrading.
 */
class Queries {
	/**
	 * Retrieve table queries for install
	 * @return array
	 */
	public function install() {
		$tables = array(
			PSM_DB_PREFIX . 'users' => "CREATE TABLE `" . PSM_DB_PREFIX . "users` (
						  `user_id` int(11) NOT NULL auto_increment,
						  `server_id` varchar(255) NOT NULL,
						  `name` varchar(255) NOT NULL,
						  `mobile` varchar(15) NOT NULL,
						  `email` varchar(255) NOT NULL,
						  PRIMARY KEY  (`user_id`)
						) ENGINE=MyISAM  DEFAULT CHARSET=utf8;",
			PSM_DB_PREFIX . 'log' => "CREATE TABLE `" . PSM_DB_PREFIX . "log` (
						  `log_id` int(11) NOT NULL auto_increment,
						  `server_id` int(11) NOT NULL,
						  `type` enum('status','email','sms') NOT NULL,
						  `message` varchar(255) NOT NULL,
						  `datetime` timestamp NOT NULL default CURRENT_TIMESTAMP,
						  `user_id` varchar(255) NOT NULL,
						  PRIMARY KEY  (`log_id`)
						) ENGINE=MyISAM  DEFAULT CHARSET=utf8;",
			PSM_DB_PREFIX . 'servers' => "CREATE TABLE `" . PSM_DB_PREFIX . "servers` (
						  `server_id` int(11) NOT NULL auto_increment,
						  `ip` varchar(100) NOT NULL,
						  `port` int(5) NOT NULL,
						  `label` varchar(255) NOT NULL,
						  `type` enum('service','website') NOT NULL default 'service',
						  `pattern` varchar(255) NOT NULL,
						  `status` enum('on','off') NOT NULL default 'on',
						  `error` varchar(255) NULL,
						  `rtime` FLOAT(9, 7) NULL,
						  `last_online` datetime NULL,
						  `last_check` datetime NULL,
						  `active` enum('yes','no') NOT NULL default 'yes',
						  `email` enum('yes','no') NOT NULL default 'yes',
						  `sms` enum('yes','no') NOT NULL default 'no',
						  PRIMARY KEY  (`server_id`)
						) ENGINE=MyISAM  DEFAULT CHARSET=utf8;",
			PSM_DB_PREFIX . 'config' => "CREATE TABLE `" . PSM_DB_PREFIX . "config` (
							`key` varchar(255) NOT NULL,
							`value` varchar(255) NOT NULL,
							PRIMARY KEY (`key`)
						) ENGINE=MyISAM DEFAULT CHARSET=utf8;",
		);
		return $tables;
	}

	/**
	 * Get queries for upgrading
	 * @param string $version
	 * @param string $version_from
	 * @return array
	 */
	public function upgrade($version, $version_from = null) {
		$queries = array();

		if($version_from === null) {
			$queries[] = "INSERT INTO `" . PSM_DB_PREFIX . "users` (`server_id`, `name`, `mobile`, `email`) VALUES ('1,2', 'example_user', '0123456789', 'user@example.com')";
			$queries[] = "INSERT INTO `" . PSM_DB_PREFIX . "servers` (`ip`, `port`, `label`, `type`, `status`, `error`, `rtime`, `last_online`, `last_check`, `active`, `email`, `sms`) VALUES ('http://sourceforge.net/index.php', 80, 'SourceForge', 'website', 'on', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'yes', 'yes', 'yes'), ('smtp.gmail.com', 465, 'Gmail SMTP', 'service', 'on', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'yes', 'yes', 'yes')";
			$queries[] = "INSERT INTO `" . PSM_DB_PREFIX . "config` (`key`, `value`) VALUE
						('language', 'en'),
						('email_status', '1'),
						('email_from_email', 'monitor@example.org'),
						('email_from_name', 'Server Monitor'),
						('sms_status', '1'),
						('sms_gateway', 'mollie'),
						('sms_gateway_username', 'username'),
						('sms_gateway_password', 'password'),
						('sms_from', '1234567890'),
						('alert_type', 'status'),
						('log_status', '1'),
						('log_email', '1'),
						('log_sms', '1'),
						('version', '{$version}'),
						('auto_refresh_servers', '0'),
						('show_update', '1'),
						('last_update_check', '0'),
						('cron_running', '0'),
						('cron_running_time', '0');";
		} else {
			if(version_compare($version_from, '2.1.0', '<')) {
				// 2.0 upgrade
				$queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "config` DROP `config_id`;";
				$queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "config` ADD PRIMARY KEY ( `key` );";
				$queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "config` DROP INDEX `key`;";
				$queries[] = "INSERT INTO `" . PSM_DB_PREFIX . "config` (`key`, `value`) VALUES ('cron_running', '0');";
				$queries[] = "INSERT INTO `" . PSM_DB_PREFIX . "config` (`key`, `value`) VALUES ('cron_running_time', '0');";

				$queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "servers` CHANGE `error` `error` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;";
				$queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "servers` CHANGE `rtime` `rtime` FLOAT( 9, 7 ) NULL;";
				$queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "servers` CHANGE `last_online` `last_online` DATETIME NULL;";
				$queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "servers` CHANGE `last_check` `last_check` DATETIME NULL;";
				$queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "servers` ADD  `pattern` VARCHAR( 255 ) NOT NULL AFTER  `type`;";


			}
			$queries[] = "UPDATE `" . PSM_DB_PREFIX . "config` SET `value` = '{$version}' WHERE `key` = 'version';";
		}
		return $queries;
	}
}

?>