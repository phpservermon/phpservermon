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
 * @since       phpservermon 2.1.0
 **/

namespace psm\Util\Install;

/**
 * Installer class.
 *
 * Executes the queries to install/upgrade phpservermon.
 */
class Installer
{

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
    public function __construct(\psm\Service\Database $db, $logger = null)
    {
        $this->db = $db;
        $this->logger = $logger;
    }

    /**
     * Check if an upgrade is required for the current version.
     * @return boolean
     * @see upgrade()
     */
    public function isUpgradeRequired()
    {
        $version_db = psm_get_conf('version');

        if (version_compare(PSM_VERSION, $version_db, '==')) {
            // version is up to date
            return false;
        }

        // different DB version, check if the version requires any changes
        if (version_compare($version_db, PSM_VERSION, '<')) {
            return true;
        } else {
            // change database version to current version so this check won't be required next time
            psm_update_conf('version', PSM_VERSION);
        }
        return false;
    }

    /**
     * Log a message to the logger callable (if any)
     * @param string|array $msg
     * @return \psm\Util\Install\Installer
     */
    protected function log($msg)
    {
        if (is_callable($this->logger)) {
            $msg = (!is_array($msg)) ? array($msg) : $msg;

            foreach ($msg as $m) {
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
    protected function execSQL($query)
    {
        $query = (!is_array($query)) ? array($query) : $query;

        foreach ($query as $q) {
            $this->queries[] = $q;
            $this->db->exec($q);
        }
        return $this;
    }

    /**
     * Retrieve table queries for install
     */
    public function install()
    {
        $this->installTables();

        $this->log('Populating database...');
        $queries = array();
        $queries[] = "INSERT INTO `" . PSM_DB_PREFIX . "servers` (
            `ip`, `port`, `label`, `type`, `pattern`, `pattern_online`, `redirect_check`,
            `status`, `rtime`, `active`, `email`, `sms`, `pushover`,`webhook`, `telegram`, `jabber`)
            VALUES ('http://sourceforge.net/index.php', 80, 'SourceForge', 'website', '',
                'yes', 'bad', 'on', '0.0000000', 'yes', 'yes', 'yes', 'yes','yes', 'yes', 'yes'),
                ('smtp.gmail.com', 465, 'Gmail SMTP', 'service', '',
                'yes', 'bad','on', '0.0000000', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes')";
        $queries[] = "INSERT INTO `" . PSM_DB_PREFIX . "users_servers` (`user_id`,`server_id`) VALUES (1, 1), (1, 2);";
        $queries[] = "INSERT INTO `" . PSM_DB_PREFIX . "config` (`key`, `value`) VALUE
                    ('language', 'en_US'),
                    ('proxy', '0'),
                    ('proxy_url', ''),
                    ('proxy_user', ''),
                    ('proxy_password', ''),
                    ('email_status', '1'),
                    ('email_from_email', 'monitor@example.org'),
                    ('email_from_name', 'Server Monitor'),
                    ('email_smtp', ''),
                    ('email_smtp_host', ''),
                    ('email_smtp_port', ''),
                    ('email_smtp_security', ''),
                    ('email_smtp_username', ''),
                    ('email_smtp_password', ''),
                    ('sms_status', '0'),
                    ('sms_gateway', 'messagebird'),
                    ('sms_gateway_username', 'username'),
                    ('sms_gateway_password', 'password'),
                    ('sms_from', '1234567890'),
                    ('webhook_status', '0'),
                    ('pushover_status', '0'),
                    ('pushover_api_token', ''),
                    ('telegram_status', '0'),
                    ('telegram_api_token', ''),
                    ('jabber_status', '1'),
                    ('jabber_host', ''),
                    ('jabber_port', ''),
                    ('jabber_username', ''),
                    ('jabber_domain', ''),
                    ('jabber_password', ''),
                    ('password_encrypt_key', '" . sha1(microtime()) . "'),
                    ('alert_type', 'status'),
                    ('log_status', '1'),
                    ('log_email', '1'),
                    ('log_sms', '1'),
                    ('log_pushover', '1'),
                    ('log_webhook', '1'),
                    ('log_telegram', '1'),
                    ('log_jabber', '1'),
                    ('discord_status', '0'),
                    ('log_jdiscord', '1'),
                    ('log_retention_period', '365'),
                    ('version', '" . PSM_VERSION . "'),
                    ('version_update_check', '" . PSM_VERSION . "'),
                    ('auto_refresh_servers', '0'),
                    ('show_update', '1'),
                    ('last_update_check', '0'),
                    ('cron_running', '0'),
                    ('cron_running_time', '0'),
                    ('cron_off_running', '0'),
                    ('cron_off_running_time', '0');";
        $this->execSQL($queries);
    }

    /**
     * Install the tables for the monitor
     */
    protected function installTables()
    {
        $tables = array(
            PSM_DB_PREFIX . 'config' => "CREATE TABLE `" . PSM_DB_PREFIX . "config` (
                `key` varchar(255) NOT NULL,
                `value` varchar(255) NOT NULL,
                PRIMARY KEY (`key`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8;",
            PSM_DB_PREFIX . 'users' => "CREATE TABLE IF NOT EXISTS `" . PSM_DB_PREFIX . "users` (
                `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `user_name` varchar(64) NOT NULL COMMENT 'user''s name, unique',
                `password` varchar(255) NOT NULL COMMENT 'user''s password in salted and hashed format',
                `password_reset_hash` char(40) DEFAULT NULL COMMENT 'user''s password reset code',
                `password_reset_timestamp` bigint(20) DEFAULT NULL COMMENT 'timestamp of the password reset request',
                `rememberme_token` varchar(64) DEFAULT NULL COMMENT 'user''s remember-me cookie token',
                `level` tinyint(2) unsigned NOT NULL DEFAULT '20',
                `name` varchar(255) NOT NULL,
                `mobile` varchar(15) NOT NULL,
                `discord` varchar(255) NOT NULL,
                `pushover_key` varchar(255) NOT NULL,
                `pushover_device` varchar(255) NOT NULL,
                `webhook_url` varchar(255) NOT NULL,
                `webhook_json` varchar(255) NOT NULL DEFAULT '{\"text\":\"servermon: #message\"}',
                `telegram_id` varchar(255) NOT NULL ,
                `jabber` varchar(255) NOT NULL,
                `email` varchar(255) NOT NULL,
                PRIMARY KEY (`user_id`),
                UNIQUE KEY `unique_username` (`user_name`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8;",
            PSM_DB_PREFIX .
            'users_preferences' => "CREATE TABLE IF NOT EXISTS `" . PSM_DB_PREFIX . "users_preferences` (
                `user_id` int(11) unsigned NOT NULL,
                `key` varchar(255) NOT NULL,
                `value` varchar(255) NOT NULL,
                PRIMARY KEY (`user_id`, `key`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8;",
            PSM_DB_PREFIX . 'users_servers' => "CREATE TABLE `" . PSM_DB_PREFIX . "users_servers` (
                `user_id` INT( 11 ) UNSIGNED NOT NULL ,
                `server_id` INT( 11 ) UNSIGNED NOT NULL ,
                PRIMARY KEY ( `user_id` , `server_id` )
            ) ENGINE = MyISAM DEFAULT CHARSET=utf8;",
            PSM_DB_PREFIX . 'log' => "CREATE TABLE `" . PSM_DB_PREFIX . "log` (
                `log_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `server_id` int(11) unsigned NOT NULL,
                `type` enum('status','email','sms','discord','pushover','webhook','telegram', 'jabber') NOT NULL,
                `message` TEXT NOT NULL,
                `datetime` timestamp NOT NULL default CURRENT_TIMESTAMP,
                PRIMARY KEY  (`log_id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8;",
            PSM_DB_PREFIX . 'log_users' => "CREATE TABLE `" . PSM_DB_PREFIX . "log_users` (
                `log_id`  int(11) UNSIGNED NOT NULL ,
                `user_id`  int(11) UNSIGNED NOT NULL ,
                PRIMARY KEY (`log_id`, `user_id`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;",
            PSM_DB_PREFIX . 'servers' => "CREATE TABLE `" . PSM_DB_PREFIX . "servers` (
                `server_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `ip` varchar(500) NOT NULL,
                `port` int(5) NOT NULL,
                `request_method` varchar(50) NULL,
                `label` varchar(255) NOT NULL,
                `type` enum('ping','service','website') NOT NULL default 'service',
                `pattern` varchar(255) NOT NULL default '',
                `pattern_online` enum('yes','no') NOT NULL default 'yes',
                `post_field` varchar(255) NULL,
                `redirect_check` enum('ok','bad') NOT NULL default 'bad',
                `allow_http_status` varchar(255) NOT NULL default '',
                `header_name` varchar(255) NOT NULL default '',
                `header_value` varchar(255) NOT NULL default '',
                `status` enum('on','off') NOT NULL default 'on',
                `error` varchar(255) NULL,
                `rtime` FLOAT(9, 7) NULL,
                `last_online` datetime NULL,
                `last_offline` datetime NULL,
                `last_offline_duration` varchar(255) NULL,
                `last_check` datetime NULL,
                `active` enum('yes','no') NOT NULL default 'yes',
                `email` enum('yes','no') NOT NULL default 'yes',
                `sms` enum('yes','no') NOT NULL default 'no',
                `discord` enum('yes','no') NOT NULL default 'yes',
                `pushover` enum('yes','no') NOT NULL default 'yes',
                `webhook` enum('yes','no') NOT NULL default 'yes',
                `telegram` enum('yes','no') NOT NULL default 'yes',
                `jabber` enum('yes','no') NOT NULL default 'yes',
                `warning_threshold` mediumint(1) unsigned NOT NULL DEFAULT '1',
                `warning_threshold_counter` mediumint(1) unsigned NOT NULL DEFAULT '0',
                `ssl_cert_expiry_days` mediumint(1) unsigned NOT NULL DEFAULT '0',
                `ssl_cert_expired_time` varchar(255) NULL,
                `timeout` smallint(1) unsigned NULL DEFAULT NULL,
                `website_username` varchar(255) DEFAULT NULL,
                `website_password` varchar(255) DEFAULT NULL,
                `last_error` varchar(255) DEFAULT NULL,
                `last_error_output` TEXT,
                `last_output` TEXT,
                PRIMARY KEY  (`server_id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8;",
            PSM_DB_PREFIX . 'servers_uptime' => "CREATE TABLE IF NOT EXISTS `" . PSM_DB_PREFIX . "servers_uptime` (
                `servers_uptime_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `server_id` int(11) unsigned NOT NULL,
                `date` datetime NOT NULL,
                `status` tinyint(1) unsigned NOT NULL,
                `latency` float(9,7) DEFAULT NULL,
                PRIMARY KEY (`servers_uptime_id`),
                KEY `server_id` (`server_id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8;",
            PSM_DB_PREFIX . 'servers_history' => "CREATE TABLE IF NOT EXISTS `" . PSM_DB_PREFIX . "servers_history` (
                `servers_history_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `server_id` int(11) unsigned NOT NULL,
                `date` date NOT NULL,
                `latency_min` float(9,7) NOT NULL,
                `latency_avg` float(9,7) NOT NULL,
                `latency_max` float(9,7) NOT NULL,
                `checks_total` int(11) unsigned NOT NULL,
                `checks_failed` int(11) unsigned NOT NULL,
                PRIMARY KEY (`servers_history_id`),
                UNIQUE KEY `server_id_date` (`server_id`,`date`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;",
        );

        foreach ($tables as $name => $sql) {
            $if_table_exists = $this->db->query("SHOW TABLES LIKE '{$name}'");

            if (!empty($if_table_exists)) {
                $this->log('Table ' . $name . ' already exists in your database!');
            } else {
                $this->execSQL($sql);
                $this->log('Table ' . $name . ' added.');
            }
        }
    }

    /**
     * Populate the tables and perform upgrades if necessary
     * @param string $version_from
     * @param string $version_to
     * @see isUpgradeRequired()
     */
    public function upgrade($version_from, $version_to)
    {
        if (version_compare($version_from, '2.1.0', '<')) {
            $this->upgrade210();
        }
        if (version_compare($version_from, '3.0.0', '<')) {
            $this->upgrade300();
        }
        if (version_compare($version_from, '3.1.0', '<')) {
            $this->upgrade310();
        }
        if (version_compare($version_from, '3.2.0', '<')) {
            $this->upgrade320();
        }
        if (version_compare($version_from, '3.2.1', '<')) {
            $this->upgrade321();
        }
        if (version_compare($version_from, '3.2.2', '<')) {
            $this->upgrade322();
        }
        if (version_compare($version_from, '3.3.0', '<')) {
            $this->upgrade330();
        }
        if (version_compare($version_from, '3.4.0', '<')) {
            $this->upgrade340();
        }
        if (version_compare($version_from, '3.4.2', '<')) {
            $this->upgrade342();
        }
        if (version_compare($version_from, '3.5.0', '<')) {
            $this->upgrade350();
        }
        if (version_compare($version_from, '3.6.0', '<')) {
            $this->upgrade360();
        }
        psm_update_conf('version', $version_to);
    }

    /**
     * Upgrade for v2.1.0 release
     */
    protected function upgrade210()
    {
        $queries = array();
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "config` DROP `config_id`;";
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "config` ADD PRIMARY KEY ( `key` );";
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "config` DROP INDEX `key`;";
        $queries[] = "INSERT INTO `" . PSM_DB_PREFIX . "config` (`key`, `value`) VALUES ('cron_running', '0');";
        $queries[] = "INSERT INTO `" . PSM_DB_PREFIX . "config` (`key`, `value`) VALUES ('cron_running_time', '0');";

        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "servers` CHANGE `error` `error` VARCHAR( 255 )
            CHARACTER SET utf8 COLLATE utf8_general_ci NULL;";
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "servers` CHANGE `rtime` `rtime` FLOAT( 9, 7 ) NULL;";
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "servers` CHANGE `last_online` `last_online` DATETIME NULL;";
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "servers` CHANGE `last_check` `last_check` DATETIME NULL;";
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "servers` ADD  `pattern` VARCHAR( 255 ) NOT NULL AFTER  `type`;";
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "servers` ADD  `last_offline` DATETIME NULL;";
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "servers` ADD  `last_offline_duration` varchar(255) NULL;";

        $this->execSQL($queries);
    }

    /**
     * Upgrade for v3.0.0 release
     */
    protected function upgrade300()
    {
        $queries = array();
        // language is now stored as language code (ISO 639-1) + country code (ISO 3166-1)
        $queries[] = "UPDATE `" . PSM_DB_PREFIX . "config` SET `value`='bg_BG' 
            WHERE `key`='language' AND `value`='bg';";
        $queries[] = "UPDATE `" . PSM_DB_PREFIX . "config` SET `value`='de_DE' 
            WHERE `key`='language' AND `value`='de';";
        $queries[] = "UPDATE `" . PSM_DB_PREFIX . "config` SET `value`='en_US' 
            WHERE `key`='language' AND `value`='en';";
        $queries[] = "UPDATE `" . PSM_DB_PREFIX . "config` SET `value`='fr_FR' 
            WHERE `key`='language' AND `value`='fr';";
        $queries[] = "UPDATE `" . PSM_DB_PREFIX . "config` SET `value`='ko_KR' 
            WHERE `key`='language' AND `value`='kr';";
        $queries[] = "UPDATE `" . PSM_DB_PREFIX . "config` SET `value`='nl_NL' 
            WHERE `key`='language' AND `value`='nl';";
        $queries[] = "UPDATE `" . PSM_DB_PREFIX . "config` SET `value`='pt_BR' 
            WHERE `key`='language' AND `value`='br';";

        $queries[] = "INSERT INTO `" . PSM_DB_PREFIX . "config` (`key`, `value`) VALUES
            ('version_update_check', '" . PSM_VERSION . "');";
        $queries[] = "INSERT INTO `" . PSM_DB_PREFIX . "config` (`key`, `value`) VALUES ('email_smtp', '');";
        $queries[] = "INSERT INTO `" . PSM_DB_PREFIX . "config` (`key`, `value`) VALUES ('email_smtp_host', '');";
        $queries[] = "INSERT INTO `" . PSM_DB_PREFIX . "config` (`key`, `value`) VALUES ('email_smtp_port', '');";
        $queries[] = "INSERT INTO `" . PSM_DB_PREFIX . "config` (`key`, `value`) VALUES ('email_smtp_username', '');";
        $queries[] = "INSERT INTO `" . PSM_DB_PREFIX . "config` (`key`, `value`) VALUES ('email_smtp_password', '');";

        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "log` CHANGE `log_id` `log_id` INT( 11 )
            UNSIGNED NOT NULL AUTO_INCREMENT;";
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "log` CHANGE `server_id` `server_id` INT( 11 )
            UNSIGNED NOT NULL;";

        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "servers` CHANGE `server_id` `server_id` INT( 11 )
            UNSIGNED NOT NULL AUTO_INCREMENT;";
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "servers` ADD `warning_threshold` MEDIUMINT( 1 )
            UNSIGNED NOT NULL DEFAULT '1';";
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "servers` ADD `warning_threshold_counter` MEDIUMINT( 1 )
            UNSIGNED NOT NULL DEFAULT '0';";
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "servers` ADD  `last_offline` DATETIME NULL;";
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "servers` ADD  `last_offline_duration` varchar(255) NULL;";

        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "users` CHANGE `user_id` `user_id` INT( 11 )
            UNSIGNED NOT NULL AUTO_INCREMENT;";
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "users`
            ADD `user_name` varchar(64) COLLATE utf8_general_ci NOT NULL 
                COMMENT 'user\'s name, unique' AFTER `user_id`,
            ADD `password` varchar(255) COLLATE utf8_general_ci NOT NULL 
                COMMENT 'user\'s password in salted and hashed format' AFTER `user_name`,
            ADD `password_reset_hash` char(40) COLLATE utf8_general_ci DEFAULT NULL 
                COMMENT 'user\'s password reset code' AFTER `password`,
            ADD `password_reset_timestamp` bigint(20) DEFAULT NULL 
                COMMENT 'timestamp of the password reset request' AFTER `password_reset_hash`,
            ADD `rememberme_token` varchar(64) COLLATE utf8_general_ci DEFAULT NULL 
                COMMENT 'user\'s remember-me cookie token' AFTER `password_reset_timestamp`,
            ADD `level` TINYINT( 2 ) UNSIGNED NOT NULL DEFAULT '20' AFTER `rememberme_token`;";
        // make sure all current users are admins (previously we didnt have non-admins):
        $queries[] = "UPDATE `" . PSM_DB_PREFIX . "users` SET `user_name`=`email`, `level`=10;";
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "users` ADD UNIQUE `unique_username` ( `user_name` );";

        $queries[] = "CREATE TABLE IF NOT EXISTS `" . PSM_DB_PREFIX . "servers_uptime` (
                        `servers_uptime_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                        `server_id` int(11) unsigned NOT NULL,
                        `date` datetime NOT NULL,
                        `status` tinyint(1) unsigned NOT NULL,
                        `latency` float(9,7) DEFAULT NULL,
                        PRIMARY KEY (`servers_uptime_id`),
                        KEY `server_id` (`server_id`)
                      ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";

        $queries[] = "CREATE TABLE IF NOT EXISTS `" . PSM_DB_PREFIX . "servers_history` (
                `servers_history_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `server_id` int(11) unsigned NOT NULL,
                `date` date NOT NULL,
                `latency_min` float(9,7) NOT NULL,
                `latency_avg` float(9,7) NOT NULL,
                `latency_max` float(9,7) NOT NULL,
                `checks_total` int(11) unsigned NOT NULL,
                `checks_failed` int(11) unsigned NOT NULL,
                          PRIMARY KEY (`servers_history_id`),
                          UNIQUE KEY `server_id_date` (`server_id`,`date`)
                        ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";

        $queries[] = "CREATE TABLE `" . PSM_DB_PREFIX . "users_servers` (
                        `user_id` INT( 11 ) UNSIGNED NOT NULL ,
                        `server_id` INT( 11 ) UNSIGNED NOT NULL ,
                        PRIMARY KEY ( `user_id` , `server_id` )
                        ) ENGINE = MYISAM ;";
        $this->execSQL($queries);

        // from 3.0 all user-server relations are in a separate table
        $users = $this->db->select(PSM_DB_PREFIX . 'users', null, array('user_id', 'server_id'));
        foreach ($users as $user) {
            $idc = array();
            if ($user['server_id'] == '') {
                continue;
            }
            if (strpos($user['server_id'], ',') === false) {
                $idc[] = $user['server_id'];
            } else {
                $idc = explode(',', $user['server_id']);
            }
            foreach ($idc as $id) {
                $this->db->save(PSM_DB_PREFIX . 'users_servers', array(
                    'user_id' => $user['user_id'],
                    'server_id' => $id,
                ));
            }
        }
        $this->execSQL("ALTER TABLE `" . PSM_DB_PREFIX . "users` DROP `server_id`;");
    }

    /**
     * Upgrade for v3.1.0 release
     */
    protected function upgrade310()
    {
        $queries = array();
        psm_update_conf('log_retention_period', '365');

        psm_update_conf('pushover_status', 0);
        psm_update_conf('log_pushover', 1);
        psm_update_conf('pushover_api_token', '');
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "users` ADD  `pushover_key` VARCHAR( 255 )
            NOT NULL AFTER `mobile`;";
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "users` ADD  `pushover_device` VARCHAR( 255 )
            NOT NULL AFTER `pushover_key`;";

        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "servers` ADD  `pushover` ENUM( 'yes','no' )
            NOT NULL DEFAULT 'yes' AFTER  `sms`;";
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX .
            "log` CHANGE `type` `type` ENUM( 'status', 'email', 'sms', 'pushover' )
            CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;";

        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "servers` ADD `timeout` smallint(1) unsigned NULL DEFAULT NULL;";
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "servers` ADD  `last_offline` DATETIME NULL;";
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "servers` ADD  `last_offline_duration` varchar(255) NULL;";

        $queries[] = "CREATE TABLE IF NOT EXISTS `" . PSM_DB_PREFIX . "users_preferences` (
                        `user_id` int(11) unsigned NOT NULL,
                        `key` varchar(255) NOT NULL,
                        `value` varchar(255) NOT NULL,
                        PRIMARY KEY (`user_id`, `key`)
                      ) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

        $this->execSQL($queries);
    }

    /**
     * Upgrade for v3.2.0 release
     */
    protected function upgrade320()
    {
        $queries = array();

        psm_update_conf('password_encrypt_key', sha1(microtime()));
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "servers` CHANGE `ip` `ip` VARCHAR(500) NOT NULL;";
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "servers` ADD `website_username` varchar(255) NULL,
            ADD `website_password` varchar(255) NULL AFTER `website_username`;";
        $queries[] = "INSERT INTO `" . PSM_DB_PREFIX . "config` (`key`, `value`) VALUE
                    ('proxy', '0'),
                    ('proxy_url', ''),
                    ('proxy_user', ''),
                    ('proxy_password', '');";

        $this->execSQL($queries);

        // Create log_users table
        $this->execSQL("CREATE TABLE `" . PSM_DB_PREFIX . "log_users` (
                        `log_id`  int(11) UNSIGNED NOT NULL ,
                        `user_id`  int(11) UNSIGNED NOT NULL ,
                        PRIMARY KEY (`log_id`, `user_id`)
                      ) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

        // Migrate the data
        $logs = $this->db->select(PSM_DB_PREFIX . 'log', null, array('log_id', 'user_id'));
        foreach ($logs as $log) {
            // Validation
            if (empty($log['user_id']) || trim($log['user_id']) == '') {
                continue;
            }

            // Insert into new table
            foreach (explode(',', $log['user_id']) as $user_id) {
                psm_add_log_user($log['log_id'], $user_id);
            }
        }

        // Drop old user_id('s) column
        $this->execSQL("ALTER TABLE `" . PSM_DB_PREFIX . "log` DROP COLUMN `user_id`;");
    }

    /**
     * Upgrade for v3.2.1 release
     */
    protected function upgrade321()
    {
        $queries = array();
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "servers` ADD COLUMN `header_name` VARCHAR(255) AFTER `pattern`,
            ADD COLUMN `header_value` VARCHAR(255) AFTER `header_name`";
        $this->execSQL($queries);
    }

    /**
     * Upgrade for v3.2.2 release
     */
    protected function upgrade322()
    {
        $queries = array();
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "users` ADD  `telegram_id` VARCHAR( 255 ) 
            NOT NULL AFTER `pushover_device`;";
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "servers` ADD  `telegram` ENUM( 'yes','no' ) 
            NOT NULL DEFAULT 'yes' AFTER  `pushover`;";
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX .
            "log` CHANGE `type` `type` ENUM( 'status', 'email', 'sms', 'pushover', 'telegram' )
            CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;";
        $queries[] = "INSERT INTO `" . PSM_DB_PREFIX . "config` (`key`, `value`) VALUE
                    ('telegram_status', '0'),
                    ('log_telegram', '1'),
                    ('telegram_api_token', '');";
        $this->execSQL($queries);
    }

    /**
     * Upgrade for v3.3.0 release
     */
    protected function upgrade330()
    {
        $queries = array();
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "servers` ADD COLUMN `last_offline` DATETIME
            NULL AFTER `last_online`, ADD COLUMN `last_offline_duration` varchar(255) NULL AFTER `last_offline`;";
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "servers` ADD `pattern_online` ENUM( 'yes','no' )
            NOT NULL DEFAULT 'yes' AFTER `pattern`;";
        $this->execSQL($queries);
        if (psm_get_conf('sms_gateway') == 'mollie') {
            psm_update_conf('sms_gateway', 'messagebird');
        }
    }

    /**
     * Upgrade for v3.4.0 release
     */
    protected function upgrade340()
    {
        $queries = array();
        /**
         * Redirect_check is first set to default ok.
         * If you have a lot of server that are redirecting,
         * this will make sure you're servers stay online.
         */
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "servers`
            ADD COLUMN `allow_http_status` VARCHAR(255) NOT NULL DEFAULT '' AFTER `pattern_online`;";
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "servers`
            ADD `redirect_check` ENUM( 'ok','bad' ) NOT NULL DEFAULT 'ok' AFTER `allow_http_status`;";
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "servers`
            CHANGE `redirect_check` `redirect_check` ENUM('ok','bad') NOT NULL DEFAULT 'bad';";
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "servers`
            ADD COLUMN `last_error` VARCHAR(255) NULL AFTER `website_password`;";
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "servers`
            ADD COLUMN `last_error_output` TEXT AFTER `last_error`;";
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "servers`
            ADD COLUMN `last_output` TEXT AFTER `last_error_output`;";
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "servers`
            ADD COLUMN `request_method` varchar(50) NULL AFTER `port`;";
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "servers`
            ADD COLUMN `post_field` varchar(255) NULL AFTER `pattern_online`;";
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "log`
            CHANGE `message` `message` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;";
        $queries[] = "INSERT INTO `" . PSM_DB_PREFIX . "config` (`key`, `value`)
            VALUES ('combine_notifications', '1');";
        $this->execSQL($queries);
        $this->log('Combined notifications enabled. Check out the config page for more info.');
    }

    /**
     * Patch for v3.4.2 release
     * Version_compare was forgotten in v3.4.1 and query failed.
     * Fixed in v3.4.2, 3.4.1 has been removed.
     */
    protected function upgrade342()
    {
        $queries = array();
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "servers` CHANGE `last_output` `last_output` TEXT;";
        $this->execSQL($queries);
    }

    /**
     * Upgrade for v3.5.0 release
     */
    protected function upgrade350()
    {
        $queries = array();
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "servers` 
            ADD `ssl_cert_expiry_days` MEDIUMINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER `warning_threshold_counter`";
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "servers` 
            ADD `ssl_cert_expired_time` VARCHAR(255) NULL AFTER `ssl_cert_expiry_days`";

        if (
            @psm_password_decrypt(
                psm_get_conf('password_encrypt_key'),
                psm_get_conf('email_smtp_password')
            ) === false
        ) {
            // Prevents encrypting the password multiple times.
            $queries[] = "UPDATE `" . PSM_DB_PREFIX . "config` 
                SET `value` = '" .
                psm_password_encrypt(psm_get_conf('password_encrypt_key'), psm_get_conf('email_smtp_password')) .
                "' WHERE `key` = 'email_smtp_password'";
            $this->log('SMTP password is now encrypted.');
        }

        $queries[] = 'ALTER TABLE `' . PSM_DB_PREFIX . 'users` ADD  `jabber` VARCHAR( 255 )
            NOT NULL AFTER `telegram_id`;';
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "servers` ADD  `jabber` ENUM( 'yes','no' )
            NOT NULL DEFAULT 'yes' AFTER  `telegram`;";
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX .
            "log` CHANGE `type` `type` ENUM( 'status', 'email', 'sms', 'pushover', 'telegram', 'jabber' )
            CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;";
        $queries[] = "INSERT INTO `" . PSM_DB_PREFIX . "config` (`key`, `value`) VALUE
                    ('jabber_status', '0'),
                    ('log_jabber', '1'),
                    ('jabber_host', ''),
                    ('jabber_port', ''),
                    ('jabber_username', ''),
                    ('jabber_domain', ''),
                    ('jabber_password', '');";
        $this->execSQL($queries);
    }

    /**
     * Patch for v3.6.0 release
     * Added support for Discord and webhooks
     */
    protected function upgrade360()
    {
        $queries = array();

        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "users` 
            ADD  `webhook_url` VARCHAR( 255 ) NOT NULL AFTER `telegram_id`;";
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "users` 
            ADD  `webhook_json` VARCHAR( 255 ) NOT NULL AFTER `telegram_id`;";
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "log` 
            CHANGE `type` `type` ENUM('status','email','sms','discord','webhook','pushover','telegram','jabber') 
            CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;";
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "servers` 
            ADD `webhook` ENUM( 'yes','no' ) NOT NULL DEFAULT 'yes' AFTER `telegram`;";
        $queries[] = "INSERT INTO `" . PSM_DB_PREFIX . "config` (`key`, `value`) VALUE
                    ('discord_status', '0'),
                    ('log_discord', '1'),
                    ('webhook_status', '0'),
                    ('log_webhook', '1')";
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "users` 
            ADD `discord` VARCHAR( 255 ) NOT NULL AFTER `mobile`;";
        $queries[] = "ALTER TABLE `" . PSM_DB_PREFIX . "servers` 
            ADD `discord` ENUM( 'yes','no' ) NOT NULL DEFAULT 'yes' AFTER  `sms`;";
        $queries[] = "INSERT INTO `" . PSM_DB_PREFIX . "users` (
            `user_name`, `level`, `name`, `email`)
            VALUES ('__PUBLIC__', 30, 'Public page', 'publicpage@psm.psm')";
        $this->execSQL($queries);

        $this->log('Public page is now available. Added user \'__PUBLIC__\'. See documentation for more info.');
    }
}
