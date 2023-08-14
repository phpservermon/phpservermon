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
 * @since       phpservermon 3.0.0
 **/

namespace psm\Module\Server\Controller;

use psm\Module\AbstractController;
use psm\Service\Database;

abstract class AbstractServerController extends AbstractController
{

    /**
     * Get all servers for the current user
     * @param Countable|array|\PDOStatement $server_id (int) if true only that server will be retrieved.
     * @return array
     */
    public function getServers($server_id = null)
    {
        $sql_join = '';
        $sql_where = '';

        if ($this->getUser()->getUserLevel() > PSM_USER_ADMIN) {
            // restrict by user_id
            $sql_join = "JOIN `" . PSM_DB_PREFIX . "users_servers` AS `us` ON (
						`us`.`user_id`={$this->getUser()->getUserId()}
						AND `us`.`server_id`=`s`.`server_id`
						)";
        }
        if ($server_id !== null) {
            $server_id = intval($server_id);
            $sql_where = "WHERE `s`.`server_id`={$server_id} ";
        }

        $sql = "SELECT
					`s`.`server_id`,
					`s`.`ip`,
					`s`.`port`,
					`s`.`request_method`,
					`s`.`post_field`,
					`s`.`type`,
					`s`.`label`,
					`s`.`pattern`,
					`s`.`pattern_online`,
					`s`.`redirect_check`,
					`s`.`allow_http_status`,
					`s`.`header_name`,
					`s`.`header_value`,
					`s`.`status`,
					`s`.`error`,
					`s`.`rtime`,
					`s`.`last_check`,
					`s`.`last_online`,
					`s`.`last_offline`,
					`s`.`last_offline_duration`,
					`s`.`active`,
					`s`.`email`,
					`s`.`sms`,
          `s`.`discord`,
					`s`.`webhook`,
					`s`.`pushover`,
					`s`.`telegram`,
					`s`.`jabber`,
					`s`.`warning_threshold`,
					`s`.`warning_threshold_counter`,
                    `s`.`ssl_cert_expiry_days`,
                    `s`.`ssl_cert_expired_time`,
					`s`.`timeout`,
					`s`.`website_username`,
					`s`.`website_password`,
					`s`.`last_error`,
					`s`.`last_error_output`,
					`s`.`last_output`
				FROM `" . PSM_DB_PREFIX . "servers` AS `s`
				{$sql_join}
				{$sql_where}
				ORDER BY `active` ASC, `status` DESC, `label` ASC";
        $servers = $this->db->query($sql);

        if ($server_id !== null && count($servers) == 1) {
            $servers = $servers[0];
        }

        return $servers;
    }

    /**
     * Format server data for display
     * @param array $server
     * @return array
     */
    protected function formatServer($server)
    {
        $server['rtime'] = $server['rtime'];
        $server['last_online'] = psm_timespan($server['last_online']);
        $server['last_offline'] = psm_timespan($server['last_offline']);
        if ($server['last_offline'] != psm_get_lang('system', 'never')) {
            $server['last_offline_duration'] = is_null($server['last_offline_duration']) ?
                null : "(" . $server['last_offline_duration'] . ")";
        }
        $server['last_check'] = psm_timespan($server['last_check']);

        if (
            (
                $server['status'] == 'on' &&
                $server['warning_threshold_counter'] > 0
            ) || (
                $server['status'] == 'on' &&
                $server['ssl_cert_expired_time'] !== null &&
                $server['ssl_cert_expiry_days'] > 0
            )
        ) {
            $server['status'] = 'warning';
        }

        $server['error'] = htmlentities($server['error']);
        $server['type'] = psm_get_lang('servers', 'type_' . $server['type']);
        $server['timeout'] = ($server['timeout'] > 0) ? $server['timeout'] : PSM_CURL_TIMEOUT;

        $server['last_error'] = htmlentities($server['last_error']);
        $server['last_error_output'] = htmlentities($server['last_error_output']);
        $server['last_output'] = htmlentities($server['last_output']);

        $url_actions = array('delete', 'edit', 'view');
        foreach ($url_actions as $action) {
            $server['url_' . $action] = psm_build_url(array(
                'mod' => 'server',
                'action' => $action,
                'id' => $server['server_id'],
            ));
        }

        return $server;
    }
}
