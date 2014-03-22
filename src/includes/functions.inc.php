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
 * This function adds the result of a check to the uptime table for logging purposes.
 *
 * @param int $server_id
 * @param int $status
 * @param string $latency
 */
function psm_log_uptime($server_id, $status, $latency) {
    global $db;

    $db->save(
        PSM_DB_PREFIX.'servers_uptime',
        array(
            'server_id' => $server_id,
            'date' => date('Y-m-d H:i:s'),
            'status' => $status,
            'latency' => $latency,
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
 * @param boolean $header return headers?
 * @param boolean $body return body?
 * @param int $timeout connection timeout in seconds
 * @param boolean $add_agent add user agent?
 * @return string cURL result
 */
function psm_curl_get($href, $header = false, $body = true, $timeout = 10, $add_agent = true) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HEADER, $header);
	curl_setopt($ch, CURLOPT_NOBODY, (!$body));
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
	curl_setopt($ch, CURLOPT_ENCODING, '');
	curl_setopt($ch, CURLOPT_URL, $href);
	if($add_agent) {
		curl_setopt ($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.11) Gecko/20071127 Firefox/2.0.0.11');
	}

	$result = curl_exec($ch);
	curl_close($ch);

	return $result;
}

/**
 * Get a "nice" timespan message
 *
 * Source: http://www.interactivetools.com/forum/forum-posts.php?postNum=2208966
 * @param string $time
 * @return string
 * @todo add translation to timespan messages
 */
function psm_timespan($time) {
	if(empty($time) || $time == '0000-00-00 00:00:00')
		return 'never';
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
 * Get a localised date from MySQL date format
 * @param string $time
 * @return string
 * @todo add translation
 */
function psm_date($time)
{
	if(empty($time) || $time == '0000-00-00 00:00:00')
		return 'never';
	return date('d/m/Y H:i:s', strtotime($time));
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
		$latest = psm_curl_get('http://www.phpservermonitor.org/version.php');
		$current = psm_get_conf('version');

		return version_compare($latest, $current, '>');
	}
	return false;
}

/**
 * Prepare a new Mailer util.
 *
 * If the from name and email are left blank they will be prefilled from the config.
 * @param string $from_name
 * @param string $from_email
 * @return \psm\Util\Mailer
 */
function psm_build_mail($from_name = null, $from_email = null) {
	$phpmailer = new \psm\Util\Mailer();
	$phpmailer->Encoding = "base64";
	$phpmailer->SMTPDebug = false;

	if(psm_get_conf('email_smtp') == '1') {
		$phpmailer->IsSMTP();
		$phpmailer->Host = psm_get_conf('email_smtp_host');
		$phpmailer->Port = psm_get_conf('email_smtp_port');

		$smtp_user = psm_get_conf('email_smtp_username');
		$smtp_pass = psm_get_conf('email_smtp_password');

		if($smtp_user != '' && $smtp_pass != '') {
			$phpmailer->SMTPAuth = true;
			$phpmailer->Username = $smtp_user;
			$phpmailer->Password = $smtp_pass;
		}
	} else {
		$phpmailer->IsMail();
	}
	if($from_name == null) {
		$from_name = psm_get_conf('email_from_name');
	}
	if($from_email == null) {
		$from_email = psm_get_conf('email_from_email');
	}
	$phpmailer->SetFrom($from_email, $from_name);

	return $phpmailer;
}

/**
 * Generate a new link to the current monitor
 * @param array $params key value pairs
 * @param boolean $urlencode urlencode all params?
 * @param boolean $htmlentities use entities in url?
 * @return string
 */
function psm_build_url($params = array(), $urlencode = true, $htmlentities = true) {
	$defports = array(80, 443);
	$url = ($_SERVER['SERVER_PORT'] == 443 ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
	if(!in_array($_SERVER['SERVER_PORT'], $defports)) {
		$url .= ':' . $_SERVER['SERVER_PORT'];
	}
	$url .= dirname($_SERVER['SCRIPT_NAME']) . '/';

	if($params != null) {
		$url .= '?';
		$delim = ($htmlentities) ? '&amp;' : '&';

		foreach($params as $k => $v) {
			if($urlencode) {
				$v = urlencode($v);
			}
			$url .= $delim . $k . '=' . $v;
		}
	}

	return $url;
}

/**
 * Try existence of a GET var, if not return the alternative
 * @param string $key
 * @param string $alt
 * @return mixed
 */
function psm_GET($key, $alt = null) {
	if(isset($_GET[$key])) {
		return $_GET[$key];
	} else {
		return $alt;
	}
}

/**
 * Try existence of a POST var, if not return the alternative
 * @param string $key
 * @param string $alt
 * @return mixed
 */
function psm_POST($key, $alt = null) {
	if(isset($_POST[$key])) {
		return $_POST[$key];
	} else {
		return $alt;
	}
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
