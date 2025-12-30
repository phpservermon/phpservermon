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

namespace {

###############################################
#
# Language functions
#
###############################################

    /**
     * Retrieve language settings from the selected language file
     * Return false if arg is not found
     *
     * @return string|bool
     * @see psm_load_lang()
     */
    function psm_get_lang()
    {
        $args = func_get_args();

        if (empty($args)) {
            return isset($GLOBALS['sm_lang']) ? $GLOBALS['sm_lang'] : $GLOBALS['sm_lang_default'];
        }

        if (isset($GLOBALS['sm_lang'])) {
            $lang = $GLOBALS['sm_lang'];
            $not_found = false;
            foreach ($args as $translation) {
                // if translation does not exist, use default translation
                if (!isset($lang[$translation])) {
                    $not_found = true;
                    break;
                }
                $lang = $lang[$translation];
            }
            if (!$not_found) {
                return $lang;
            }
        }

        $lang = $GLOBALS['sm_lang_default'];
        foreach ($args as $translation) {
            $lang = $lang[$translation];
        }
        return $lang;
    }

    /**
     * Load default language from the English (en_US) language file to the $GLOBALS['sm_lang_default'] variable
     * Load language from the language file to the $GLOBALS['sm_lang'] variable if language is different from default
     *
     * @param string $lang language
     * @see psm_get_lang()
     */
    function psm_load_lang($lang)
    {
        // load default language - English (en_US)
        // this will also fill in every part that is not translated in other translation files
        $default_lang_file = PSM_PATH_LANG . 'en_US.lang.php';

        file_exists($default_lang_file) ? require $default_lang_file :
            trigger_error("English translation needs to be installed at all time!", E_USER_ERROR);
        isset($sm_lang) ? $GLOBALS['sm_lang_default'] = $sm_lang :
            trigger_error("\$sm_lang not found in English translation!", E_USER_ERROR);
        unset($sm_lang);
        // load translation is the selected language is not English (en_US)
        if ($lang != "en_US") {
            $lang_file = PSM_PATH_LANG . $lang . '.lang.php';
            file_exists($lang_file) ? require $lang_file :
                trigger_error("Translation file could not be found! Default language will be used.", E_USER_WARNING);

            isset($sm_lang) ? $GLOBALS['sm_lang'] = $sm_lang :
                trigger_error("\$sm_lang not found in translation file! Default language will be used.", E_USER_WARNING);
            isset($sm_lang['locale']) ? setlocale(LC_TIME, $sm_lang['locale']) :
                trigger_error("locale could not ben found in translation file.", E_USER_WARNING);
        }
    }

    /**
     * Retrieve a list with keys of the available languages
     *
     * @return array
     * @see psm_load_lang()
     */
    function psm_get_langs()
    {
        $fn_ext = '.lang.php';
        $lang_files = glob(PSM_PATH_LANG . '*' . $fn_ext);
        $langs = array();

        foreach ($lang_files as $file) {
            $key = str_replace($fn_ext, '', basename($file));
            $sm_lang = array();
            if (file_exists($file)) {
                require $file;
            }
            if (isset($sm_lang['name'])) {
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
     * Retrieve a list with available sms gateways
     *
     * @return array
     */
    function psm_get_sms_gateways()
    {
        $sms_gateway_files = glob(PSM_PATH_SMS_GATEWAY . '*.php');
        $sms_gateways = array();

        foreach ($sms_gateway_files as $file) {
            $name = basename($file, ".php");
            // filter system files out
            if ($name != "Core" && $name != "TxtmsgInterface") {
                $sms_gateways[strtolower($name)] = $name;
            }
        }

        ksort($sms_gateways);
        return $sms_gateways;
    }

    /**
     * Get a setting from the config.
     *
     * @param string $key
     * @param mixed $alt if not set, return this alternative
     * @return string
     * @see psm_load_conf()
     */
    function psm_get_conf($key, $alt = null)
    {
        if (!isset($GLOBALS['sm_config'])) {
            psm_load_conf();
        }
        $result = (isset($GLOBALS['sm_config'][$key])) ? $GLOBALS['sm_config'][$key] : $alt;

        return $result;
    }

    /**
     * Load config from the database to the $GLOBALS['sm_config'] variable
     *
     * @param bool $forceReload set to true to refresh the cached configuration
     * @return boolean
     * @global object $db
     * @see psm_get_conf()
     */
    function psm_load_conf($forceReload = false)
    {
        global $db;

        if (isset($GLOBALS['sm_config']) && !$forceReload && !empty($GLOBALS['sm_config'])) {
            return true;
        }

        $GLOBALS['sm_config'] = array();

        if (!defined('PSM_DB_PREFIX') || !$db->status()) {
            return false;
        }
        if (!$db->ifTableExists(PSM_DB_PREFIX . 'config')) {
            return false;
        }
        try {
            $config_db = $db->select(PSM_DB_PREFIX . 'config', null, array('key', 'value'));

            if (is_array($config_db) && !empty($config_db)) {
                foreach ($config_db as $setting) {
                    $GLOBALS['sm_config'][$setting['key']] = $setting['value'];
                }
                return true;
            }
        } catch (\Throwable $exception) {
            error_log('Failed to load configuration: ' . $exception->getMessage());
        }

        return false;
    }

    /**
     * Update a config setting.
     *
     * If the key does not exist yet it will be created.
     * @param string $key
     * @param string $value
     * @global \psm\Service\Database $db
     */
    function psm_update_conf($key, $value)
    {
        global $db;

        // check if key exists
        $exists = psm_get_conf($key, false);
        if ($exists === false) {
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
                PSM_DB_PREFIX . 'config',
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
    function psm_add_log($server_id, $type, $message)
    {
        global $db;

        return $db->save(
            PSM_DB_PREFIX . 'log',
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
    function psm_add_log_user($log_id, $user_id)
    {
        global $db;

        $db->save(
            PSM_DB_PREFIX . 'log_users',
            array(
                'log_id' => $log_id,
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
    function psm_log_uptime($server_id, $status, $latency)
    {
        global $db;

        $db->save(
            PSM_DB_PREFIX . 'servers_uptime',
            array(
                'server_id' => $server_id,
                'date' => date('Y-m-d H:i:s'),
                'status' => $status,
                'latency' => $latency,
            )
        );
    }

    /**
     * Converts an interval into a string
     *
     * @param DateInterval $interval
     * @return string
     */
    function psm_format_interval(DateInterval $interval)
    {
        $result = "";

        if ($interval->y) {
            $result .= $interval->format("%y ") . (($interval->y == 1) ?
                    psm_get_lang('system', 'year') : psm_get_lang('system', 'years')) . " ";
        }
        if ($interval->m) {
            $result .= $interval->format("%m ") . (($interval->m == 1) ?
                    psm_get_lang('system', 'month') : psm_get_lang('system', 'months')) . " ";
        }
        if ($interval->d) {
            $result .= $interval->format("%d ") . (($interval->d == 1) ?
                    psm_get_lang('system', 'day') : psm_get_lang('system', 'days')) . " ";
        }
        if ($interval->h) {
            $result .= $interval->format("%h ") . (($interval->h == 1) ?
                    psm_get_lang('system', 'hour') : psm_get_lang('system', 'hours')) . " ";
        }
        if ($interval->i) {
            $result .= $interval->format("%i ") . (($interval->i == 1) ?
                    psm_get_lang('system', 'minute') : psm_get_lang('system', 'minutes')) . " ";
        }
        if ($interval->s) {
            $result .= $interval->format("%s ") . (($interval->s == 1) ?
                    psm_get_lang('system', 'second') : psm_get_lang('system', 'seconds')) . " ";
        }

        return $result;
    }

    /**
     * Parses a string from the language file with the correct variables replaced in the message
     *
     * @param boolean|null $status
     * @param string $type is either 'sms', 'email', 'pushover_title', 'pushover_message', 'webhook_title', 'webhook_message' or 'telegram_message'
     * @param array $vars server information about the server which may be placed in a message:
     *     %KEY% will be replaced by your value
     * @param boolean $combi parse other message if notifications need to be send combined
     * @return string parsed message
     */
    function psm_parse_msg($status, $type, $vars, $combi = false)
    {
        if (is_bool($status)) {
            $status = ($status === true) ? 'on_' : 'off_';
        }

        $combi = ($combi === true) ? 'combi_' : '';

        $message = psm_get_lang('notifications', $combi . $status . $type);

        if (!$message) {
            return $message;
        }
        $vars['date'] = date('Y-m-d H:i:s');

        foreach ($vars as $k => $v) {
            $message = str_replace('%' . strtoupper($k) . '%', $v, $message);
        }

        return $message;
    }

    /**
     *
     * @param string $href
     * @param boolean $header return headers?
     * @param boolean $body return body?
     * @param int|null $timeout connection timeout in seconds. defaults to PSM_CURL_TIMEOUT (10 secs).
     * @param boolean $add_agent add user agent?
     * @param string|bool $website_username Username website
     * @param string|bool $website_password Password website
     * @param string|null $request_method Request method like GET, POST etc.
     * @param string|null $post_field POST data
     * @param string|null $custom_header HEADER data
     * @param bool $send_authentication_header Send Authorization header with the first request
     * @return array cURL result
     */
    function psm_curl_get(
        $href,
        $header = false,
        $body = true,
        $timeout = null,
        $add_agent = true,
        $website_username = false,
        $website_password = false,
        $request_method = null,
        $post_field = null,
        $custom_header = null,
        $send_authentication_header = false
    ) {
        $timeout = ($timeout === null || $timeout <= 0)
            ? PSM_CURL_TIMEOUT
            : intval($timeout);

        $ch = curl_init();
        if (defined('PSM_DEBUG') && PSM_DEBUG === true && psm_is_cli()) {
            curl_setopt($ch, CURLOPT_VERBOSE, true);
        }
        curl_setopt($ch, CURLOPT_HEADER, $header);
        curl_setopt($ch, CURLOPT_NOBODY, (!$body));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_CERTINFO, 1);
        curl_setopt($ch, CURLOPT_COOKIEFILE, '');

        if (!empty($request_method)) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $request_method);
        }

        if (!empty($post_field)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_field);
        }

        $headers = array();
        if (!empty($custom_header)){
            $headers[] = $custom_header;
        }

        if (
            $website_username !== false &&
            $website_password !== false &&
            !empty($website_username) &&
            !empty($website_password)
        ) {
            // Explicitly allow cURL to negotiate the authentication scheme when credentials are provided.
            // Some servers will not challenge without this flag, which makes wrong credentials appear successful.
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            // Keep the Authorization header across redirects so HTTP-authenticated sites that redirect
            // (e.g. HTTP → HTTPS) still validate credentials instead of loading the login page anonymously.
            curl_setopt($ch, CURLOPT_UNRESTRICTED_AUTH, true);
            curl_setopt($ch, CURLOPT_USERPWD, $website_username . ":" . $website_password);

            if ($send_authentication_header) {
                $headers[] = 'Authorization: Basic ' . base64_encode($website_username . ':' . $website_password);
            }
        }

        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        $href = preg_replace('/(.*)(%cachebuster%)/', '$0' . time(), $href);

        curl_setopt($ch, CURLOPT_URL, $href);

        $proxy_url = psm_get_conf('proxy_url', '');
        if (psm_get_conf('proxy', '0') === '1') {
            curl_setopt($ch, CURLOPT_PROXY, $proxy_url);
            $proxy_user = psm_get_conf('proxy_user', '');
            $proxy_password = psm_get_conf('proxy_password', '');
            if (!empty($proxy_user) && !empty($proxy_password)) {
                curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxy_user . ':' . $proxy_password);
            }
        }

        if ($add_agent) {
            curl_setopt($ch, CURLOPT_USERAGENT, psm_get_conf('user_agent', 'Mozilla/5.0 (compatible; phpservermon/' .
                PSM_VERSION . '; +https://github.com/phpservermon/phpservermon)'));
        }

        $result['exec'] = curl_exec($ch);
        $result['info'] = curl_getinfo($ch);


        if (defined('PSM_DEBUG') && PSM_DEBUG === true && psm_is_cli()) {
            echo PHP_EOL .
                '==============cURL Result for: ' . $href . '===========================================' . PHP_EOL;
            print_r($result);
            echo PHP_EOL .
                '==============END cURL Resul for: ' . $href . '===========================================' . PHP_EOL;
        }

        return $result;
    }

    /**
     * Get a "nice" timespan message
     *
     * Source: http://www.interactivetools.com/forum/forum-posts.php?postNum=2208966
     * @param string $time
     * @return string
     */
    function psm_timespan($time)
    {
        if (empty($time) || $time == '0000-00-00 00:00:00') {
            return psm_get_lang('system', 'never');
        }
        if ($time !== intval($time)) {
            $time = strtotime($time);
        }
        if ($time < strtotime(date('Y-m-d 00:00:00')) - 60 * 60 * 24 * 3) {
            $format = psm_get_lang('system', (date('Y') !== date('Y', $time) ? 'long_day_format' : 'short_day_format'));
            
            return formatLanguage($format, $time);
        }
        $d = time() - $time;
        if ($d >= 60 * 60 * 24) {
            $format = psm_get_lang('system', (date('l', time() - 60 * 60 * 24) == date('l', $time)) ?
            'yesterday_format' : 'other_day_format');
            return formatLanguage($format, $time);
        }
        if ($d >= 60 * 60 * 2) {
            return sprintf(psm_get_lang('system', 'hours_ago'), intval($d / (60 * 60)));
        }
        if ($d >= 60 * 60) {
            return psm_get_lang('system', 'an_hour_ago');
        }
        if ($d >= 60 * 2) {
            return sprintf(psm_get_lang('system', 'minutes_ago'), intval($d / 60));
        }
        if ($d >= 60) {
            return psm_get_lang('system', 'a_minute_ago');
        }
        if ($d >= 2) {
            return sprintf(psm_get_lang('system', 'seconds_ago'), intval($d));
        }

        return psm_get_lang('system', 'a_second_ago');
    }

    /**
     * Get a localised date from MySQL date format
     * @param string $time
     * @return string
     */
    function psm_date($time)
    {
        if (empty($time) || $time == '0000-00-00 00:00:00') {
            return psm_get_lang('system', 'never');
        }
        return formatLanguage('%x %X', strtotime($time));
    }

    /**
     * Check if an update is available for PHP Server Monitor.
     *
     * Will only check for new version if user turned updates on in config.
     * @return boolean
     */
    function psm_update_available()
    {
        if (!psm_get_conf('show_update')) {
            // user does not want updates, fair enough.
            return false;
        }

        $last_update = psm_get_conf('last_update_check');

        if ((time() - PSM_UPDATE_INTERVAL) > $last_update) {
            // been more than a week since update, lets go
            // update last check date
            psm_update_conf('last_update_check', time());
            $latest = psm_curl_get(PSM_UPDATE_URL);
            if ($latest['info'] === false || (int)$latest['info']['http_code'] >= 300) {
                // error
                return false;
            }
            // extract latest version from Github.
            $githubInfo = json_decode($latest['exec']);
            if (property_exists($githubInfo, 'tag_name') === false) {
                // version not found
                return false;
            }
            $tagName = $githubInfo->tag_name;
            $latestVersion = str_replace('v', '', $tagName);
            // check from old version ... maybe has reason but I don't think so ...
            if (empty($latestVersion) === true || strlen($latestVersion) >= 15) {
                // weird version
                return false;
            }
            // add latest version to database
            psm_update_conf('version_update_check', $latestVersion);
        } else {
            $latestVersion = psm_get_conf('version_update_check');
        }

        $current = psm_get_conf('version');
        return version_compare($latestVersion, $current, '>');
    }

    /**
     * Prepare a new phpmailer instance.
     *
     * If the from name and email are left blank they will be prefilled from the config.
     * @param string $from_name
     * @param string $from_email
     * @return \PHPMailer\PHPMailer\PHPMailer
     */
    function psm_build_mail($from_name = null, $from_email = null, $throw_exceptions = false)
    {
        $phpmailer = new \PHPMailer\PHPMailer\PHPMailer($throw_exceptions);
        $phpmailer->Encoding = "base64";
        $phpmailer->CharSet = 'UTF-8';
        $phpmailer->SMTPDebug = 0;
        // Prevent extremely long timeouts when testing email configuration
        $phpmailer->Timeout = 15;
        $phpmailer->Timelimit = 15;

        if (psm_get_conf('email_smtp') == '1') {
            $phpmailer->IsSMTP();
            $phpmailer->Host = psm_get_conf('email_smtp_host');
            $phpmailer->Port = (int)psm_get_conf('email_smtp_port');
            $phpmailer->SMTPSecure = psm_get_conf('email_smtp_security');
            if (psm_get_conf('email_smtp_security') == ''){
                $phpmailer->SMTPAutoTLS = false;
            }
            $smtp_user = psm_get_conf('email_smtp_username');
            $smtp_pass = psm_password_decrypt(
                psm_get_conf('password_encrypt_key'),
                psm_get_conf('email_smtp_password')
            );

            if ($smtp_user != '' && $smtp_pass != '') {
                $phpmailer->SMTPAuth = true;
                $phpmailer->Username = $smtp_user;
                $phpmailer->Password = $smtp_pass;
            }
        } else {
            $phpmailer->IsMail();
        }
        if ($from_name == null) {
            $from_name = psm_get_conf('email_from_name');
        }
        if ($from_email == null) {
            $from_email = psm_get_conf('email_from_email');
        }
        $phpmailer->SetFrom($from_email, $from_name);

        return $phpmailer;
    }

    /**
     * Send an email and log the delivery attempt.
     *
     * @param \PHPMailer\PHPMailer\PHPMailer $phpmailer
     * @param array $metadata Additional metadata to include in the log entry.
     * @return bool True when the email was accepted for delivery, false otherwise.
     */
    function psm_send_and_log_mail($phpmailer, array $metadata = array())
    {
        $sent = false;

        try {
            $sent = $phpmailer->send();
        } catch (\Throwable $exception) {
            $error_info = trim($phpmailer->ErrorInfo . ' ' . $exception->getMessage());
            $phpmailer->ErrorInfo = $error_info;
            $sent = false;
        }

        psm_log_email_attempt($phpmailer, $sent, $metadata);

        return $sent;
    }

    /**
     * Resolve the application logs directory.
     *
     * @return string|null Absolute path to the logs directory or null when it cannot be created.
     */
    function psm_get_logs_directory()
    {
        $log_dir = PSM_PATH_SRC . '..' . DIRECTORY_SEPARATOR . 'logs';
        $resolved_dir = realpath($log_dir) ?: $log_dir;

        if (!is_dir($resolved_dir)) {
            if (!@mkdir($resolved_dir, 0777, true) && !is_dir($resolved_dir)) {
                error_log('Unable to create logs directory: ' . $resolved_dir);

                return null;
            }
        }

        return $resolved_dir;
    }

    /**
     * Write a generic application log entry.
     *
     * @param string $context
     * @param string $message
     * @return void
     */
    function psm_log_event($context, $message)
    {
        $log_dir = psm_get_logs_directory();
        if ($log_dir === null) {
            return;
        }

        $log_entry = sprintf('[%s] [%s] %s%s', date('c'), $context, trim($message), PHP_EOL);
        $log_file = rtrim($log_dir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'application.log';

        if (false === @file_put_contents($log_file, $log_entry, FILE_APPEND)) {
            error_log('Unable to write application log entry to ' . $log_file);
        }
    }

    /**
     * Log an email delivery attempt to the webroot logs directory.
     *
     * @param \PHPMailer\PHPMailer\PHPMailer $phpmailer
     * @param bool $sent
     * @param array $metadata
     * @return void
     */
    function psm_log_email_attempt($phpmailer, $sent, array $metadata = array())
    {
        $log_dir = psm_get_logs_directory();
        if ($log_dir === null) {
            return;
        }

        $context = isset($metadata['context']) ? $metadata['context'] : 'general';
        if (isset($metadata['context'])) {
            unset($metadata['context']);
        }

        $recipients = array();
        if (method_exists($phpmailer, 'getToAddresses')) {
            foreach ($phpmailer->getToAddresses() as $address) {
                $recipients[] = $address[0];
            }
        }

        $subject = property_exists($phpmailer, 'Subject') ? $phpmailer->Subject : '';
        $status = $sent ? 'sent' : 'failed';
        $error_info = (!$sent && property_exists($phpmailer, 'ErrorInfo')) ? trim($phpmailer->ErrorInfo) : '';

        $metadata_string = '';
        if (!empty($metadata)) {
            $metadata_string = ' meta=' . json_encode($metadata);
        }

        $log_entry = sprintf(
            '[%s] [%s] to=%s subject="%s" result=%s',
            date('c'),
            $context,
            empty($recipients) ? '-' : implode(',', $recipients),
            $subject,
            $status
        );

        if ($error_info !== '') {
            $log_entry .= ' error=' . $error_info;
        }
        $log_entry .= $metadata_string . PHP_EOL;

        $log_file = rtrim($log_dir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'emails.log';
        if (false === @file_put_contents($log_file, $log_entry, FILE_APPEND)) {
            error_log('Unable to write email log entry to ' . $log_file);
        }
    }

    /**
     * Prepare a new Pushover util.
     *
     * @return \Pushover
     */
    function psm_build_pushover()
    {
        $pushover = new \Pushover();
        $pushover->setToken(psm_get_conf('pushover_api_token'));

        return $pushover;
    }

    /**
     * Prepare a new Webhook util.
     *
     * @return Webhook
     */
    function psm_build_webhook()
    {
        $webhook = new Webhook();

        return $webhook;
    }

    /**
     *
     * @return \Telegram
     */
    function psm_build_telegram()
    {
        $telegram = new \Telegram(PSM_TELEGRAM_API_URL);
        $telegram->setToken(psm_get_conf('telegram_api_token'));

        return $telegram;
    }

    /**
     * Send message via XMPP.
     *
     * @param string $host
     * @param string $username
     * @param string $password
     * @param array $receivers
     * @param string $message
     * @param int|null $port
     * @param string|null $domain
     */
    function psm_jabber_send_message($host, $username, $password, $receivers, $message, $port = null, $domain = null)
    {
        $options = [
            'jid' => $username, // incl. gmail.com
            'pass' => $password,
            'domain' => $domain, // gmail.com or null
            'host' => $host, // talk.google.com
            'port' => $port, // talk.google.com needs to have 5223 ... 5222 - CN problem - gmail.com vs talk.google.com
            'log_path' => __DIR__ . '/../../logs/jaxl.log', // own log

            // force tls
            'force_tls' => PSM_JABBER_FORCE_TLS,
            // (required) perform X-OAUTH2
            'auth_type' => PSM_JABBER_AUTH_TYPE, //'X-OAUTH2', // auth failure with this option :( so just PLAIN ...

            'log_level' => PSM_JABBER_DEBUG_LEVEL
        ];

        try {
            $client = new JAXL($options);

            // Add Callbacks
            $client->add_cb('on_auth_success', function () use ($client, $receivers, $message) {
                JAXLLogger::info('got on_auth_success cb');
                foreach ($receivers as $receiver) {
                    $client->send_chat_msg($receiver, $message);
                }
                $client->send_end_stream();
            });
            $client->add_cb('on_auth_failure', function ($reason) use ($client) {
                $client->send_end_stream();
                JAXLLogger::info('got on_auth_failure cb with reason: ' . $reason);
            });
            $client->add_cb('on_disconnect', function () use ($client) {
                JAXLLogger::info('got on_disconnect cb');
            });

            $client->start();
        } catch (Exception $ex) {
            JAXLLogger::error('Exception: ' . $ex->getMessage());
        }
    }

    /**
     * Prepare a new SMS util.
     *
     * @return \psm\Txtmsg\TxtmsgInterface
     */
    function psm_build_sms()
    {
        $sms = null;

        // open the right class
        // not making this any more dynamic, because perhaps some gateways need custom settings
        switch (strtolower(psm_get_conf('sms_gateway'))) {
            case 'mosms':
                $sms = new \psm\Txtmsg\Mosms();
                break;
            case 'smsit':
                $sms = new \psm\Txtmsg\Smsit();
                break;
            case 'inetworx':
                $sms = new \psm\Txtmsg\Inetworx();
                break;
            case 'messagebird':
                $sms = new \psm\Txtmsg\Messagebird();
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
            case 'infobip':
                $sms = new \psm\Txtmsg\Infobip();
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
            case 'ovhsms':
                $sms = new \psm\Txtmsg\OVHsms();
                break;
            case 'smsgw':
                $sms = new \psm\Txtmsg\Smsgw();
                break;
            case 'twilio':
                $sms = new \psm\Txtmsg\Twilio();
                break;
            case 'cmbulksms':
                $sms = new \psm\Txtmsg\CMBulkSMS();
                break;
            case 'gatewayapi':
                $sms = new \psm\Txtmsg\GatewayAPI();
                break;
            case 'callr':
                $sms = new \psm\Txtmsg\Callr();
                break;
            case 'plivo':
                $sms = new \psm\Txtmsg\Plivo();
                break;
            case 'solutionsinfini':
                $sms = new \psm\Txtmsg\SolutionsInfini();
                break;
            case 'ysmal':
                $sms = new \psm\Txtmsg\Ysmal();
            case 'smsapi':
                $sms = new \psm\Txtmsg\SMSAPI();
                break;
            case 'promosms':
                $sms = new \psm\Txtmsg\PromoSMS();
            case 'labsmobile':
                $sms = new \psm\Txtmsg\LabsMobile();
                break;
            case 'tele2':
                $sms = new \psm\Txtmsg\Tele2();
                break;
        }

        // copy login information from the config file
        if ($sms) {
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
    function psm_build_url($params = array(), $urlencode = true, $htmlentities = true)
    {
        if (defined('PSM_BASE_URL') && PSM_BASE_URL !== null) {
            $url = PSM_BASE_URL;
        } else {
            $url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ||
                $_SERVER['SERVER_PORT'] == 443 ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
            // on Windows, dirname() adds both back- and forward slashes (http://php.net/dirname).
            // for urls, we only want the forward slashes.
            $url .= dirname($_SERVER['SCRIPT_NAME']);
            $url = str_replace('\\', '', $url);
        }
        $url = rtrim($url, '/') . '/';

        if ($params != null) {
            $url .= '?';
            if (is_array($params)) {
                $delim = ($htmlentities) ? '&amp;' : '&';

                $first = true;
                foreach ($params as $k => $v) {
                    if ($urlencode) {
                        $v = urlencode($v);
                    }

                    if (!$first) {
                        $url .= $delim;
                    }

                    $url .= $k . '=' . $v;
                    $first = false;
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
    function psm_GET($key, $alt = null)
    {
        if (isset($_GET[$key])) {
            return $_GET[$key];
        } else {
            return $alt;
        }
    }

    /**
     * Try existence of a POST var, if not return the alternative
     * @param string $key
     * @param string|array|bool $alt
     * @return mixed
     */
    function psm_POST($key, $alt = null)
    {
        if (isset($_POST[$key])) {
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
    function psm_is_cli()
    {
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
    function pre($arr = null)
    {
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
    function psm_no_cache()
    {
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
        if (empty($password)) {
            return '';
        }

        if (empty($key)) {
            throw new \InvalidArgumentException('invalid_encryption_key');
        }

        // using open ssl
        $cipher = "AES-256-CBC";
        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);
        $encrypted = base64_encode(
            $iv .
            openssl_encrypt(
                $password,
                $cipher,
                hash('sha256', $key, true),
                OPENSSL_RAW_DATA,   // OPENSSL_ZERO_PADDING  OPENSSL_RAW_DATA
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
        if (empty($encryptedString)) {
            return '';
        }

        if (empty($key)) {
            throw new \InvalidArgumentException('invalid_encryption_key');
        }

        // using open ssl
        $data = base64_decode($encryptedString);
        $cipher = "AES-256-CBC";
        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = substr($data, 0, $ivlen);
        $decrypted = openssl_decrypt(
            substr($data, $ivlen),
            $cipher,
            hash('sha256', $key, true),
            OPENSSL_RAW_DATA,
            $iv
        );

        return $decrypted;
    }
    
    /**
     * Convert strftime format to php date format
     * @param $strftimeformat
     * @return string|string[]
     * @throws Exception
     */
    function strftimeFormatToDateFormat($strftimeformat){
        $unsupported = ['%U', '%V', '%C', '%g', '%G'];
        $foundunsupported = [];
        foreach($unsupported as $unsup){
            if (strpos($strftimeformat, $unsup) !== false){
                $foundunsupported[] = $unsup;
            }
        }
        if (!empty($foundunsupported)){
            throw new \Exception("Found these unsupported chars: ".implode(",", $foundunsupported).' in '.$strftimeformat);
        }
        // It is important to note that some do not translate accurately ie. lowercase L is supposed to convert to number with a preceding space if it is under 10, there is no accurate conversion so we just use 'g'
        $phpdateformat = str_replace(
            ['%a','%A','%d','%e','%u','%w','%W','%b','%h','%B','%m','%y','%Y', '%D',    '%F',   '%x', '%n', '%t', '%H', '%k', '%I', '%l', '%M', '%p', '%P', '%r' /* %I:%M:%S %p */, '%R' /* %H:%M */, '%S', '%T' /* %H:%M:%S */, '%X', '%z', '%Z',
                '%c', '%s',
                '%%'],
            ['D','l', 'd', 'j', 'N', 'w', 'W', 'M', 'M', 'F', 'm', 'y', 'Y', 'm/d/y', 'Y-m-d', 'm/d/y',"\n","\t", 'H', 'G', 'h', 'g', 'i', 'A', 'a', 'h:i:s A', 'H:i', 's', 'H:i:s', 'H:i:s', 'O', 'T',
                'D M j H:i:s Y' /*Tue Feb 5 00:45:10 2009*/, 'U',
                '%'],
            $strftimeformat
        );
        return $phpdateformat;
    }

    function formatLanguage(string $formatSTRF,int $timestamp) : string {
        $format = strftimeFormatToDateFormat($formatSTRF);
        
        $dt = new DateTime();
        $dt->setTimestamp($timestamp);

        $language = isset($GLOBALS['sm_lang']) ? $GLOBALS['sm_lang']['locale'][1] : $GLOBALS['sm_lang_default']['locale'][1];
        $curTz = $dt->getTimezone();
        if($curTz->getName() === 'Z'){
            //INTL don't know Z
            $curTz = new DateTimeZone('UTC');
        }

        $formatPattern = strtr($format,array(
            'D' => '{#1}',
            'l' => '{#2}',
            'M' => '{#3}',
            'F' => '{#4}',
        ));
        $strDate = $dt->format($formatPattern);
        $regEx = '~\{#\d\}~';
        while(preg_match($regEx,$strDate,$match)) {
            $IntlFormat = strtr($match[0],array(
              '{#1}' => 'E',
              '{#2}' => 'EEEE',
              '{#3}' => 'MMM',
              '{#4}' => 'MMMM',
            ));
            $fmt = datefmt_create($language, IntlDateFormatter::FULL, IntlDateFormatter::FULL,
                $curTz, IntlDateFormatter::GREGORIAN, $IntlFormat
            );
            $replace = $fmt ? datefmt_format( $fmt ,$dt) : "???";
            $strDate = str_replace($match[0], $replace, $strDate);
        }

        return $strDate;
    }

	/**
	* Send notification to Telegram
	*
	* @return string
	* @author Tim Zandbergen <tim@xervion.nl>
	*/
    class Telegram
    {
        private $token;
        private $user;
        private $message;
        private $apiBase;
        private $parseMode = 'HTML';
        private $disableWebPagePreview = true;

        public function __construct($apiBase = null)
        {
            $this->apiBase = rtrim($apiBase ?: PSM_TELEGRAM_API_URL, '/');
        }

        public function setToken($token)
        {
            $this->token = (string)$token;
        }

        public function setUser($user)
        {
            $this->user = (string)$user;
        }

        public function setMessage($message)
        {
            $message = str_replace("<ul>", "", $message);
            $message = str_replace("</ul>", "\n", $message);
            $message = str_replace("<li>", "- ", $message);
            $message = str_replace("</li>", "\n", $message);
            $message = str_replace("<br>", "\n", $message);
            $message = str_replace("<br/>", "\n", $message);
            $this->message = (string)$message;
        }

        private function buildEndpoint($method)
        {
            return $this->apiBase . '/bot' . urlencode($this->token) . '/' . ltrim($method, '/');
        }

        private function sendRequest($method, array $payload)
        {
            if (empty($this->token)) {
                return [
                    'ok' => false,
                    'description' => 'No Telegram API token configured',
                ];
            }

            $endpoint = $this->buildEndpoint($method);
            $encodedPayload = json_encode($payload);

            if ($encodedPayload === false) {
                return [
                    'ok' => false,
                    'description' => 'Unable to encode Telegram payload',
                ];
            }

            $con = curl_init($endpoint);
            if ($con === false) {
                return [
                    'ok' => false,
                    'description' => 'Failed to initialize request to Telegram',
                ];
            }

            curl_setopt($con, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($con, CURLOPT_CONNECTTIMEOUT, 5);
            // Keep the total request time short to avoid tying up the config save request
            curl_setopt($con, CURLOPT_TIMEOUT, 15);
            curl_setopt($con, CURLOPT_POST, true);
            curl_setopt($con, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Accept: application/json'
            ));
            curl_setopt($con, CURLOPT_POSTFIELDS, $encodedPayload);

            $response = curl_exec($con);
            if ($response === false) {
                $curlError = curl_error($con);

                return [
                    'ok' => false,
                    'description' => $curlError ?: 'Unknown cURL error while contacting Telegram',
                ];
            }

            $httpCode = curl_getinfo($con, CURLINFO_HTTP_CODE);

            $decodedResponse = json_decode($response, true);

            if ($httpCode < 200 || $httpCode >= 300) {
                return [
                    'ok' => false,
                    'description' => $decodedResponse['description'] ?? ('Telegram returned HTTP ' . $httpCode),
                    'http_code' => $httpCode,
                ];
            }

            return $decodedResponse ?: [
                'ok' => false,
                'description' => 'Unable to decode Telegram response',
            ];
        }

        public function send()
        {
            if (empty($this->token)) {
                return [
                    'ok' => false,
                    'description' => 'No Telegram API token configured',
                ];
            }

            if (empty($this->user)) {
                return [
                    'ok' => false,
                    'description' => 'No Telegram chat id configured',
                ];
            }

            if (empty($this->message)) {
                return [
                    'ok' => false,
                    'description' => 'No Telegram message provided',
                ];
            }

            $payload = array(
                'chat_id' => $this->user,
                'text' => $this->message,
                'parse_mode' => $this->parseMode,
                'disable_web_page_preview' => $this->disableWebPagePreview,
            );

            return $this->sendRequest('sendMessage', $payload);
        }

        // Get the bots username
        public function getBotUsername()
        {
            if (empty($this->token)) {
                return [
                    'ok' => false,
                    'description' => 'No Telegram API token configured',
                ];
            }

            return $this->sendRequest('getMe', array());
        }
    }

    /**
     * Send notification via webhooks
     *
     * @return string
     * @author Malte Grosse
     */
    class Webhook
    {
        protected $url;
        protected $json;

        /**
         * Send Webhook
         *
         * @return bool|string
         * @var array $replacements should be an array of key value as strings where key is the placeholder name to replace in json template with the value
         *
         */

        public function sendWebhook($replacements)
        {
            $error = "";
            $success = 1;

            $jsonMessage = $this->json;

            $replacements['#message'] = $this->stripTagsFromMessage($replacements['#message']);

           foreach($replacements as $key => $val) {
                 $jsonMessage = str_replace($key, $val, $jsonMessage);
            }

            $curl = curl_init($this->url);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonMessage);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
            // Avoid long-running webhook calls when saving configuration
            curl_setopt($curl, CURLOPT_TIMEOUT, 15);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            $result = curl_exec($curl);

            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $err = curl_errno($curl);

            if ($err != 0 || $httpcode < 200 || $httpcode >= 300) {
                $success = 0;
                $error = "HTTP_code: " . $httpcode . ".\ncURL error (" . $err . "): " . $err . ". \nResult: " . $result;
            }


            if ($success) {
                return 1;
            }
            return $error;
        }

        /**
         * setUrl
         *
         * @var string $url
         *
         */
        public function setUrl($url)
        {
            $this->url = $url;
        }

        /**
         * getUrl
         *
         * @return string
         */
        public function getUrl()
        {
            return $this->url;
        }

        /**
         * setJson
         *
         * @var string $json
         *
         */
        public function setJson($json)
        {
            $this->json = $json;
        }

        /**
         * getJson
         *
         * @return string
         */
        public function getJson()
        {
            return $this->json;
        }

        /**
         * Set message
         *
         * @return string
         * @var string $message
         *
         */
        public function stripTagsFromMessage($message)
        {
            $message = str_replace("<ul>", "", $message);
            $message = str_replace("</ul>", "\n", $message);
            $message = str_replace("<li>", "- ", $message);
            $message = str_replace("</li>", "\n", $message);
            $message = str_replace("<br>", "\n", $message);
            $message = str_replace("<br/>", "\n", $message);
            $message = str_replace("<b>", "", $message);
            $message = str_replace("<b/>", "", $message);
            $message = strip_tags($message);
            return (string)$message;
        }
    }
}
