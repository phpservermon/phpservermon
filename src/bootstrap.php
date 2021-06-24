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

namespace {
    // Include paths
    define('PSM_PATH_SRC', __DIR__ . DIRECTORY_SEPARATOR);
    define('PSM_PATH_CONFIG', PSM_PATH_SRC . 'config' . DIRECTORY_SEPARATOR);
    define('PSM_PATH_LANG', PSM_PATH_SRC . 'lang' . DIRECTORY_SEPARATOR);
    define('PSM_PATH_SMS_GATEWAY', PSM_PATH_SRC . 'psm' . DIRECTORY_SEPARATOR . 'Txtmsg' . DIRECTORY_SEPARATOR);

    // user levels
    define('PSM_USER_ADMIN', 10);
    define('PSM_USER_USER', 20);
    define('PSM_USER_ANONYMOUS', 30);

    if (function_exists('date_default_timezone_set') && function_exists('date_default_timezone_get')) {
        date_default_timezone_set(@date_default_timezone_get());
    }

    // find config file
    $path_conf = PSM_PATH_SRC . '../config.php';
    if (file_exists($path_conf)) {
        include_once $path_conf;
    }
    // check for a debug var
    if (!defined('PSM_DEBUG')) {
        define('PSM_DEBUG', false);
    }

    // Debug enabled: report everything
    // Debug disabled: report error only if created manually
    ini_set('display_errors', 1);
    PSM_DEBUG ? error_reporting(E_ALL) : error_reporting(E_USER_ERROR);

    // check for a cron allowed ip array
    if (!defined('PSM_CRON_ALLOW')) {
    //serialize for php version lower than 7.0.0
        define('PSM_CRON_ALLOW', serialize(array()));
    }

    $vendor_autoload = PSM_PATH_SRC . '..' . DIRECTORY_SEPARATOR . 'vendor' .
    DIRECTORY_SEPARATOR . 'autoload.php';
    if (!file_exists($vendor_autoload)) {
        trigger_error(
            "No dependencies found in vendor dir. Did you install the dependencies?
                Please run \"php composer.phar install\".",
            E_USER_ERROR
        );
    }
    require_once $vendor_autoload;

    $router = new psm\Router();
    // this may seem insignificant, but right now lots of functions
    // depend on the following global var definition:
    $db = $router->getService('db');

    // sanity check!
    if (!defined('PSM_INSTALL') || !PSM_INSTALL) {
        if ($db->getDbHost() === null) {
            // no config file has been loaded, redirect the user to the install
            header('Location: install.php');
            die();
        }
        // config file has been loaded, check if we have a connection
        if (!$db->status()) {
            trigger_error("Unable to establish database connection...", E_USER_ERROR);
        }
        // attempt to load configuration from database
        if (!psm_load_conf()) {
            // unable to load from config table
            header('Location: install.php');
            die();
        }
        // config load OK, make sure database version is up to date
        $installer = new \psm\Util\Install\Installer($db);
        if ($installer->isUpgradeRequired()) {
            trigger_error(
                "Your database is for an older version and requires an upgrade, 
                    <a href=\"install.php\">please click here</a> to update your database to the latest version.",
                E_USER_ERROR
            );
        }
    }

    // check for a public page var
    // This should be defined in the config
    if (!defined('PSM_PUBLIC')) {
        define('PSM_PUBLIC', false);
    }

    // check for a public page
    // This variable is for internal use
    // and should not be changed by the user manualy
    if (!defined('PSM_PUBLIC_PAGE')) {
        define('PSM_PUBLIC_PAGE', false);
    }

    $lang = psm_get_conf('language', 'en_US');
    psm_load_lang($lang);
}
