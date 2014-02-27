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
 * @since		phpservermon 2.1.0
 **/

namespace psm\Util\Install;

/**
 * Installer class.
 *
 * Executes the queries to install/upgrade phpservermon.
 */
class Installer {

	/**
	 * Database service
	 * @var \psm\Service\Database $db
	 */
	protected $db;

	/**
	 * Log callback
	 * @var callable $logger
	 */
	protected $logger;

	/**
	 * Log of executed queries
	 * @var array $queries
	 */
	protected $queries = array();

	/**
	 * Open a new installer instance
	 * @param \psm\Service\Database $db
	 * @param callable $logger
	 */
	function __construct(\psm\Service\Database $db, $logger = null) {
		$this->db = $db;
		$this->logger = $logger;
	}

	/**
	 * Log a message to the logger callable (if any)
	 * @param string|array $msg
	 * @return \psm\Util\Install\Installer
	 */
	protected function log($msg) {
		if(is_callable($this->logger)) {
			$msg = (!is_array($msg)) ? array($msg) : $msg;

			foreach($msg as $m) {
				call_user_func($this->logger, $m);
			}
		}
		return $this;
	}

	/**
	 * Execute one or more queries. Does no fetching or anything, so execute only.
	 * @param string|array $query
	 * @return \psm\Util\Install\Installer
	 */
	protected function execSQL($query) {
		$query = (!is_array($query)) ? array($query) : $query;

		foreach($query as $q) {
			$this->queries[] = $q;
			$this->db->exec($q);
		}
		return $this;
	}

	/**
	 * Retrieve table queries for install
	 */
	public function install() {
		$this->installTables();

		$version_conf = $this->db->selectRow(PSM_DB_PREFIX . 'config', array('key' => 'version'), array('key', 'value'));

		if(empty($version_conf)) {
			// fresh install
			$version_from = null;
		} else {
			// existing install
			$version_from = $version_conf['value'];
			if(strpos($version_from, '.') === false) {
				// yeah, my bad.. previous version did not follow proper naming scheme
				$version_from = rtrim(chunk_split($version_from, 1, '.'), '.');
			}
		}
		$this->upgrade(PSM_VERSION, $version_from);


		$this->log('Installation finished!');
	}

	/**
	 * Install the tables for the monitor
	 */
	protected function installTables() {
		$tables = array(
			PSM_DB_PREFIX . 'users' => "CREATE TABLE `" . PSM_DB_PREFIX . "users` (
						  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
						  `server_id` varchar(255) NOT NULL,
						  `name` varchar(255) NOT NULL,
						  `mobile` varchar(15) NOT NULL,
						  `email` varchar(255) NOT NULL,
						  PRIMARY KEY  (`user_id`)
						) ENGINE=MyISAM  DEFAULT CHARSET=utf8;",
			PSM_DB_PREFIX . 'log' => "CREATE TABLE `" . PSM_DB_PREFIX . "log` (
						  `log_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
						  `server_id` int(11) unsigned NOT NULL,
						  `type` enum('status','email','sms') NOT NULL,
						  `message` varchar(255) NOT NULL,
						  `datetime` timestamp NOT NULL default CURRENT_TIMESTAMP,
						  `user_id` varchar(255) NOT NULL,
						  PRIMARY KEY  (`log_id`)
						) ENGINE=MyISAM  DEFAULT CHARSET=utf8;",
			PSM_DB_PREFIX . 'servers' => "CREATE TABLE `" . PSM_DB_PREFIX . "servers` (
						  `server_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
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

		foreach($tables as $name => $sql) {
			$if_table_exists = $this->db->query("SHOW TABLES LIKE '{$name}'");

			if(!empty($if_table_exists)) {
				$this->log('Table ' . $name . ' already exists in your database!');
			} else {
				$this->execSQL($sql);
				$this->log('Table ' . $name . ' added.');
			}
		}
	}

	/**
	 * Populate the tables and perform upgrades if necessary
	 * @param string $version
	 * @param string $version_from
	 */
	public function upgrade($version, $version_from = null) {
		if($version_from === null) {
			$this->log('Populating database...');
			$queries = array();
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
			$this->execSQL($queries);
		} else {
			if(version_compare($version_from, $version, '<')) {
				$this->log('Upgrade detected, upgrading from ' . $version_from . ' to ' . $version);
				if(version_compare($version_from, '2.1.0', '<')) {
					// upgrade to 2.1.0
					$this->upgrade210();
				}
				if(version_compare($version_from, '2.2.0', '<')) {
					// upgrade to 2.2.0
					$this->upgrade220();
				}
			}
			$this->execSQL("UPDATE `" . PSM_DB_PREFIX . "config` SET `value` = '{$version}' WHERE `key` = 'version';");
		}
	}

	/**
	 * Upgrade for v2.1.0 release
	 */
	protected function upgrade210() {
		$queries = array();
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

		$this->execSQL($queries);
	}

	/**
	 * Upgrade for v2.2.0 release
	 */
	protected function upgrade220() {
		$queries = array();
		$queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "log` CHANGE `log_id` `log_id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT;";
		$queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "log` CHANGE `server_id` `server_id` INT( 11 ) UNSIGNED NOT NULL;";
		$queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "servers` CHANGE `server_id` `server_id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT;";
		$queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "users` CHANGE `user_id` `user_id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT;";
		$queries[] = "CREATE TABLE IF NOT EXISTS `" . PSM_DB_PREFIX . "uptime` (
				`server_id` INT( 11 ) NOT NULL,
				`date` DATETIME NOT NULL ,
				`status` INT( 1 ) NOT NULL ,
				`latency`  FLOAT( 9, 7 ) NULL
			   ) ENGINE = MYISAM ;";

		$this->execSQL($queries);
	}
}

?>