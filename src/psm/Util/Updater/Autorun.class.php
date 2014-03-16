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
 * @since		phpservermon 2.2.0
 **/

namespace psm\Util\Updater;
use psm\Service\Database;
use psm\Service\User;

/**
 * Run an update on all servers.
 *
 * If you provide a User service instance it will be
 * restricted to that user only.
 */
class Autorun {

	/**
	 * Database service
	 * @var \psm\Service\Database $db
	 */
	protected $db;

	/**
	 * User service
	 * @var \psm\Service\User $user
	 */
	protected $user;

	function __construct(Database $db) {
		$this->db = $db;
	}

	/**
	 * Go :-)
	 */
	public function run() {
		// check if we need to restrict the servers to a certain user
		$sql_join = '';

		if($this->user != null && $this->user->getUserLevel() > PSM_USER_ADMIN) {
			// restrict by user_id
			$sql_join = "JOIN `".PSM_DB_PREFIX."users_servers` AS `us` ON (
						`us`.`user_id`={$this->user->getUserId()}
						AND `us`.`server_id`=`s`.`server_id`
						)";
		}

		$sql = "SELECT `s`.`server_id`,`s`.`ip`,`s`.`port`,`s`.`label`,`s`.`type`,`s`.`pattern`,`s`.`status`,`s`.`active`,`s`.`email`,`s`.`sms`
				FROM `".PSM_DB_PREFIX."servers` AS `s`
				{$sql_join}
				WHERE `active`='yes' ";

		$servers = $this->db->query($sql);

		$updater = new Status($this->db);

		foreach($servers as $server) {
			$status_org = $server['status'];
			// remove the old status from the array to avoid confusion between the new and old status
			unset($server['status']);

			$updater->setServer($server, $status_org);

			// check server status
			// it returns the new status, and performs the update check automatically.
			$status_new = $updater->getStatus();
			// notify the nerds if applicable
			$updater->notify();

			// update server status
			$save = array(
				'last_check' => date('Y-m-d H:i:s'),
				'status' => $status_new,
				'error' => $updater->getError(),
				'rtime' => $updater->getRtime(),
			);

			// if the server is on, add the last_online value
			if($save['status'] == 'on') {
				$save['last_online'] = date('Y-m-d H:i:s');
			}

			$this->db->save(
				PSM_DB_PREFIX . 'servers',
				$save,
				array('server_id' => $server['server_id'])
			);

			$log_status = ($status_new == 'on') ? 1 : 0;
			psm_log_uptime($server['server_id'], $log_status, $updater->getRtime());
		}
	}

	/**
	 * Set a user to restrict the servers being updated
	 * @param \psm\Service\User $user
	 */
	public function setUser(User $user) {
		$this->user = $user;
	}
}