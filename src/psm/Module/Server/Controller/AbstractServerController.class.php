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
 * @since		phpservermon 3.0.0
 **/

namespace psm\Module\Server\Controller;
use psm\Module\AbstractController;
use psm\Service\Database;
use psm\Service\Template;

abstract class AbstractServerController extends AbstractController {

	function __construct(Database $db, Template $tpl) {
		parent::__construct($db, $tpl);
	}

	/**
	 * Get all servers for the current user
	 * @param int $server_id if true only that server will be retrieved.
	 * @return array
	 */
	public function getServers($server_id = null) {
		$sql_join = '';
		$sql_where = '';

		if($this->user != null && $this->user->getUserLevel() > PSM_USER_ADMIN) {
			// restrict by user_id
			$sql_join = "JOIN `".PSM_DB_PREFIX."users_servers` AS `us` ON (
						`us`.`user_id`={$this->user->getUserId()}
						AND `us`.`server_id`=`s`.`server_id`
						)";
		}
		if($server_id !== null) {
			$server_id = intval($server_id);
			$sql_where ="WHERE `s`.`server_id`={$server_id} ";
		}

		$sql = "SELECT
					`s`.`server_id`,
					`s`.`ip`,
					`s`.`port`,
					`s`.`type`,
					`s`.`label`,
					`s`.`pattern`,
					`s`.`status`,
					`s`.`error`,
					`s`.`rtime`,
					`s`.`last_check`,
					`s`.`last_online`,
					`s`.`active`,
					`s`.`email`,
					`s`.`sms`,
					`s`.`pushover`,
					`s`.`warning_threshold`,
					`s`.`warning_threshold_counter`,
					`s`.`timeout`
				FROM `".PSM_DB_PREFIX."servers` AS `s`
				{$sql_join}
				{$sql_where}
				ORDER BY `active` ASC, `status` DESC, `label` ASC";
		$servers = $this->db->query($sql);

		if($server_id !== null && count($servers) == 1) {
			$servers = $servers[0];
		}

		return $servers;
	}

	/**
	 * Format server data for display
	 * @param array $server
	 * @return array
	 */
	protected function formatServer($server) {
		$server['rtime'] = round((float) $server['rtime'], 4);
		$server['last_online']  = psm_timespan($server['last_online']);
		$server['last_check']  = psm_timespan($server['last_check']);
		$server['active'] = psm_get_lang('system', $server['active']);
		$server['email'] = psm_get_lang('system', $server['email']);
		$server['sms'] = psm_get_lang('system', $server['sms']);
		$server['pushover'] = psm_get_lang('system', $server['pushover']);
		$server['url_view'] = psm_build_url(array(
			'mod' => 'server',
			'action' => 'view',
			'id' => $server['server_id'],
		));

		if($server['status'] == 'on' && $server['warning_threshold_counter'] > 0) {
			$server['status'] = 'warning';
		}

		$server['error'] = htmlentities($server['error']);
		$server['type'] = psm_get_lang('servers', 'type_' . $server['type']);
		$server['timeout'] = ($server['timeout'] > 0) ? $server['timeout'] : PSM_CURL_TIMEOUT;

		return $server;
	}
}
