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
 * @since       phpservermon 3.0.0
 **/

/**
 * Current PSM version
 */
define('PSM_VERSION', '3.6.0.beta2');

/**
 * URL to check for updates. Will not be checked if turned off on config page.
 * @see psm_update_available()
 */
define('PSM_UPDATE_URL', 'https://api.github.com/repos/phpservermon/phpservermon/releases/latest');

/**
 * Default update interval (1 day). Only applicable when updates are enabled.
 * @see psm_update_available()
 */
define('PSM_UPDATE_INTERVAL', 1 * 24 * 60 * 60);

/**
 * Configuration for: Hashing strength
 * This is the place where you define the strength of your password hashing/salting
 *
 * To make password encryption very safe and future-proof, the PHP 5.5 hashing/salting functions
 * come with a clever so called COST FACTOR. This number defines the base-2 logarithm of the rounds of hashing,
 * something like 2^12 if your cost factor is 12. By the way, 2^12 would be 4096 rounds of hashing, doubling the
 * round with each increase of the cost factor and therefore doubling the CPU power it needs.
 * Currently, in 2013, the developers of this functions have chosen a cost factor of 10, which fits most standard
 * server setups. When time goes by and server power becomes much more powerful, it might be useful to increase
 * the cost factor, to make the password hashing one step more secure. Have a look here
 * (@see https://github.com/panique/php-login/wiki/Which-hashing-&-salting-algorithm-should-be-used-%3F)
 * in the BLOWFISH benchmark table to get an idea how this factor behaves. For most people this is irrelevant,
 * but after some years this might be very very useful to keep the encryption of your database up to date.
 *
 * Remember: Every time a user registers or tries to log in (!) this calculation will be done.
 * Don't change this if you don't know what you do.
 *
 * To get more information about the best cost factor please have a look here
 * @see http://stackoverflow.com/q/4443476/1114320
 *
 * This constant will be used in the login and the registration class.
 */
define('PSM_LOGIN_HASH_COST_FACTOR', '10');

/**
 * Configuration for: Cookies
 * Please note: The COOKIE_DOMAIN needs the domain where your app is,
 * in a format like this: .mydomain.com
 * Note the . in front of the domain. No www, no http, no slash here!
 * For local development .127.0.0.1 or .localhost is fine, but when deploying you should
 * change this to your real domain, like '.mydomain.com' ! The leading dot makes the cookie available for
 * sub-domains too.
 * @see http://stackoverflow.com/q/9618217/1114320
 * @see http://www.php.net/manual/en/function.setcookie.php
 *
 * COOKIE_RUNTIME: How long should a cookie be valid ? 1209600 seconds = 2 weeks
 * COOKIE_DOMAIN: The domain where the cookie is valid for, like '.mydomain.com'
 * COOKIE_SECRET_KEY: Put a random value here to make your app more secure. When changed, all cookies are reset.
 */
define('PSM_LOGIN_COOKIE_RUNTIME', 1209600);
define('PSM_LOGIN_COOKIE_DOMAIN', null);
define('PSM_LOGIN_COOKIE_SECRET_KEY', '4w900de52e3ap7y77y8675jy6c594286');

/**
 * Number of seconds the reset link is valid after sending it to the user.
 */
define('PSM_LOGIN_RESET_RUNTIME', 3600);

/**
 * Number of seconds the cron is supposedly dead and we will run another cron anyway. Set to 0 to disable.
 */
define('PSM_CRON_TIMEOUT', 600);

/**
 * Default timeout in seconds for curl requests (can be overwritten per-server).
 */
define('PSM_CURL_TIMEOUT', 10);

/**
 * Clone URL for the Pushover.net service.
 */
define('PSM_PUSHOVER_CLONE_URL', 'https://pushover.net/apps/clone/php_server_monitor');

/**
 * Get chat id for Telegram service.
 */
define('PSM_TELEGRAM_GET_ID_URL', 'https://telegram.me/cid_bot');

/**
 * By defining the PSM_BASE_URL, you will force the psm_build_url() to use this.
 * Useful for cronjobs if it cannot be auto-detected.
 */
//define('PSM_BASE_URL', null);

if (!defined('PSM_MODULE_DEFAULT')) {
    /**
     * Default theme
     */
    define('PSM_THEME', 'default');

    /**
     * Default module (if none given or invalid one)
     */
    define('PSM_MODULE_DEFAULT', 'server_status');
}

if (defined('PSM_JABBER_FORCE_TLS') === false) {
    define('PSM_JABBER_FORCE_TLS', true);
}
if (defined('PSM_JABBER_AUTH_TYPE') === false) {
    // possible values: PLAIN, X-OAUTH2, DIGEST-MD5, CRAM-MD5, SCRAM-SHA-1, ANONYMOUS, EXTERNAL
    define('PSM_JABBER_AUTH_TYPE', 'PLAIN'); // default just plain because of google for example :(
}
if (defined('PSM_JABBER_DEBUG_LEVEL') === false) {
    // possible values: ERROR, WARNING, NOTICE, INFO, DEBUG
    define('PSM_JABBER_DEBUG_LEVEL', JAXLLogger::WARNING);
}
