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

/**
 *
 * Autoload
 *
 */
function __autoload($class) {
	// first check if a subdir exists for the class
	// it splits using uppercase chars
	preg_match_all("/(\P{Lu}+)|(\p{Lu}+\P{Lu}*)/", $class, $subdir_matches);

	if(!empty($subdir_matches) && count($subdir_matches[0]) > 1) {
		// okay we have some upper case, lets see if a dir exists
		$dir = dirname(__FILE__) . '/classes/' . trim($subdir_matches[0][0]);
		$file = $dir . '/' . trim($class) . '.class.php';

		if(is_dir($dir) && file_exists($file)) {
			require $file;
			return $file;
		}
	} else {
		$file = dirname(__FILE__).'/classes/'.trim(strtolower($class)).'.class.php';

		if(file_exists($file)){
			require $file;
			return $file;
		}
	}

	trigger_error("KERNEL_ERR : Unable to find file:\n\t\t[$file]\n\t associated with class:\n\t\t$class", E_USER_ERROR);
	return false;
}

###############################################
#
# Language functions
#
###############################################

/**
 * Retrieve language settings from the selected language file
 *
 * @return string
 * @see sm_load_lang()
 */
function sm_get_lang() {
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
 * @see sm_get_lang()
 */
function sm_load_lang($lang) {
	$lang_file = dirname(__FILE__) . '/lang/' . $lang . '.lang.php';

	if(!file_exists($lang_file)) {
		die('unable to load language file: ' . $lang_file);
	}

	require $lang_file;

	$GLOBALS['sm_lang'] = $sm_lang;
}

/**
 * Get a setting from the config.
 * The config must have been loaded first using sm_load_conf()
 *
 * @param string $key
 * @return string
 * @see sm_load_conf()
 */
function sm_get_conf($key) {
	$result = (isset($GLOBALS['sm_config'][$key])) ? $GLOBALS['sm_config'][$key] : null;

	return $result;
}

/**
 * Load config from the database to the $GLOBALS['sm_config'] variable
 *
 * @global object $db
 * @see sm_get_conf()
 */
function sm_load_conf() {
	global $db;

	// load config from database into global scope
	$GLOBALS['sm_config'] = array();
	$config_db = $db->select(SM_DB_PREFIX . 'config', null, array('key', 'value'));
	foreach($config_db as $setting) {
		$GLOBALS['sm_config'][$setting['key']] = $setting['value'];
	}

	if(empty($GLOBALS['sm_config']) && basename($_SERVER['SCRIPT_NAME']) != 'install.php') {
		// no config found, go to install page
		die('Failed to load config table. Please run the install.php file');
	}
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
function sm_add_log($server_id, $type, $message, $user_id = null) {
	global $db;

	$db->save(
		SM_DB_PREFIX.'log',
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
function sm_parse_msg($status, $type, $vars) {
	$message = '';

	$message = sm_get_lang('notifications', $status . '_' . $type);

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
function sm_curl_get($href) {
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
 * Check if an update is available for PHP Server Monitor
 *
 * @global object $db
 * @return boolean
 */
function sm_check_updates() {
	global $db;

	$last_update = sm_get_conf('last_update_check');

	if((time() - (7 * 24 * 60 * 60)) > $last_update) {
		// been more than a week since update, lets go
		// update "update-date"
		$db->save(SM_DB_PREFIX . 'config', array('value' => time()), array('key' => 'last_update_check'));
		$latest = sm_curl_get('http://phpservermon.neanderthal-technology.com/version');
		$current = sm_get_conf('version');

		if((int) $current < (int) $latest) {
			// new update available
			return true;
		}
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
function sm_no_cache() {
	header("Expires: Mon, 20 Dec 1998 01:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-cache, must-revalidate");
	header("Pragma: no-cache");
}

?>