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

namespace psm\Module;
use psm\Service\Database;
use psm\Service\Template;

/**
 * User module. Add, edit and delete users, or assign
 * servers to users.
 */
class Users extends AbstractModule {
	public $servers;

	function __construct(Database $db, Template $tpl) {
		parent::__construct($db, $tpl);

		$this->setActions(array(
			'index', 'edit', 'delete', 'save',
		), 'index');

		$this->servers = $this->db->select(PSM_DB_PREFIX.'servers', null, array('server_id', 'label'));
	}

	/**
	 * Prepare the template to show the update screen for a user
	 */
	protected function executeEdit() {
		$this->setTemplateId('users_update', 'users.tpl.html');

		$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

		$tpl_data = array();
		$servers_count = count($this->servers);

		switch((int) $user_id) {
			case 0:
				// insert mode
				$tpl_data['titlemode'] = psm_get_lang('system', 'insert');
				$tpl_data['edit_user_id'] = '0';

				// add inactive class to all servers
				for ($i = 0; $i < $servers_count; $i++) {
					$this->servers[$i]['class'] = 'inactive';
				}

				break;
			default:
				// edit mode
				$edit_user = $this->db->selectRow(
					PSM_DB_PREFIX.'users',
					array('user_id' => $user_id)
				);
				if (empty($edit_user)) {
					$this->addMessage('Invalid user.');
					return $this->initializeAction('index');
				}

				$tpl_data = array_merge($tpl_data, array(
					'titlemode' => psm_get_lang('system', 'edit') . ' ' . $edit_user['name'],
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
	protected function executeIndex() {
		$this->setTemplateId('users_list', 'users.tpl.html');

		// build label array for the next loop
		$servers_labels = array();
		foreach ($this->servers as $server) {
			$servers_labels[$server['server_id']] = $server['label'];
		}

		// get users from database
		$users = $this->db->select(
			PSM_DB_PREFIX.'users',
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
			$id = (isset($_GET['id'])) ? intval($_GET['id']) : 0;

			// check for edit or add
			if ((int) $id > 0) {
				// edit
				$this->db->save(
					PSM_DB_PREFIX.'users',
					$clean,
					array('user_id' => $id)
				);
				$this->addMessage(psm_get_lang('users', 'updated'));
			} else {
				// add
				$this->db->save(PSM_DB_PREFIX.'users', $clean);
				$this->addMessage(psm_get_lang('users', 'inserted'));
			}
		}
		$this->initializeAction('index');
	}

	/**
	 * Executes the deletion of a user
	 */
	protected function executeDelete() {
		$id = (isset($_GET['id'])) ? intval($_GET['id']) : 0;

		if($id > 0) {
			$this->db->delete(
				PSM_DB_PREFIX . 'users',
				array(
					'user_id' => $id,
				)
			);
			$this->addMessage(psm_get_lang('system', 'deleted'));
		}
		$this->initializeAction('index');
	}

	// override parent::createHTMLLabels()
	protected function createHTMLLabels() {
		$this->tpl->addTemplateData(
			$this->getTemplateId(),
			array(
				'label_users' => psm_get_lang('system', 'users'),
				'label_name' => psm_get_lang('users', 'name'),
				'label_mobile' => psm_get_lang('users', 'mobile'),
				'label_email' => psm_get_lang('users', 'email'),
				'label_servers' => psm_get_lang('system', 'servers'),
				'label_action' => psm_get_lang('system', 'action'),
				'label_save' => psm_get_lang('system', 'save'),
				'label_edit' => psm_get_lang('system', 'edit') . ' ' . psm_get_lang('users', 'user'),
				'label_delete' => psm_get_lang('system', 'delete') . ' ' . psm_get_lang('users', 'user'),
				'label_add_new' => psm_get_lang('system', 'add_new'),
			)
		);

		return parent::createHTMLLabels();
	}
}

?>