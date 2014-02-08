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

###############################################
#
# Language functions
#
###############################################

/**
 * Retrieve language settings from the selected language file
 *
 * @return string
 * @see psm_load_lang()
 */
function psm_get_lang() {
	$args = func_get_args();

	if(empty($args)) return $GLOBALS['sm_lang'];

	$result = null;
	$node = null;

	if($args) {
		$node = '$GLOBALS[\'sm_lang\'][\'' . implode('\'][\'', $args) . '\']';
	}
	eval('if (isset('.$node.')) $result = '.$node.';');

	return $result;
}

/**
 * Load language from the language file to the $GLOBALS['sm_lang'] variable
 *
 * @param string $lang language
 * @see psm_get_lang()
 */
function psm_load_lang($lang) {
	$lang_file = PSM_PATH_LANG . $lang . '.lang.php';

	if(!file_exists($lang_file)) {
		die('unable to load language file: ' . $lang_file);
	}

	require $lang_file;

	$GLOBALS['sm_lang'] = $sm_lang;
}

/**
 * Retrieve a list with keys of the available languages
 *
 * @return array
 * @see psm_load_lang()
 */
function psm_get_langs() {
	$fn_ext = '.lang.php';
	$lang_files = glob(PSM_PATH_LANG . '*' . $fn_ext);
	$langs = array();

	foreach($lang_files as $file) {
		$langs[] = str_replace($fn_ext, '', basename($file));
	}
	return $langs;
}

/**
 * Get a setting from the config.
 * The config must have been loaded first using psm_load_conf()
 *
 * @param string $key
 * @param mixed $alt if not set, return this alternative
 * @return string
 * @see psm_load_conf()
 */
function psm_get_conf($key, $alt = null) {
	$result = (isset($GLOBALS['sm_config'][$key])) ? $GLOBALS['sm_config'][$key] : $alt;

	return $result;
}

/**
 * Load config from the database to the $GLOBALS['sm_config'] variable
 *
 * @global object $db
 * @see psm_get_conf()
 */
function psm_load_conf() {
	global $db;

	// load config from database into global scope
	$GLOBALS['sm_config'] = array();
	$config_db = $db->select(PSM_DB_PREFIX . 'config', null, array('key', 'value'));
	foreach($config_db as $setting) {
		$GLOBALS['sm_config'][$setting['key']] = $setting['value'];
	}

	if(empty($GLOBALS['sm_config']) && basename($_SERVER['SCRIPT_NAME']) != 'install.php') {
		// no config found, go to install page
		die('Failed to load config table. Please run the install.php file');
	}
}

/**
 * Update a config setting
 * @global \psm\Service\Database $db
 * @param string $key
 * @param string $value
 */
function psm_update_conf($key, $value) {
	global $db;

	$db->save(
		PSM_DB_PREFIX.'config',
		array('value' => $value),
		array('key' => $key)
	);
}

###############################################
#
# Miscellaneous functions
#
###############################################

/**
 * This function merely adds the message to the log table. It does not perform any checks,
 * everything should have been handled when calling this function
 *
 * @param string $server_id
 * @param string $message
 */
function psm_add_log($server_id, $type, $message, $user_id = null) {
	global $db;

	$db->save(
		PSM_DB_PREFIX.'log',
		array(
			'server_id' => $server_id,
			'type' => $type,
			'message' => $message,
			'user_id' => ($user_id === null) ? '' : $user_id,
		)
	);
}

/**
 * Parses a string from the language file with the correct variables replaced in the message
 *
 * @param string $status is either 'on' or 'off'
 * @param string $type is either 'sms' or 'email'
 * @param array $server information about the server which may be placed in a message: %KEY% will be replaced by your value
 * @return string parsed message
 */
function psm_parse_msg($status, $type, $vars) {
	$message = '';

	$message = psm_get_lang('notifications', $status . '_' . $type);

	if(!$message) {
		return $message;
	}
	$vars['date'] = date('Y-m-d H:i:s');

	foreach($vars as $k => $v) {
		$message = str_replace('%' . strtoupper($k) . '%', $v, $message);
	}

	return $message;
}

/**
 * Shortcut to curl_init(), curl_exec and curl_close()
 *
 * @param string $href
 * @return string cURL result
 */
function psm_curl_get($href) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	curl_setopt($ch, CURLOPT_URL, $href);
	$result = curl_exec($ch);
	curl_close($ch);

	return $result;
}

/**
 * Get a "nice" timespan message
 *
 * Source: http://www.interactivetools.com/forum/forum-posts.php?postNum=2208966
 * @param int $time
 * @return string
 * @todo add translation to timespan messages
 */
function psm_timespan($time) {
	if ($time !== intval($time)) { $time = strtotime($time); }
	$d = time() - $time;
	if ($time < strtotime(date('Y-m-d 00:00:00')) - 60*60*24*3) {
		$format = 'F j';
		if (date('Y') !== date('Y', $time)) {
			$format .= ", Y";
		}
		return date($format, $time);
	}
	if ($d >= 60*60*24) {
		$day = 'Yesterday';
		if (date('l', time() - 60*60*24) !== date('l', $time)) { $day = date('l', $time); }
		return $day . " at " . date('g:ia', $time);
	}
	if ($d >= 60*60*2) { return intval($d / (60*60)) . " hours ago"; }
	if ($d >= 60*60) { return "about an hour ago"; }
	if ($d >= 60*2) { return intval($d / 60) . " minutes ago"; }
	if ($d >= 60) { return "about a minute ago"; }
	if ($d >= 2) { return intval($d) . " seconds ago"; }

	return "a few seconds ago";
}

/**
 * Check if an update is available for PHP Server Monitor
 *
 * @global object $db
 * @return boolean
 */
function psm_check_updates() {
	global $db;

	$last_update = psm_get_conf('last_update_check');

	if((time() - (7 * 24 * 60 * 60)) > $last_update) {
		// been more than a week since update, lets go
		// update "update-date"
		$db->save(PSM_DB_PREFIX . 'config', array('value' => time()), array('key' => 'last_update_check'));
		$latest = psm_curl_get('http://phpservermon.neanderthal-technology.com/version.php');
		$current = psm_get_conf('version');

		return version_compare($latest, $current, '>');
	}
	return false;
}

###############################################
#
# Debug functions
#
###############################################

/**
 * Only used for debugging and testing
 *
 * @param mixed $arr
 */
function pre($arr = null) {
	echo "<pre>";
	if ($arr === null) debug_print_backtrace();
	print_r($arr);
	echo "</pre>";
}

/**
 * Send headers to the browser to avoid caching
 */
function psm_no_cache() {
	header("Expires: Mon, 20 Dec 1998 01:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-cache, must-revalidate");
	header("Pragma: no-cache");
}

?>