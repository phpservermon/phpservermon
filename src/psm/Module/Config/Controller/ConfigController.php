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

namespace psm\Module\Config\Controller;
use psm\Module\AbstractController;
use psm\Service\Database;

class ConfigController extends AbstractController {

	/**
	 * Checkboxes
	 * @var array $checkboxes
	 */
	protected $checkboxes = array(
		'proxy',
		'email_status',
		'email_smtp',
		'sms_status',
		'pushover_status',
		'log_status',
		'log_email',
		'log_sms',
		'log_pushover',
		'show_update',
	);

	/**
	 * Fields for saving
	 * @var array $fields
	 */
	protected $fields = array(
		'proxy_url',
		'proxy_user',
		'proxy_password',
		'email_from_name',
		'email_from_email',
		'email_smtp_host',
		'email_smtp_port',
		'email_smtp_username',
		'email_smtp_password',
		'sms_gateway_username',
		'sms_gateway_password',
		'sms_from',
		'pushover_api_token',
	);

	private $default_tab = 'general';

	function __construct(Database $db, \Twig_Environment $twig) {
		parent::__construct($db, $twig);

		$this->setMinUserLevelRequired(PSM_USER_ADMIN);
		$this->setCSRFKey('config');

		$this->setActions(array(
			'index', 'save',
		), 'index');
	}

	/**
	 * Populate all the config fields with values from the database
	 *
	 * @return string
	 */
	protected function executeIndex() {
		$this->twig->addGlobal('subtitle', psm_get_lang('menu', 'config'));
		$tpl_data = $this->getLabels();

		$config_db = $this->db->select(
			PSM_DB_PREFIX . 'config',
			null,
			array('key', 'value')
		);

		$config = array();
		foreach($config_db as $entry) {
			$config[$entry['key']] = $entry['value'];
		}

		// generate language array
		$lang_keys = psm_get_langs();
		$tpl_data['language_current'] = (isset($config['language']))
				? $config['language']
				: 'en_US';
		$tpl_data['languages'] = array();
		foreach($lang_keys as $key => $label) {
			$tpl_data['languages'][] = array(
				'value' => $key,
				'label' => $label,
			);
		}

		// @todo these selected values can easily be rewritten in the template using twig
		$tpl_data['sms_selected_' . $config['sms_gateway']] = 'selected="selected"';
		$tpl_data['alert_type_selected_' . $config['alert_type']] = 'selected="selected"';
		$smtp_sec = isset($config['email_smtp_security']) ? $config['email_smtp_security'] : '';
		$tpl_data['email_smtp_security_selected_' . $smtp_sec] = 'selected="selected"';
		$tpl_data['auto_refresh_servers'] = (isset($config['auto_refresh_servers'])) ? $config['auto_refresh_servers'] : '0';
		$tpl_data['log_retention_period'] = (isset($config['log_retention_period'])) ? $config['log_retention_period'] : '365';
		$tpl_data['password_encrypt_key'] = (isset($config['password_encrypt_key'])) ? $config['password_encrypt_key'] : sha1(microtime());

		foreach($this->checkboxes as $input_key) {
			$tpl_data[$input_key . '_checked'] =
				(isset($config[$input_key]) && (int) $config[$input_key] == 1)
				? 'checked="checked"'
				: '';
		}
		foreach($this->fields as $input_key) {
			$tpl_data[$input_key] = (isset($config[$input_key])) ? $config[$input_key] : '';
		}

		$tpl_data[$this->default_tab . '_active'] = 'active';

		$testmodals = array('email', 'sms', 'pushover');
		foreach($testmodals as $modal_id) {
			$modal = new \psm\Util\Module\Modal($this->twig, 'test' . ucfirst($modal_id), \psm\Util\Module\Modal::MODAL_TYPE_OKCANCEL);
			$this->addModal($modal);
			$modal->setTitle(psm_get_lang('servers', 'send_' . $modal_id));
			$modal->setMessage(psm_get_lang('config', 'test_' . $modal_id));
			$modal->setOKButtonLabel(psm_get_lang('config', 'send'));
		}

		return $this->twig->render('module/config/config.tpl.html', $tpl_data);
	}

	/**
	 * If a post has been done, gather all the posted data
	 * and save it to the database
	 */
	protected function executeSave() {
		if(!empty($_POST)) {
			// save new config
			$clean = array(
				'language' => $_POST['language'],
				'sms_gateway' => $_POST['sms_gateway'],
				'alert_type' => $_POST['alert_type'],
				'email_smtp_security' =>
					in_array($_POST['email_smtp_security'], array('', 'ssl', 'tls'))
					? $_POST['email_smtp_security']
					: '',
				'auto_refresh_servers' => intval(psm_POST('auto_refresh_servers', 0)),
				'log_retention_period' => intval(psm_POST('log_retention_period', 365)),
				'password_encrypt_key' => psm_POST('password_encrypt_key', sha1(microtime())),
			);
			foreach($this->checkboxes as $input_key) {
				$clean[$input_key] = (isset($_POST[$input_key])) ? '1': '0';
			}
			foreach($this->fields as $input_key) {
				if(isset($_POST[$input_key])) {
					$clean[$input_key] = $_POST[$input_key];
				}
			}
			$language_refresh = ($clean['language'] != psm_get_conf('language'));
			foreach($clean as $key => $value) {
				psm_update_conf($key, $value);
			}
			$this->addMessage(psm_get_lang('config', 'updated'), 'success');

			if(!empty($_POST['test_email'])) {
				$this->testEmail();
			} elseif(!empty($_POST['test_sms'])) {
				$this->testSMS();
			} elseif(!empty($_POST['test_pushover'])) {
				$this->testPushover();
			}

			if($language_refresh) {
				header('Location: ' . psm_build_url(array('mod' => 'config'), true, false));
				die();
			}

			if(isset($_POST['general_submit'])) {
				$this->default_tab = 'general';
			} elseif(isset($_POST['email_submit']) || !empty($_POST['test_email'])) {
				$this->default_tab = 'email';
			} elseif(isset($_POST['sms_submit']) || !empty($_POST['test_sms'])) {
				$this->default_tab = 'sms';
			} elseif(isset($_POST['pushover_submit']) || !empty($_POST['test_pushover'])) {
				$this->default_tab = 'pushover';
			}
		}
		return $this->runAction('index');
	}

	/**
	 * Execute email test
	 *
	 * @todo move test to separate class
	 */
	protected function testEmail() {
		$mail = psm_build_mail();
		$message = psm_get_lang('config', 'test_message');
		$mail->Subject	= psm_get_lang('config', 'test_subject');
		$mail->Priority	= 1;
		$mail->Body		= $message;
		$mail->AltBody	= str_replace('<br/>', "\n", $message);
		$user = $this->getUser()->getUser();
		$mail->AddAddress($user->email, $user->name);
		if($mail->Send()) {
			$this->addMessage(psm_get_lang('config', 'email_sent'), 'success');
		} else {
			$this->addMessage(psm_get_lang('config', 'email_error') . ': ' . $mail->ErrorInfo, 'error');
		}
	}

	/**
	 * Execute SMS test
	 *
	 * @todo move test to separate class
	 */
	protected function testSMS() {
		$sms = psm_build_sms();
		if($sms) {
			$user = $this->getUser()->getUser();
			if(empty($user->mobile)) {
				$this->addMessage(psm_get_lang('config', 'sms_error_nomobile'), 'error');
			} else {
				$sms->addRecipients($user->mobile);
				if($sms->sendSMS(psm_get_lang('config', 'test_message'))) {
					$this->addMessage(psm_get_lang('config', 'sms_sent'), 'success');
				} else {
					$this->addMessage(psm_get_lang('config', 'sms_error'), 'error');
				}
			}
		}
	}

	/**
	 * Execute pushover test
	 *
	 * @todo move test to separate class
	 */
	protected function testPushover() {
		$pushover = psm_build_pushover();
		$pushover->setDebug(true);
		$user = $this->getUser()->getUser();
		$api_token = psm_get_conf('pushover_api_token');

		if(empty($api_token)) {
			$this->addMessage(psm_get_lang('config', 'pushover_error_noapp'), 'error');
		} elseif(empty($user->pushover_key)) {
			$this->addMessage(psm_get_lang('config', 'pushover_error_nokey'), 'error');
		} else {
			$pushover->setPriority(0);
			$pushover->setTitle(psm_get_lang('config', 'test_subject'));
			$pushover->setMessage(psm_get_lang('config', 'test_message'));
			$pushover->setUser($user->pushover_key);
			if($user->pushover_device != '') {
				$pushover->setDevice($user->pushover_device);
			}
			$result = $pushover->send();

			if(isset($result['output']->status) && $result['output']->status == 1) {
				$this->addMessage(psm_get_lang('config', 'pushover_sent'), 'success');
			} else {
				if(isset($result['output']->errors->error)) {
					$error = $result['output']->errors->error;
				} else {
					$error = 'Unknown';
				}
				$this->addMessage(sprintf(psm_get_lang('config', 'pushover_error'), $error), 'error');
			}
		}
	}

	protected function getLabels() {
		return array(
			'label_tab_email' => psm_get_lang('config', 'tab_email'),
			'label_tab_sms' => psm_get_lang('config', 'tab_sms'),
			'label_tab_pushover' => psm_get_lang('config', 'tab_pushover'),
			'label_settings_email' => psm_get_lang('config', 'settings_email'),
			'label_settings_sms' => psm_get_lang('config', 'settings_sms'),
			'label_settings_pushover' => psm_get_lang('config', 'settings_pushover'),
			'label_settings_notification' => psm_get_lang('config', 'settings_notification'),
			'label_settings_log' => psm_get_lang('config', 'settings_log'),
			'label_settings_proxy' => psm_get_lang('config', 'settings_proxy'),
			'label_general' => psm_get_lang('config', 'general'),
			'label_language' => psm_get_lang('config', 'language'),
			'label_show_update' => psm_get_lang('config', 'show_update'),
			'label_password_encrypt_key' => psm_get_lang('config', 'password_encrypt_key'),
			'label_password_encrypt_key_note' => psm_get_lang('config', 'password_encrypt_key_note'),
			'label_proxy' => psm_get_lang('config', 'proxy'),
			'label_proxy_url' => psm_get_lang('config', 'proxy_url'),
			'label_proxy_user' => psm_get_lang('config', 'proxy_user'),
			'label_proxy_password' => psm_get_lang('config', 'proxy_password'),
			'label_email_status' => psm_get_lang('config', 'email_status'),
			'label_email_from_email' => psm_get_lang('config', 'email_from_email'),
			'label_email_from_name' => psm_get_lang('config', 'email_from_name'),
			'label_email_smtp' => psm_get_lang('config', 'email_smtp'),
			'label_email_smtp_host' => psm_get_lang('config', 'email_smtp_host'),
			'label_email_smtp_port' => psm_get_lang('config', 'email_smtp_port'),
			'label_email_smtp_security' => psm_get_lang('config', 'email_smtp_security'),
			'label_email_smtp_security_none' => psm_get_lang('config', 'email_smtp_security_none'),
			'label_email_smtp_username' => psm_get_lang('config', 'email_smtp_username'),
			'label_email_smtp_password' => psm_get_lang('config', 'email_smtp_password'),
			'label_email_smtp_noauth' => psm_get_lang('config', 'email_smtp_noauth'),
			'label_sms_status' => psm_get_lang('config', 'sms_status'),
			'label_sms_gateway' => psm_get_lang('config', 'sms_gateway'),
			'label_sms_gateway_mosms' => psm_get_lang('config', 'sms_gateway_mosms'),
			'label_sms_gateway_mollie' => psm_get_lang('config', 'sms_gateway_mollie'),
			'label_sms_gateway_spryng' => psm_get_lang('config', 'sms_gateway_spryng'),
			'label_sms_gateway_inetworx' => psm_get_lang('config', 'sms_gateway_inetworx'),
			'label_sms_gateway_clickatell' => psm_get_lang('config', 'sms_gateway_clickatell'),
			'label_sms_gateway_textmarketer' => psm_get_lang('config', 'sms_gateway_textmarketer'),
			'label_sms_gateway_smsit' => psm_get_lang('config', 'sms_gateway_smsit'),
			'label_sms_gateway_freevoipdeal' => psm_get_lang('config', 'sms_gateway_freevoipdeal'),
			'label_sms_gateway_smsglobal' => psm_get_lang('config', 'sms_gateway_smsglobal'),
			'label_sms_gateway_nexmo' => psm_get_lang('config', 'sms_gateway_nexmo'),
			'label_sms_gateway_smsgw' => psm_get_lang('config', 'sms_gateway_smsgw'),
			'label_sms_gateway_octopush' => psm_get_lang('config', 'sms_gateway_octopush'),
			'label_sms_gateway_freemobilesms' => psm_get_lang('config', 'sms_gateway_freemobilesms'),
			'label_sms_gateway_clicksend' => psm_get_lang('config', 'sms_gateway_clicksend'),
			'label_sms_gateway_username' => psm_get_lang('config', 'sms_gateway_username'),
			'label_sms_gateway_password' => psm_get_lang('config', 'sms_gateway_password'),
			'label_sms_from' => psm_get_lang('config', 'sms_from'),
			'label_pushover_description' => psm_get_lang('config', 'pushover_description'),
			'label_pushover_status' => psm_get_lang('config', 'pushover_status'),
			'label_pushover_clone_app' => psm_get_lang('config', 'pushover_clone_app'),
			'pushover_clone_url' => PSM_PUSHOVER_CLONE_URL,
			'label_pushover_api_token' => psm_get_lang('config', 'pushover_api_token'),
			'label_pushover_api_token_description' => sprintf(
				psm_get_lang('config', 'pushover_api_token_description'),
				PSM_PUSHOVER_CLONE_URL
			),
			'label_alert_type' => psm_get_lang('config', 'alert_type'),
			'label_alert_type_description' => psm_get_lang('config', 'alert_type_description'),
			'label_alert_type_status' => psm_get_lang('config', 'alert_type_status'),
			'label_alert_type_offline' => psm_get_lang('config', 'alert_type_offline'),
			'label_alert_type_always' => psm_get_lang('config', 'alert_type_always'),
			'label_log_status' => psm_get_lang('config', 'log_status'),
			'label_log_status_description' => psm_get_lang('config', 'log_status_description'),
			'label_log_email' => psm_get_lang('config', 'log_email'),
			'label_log_sms' => psm_get_lang('config', 'log_sms'),
			'label_log_pushover' => psm_get_lang('config', 'log_pushover'),
			'label_alert_proxy' => psm_get_lang('config', 'alert_proxy'),
			'label_alert_proxy_url' => psm_get_lang('config', 'alert_proxy_url'),
			'label_auto_refresh' => psm_get_lang('config', 'auto_refresh'),
			'label_auto_refresh_servers' => psm_get_lang('config', 'auto_refresh_servers'),
			'label_seconds' => psm_get_lang('config', 'seconds'),
			'label_save' => psm_get_lang('system', 'save'),
			'label_test' => psm_get_lang('config', 'test'),
			'label_log_retention_period' => psm_get_lang('config', 'log_retention_period'),
			'label_log_retention_period_description' => psm_get_lang('config', 'log_retention_period_description'),
			'label_log_retention_days' => psm_get_lang('config', 'log_retention_days'),
		);
	}
}