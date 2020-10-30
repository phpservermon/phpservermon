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
 * @version     Release: v3.5.0
 * @link        http://www.phpservermonitor.org/
 * @since       phpservermon 3.0.0
 **/

namespace psm\Module\Consult\Controller;

use psm\Module\AbstractController;
use psm\Module\Consult\Controller\AbstractConsultController;
use psm\Module\Server\Controller\AbstractServerController;
use psm\Service\Database;

abstract class AbstractConsultServerController extends AbstractConsultController
{
    /**
     * Get all servers for the current user
     * @param Countable|array|\PDOStatement $server_id (int) if true only that server will be retrieved.
     * @param array|\PDOStatement $ip
     * @return array
     */
    public function getServers($server_id = null, $ip = null)
    {
        $sql_join = '';
        $sql_where = '';


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
        return parent::formatServer($server);
    }
}
