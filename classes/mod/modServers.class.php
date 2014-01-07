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
 * Server module. Add/edit/delete servers, show a list of all servers etc.
 */
class modServers extends modCore {

	function __construct() {
		parent::__construct();

		// check mode
		if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
			// edit mode or insert mode
			$this->mode = 'update';
		} else {
			$this->mode = 'list';

			if(!empty($_POST)) {
				$this->executeSave();
			}
			if(isset($_GET['delete']) && is_numeric($_GET['delete'])) {
				$this->executeDelete();
			}
		}
	}

	// override parent::createHTML()
	public function createHTML() {
		switch($this->mode) {
			case 'list':
				$this->createHTMLList();
				break;
			case 'update':
				$this->createHTMLUpdate();
				break;
		}

		return parent::createHTML();
	}

	/**
	 * Prepare the template to show the update screen for a single server
	 */
	protected function createHTMLUpdate() {
		$this->setTemplateId('servers_update', 'servers.tpl.html');

		$server_id = $_GET['edit'];

		$tpl_data = array();

		switch(intval($server_id)) {
			case 0:
				// insert mode
				$tpl_data['titlemode'] = sm_get_lang('system', 'insert');
				$tpl_data['edit_server_id'] = '0';
				break;
			default:
				// edit mode

				// get server entry
				$edit_server = $this->db->selectRow(
					SM_DB_PREFIX.'servers',
					array('server_id' => $server_id)
				);
				if (empty($edit_server)) {
					$this->message = 'Invalid server id';
					return $this->createHTMLList();
				}

				$tpl_data = array_merge($tpl_data, array(
					'titlemode' => sm_get_lang('system', 'edit') . ' ' . $edit_server['label'],
					'edit_server_id' => $edit_server['server_id'],
					'edit_value_label' => $edit_server['label'],
					'edit_value_ip' => $edit_server['ip'],
					'edit_value_port' => $edit_server['port'],
					'edit_type_selected_' . $edit_server['type'] => 'selected="selected"',
					'edit_active_selected_' . $edit_server['active'] => 'selected="selected"',
					'edit_email_selected_' . $edit_server['email'] => 'selected="selected"',
					'edit_sms_selected_' . $edit_server['sms'] => 'selected="selected"',
				));

				break;
		}

		$this->tpl->addTemplateData(
			$this->getTemplateId(),
			$tpl_data
		);
	}

	/**
	 * Prepare the template to show a list of all servers
	 */
	protected function createHTMLList() {
		$this->setTemplateId('servers_list', 'servers.tpl.html');

		// get servers from database
		$servers = $this->db->query(
			'SELECT '.
				'`server_id`, '.
				'`ip`, '.
				'`port`, '.
				'`type`, '.
				'`label`, '.
				'`status`, '.
				'`error`, '.
				'`rtime`, '.
				'IF('.
					'`last_check`=\'0000-00-00 00:00:00\', '.
					'\'never\', '.
					'DATE_FORMAT(`last_check`, \'%d-%m-%y %H:%i\') '.
				') AS `last_check`, '.
				'IF('.
					'`last_online`=\'0000-00-00 00:00:00\', '.
					'\'never\', '.
					'DATE_FORMAT(`last_online`, \'%d-%m-%y %H:%i\') '.
				') AS `last_online`, '.
				'`active`, '.
				'`email`, '.
				'`sms` '.
			'FROM `'.SM_DB_PREFIX.'servers` '.
			'ORDER BY `active` ASC, `status` DESC, `type` ASC, `label` ASC'
		);

		$server_count = count($servers);

		for ($x = 0; $x < $server_count; $x++) {
			$servers[$x]['class'] = ($x & 1) ? 'odd' : 'even';
			$servers[$x]['rtime'] = round((float) $servers[$x]['rtime'], 4);

			if($servers[$x]['type'] == 'website') {
				// add link to label
				$servers[$x]['ip'] = '<a href="'.$servers[$x]['ip'].'" target="_blank">'.$servers[$x]['ip'].'</a>';
			}
		}
		// add servers to template
		$this->tpl->addTemplateDataRepeat($this->getTemplateId(), 'servers', $servers);

		// check if we need to add the auto refresh
		$auto_refresh = sm_get_conf('auto_refresh_servers');
		if(intval($auto_refresh) > 0) {
			// add it
			$this->tpl->newTemplate('main_auto_refresh', 'main.tpl.html');
			$this->tpl->addTemplateData('main_auto_refresh', array('seconds' => $auto_refresh));
			$this->tpl->addTemplateData('main', array('auto_refresh' => $this->tpl->getTemplate('main_auto_refresh')));
		}

	}

	/**
	 * Executes the saving of one of the servers
	 */
	protected function executeSave() {
		// check for add/edit mode
		if (isset($_POST['label']) && isset($_POST['ip']) && isset($_POST['port'])) {
			$clean = array(
				'label' => $_POST['label'],
				'ip' => $_POST['ip'],
				'port' => $_POST['port'],
				'type' => $_POST['type'],
				'active' => $_POST['active'],
				'email' => $_POST['email'],
				'sms' => $_POST['sms'],
			);

			// check for edit or add
			if ((int) $_POST['server_id'] > 0) {
				// edit
				$this->db->save(
					SM_DB_PREFIX.'servers',
					$clean,
					array('server_id' => $_POST['server_id'])
				);
				$this->message = sm_get_lang('servers', 'updated');
			} else {
				// add
				$clean['status'] = 'on';
				$this->db->save(SM_DB_PREFIX.'servers', $clean);
				$this->message = sm_get_lang('servers', 'inserted');
			}
		}
	}

	/**
	 * Executes the deletion of one of the servers
	 */
	protected function executeDelete() {
		// do delete
		$this->db->delete(
			SM_DB_PREFIX . 'servers',
			array(
				'server_id' => $_GET['delete']
			)
		);
		$this->message = sm_get_lang('system', 'deleted');
	}

	// override parent::createHTMLLabels()
	protected function createHTMLLabels() {
		$this->tpl->addTemplateData(
			$this->getTemplateId(),
			array(
				'label_label' => sm_get_lang('servers', 'label'),
				'label_domain' => sm_get_lang('servers', 'domain'),
				'label_port' => sm_get_lang('servers', 'port'),
				'label_type' => sm_get_lang('servers', 'type'),
				'label_last_check' => sm_get_lang('servers', 'last_check'),
				'label_rtime' => sm_get_lang('servers', 'rtime'),
				'label_last_online' => sm_get_lang('servers', 'last_online'),
				'label_monitoring' => sm_get_lang('servers', 'monitoring'),
				'label_send_email' => sm_get_lang('servers', 'send_email'),
				'label_send_sms' => sm_get_lang('servers', 'send_sms'),
				'label_action' => sm_get_lang('system', 'action'),
				'label_save' => sm_get_lang('system', 'save'),
				'label_edit' => sm_get_lang('system', 'edit') . ' ' . sm_get_lang('servers', 'server'),
				'label_delete' => sm_get_lang('system', 'delete') . ' ' . sm_get_lang('servers', 'server'),
				'label_yes' => sm_get_lang('system', 'yes'),
				'label_no' => sm_get_lang('system', 'no'),
				'label_add_new' => sm_get_lang('system', 'add_new'),
			)
		);

		return parent::createHTMLLabels();
	}
}

?>