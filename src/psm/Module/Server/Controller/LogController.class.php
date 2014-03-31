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
 * Log module. Create the page to view previous log messages
 */
class LogController extends AbstractServerController {

	function __construct(Database $db, Template $tpl) {
		parent::__construct($db, $tpl);

		$this->setActions('index', 'index');
	}

	/**
	 * Prepare the template with a list of all log entries
	 */
	protected function executeIndex() {
		$this->setTemplateId('server_log_list', 'server/log.tpl.html');

		$entries = array();
		$entries['status'] = $this->getEntries('status');
		$entries['email'] = $this->getEntries('email');
		$entries['sms'] = $this->getEntries('sms');

		// get users
		$users = $this->db->select(PSM_DB_PREFIX.'users', null, array('user_id','name'));

		$users_labels = array();
		foreach ($users as $user) {
			$users_labels[$user['user_id']] = $user['name'];
		}

		foreach($entries as $key => $records) {
			$log_count = count($records);

			for ($x = 0; $x < $log_count; $x++) {
				$records[$x]['class'] = ($x & 1) ? 'odd' : 'even';
				$records[$x]['users'] = '';
				$records[$x]['server'] = $records[$x]['label'] . ' (' . $records[$x]['label_adv'] . ')';
				$records[$x]['datetime_format'] = psm_date($records[$x]['datetime']);

				// fix up user list
				if($records[$x]['user_id'] == '') continue;

				$users = explode(',', $records[$x]['user_id']);
				foreach($users as $user_id) {
					if((int) $user_id == 0 || !isset($users_labels[$user_id])) continue;

					$records[$x]['users'] .= '<br/>'.$users_labels[$user_id];
				}
			}

			// add entries to template
			$this->tpl->newTemplate('server_log_entries', 'server/log.tpl.html');
			$this->tpl->addTemplateDataRepeat('server_log_entries', 'entries', $records);
			$this->tpl->addTemplateData(
				'server_log_entries',
				array(
					'logtitle' => $key,
				)
			);
			$this->tpl->addTemplateData(
				$this->getTemplateId(),
				array(
					'content_' . $key => $this->tpl->getTemplate('server_log_entries'),
				)
			);
		}
	}

	/**
	 * Get all the log entries for a specific $type
	 *
	 * @param string $type status/email/sms
	 * @return array
	 */
	public function getEntries($type) {
		$sql_join = '';
		if($this->user != null && $this->user->getUserLevel() > PSM_USER_ADMIN) {
			// restrict by user_id
			$sql_join = "JOIN `".PSM_DB_PREFIX."users_servers` AS `us` ON (
						`us`.`user_id`={$this->user->getUserId()}
						AND `us`.`server_id`=`servers`.`server_id`
						)";
		}
		$entries = $this->db->query(
			'SELECT '.
				'`servers`.`label`, '.
				'CONCAT_WS('.
					'\':\','.
					'`servers`.`ip`, '.
					'`servers`.`port`'.
				') AS `label_adv`, '.
				'`log`.`type`, '.
				'`log`.`message`, '.
				'`log`.`datetime`, '.
				'`log`.`user_id` '.
			'FROM `'.PSM_DB_PREFIX.'log` AS `log` '.
			'JOIN `'.PSM_DB_PREFIX.'servers` AS `servers` ON (`servers`.`server_id`=`log`.`server_id`) '.
			$sql_join .
			'WHERE `log`.`type`=\''.$type.'\' '.
			'ORDER BY `datetime` DESC '.
			'LIMIT 0,20'
		);
		return $entries;
	}

	// override parent::createHTMLLabels()
	protected function createHTMLLabels() {
		$this->tpl->addTemplateData(
			$this->getTemplateId(),
			array(
				'subtitle' => psm_get_lang('menu', 'server_log'),
				'label_status' => psm_get_lang('log', 'status'),
				'label_email' => psm_get_lang('log', 'email'),
				'label_sms' => psm_get_lang('log', 'sms'),
				'label_title' => psm_get_lang('log', 'title'),
				'label_server' => psm_get_lang('servers', 'server'),
				'label_type' => psm_get_lang('log', 'type'),
				'label_message' => psm_get_lang('system', 'message'),
				'label_date' => psm_get_lang('system', 'date'),
				'label_users' => ucfirst(psm_get_lang('menu', 'user')),
			)
		);

		return parent::createHTMLLabels();
	}
}
