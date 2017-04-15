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

namespace psm\Module\Server\Controller;
use psm\Service\Database;

/**
 * Log module. Create the page to view previous log messages
 */
class LogController extends AbstractServerController {

	function __construct(Database $db, \Twig_Environment $twig) {
		parent::__construct($db, $twig);

		$this->setActions('index', 'index');
	}

	/**
	 * Prepare the template with a list of all log entries
	 */
	protected function executeIndex() {
		$this->twig->addGlobal('subtitle', psm_get_lang('menu', 'server_log'));
		$tpl_data = array(
			'label_status' => psm_get_lang('log', 'status'),
			'label_email' => psm_get_lang('log', 'email'),
			'label_sms' => psm_get_lang('log', 'sms'),
			'label_pushover' => psm_get_lang('log', 'pushover'),
			'label_title' => psm_get_lang('log', 'title'),
			'label_server' => psm_get_lang('servers', 'server'),
			'label_type' => psm_get_lang('log', 'type'),
			'label_message' => psm_get_lang('system', 'message'),
			'label_date' => psm_get_lang('system', 'date'),
			'label_users' => ucfirst(psm_get_lang('menu', 'user')),
			'label_no_logs' => psm_get_lang('log', 'no_logs'),
			'tabs' => array(),
		);
		$log_types = array('status', 'email', 'sms', 'pushover');

		foreach($log_types as $key) {
			$records = $this->getEntries($key);
			$log_count = count($records);

			$tab_data = array(
				'id' => $key,
				'has_users' => ($key == 'status') ? false : true,
				'no_logs' => ($log_count == 0) ? true : false,
				'tab_active' => ($key == 'status') ? 'active' : '',
			);

			for ($x = 0; $x < $log_count; $x++) {
				$record = &$records[$x];
				$record['class'] = ($x & 1) ? 'odd' : 'even';
				$record['users'] = '';
				$record['server'] = $record['label'];
				$record['type_icon'] = ($record['server_type'] == 'website') ? 'icon-globe' : 'icon-cog';
				$record['type_title'] = psm_get_lang('servers', 'type_' . $record['server_type']);
				$ip = '(' . $record['ip'];
				if(!empty($record['port']) && (($record['server_type'] != 'website') || ($record['port'] != 80))) {
					$ip .= ':' . $record['port'];
				}
				$ip .= ')';
				$record['ip'] = $ip;
				$record['datetime_format'] = psm_date($record['datetime']);

				// fix up user list
                $users = $this->getLogUsers($record['log_id']);
				if(!empty($users)) {
					$names = array();
					foreach($users as $user) {
                        $names[] = $user['name'];
					}
					$record['users'] = implode('<br/>', $names);
					$record['user_list'] = implode('&nbsp;&bull; ', $names);
				}
			}
			$tab_data['entries'] = $records;
			$tpl_data['tabs'][] = $tab_data;
		}
		return $this->twig->render('module/server/log.tpl.html', $tpl_data);
	}

	/**
	 * Get all the log entries for a specific $type
	 *
	 * @param string $type status/email/sms
	 * @return array
	 */
	public function getEntries($type) {
		$sql_join = '';
		if($this->getUser()->getUserLevel() > PSM_USER_ADMIN) {
			// restrict by user_id
			$sql_join = "JOIN `".PSM_DB_PREFIX."users_servers` AS `us` ON (
						`us`.`user_id`={$this->getUser()->getUserId()}
						AND `us`.`server_id`=`servers`.`server_id`
						)";
		}
		$entries = $this->db->query(
			'SELECT '.
				'`servers`.`label`, '.
				'`servers`.`ip`, '.
				'`servers`.`port`, '.
				'`servers`.`type` AS server_type, '.
				'`log`.`log_id`, '.
				'`log`.`type`, '.
				'`log`.`message`, '.
				'`log`.`datetime` '.
			'FROM `'.PSM_DB_PREFIX.'log` AS `log` '.
			'JOIN `'.PSM_DB_PREFIX.'servers` AS `servers` ON (`servers`.`server_id`=`log`.`server_id`) '.
			$sql_join .
			'WHERE `log`.`type`=\''.$type.'\' '.
			'ORDER BY `datetime` DESC '.
			'LIMIT 0,20'
		);
		return $entries;
	}

    /**
     * Get all the user entries for a specific $log_id
     *
     * @param $log_id
     * @return array
     */
    protected function getLogUsers($log_id) {
        return $this->db->query(
            "SELECT
                u.`user_id`,
                u.`name`
            FROM `" . PSM_DB_PREFIX . "log_users` AS lu
            LEFT JOIN `" . PSM_DB_PREFIX . "users` AS u ON lu.`user_id` = u.`user_id`
            WHERE lu.`log_id` = " . (int)$log_id . "
            ORDER BY u.`name` ASC"
        );
    }
}
