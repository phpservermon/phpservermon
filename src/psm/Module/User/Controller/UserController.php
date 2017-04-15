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

namespace psm\Module\User\Controller;
use psm\Module\AbstractController;
use psm\Service\Database;

/**
 * User module. Add, edit and delete users, or assign
 * servers to users.
 */
class UserController extends AbstractController {
	public $servers;

	function __construct(Database $db, \Twig_Environment $twig) {
		parent::__construct($db, $twig);

		$this->setMinUserLevelRequired(PSM_USER_ADMIN);
		$this->setCSRFKey('user');

		$this->setActions(array(
			'index', 'edit', 'delete', 'save',
		), 'index');
		$this->twig->addGlobal('subtitle', psm_get_lang('menu', 'user'));
	}

	public function run() {
		$servers = $this->db->select(PSM_DB_PREFIX.'servers', null, array('server_id', 'label'), '', "ORDER BY `active` ASC, `status` DESC, `label` ASC");
		// change the indexes to reflect their server ids
		foreach($servers as $server) {
			$this->servers[$server['server_id']] = $server;
		}

		return parent::run();
	}

	/**
	 * Create HTML to show a list of all users
	 *
	 * @return string
	 */
	protected function executeIndex() {
		$sidebar = new \psm\Util\Module\Sidebar($this->twig);
		$this->setSidebar($sidebar);

		$sidebar->addButton(
			'add_new',
			psm_get_lang('system', 'add_new'),
			psm_build_url(array('mod' => 'user', 'action' => 'edit')),
			'plus icon-white', 'success'
		);

		$modal = new \psm\Util\Module\Modal($this->twig, 'delete', \psm\Util\Module\Modal::MODAL_TYPE_DANGER);
		$this->addModal($modal);
		$modal->setTitle(psm_get_lang('users', 'delete_title'));
		$modal->setMessage(psm_get_lang('users', 'delete_message'));
		$modal->setOKButtonLabel(psm_get_lang('system', 'delete'));

		// build label array for the next loop
		$servers_labels = array();
		foreach ($this->servers as $server) {
			$servers_labels[$server['server_id']] = $server['label'];
		}

		$users = $this->db->select(
			PSM_DB_PREFIX.'users',
			null,
			array('user_id', 'user_name', 'level', 'name', 'mobile', 'pushover_key', 'pushover_device', 'email'),
			null,
			array('name')
		);

		foreach($users as $x => &$user) {
			$user_servers = $this->getUserServers($user['user_id']);
			$user['class'] = ($x & 1) ? 'odd' : 'even';
			$user['level_text'] = psm_get_lang('users', 'level_' . $user['level']);

			$user['emp_servers'] = array();

			// fix server list
			foreach($user_servers as $server_id) {
				if (!isset($servers_labels[$server_id])) continue;
				$user['emp_servers'][] = array(
					'label' => $servers_labels[$server_id]
				);
			}

			$user['url_delete'] = psm_build_url(array(
				'mod' => 'user',
				'action' => 'delete',
				'id' => $user['user_id'],
			));
			$user['url_edit'] = psm_build_url(array(
				'mod' => 'user',
				'action' => 'edit',
				'id' => $user['user_id'],
			));
		}
		$tpl_data = $this->getLabels();
		$tpl_data['users'] = $users;

		return $this->twig->render('module/user/user/list.tpl.html', $tpl_data);
	}

	/**
	 * Crate HTML for the update screen for a user
	 *
	 * @return string
	 */
	protected function executeEdit() {
		$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		$fields_prefill = array('name', 'user_name', 'mobile', 'pushover_key', 'pushover_device', 'email');

		if($user_id == 0) {
			// insert mode
			$title = psm_get_lang('system', 'insert');
			$placeholder_password = '';
			$lvl_selected = PSM_USER_USER; // default level is regular user

			// attempt to prefill previously posted fields
			$edit_user = new \stdClass();
			foreach($fields_prefill as $field) {
				$edit_user->$field = (isset($_POST[$field])) ? $_POST[$field] : '';
			}

			// add inactive class to all servers
			foreach($this->servers as &$server) {
				$server['class'] = 'inactive';
			}
		} else {
			// edit mode
			try {
				$this->container->get('util.user.validator')->userId($user_id);
			} catch(\InvalidArgumentException $e) {
				$this->addMessage(psm_get_lang('users', 'error_' . $e->getMessage()), 'error');
				return $this->executeIndex();
			}
			$edit_user = $this->getUser()->getUser($user_id);
			$title = psm_get_lang('system', 'edit') . ' ' . $edit_user->name;
			$placeholder_password = psm_get_lang('users', 'password_leave_blank');
			$lvl_selected = $edit_user->level;

			// select servers for this user
			$user_servers = $this->getUserServers($user_id);

			foreach($this->servers as &$server) {
				if(in_array($server['server_id'], $user_servers)) {
					$server['edit_selected'] = 'selected="selected"';
					$server['class'] = 'active';
				}
			}
		}
		$tpl_data = array(
			'titlemode' => $title,
			'placeholder_password' => $placeholder_password,
			'edit_user_id' => $user_id,
			'url_save' => psm_build_url(array(
				'mod' => 'user',
				'action' => 'save',
				'id' => $user_id,
			)),
			'servers' => $this->servers,
			'user_level' => $lvl_selected,
		);
		foreach($fields_prefill as $field) {
			if(isset($edit_user->$field)) {
				$tpl_data['edit_value_' . $field] = $edit_user->$field;
			}
		}

		$tpl_data['levels'] = array();
		foreach($this->container->get('util.user.validator')->getUserLevels() as $lvl) {
			$tpl_data['levels'][] = array(
				'value' => $lvl,
				'label' => psm_get_lang('users', 'level_' . $lvl),
			);
		}

		$tpl_data = array_merge($this->getLabels(), $tpl_data);

		return $this->twig->render('module/user/user/update.tpl.html', $tpl_data);
	}

	/**
	 * Executes the saving of a user
	 */
	protected function executeSave() {
		if(empty($_POST)) {
			// dont process anything if no data has been posted
			return $this->executeIndex();
		}
		$user_id = (isset($_GET['id'])) ? intval($_GET['id']) : 0;

		$fields = array('name', 'user_name', 'password', 'password_repeat', 'level', 'mobile', 'pushover_key', 'pushover_device', 'email');
		$clean = array();
		foreach($fields as $field) {
			if(isset($_POST[$field])) {
				$clean[$field] = trim(strip_tags($_POST[$field]));
			} else {
				$clean[$field] = '';
			}
		}

		$user_validator = $this->container->get('util.user.validator');

		try {
			$user_validator->username($clean['user_name'], $user_id);
			$user_validator->email($clean['email']);
			$user_validator->level($clean['level']);

			// always validate password for new users,
			// but only validate it for existing users when they change it.
			if($user_id == 0 || ($user_id > 0 && $clean['password'] != '')) {
				$user_validator->password($clean['password'], $clean['password_repeat']);
			}
			if($user_id > 0) {
				$user_validator->userId($user_id);
			}
		} catch(\InvalidArgumentException $e) {
			$this->addMessage(psm_get_lang('users', 'error_' . $e->getMessage()), 'error');
			return $this->executeEdit();
		}
		if(!empty($clean['password'])) {
			$password = $clean['password'];
		}
		unset($clean['password_repeat']);

		if($user_id > 0) {
			// edit user
			unset($clean['password']); // password update is executed separately
			$this->db->save(PSM_DB_PREFIX.'users', $clean, array('user_id' => $user_id));
			$this->addMessage(psm_get_lang('users', 'updated'), 'success');

			$event = \psm\Module\User\UserEvents::USER_EDIT;
		} else {
			// add user
			$clean['password'] = ''; // password update is executed separately
			$user_id = $this->db->save(PSM_DB_PREFIX.'users', $clean);
			$this->addMessage(psm_get_lang('users', 'inserted'), 'success');

			$event = \psm\Module\User\UserEvents::USER_ADD;
		}
		$this->container->get('event')->dispatch(
			$event,
			new \psm\Module\User\Event\UserEvent($user_id, $this->getUser()->getUserId())
		);
		if(isset($password)) {
			$this->getUser()->changePassword($user_id, $password);
		}

		// update servers
		$server_idc = psm_POST('server_id', array());
		$server_idc_save = array();

		foreach($server_idc as $server_id) {
			$server_idc_save[] = array(
				'user_id' => $user_id,
				'server_id' => intval($server_id),
			);
		}
		// delete all existing records
		$this->db->delete(PSM_DB_PREFIX.'users_servers', array('user_id' => $user_id));
		if(!empty($server_idc_save)) {
			// add all new servers
			$this->db->insertMultiple(PSM_DB_PREFIX.'users_servers', $server_idc_save);
		}

		return $this->executeIndex();
	}

	/**
	 * Executes the deletion of a user
	 */
	protected function executeDelete() {
		$id = (isset($_GET['id'])) ? intval($_GET['id']) : 0;

		try {
			$this->container->get('util.user.validator')->userId($id);

			$this->db->delete(PSM_DB_PREFIX . 'users', array('user_id' => $id,));
			$this->db->delete(PSM_DB_PREFIX.'users_servers', array('user_id' => $id));

			$this->container->get('event')->dispatch(
				\psm\Module\User\UserEvents::USER_DELETE,
				new \psm\Module\User\Event\UserEvent($id, $this->getUser()->getUserId())
			);

			$this->addMessage(psm_get_lang('users', 'deleted'), 'success');
		} catch(\InvalidArgumentException $e) {
			$this->addMessage(psm_get_lang('users', 'error_' . $e->getMessage()), 'error');
		}

		return $this->executeIndex();
	}

	protected function getLabels() {
		return array(
			'label_users' => psm_get_lang('menu', 'users'),
			'label_user' => psm_get_lang('users', 'user'),
			'label_name' => psm_get_lang('users', 'name'),
			'label_user_name' => psm_get_lang('users', 'user_name'),
			'label_password' => psm_get_lang('users', 'password'),
			'label_password_repeat' => psm_get_lang('users', 'password_repeat'),
			'label_level' => psm_get_lang('users', 'level'),
			'label_level_description' => psm_get_lang('users', 'level_description'),
			'label_mobile' => psm_get_lang('users', 'mobile'),
			'label_pushover' => psm_get_lang('users', 'pushover'),
			'label_pushover_description' => psm_get_lang('users', 'pushover_description'),
			'label_pushover_key' => psm_get_lang('users', 'pushover_key'),
			'label_pushover_device' => psm_get_lang('users', 'pushover_device'),
			'label_pushover_device_description' => psm_get_lang('users', 'pushover_device_description'),
			'label_email' => psm_get_lang('users', 'email'),
			'label_servers' => psm_get_lang('menu', 'server'),
			'label_action' => psm_get_lang('system', 'action'),
			'label_save' => psm_get_lang('system', 'save'),
			'label_go_back' => psm_get_lang('system', 'go_back'),
			'label_edit' => psm_get_lang('system', 'edit'),
			'label_delete' => psm_get_lang('system', 'delete'),
			'label_add_new' => psm_get_lang('system', 'add_new'),
		);
	}

	/**
	 * Get all server ids for a user
	 * @param int $user_id
	 * @return array with ids only
	 * @todo we should probably find a central place for this kind of stuff
	 */
	protected function getUserServers($user_id) {
		$servers = $this->db->select(
			PSM_DB_PREFIX.'users_servers',
			array('user_id' => $user_id),
			array('server_id')
		);
		$result = array();
		foreach($servers as $server) {
			$result[] = $server['server_id'];
		}
		return $result;
	}
}
