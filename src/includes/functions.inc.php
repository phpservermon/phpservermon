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

	if (empty($args)) return $GLOBALS['sm_lang'];

	$result = null;
	$resultDefault = null;
	$node = null;
	$nodeDefault = null;

	if ($args) {
		$node = '$GLOBALS[\'sm_lang\'][\'' . implode('\'][\'', $args) . '\']';
		$nodeDefault = '$GLOBALS[\'sm_lang_default\'][\'' . implode('\'][\'', $args) . '\']';
	}

	eval('if (isset(' . $node . ')) $result = ' . $node . ';');
	eval('if (isset(' . $nodeDefault . ')) $resultDefault = ' . $nodeDefault . ';');

	if (empty($result)) {
		return $resultDefault;
	} else {
		return $result;
	}
}

/**
 * Load language from the language file to the $GLOBALS['sm_lang'] variable
 *
 * @param string $lang language
 * @see psm_get_lang()
 */
function psm_load_lang($lang) {
	// if not in the language translation must always be available starting translation - English
	$default_lang_file = PSM_PATH_LANG . 'en_US.lang.php';

	if (file_exists($default_lang_file)) {
		require $default_lang_file;

		if (isset($sm_lang)) {
			$GLOBALS['sm_lang_default'] = $sm_lang;
			unset($sm_lang);
		}
	}

	// translated language
	$lang_file = PSM_PATH_LANG . $lang . '.lang.php';

	if (!file_exists($lang_file)) {
		// If the file has been removed, we use the english one
		$en_file = PSM_PATH_LANG . 'en_US.lang.php';
		if (!file_exists($en_file)) {
			// OK, nothing we can do
			die('unable to load language file: ' . $lang_file);
		}
		$lang_file = $en_file;
	}

	require $lang_file;
	if (isset($sm_lang['locale'])) {
		setlocale(LC_TIME, $sm_lang['locale']);
	}

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
		$key = str_replace($fn_ext, '', basename($file));
		$sm_lang = array();
		if(file_exists($file)) {
			require $file;
		}
		if(isset($sm_lang['name'])) {
			$name = $sm_lang['name'];
		} else {
			$name = $key;
		}
		$langs[$key] = $name;
		unset($sm_lang);
	}
	ksort($langs);
	return $langs;
}

/**
 * Get a setting from the config.
 *
 * @param string $key
 * @param mixed $alt if not set, return this alternative
 * @return string
 * @see psm_load_conf()
 */
function psm_get_conf($key, $alt = null) {
	if(!isset($GLOBALS['sm_config'])) {
		psm_load_conf();
	}
	$result = (isset($GLOBALS['sm_config'][$key])) ? $GLOBALS['sm_config'][$key] : $alt;

	return $result;
}

/**
 * Load config from the database to the $GLOBALS['sm_config'] variable
 *
 * @global object $db
 * @return boolean
 * @see psm_get_conf()
 */
function psm_load_conf() {
	global $db;

	$GLOBALS['sm_config'] = array();

	if(!defined('PSM_DB_PREFIX') || !$db->status()) {
		return false;
	}
	if(!$db->ifTableExists(PSM_DB_PREFIX.'config')) {
		return false;
	}
	$config_db = $db->select(PSM_DB_PREFIX . 'config', null, array('key', 'value'));

	if(is_array($config_db) && !empty($config_db)) {
		foreach($config_db as $setting) {
			$GLOBALS['sm_config'][$setting['key']] = $setting['value'];
		}
		return true;
	} else {
		return false;
	}
}

/**
 * Update a config setting.
 *
 * If the key does not exist yet it will be created.
 * @global \psm\Service\Database $db
 * @param string $key
 * @param string $value
 */
function psm_update_conf($key, $value) {
	global $db;

	// check if key exists
	$exists = psm_get_conf($key, false);
	if($exists === false) {
		// add new config record
		$db->save(
			PSM_DB_PREFIX . 'config',
			array(
				'key' => $key,
				'value' => $value,
			)
		);
	} else {
		$db->save(
			PSM_DB_PREFIX.'config',
			array('value' => $value),
			array('key' => $key)
		);
	}
	$GLOBALS['sm_config'][$key] = $value;
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
 * @param string $type
 * @param string $message
 *
 * @return int log_id
 */
function psm_add_log($server_id, $type, $message) {
	global $db;

	return $db->save(
		PSM_DB_PREFIX.'log',
		array(
			'server_id' => $server_id,
			'type' => $type,
			'message' => $message,
		)
	);
}

/**
 * This function just adds a user to the log_users table.
 *
 * @param $log_id
 * @param $user_id
 */
function psm_add_log_user($log_id, $user_id) {
	global $db;

    $db->save(
        PSM_DB_PREFIX . 'log_users',
        array(
            'log_id'  => $log_id,
            'user_id' => $user_id,
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
 * @param boolean $status
 * @param string $type is either 'sms' or 'email'
 * @param array $server information about the server which may be placed in a message: %KEY% will be replaced by your value
 * @return string parsed message
 */
function psm_parse_msg($status, $type, $vars) {
	$status = ($status == true) ? 'on' : 'off';

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
 * @param int $timeout connection timeout in seconds. defaults to PSM_CURL_TIMEOUT (10 secs).
 * @param boolean $add_agent add user agent?
 * @param string|bool $website_username Username website
 * @param string|bool $website_password Password website
 * @return string cURL result
 */
function psm_curl_get($href, $header = false, $body = true, $timeout = null, $add_agent = true, $website_username = false, $website_password = false) {
	$timeout = $timeout == null ? PSM_CURL_TIMEOUT : intval($timeout);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HEADER, $header);
	curl_setopt($ch, CURLOPT_NOBODY, (!$body));
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
	curl_setopt($ch, CURLOPT_ENCODING, '');

    if($website_username !== false && $website_password !== false && !empty($website_username) && !empty($website_password)) {
        curl_setopt($ch, CURLOPT_USERPWD, $website_username . ":" . $website_password);
    }

	curl_setopt($ch, CURLOPT_URL, $href);

	$proxy_url = psm_get_conf('proxy_url','');
	if (psm_get_conf('proxy','0') === '1') {
		curl_setopt($ch, CURLOPT_PROXY, $proxy_url);
		$proxy_user = psm_get_conf('proxy_user','');
		$proxy_password = psm_get_conf('proxy_password','');
		if (!empty($proxy_user) && !empty($proxy_password)) {
			curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxy_user . ':' . $proxy_password);
		}
	}

	if($add_agent) {
		curl_setopt ($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; phpservermon/'.PSM_VERSION.'; +http://www.phpservermonitor.org)');
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
 */
function psm_timespan($time) {
	if(empty($time) || $time == '0000-00-00 00:00:00') {
		return psm_get_lang('system', 'never');
	}
	if ($time !== intval($time)) { $time = strtotime($time); }
	if ($time < strtotime(date('Y-m-d 00:00:00')) - 60*60*24*3) {
		$format = psm_get_lang('system', (date('Y') !== date('Y', $time)) ? 'long_day_format' : 'short_day_format');
		// Check for Windows to find and replace the %e
		// modifier correctly
		if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
			$format = preg_replace('#(?<!%)((?:%%)*)%e#', '\1%#d', $format);
		}
		return strftime($format, $time);
	}
	$d = time() - $time;
	if ($d >= 60*60*24) {
		$format = psm_get_lang('system', (date('l', time() - 60*60*24) == date('l', $time)) ? 'yesterday_format' : 'other_day_format');
		return strftime($format, $time);
	}
	if ($d >= 60*60*2) { return sprintf(psm_get_lang('system', 'hours_ago'), intval($d / (60*60))); }
	if ($d >= 60*60) { return psm_get_lang('system', 'an_hour_ago'); }
	if ($d >= 60*2) { return sprintf(psm_get_lang('system', 'minutes_ago'), intval($d / 60)); }
	if ($d >= 60) { return psm_get_lang('system', 'a_minute_ago'); }
	if ($d >= 2) { return sprintf(psm_get_lang('system', 'seconds_ago'), intval($d));intval($d); }

	return psm_get_lang('system', 'a_second_ago');
}

/**
 * Get a localised date from MySQL date format
 * @param string $time
 * @return string
 */
function psm_date($time) {
	if(empty($time) || $time == '0000-00-00 00:00:00') {
		return psm_get_lang('system', 'never');
	}
	return strftime('%x %X', strtotime($time));
}

/**
 * Check if an update is available for PHP Server Monitor.
 *
 * Will only check for new version if user turned updates on in config.
 * @return boolean
 */
function psm_update_available() {
	if(!psm_get_conf('show_update')) {
		// user does not want updates, fair enough.
		return false;
	}

	$last_update = psm_get_conf('last_update_check');

	if((time() - PSM_UPDATE_INTERVAL) > $last_update) {
		// been more than a week since update, lets go
		// update last check date
		psm_update_conf('last_update_check', time());
		$latest = psm_curl_get(PSM_UPDATE_URL);
		// add latest version to database
		if($latest !== false && strlen($latest) < 15) {
			psm_update_conf('version_update_check', $latest);
		}
	} else {
		$latest = psm_get_conf('version_update_check');
	}

	if($latest != false) {
		$current = psm_get_conf('version');
		return version_compare($latest, $current, '>');
	} else {
		return false;
	}
}

/**
 * Prepare a new phpmailer instance.
 *
 * If the from name and email are left blank they will be prefilled from the config.
 * @param string $from_name
 * @param string $from_email
 * @return \PHPMailer
 */
function psm_build_mail($from_name = null, $from_email = null) {
	$phpmailer = new \PHPMailer();
	$phpmailer->Encoding = "base64";
	$phpmailer->CharSet = 'UTF-8';
	$phpmailer->SMTPDebug = false;

	if(psm_get_conf('email_smtp') == '1') {
		$phpmailer->IsSMTP();
		$phpmailer->Host = psm_get_conf('email_smtp_host');
		$phpmailer->Port = psm_get_conf('email_smtp_port');
		$phpmailer->SMTPSecure = psm_get_conf('email_smtp_security');

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
 * Prepare a new Pushover util.
 *
 * @return \Pushover
 */
function psm_build_pushover() {
	$pushover = new \Pushover();
	$pushover->setToken(psm_get_conf('pushover_api_token'));

	return $pushover;
}

/**
 * Prepare a new SMS util.
 *
 * @return \psm\Txtmsg\TxtmsgInterface
 */
function psm_build_sms() {
	$sms = null;

	// open the right class
	// not making this any more dynamic, because perhaps some gateways need custom settings (like Mollie)
	switch(strtolower(psm_get_conf('sms_gateway'))) {
		case 'mosms':
			$sms = new \psm\Txtmsg\Mosms();
			break;
		case 'smsit':
			$sms = new \psm\Txtmsg\Smsit();
			break;
		case 'inetworx':
			$sms = new \psm\Txtmsg\Inetworx();
			break;
		case 'mollie':
			$sms = new \psm\Txtmsg\Mollie();
			$sms->setGateway(1);
			break;
		case 'spryng':
			$sms = new \psm\Txtmsg\Spryng();
			break;
		case 'clickatell':
			$sms = new \psm\Txtmsg\Clickatell();
			break;
		case 'textmarketer':
			$sms = new \psm\Txtmsg\Textmarketer();
			break;
		case 'smsglobal':
			$sms = new \psm\Txtmsg\Smsglobal();
			break;
		case 'freevoipdeal':
			$sms = new \psm\Txtmsg\FreeVoipDeal();
			break;
		case 'nexmo':
			$sms = new \psm\Txtmsg\Nexmo();
			break;
		case 'freemobilesms':
			$sms = new \psm\Txtmsg\FreeMobileSMS();
			break;
		case 'clicksend':
			$sms = new \psm\Txtmsg\ClickSend();
			break;
		case 'octopush':
			$sms = new \psm\Txtmsg\Octopush();
			break;
		case 'smsgw':
			$sms = new \psm\Txtmsg\Smsgw();
			break;
	}

	// copy login information from the config file
	if($sms) {
		$sms->setLogin(psm_get_conf('sms_gateway_username'), psm_get_conf('sms_gateway_password'));
		$sms->setOriginator(psm_get_conf('sms_from'));
	}

	return $sms;
}

/**
 * Generate a new link to the current monitor
 * @param array|string $params key value pairs or pre-formatted string
 * @param boolean $urlencode urlencode all params?
 * @param boolean $htmlentities use entities in url?
 * @return string
 */
function psm_build_url($params = array(), $urlencode = true, $htmlentities = true) {
	if(defined('PSM_BASE_URL') && PSM_BASE_URL !== null) {
		$url = PSM_BASE_URL;
	} else {
		$url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443 ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
		// on Windows, dirname() adds both back- and forward slashes (http://php.net/dirname).
		// for urls, we only want the forward slashes.
		$url .= dirname($_SERVER['SCRIPT_NAME']);
		$url = str_replace('\\', '', $url);
	}
	$url = rtrim($url, '/') . '/';

	if($params != null) {
		$url .= '?';
		if(is_array($params)) {
			$delim = ($htmlentities) ? '&amp;' : '&';

			foreach($params as $k => $v) {
				if($urlencode) {
					$v = urlencode($v);
				}
				$url .= $delim . $k . '=' . $v;
			}
		} else {
			$url .= $params;
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

/**
 * Check if we are in CLI mode
 *
 * Note, php_sapi cannot be used because cgi-fcgi returns both for web and cli.
 * @return boolean
 */
function psm_is_cli() {
	return (!isset($_SERVER['SERVER_SOFTWARE']) || php_sapi_name() == 'cli');
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
	if ($arr === null) {
		debug_print_backtrace();
	}
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

/**
 * Encrypts the password for storage in the database
 *
 * @param string $key
 * @param string $password
 * @return string
 * @author Pavel Laupe Dvorak <pavel@pavel-dvorak.cz>
 */
function psm_password_encrypt($key, $password)
{
    if(empty($password))
        return '';

    if (empty($key))
        throw new \InvalidArgumentException('invalid_encryption_key');

    $iv = mcrypt_create_iv(
		mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC),
		MCRYPT_DEV_URANDOM
	);

	$encrypted = base64_encode(
		$iv .
		mcrypt_encrypt(
			MCRYPT_RIJNDAEL_128,
			hash('sha256',  $key, true),
			$password,
			MCRYPT_MODE_CBC,
			$iv
		)
	);

	return $encrypted;
}

/**
 * Decrypts password stored in the database for future use
 *
 * @param string $key
 * @param string $encryptedString
 * @return string
 * @author Pavel Laupe Dvorak <pavel@pavel-dvorak.cz>
 */
function psm_password_decrypt($key, $encryptedString)
{
	if(empty($encryptedString))
		return '';

	if (empty($key))
         throw new \InvalidArgumentException('invalid_encryption_key');
	
	$data = base64_decode($encryptedString);
	$iv = substr($data, 0, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC));

	$decrypted = rtrim(
		mcrypt_decrypt(
			MCRYPT_RIJNDAEL_128,
			hash('sha256',  $key, true),
			substr($data, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC)),
			MCRYPT_MODE_CBC,
			$iv
		),
		"\0"
	);

	return $decrypted;
}