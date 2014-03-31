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

namespace psm\Module\Config\Controller;
use psm\Module\AbstractController;
use psm\Service\Database;
use psm\Service\Template;

class ConfigController extends AbstractController {

	/**
	 * Checkboxes
	 * @var array $checkboxes
	 */
	protected $checkboxes = array(
		'email_status',
		'email_smtp',
		'sms_status',
		'log_status',
		'log_email',
		'log_sms',
		'show_update',
	);

	/**
	 * Fields for saving
	 * @var array $fields
	 */
	protected $fields = array(
		'email_from_name',
		'email_from_email',
		'email_smtp_host',
		'email_smtp_port',
		'email_smtp_username',
		'email_smtp_password',
		'sms_gateway_username',
		'sms_gateway_password',
		'sms_from',
	);

	function __construct(Database $db, Template $tpl) {
		parent::__construct($db, $tpl);

		$this->setMinUserLevelRequired(PSM_USER_ADMIN);

		$this->setActions(array(
			'index', 'save',
		), 'index');
	}

	/**
	 * Populate all the config fields with values from the database
	 */
	protected function executeIndex() {
		$this->setTemplateId('config', 'config/config.tpl.html');

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
		$languages = array();
		foreach($lang_keys as $key => $label) {
			$languages[] = array(
				'value' => $key,
				'label' => $label,
				'selected' => ($key == $config['language']) ? 'selected="selected"' : '',
			);
		}
		$this->tpl->addTemplateDataRepeat($this->getTemplateId(), 'languages', $languages);

		$tpl_data = array(
			'sms_selected_' . $config['sms_gateway'] => 'selected="selected"',
			'alert_type_selected_' . $config['alert_type'] => 'selected="selected"',
			'auto_refresh_servers' => (isset($config['auto_refresh_servers'])) ? $config['auto_refresh_servers'] : '0',
		);

		foreach($this->checkboxes as $input_key) {
			$tpl_data[$input_key . '_checked'] =
				(isset($config[$input_key]) && (int) $config[$input_key] == 1)
				? 'checked="checked"'
				: '';
		}
		foreach($this->fields as $input_key) {
			$tpl_data[$input_key] = (isset($config[$input_key])) ? $config[$input_key] : '';
		}

		$this->tpl->addTemplateData($this->getTemplateId(), $tpl_data);
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
				'auto_refresh_servers' => (isset($_POST['auto_refresh_servers'])) ? intval($_POST['auto_refresh_servers']) : '0',
			);
			foreach($this->checkboxes as $input_key) {
				$clean[$input_key] = (isset($_POST[$input_key])) ? '1': '0';
			}
			foreach($this->fields as $input_key) {
				if(isset($_POST[$input_key])) {
					$clean[$input_key] = $_POST[$input_key];
				}
			}

			// save all values to the database
			foreach($clean as $key => $value) {
				// check if key already exists, otherwise add it
				if(psm_get_conf($key) === null) {
					// not yet set, add it
					$this->db->save(
						PSM_DB_PREFIX . 'config',
						array(
							'key' => $key,
							'value' => $value,
						)
					);
				} else {
					// update
					$this->db->save(
						PSM_DB_PREFIX . 'config',
						array('value' => $value),
						array('key' => $key)
					);
				}
			}

			$this->addMessage(psm_get_lang('config', 'updated'), 'success');

			if($clean['language'] != psm_get_conf('language')) {
				header('Location: ' . $_SERVER['REQUEST_URI']);
				die();
			}
		}
		$this->initializeAction('index');
	}

	// override parent::createHTMLLabels()
	protected function createHTMLLabels() {
		$this->tpl->addTemplateData(
			$this->getTemplateId(),
			array(
				'subtitle' => psm_get_lang('menu', 'config'),
				'label_settings_email' => psm_get_lang('config', 'settings_email'),
				'label_settings_sms' => psm_get_lang('config', 'settings_sms'),
				'label_settings_notification' => psm_get_lang('config', 'settings_notification'),
				'label_settings_log' => psm_get_lang('config', 'settings_log'),
				'label_general' => psm_get_lang('config', 'general'),
				'label_language' => psm_get_lang('config', 'language'),
				'label_show_update' => psm_get_lang('config', 'show_update'),
				'label_email_status' => psm_get_lang('config', 'email_status'),
				'label_email_from_email' => psm_get_lang('config', 'email_from_email'),
				'label_email_from_name' => psm_get_lang('config', 'email_from_name'),
				'label_email_smtp' => psm_get_lang('config', 'email_smtp'),
				'label_email_smtp_host' => psm_get_lang('config', 'email_smtp_host'),
				'label_email_smtp_port' => psm_get_lang('config', 'email_smtp_port'),
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
				'label_sms_gateway_username' => psm_get_lang('config', 'sms_gateway_username'),
				'label_sms_gateway_password' => psm_get_lang('config', 'sms_gateway_password'),
				'label_sms_from' => psm_get_lang('config', 'sms_from'),
				'label_alert_type' => psm_get_lang('config', 'alert_type'),
				'label_alert_type_description' => psm_get_lang('config', 'alert_type_description'),
				'label_alert_type_status' => psm_get_lang('config', 'alert_type_status'),
				'label_alert_type_offline' => psm_get_lang('config', 'alert_type_offline'),
				'label_alert_type_always' => psm_get_lang('config', 'alert_type_always'),
				'label_log_status' => psm_get_lang('config', 'log_status'),
				'label_log_email' => psm_get_lang('config', 'log_email'),
				'label_log_sms' => psm_get_lang('config', 'log_sms'),
				'label_auto_refresh_servers' => psm_get_lang('config', 'auto_refresh_servers'),
				'label_save' => psm_get_lang('system', 'save'),
			)
		);

		return parent::createHTMLLabels();
	}
}
