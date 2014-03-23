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

namespace psm\Module\Server\Controller;
use psm\Service\Database;
use psm\Service\Template;

/**
 * Server module. Add/edit/delete servers, show a list of all servers etc.
 */
class ServerController extends AbstractServerController {

	function __construct(Database $db, Template $tpl) {
		parent::__construct($db, $tpl);

		$this->setActions(array(
			'index', 'edit', 'save', 'delete',
		), 'index');

		// make sure only admins are allowed to edit/delete servers:
		$this->setMinUserLevelRequiredForAction(PSM_USER_ADMIN, array(
			'delete', 'edit', 'save'
		));
	}

	/**
	 * Prepare the template to show a list of all servers
	 */
	protected function executeIndex() {
		$this->setTemplateId('servers_list', 'servers.tpl.html');
		// check if user is admin, in that case we add the buttons
		if($this->user->getUserLevel() == PSM_USER_ADMIN) {
			// first add buttons at the top
			$this->tpl->newTemplate('servers_list_admin_buttons', 'servers.tpl.html');
			$this->tpl->addTemplateData($this->getTemplateId(), array(
				'html_buttons_admin' => $this->tpl->getTemplate('servers_list_admin_buttons'),
				'url_add' => psm_build_url(array('mod' => 'server', 'action' => 'edit'))
			));
			// get the action buttons per server
			$this->tpl->newTemplate('servers_list_admin_actions', 'servers.tpl.html');
			$html_actions = $this->tpl->getTemplate('servers_list_admin_actions');
		} else {
			$html_actions = '';
		}
		// we need an array for our template magic (see below):
		$html_actions = array('html_actions' => $html_actions);

		$servers = $this->getServers();
		$server_count = count($servers);

		for ($x = 0; $x < $server_count; $x++) {
			// template magic: push the actions html to the front of the server array
			// so the template handler will add it first. that way the other server vars
			// will also be replaced in the html_actions template itself
			$servers[$x] = $html_actions + $servers[$x];
			$servers[$x]['class'] = ($x & 1) ? 'odd' : 'even';
			$servers[$x]['rtime'] = round((float) $servers[$x]['rtime'], 4);
			$servers[$x]['last_online']  = psm_date($servers[$x]['last_online']);
			$servers[$x]['last_check']  = psm_date($servers[$x]['last_check']);

			if($servers[$x]['type'] == 'website') {
				// add link to label
				$servers[$x]['ip'] = '<a href="'.$servers[$x]['ip'].'" target="_blank">'.$servers[$x]['ip'].'</a>';
			}
		}
		// add servers to template
		$this->tpl->addTemplateDataRepeat($this->getTemplateId(), 'servers', $servers);

		// check if we need to add the auto refresh
		$auto_refresh = psm_get_conf('auto_refresh_servers');
		if(intval($auto_refresh) > 0) {
			// add it
			$this->tpl->newTemplate('main_auto_refresh', 'main.tpl.html');
			$this->tpl->addTemplateData('main_auto_refresh', array('seconds' => $auto_refresh));
			$this->tpl->addTemplateData('main', array('auto_refresh' => $this->tpl->getTemplate('main_auto_refresh')));
		}
	}

	/**
	 * Prepare the template to show the update screen for a single server
	 */
	protected function executeEdit() {
		$this->setTemplateId('servers_update', 'servers.tpl.html');

		$server_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

		$tpl_data = array();

		switch(intval($server_id)) {
			case 0:
				// insert mode
				$tpl_data['titlemode'] = psm_get_lang('system', 'insert');
				$tpl_data['edit_server_id'] = '0';
				break;
			default:
				// edit mode
				// get server entry
				$edit_server = $this->db->selectRow(
					PSM_DB_PREFIX.'servers',
					array('server_id' => $server_id)
				);
				if (empty($edit_server)) {
					$this->addMessage('Invalid server id');
					return $this->initializeAction('index');
				}

				$tpl_data = array_merge($tpl_data, array(
					'titlemode' => psm_get_lang('system', 'edit') . ' ' . $edit_server['label'],
					'edit_server_id' => $edit_server['server_id'],
					'edit_value_label' => $edit_server['label'],
					'edit_value_ip' => $edit_server['ip'],
					'edit_value_port' => $edit_server['port'],
					'edit_value_pattern' => $edit_server['pattern'],
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
	 * Executes the saving of one of the servers
	 */
	protected function executeSave() {
		// check for add/edit mode
		if(isset($_POST['label']) && isset($_POST['ip']) && isset($_POST['port'])) {
			$server_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

			$clean = array(
				'label' => strip_tags($_POST['label']),
				'ip' => strip_tags($_POST['ip']),
				'port' => intval($_POST['port']),
				'type' => in_array($_POST['type'], array('website', 'service')) ? $_POST['type'] : 'website',
				'pattern' => $_POST['pattern'],
				'active' => in_array($_POST['active'], array('yes', 'no')) ? $_POST['active'] : 'no',
				'email' => in_array($_POST['email'], array('yes', 'no')) ? $_POST['email'] : 'no',
				'sms' => in_array($_POST['sms'], array('yes', 'no')) ? $_POST['sms'] : 'no',
			);

			// check for edit or add
			if($server_id > 0) {
				// edit
				$this->db->save(
					PSM_DB_PREFIX.'servers',
					$clean,
					array('server_id' => $server_id)
				);
				$this->addMessage(psm_get_lang('servers', 'updated'));
			} else {
				// add
				$clean['status'] = 'on';
				$this->db->save(PSM_DB_PREFIX.'servers', $clean);
				$this->addMessage(psm_get_lang('servers', 'inserted'));
			}
		}
		$this->initializeAction('index');
	}

	/**
	 * Executes the deletion of one of the servers
	 */
	protected function executeDelete() {
		if(isset($_GET['id'])) {
			$id = intval($_GET['id']);
			// do delete
			$res = $this->db->delete(PSM_DB_PREFIX . 'servers', array('server_id' => $id));
			if($res->rowCount() == 1) {
				$this->db->delete(PSM_DB_PREFIX.'log', array('server_id' => $id));
				$this->db->delete(PSM_DB_PREFIX.'users_servers', array('server_id' => $id));
			}
			$this->addMessage(psm_get_lang('system', 'deleted'));
		}
		$this->initializeAction('index');
	}

	// override parent::createHTMLLabels()
	protected function createHTMLLabels() {
		$this->tpl->addTemplateData(
			$this->getTemplateId(),
			array(
				'subtitle' => psm_get_lang('menu', 'server'),
				'label_label' => psm_get_lang('servers', 'label'),
				'label_domain' => psm_get_lang('servers', 'domain'),
				'label_port' => psm_get_lang('servers', 'port'),
				'label_type' => psm_get_lang('servers', 'type'),
				'label_pattern' => psm_get_lang('servers', 'pattern'),
				'label_last_check' => psm_get_lang('servers', 'last_check'),
				'label_rtime' => psm_get_lang('servers', 'rtime'),
				'label_last_online' => psm_get_lang('servers', 'last_online'),
				'label_monitoring' => psm_get_lang('servers', 'monitoring'),
				'label_send_email' => psm_get_lang('servers', 'send_email'),
				'label_send_sms' => psm_get_lang('servers', 'send_sms'),
				'label_action' => psm_get_lang('system', 'action'),
				'label_save' => psm_get_lang('system', 'save'),
				'label_edit' => psm_get_lang('system', 'edit') . ' ' . psm_get_lang('servers', 'server'),
				'label_delete' => psm_get_lang('system', 'delete') . ' ' . psm_get_lang('servers', 'server'),
				'label_yes' => psm_get_lang('system', 'yes'),
				'label_no' => psm_get_lang('system', 'no'),
				'label_add_new' => psm_get_lang('system', 'add_new'),
			)
		);

		return parent::createHTMLLabels();
	}
}
