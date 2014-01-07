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
 * User module. Add, edit and delete users, or assign
 * servers to users.
 */
class modUsers extends modCore {
	public $servers;

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

		$this->servers = $this->db->select(SM_DB_PREFIX.'servers', null, array('server_id', 'label'));
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
	 * Prepare the template to show the update screen for a user
	 */
	protected function createHTMLUpdate() {
		$this->setTemplateId('users_update', 'users.tpl.html');

		$user_id = $_GET['edit'];

		$tpl_data = array();
		$servers_count = count($this->servers);

		switch((int) $user_id) {
			case 0:
				// insert mode
				$tpl_data['titlemode'] = sm_get_lang('system', 'insert');
				$tpl_data['edit_user_id'] = '0';

				// add inactive class to all servers
				for ($i = 0; $i < $servers_count; $i++) {
					$this->servers[$i]['class'] = 'inactive';
				}

				break;
			default:
				// edit mode

				// get user entry
				$edit_user = $this->db->selectRow(
					SM_DB_PREFIX.'users',
					array('user_id' => $user_id)
				);
				if (empty($edit_user)) {
					$this->message = 'Invalid user id';
					return $this->createHTMLList();
				}

				$tpl_data = array_merge($tpl_data, array(
					'titlemode' => sm_get_lang('system', 'edit') . ' ' . $edit_user['name'],
					'edit_user_id' => $edit_user['user_id'],
					'edit_value_name' => $edit_user['name'],
					'edit_value_mobile' => $edit_user['mobile'],
					'edit_value_email' => $edit_user['email'],
				));

				// select servers for this user
				$user_servers = explode(',', $edit_user['server_id']);

				for ($h = 0; $h < $servers_count; $h++) {
					if(in_array($this->servers[$h]['server_id'], $user_servers)) {
						$this->servers[$h]['edit_checked'] = 'checked="checked"';
						$this->servers[$h]['class'] = 'active';
					}
				}

				break;
		}

		$this->tpl->addTemplateData(
			$this->getTemplateId(),
			$tpl_data
		);
		// add servers to template for the edit form
		$this->tpl->addTemplateDataRepeat('users_update', 'servers', $this->servers);
	}

	/**
	 * Prepare the template to show a list of all users
	 */
	protected function createHTMLList() {
		$this->setTemplateId('users_list', 'users.tpl.html');

		// build label array for the next loop
		$servers_labels = array();
		foreach ($this->servers as $server) {
			$servers_labels[$server['server_id']] = $server['label'];
		}

		// get users from database
		$users = $this->db->select(
			SM_DB_PREFIX.'users',
			null,
			null,
			null,
			array('name')
		);

		$user_count = count($users);

		for ($x = 0; $x < $user_count; $x++) {
			$users[$x]['class'] = ($x & 1) ? 'odd' : 'even';

			$users[$x]['emp_servers'] = '';

			// fix server list
			$user_servers = explode(',', $users[$x]['server_id']);
			if (empty($user_servers)) continue;

			foreach ($user_servers as $server) {
				if (!isset($servers_labels[$server])) continue;
				$users[$x]['emp_servers'] .= $servers_labels[$server] . '<br/>';
			}
			$users[$x]['emp_servers'] = substr($users[$x]['emp_servers'], 0, -5);
		}
		// add servers to template
		$this->tpl->addTemplateDataRepeat($this->getTemplateId(), 'users', $users);

	}

	/**
	 * Executes the saving of a user
	 */
	protected function executeSave() {
		// check for add/edit mode

		if (isset($_POST['name']) && isset($_POST['mobile']) && isset($_POST['email'])) {
			$clean = array(
				'name' => $_POST['name'],
				'mobile' => $_POST['mobile'],
				'email' => $_POST['email'],
				'server_id' => (isset($_POST['server_id'])) ? implode(',', $_POST['server_id']) : ''
			);

			// check for edit or add
			if ((int) $_POST['user_id'] > 0) {
				// edit
				$this->db->save(
					SM_DB_PREFIX.'users',
					$clean,
					array('user_id' => $_POST['user_id'])
				);
				$this->message = sm_get_lang('users', 'updated');
			} else {
				// add
				$this->db->save(SM_DB_PREFIX.'users', $clean);
				$this->message = sm_get_lang('users', 'inserted');
			}
		}
	}

	/**
	 * Executes the deletion of a user
	 */
	protected function executeDelete() {
		// do delete
		$this->db->delete(
			SM_DB_PREFIX . 'users',
			array(
				'user_id' => $_GET['delete']
			)
		);
		$this->message = sm_get_lang('system', 'deleted');
	}

	// override parent::createHTMLLabels()
	protected function createHTMLLabels() {
		$this->tpl->addTemplateData(
			$this->getTemplateId(),
			array(
				'label_users' => sm_get_lang('system', 'users'),
				'label_name' => sm_get_lang('users', 'name'),
				'label_mobile' => sm_get_lang('users', 'mobile'),
				'label_email' => sm_get_lang('users', 'email'),
				'label_servers' => sm_get_lang('system', 'servers'),
				'label_action' => sm_get_lang('system', 'action'),
				'label_save' => sm_get_lang('system', 'save'),
				'label_edit' => sm_get_lang('system', 'edit') . ' ' . sm_get_lang('users', 'user'),
				'label_delete' => sm_get_lang('system', 'delete') . ' ' . sm_get_lang('users', 'user'),
				'label_add_new' => sm_get_lang('system', 'add_new'),
			)
		);

		return parent::createHTMLLabels();
	}
}

?>