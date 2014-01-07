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

class modConfig extends modCore {

	function __construct() {
		parent::__construct();

		if(!empty($_POST)) {
			$this->executeSave();
		}
	}

	// override parent::createHTML()
	public function createHTML() {
		$this->setTemplateId('config', 'config.tpl.html');

		$this->populateFields();

		return parent::createHTML();
	}

	/**
	 * Populate all the config fields with values from the database
	 */
	public function populateFields() {
		$config_db = $this->db->select(
			SM_DB_PREFIX . 'config',
			null,
			array('key', 'value')
		);

		$config = array();
		foreach($config_db as $entry) {
			$config[$entry['key']] = $entry['value'];
		}

		$this->tpl->addTemplateData(
			$this->getTemplateId(),
			array(
				'language_selected_' . $config['language'] => 'selected="selected"',
				'email_status_checked' => ($config['email_status'] == '1') ? 'checked="checked"' : '',
				'email_from_name' => $config['email_from_name'],
				'email_from_email' => $config['email_from_email'],
				'sms_status_checked' => ($config['sms_status'] == '1') ? 'checked="checked"' : '',
				'sms_selected_' . $config['sms_gateway'] => 'selected="selected"',
				'sms_gateway_username' => $config['sms_gateway_username'],
				'sms_gateway_password' => $config['sms_gateway_password'],
				'sms_from' => $config['sms_from'],
				'alert_type_selected_' . $config['alert_type'] => 'selected="selected"',
				'log_status_checked' => ($config['log_status'] == '1') ? 'checked="checked"' : '',
				'log_email_checked' => ($config['log_email'] == '1') ? 'checked="checked"' : '',
				'log_sms_checked' => ($config['log_sms'] == '1') ? 'checked="checked"' : '',
				'show_update_checked' => ($config['show_update'] == '1') ? 'checked="checked"' : '',
				'auto_refresh_servers' => (isset($config['auto_refresh_servers'])) ? $config['auto_refresh_servers'] : '0',
			)
		);
	}

	/**
	 * If a post has been done, gather all the posted data
	 * and save it to the database
	 */
	protected function executeSave() {
		// save new config
		$clean = array(
			'language' => $_POST['language'],
			'show_update' => (isset($_POST['show_update'])) ? '1' : '0',
			'email_status' => (isset($_POST['email_status'])) ? '1' : '0',
			'email_from_name' => $_POST['email_from_name'],
			'email_from_email' => $_POST['email_from_email'],
			'sms_status' => (isset($_POST['sms_status'])) ? '1' : '0',
			'sms_gateway' => $_POST['sms_gateway'],
			'sms_gateway_username' => $_POST['sms_gateway_username'],
			'sms_gateway_password' => $_POST['sms_gateway_password'],
			'sms_from' => $_POST['sms_from'],
			'alert_type' => $_POST['alert_type'],
			'log_status' => (isset($_POST['log_status'])) ? '1' : '0',
			'log_email' => (isset($_POST['log_email'])) ? '1' : '0',
			'log_sms' => (isset($_POST['log_sms'])) ? '1' : '0',
			'auto_refresh_servers' => (isset($_POST['auto_refresh_servers'])) ? intval($_POST['auto_refresh_servers']) : '0',
		);

		// save all values to the database
		foreach($clean as $key => $value) {
			// check if key already exists, otherwise add it
			if(sm_get_conf($key) === null) {
				// not yet set, add it
				$this->db->save(
					SM_DB_PREFIX . 'config',
					array(
						'key' => $key,
						'value' => $value,
					)
				);
			} else {
				// update
				$this->db->save(
					SM_DB_PREFIX . 'config',
					array('value' => $value),
					array('key' => $key)
				);
			}
		}

		$this->message = sm_get_lang('config', 'updated');
	}

	// override parent::createHTMLLabels()
	protected function createHTMLLabels() {
		$this->tpl->addTemplateData(
			$this->getTemplateId(),
			array(
				'label_settings_email' => sm_get_lang('config', 'settings_email'),
				'label_settings_sms' => sm_get_lang('config', 'settings_sms'),
				'label_settings_notification' => sm_get_lang('config', 'settings_notification'),
				'label_settings_log' => sm_get_lang('config', 'settings_log'),
				'label_general' => sm_get_lang('config', 'general'),
				'label_language' => sm_get_lang('config', 'language'),
				'label_language_english' => sm_get_lang('config', 'english'),
				'label_language_dutch' => sm_get_lang('config', 'dutch'),
				'label_language_french' => sm_get_lang('config', 'french'),
				'label_language_german' => sm_get_lang('config', 'german'),
				'label_show_update' => sm_get_lang('config', 'show_update'),
				'label_email_status' => sm_get_lang('config', 'email_status'),
				'label_email_from_email' => sm_get_lang('config', 'email_from_email'),
				'label_email_from_name' => sm_get_lang('config', 'email_from_name'),
				'label_sms_status' => sm_get_lang('config', 'sms_status'),
				'label_sms_gateway' => sm_get_lang('config', 'sms_gateway'),
				'label_sms_gateway_mollie' => sm_get_lang('config', 'sms_gateway_mollie'),
				'label_sms_gateway_spryng' => sm_get_lang('config', 'sms_gateway_spryng'),
				'label_sms_gateway_inetworx' => sm_get_lang('config', 'sms_gateway_inetworx'),
				'label_sms_gateway_clickatell' => sm_get_lang('config', 'sms_gateway_clickatell'),
				'label_sms_gateway_username' => sm_get_lang('config', 'sms_gateway_username'),
				'label_sms_gateway_password' => sm_get_lang('config', 'sms_gateway_password'),
				'label_sms_from' => sm_get_lang('config', 'sms_from'),
				'label_alert_type' => sm_get_lang('config', 'alert_type'),
				'label_alert_type_status' => sm_get_lang('config', 'alert_type_status'),
				'label_alert_type_offline' => sm_get_lang('config', 'alert_type_offline'),
				'label_alert_type_always' => sm_get_lang('config', 'alert_type_always'),
				'label_log_status' => sm_get_lang('config', 'log_status'),
				'label_log_email' => sm_get_lang('config', 'log_email'),
				'label_log_sms' => sm_get_lang('config', 'log_sms'),
				'label_auto_refresh_servers' => sm_get_lang('config', 'auto_refresh_servers'),
			)
		);

		return parent::createHTMLLabels();
	}
}

?>