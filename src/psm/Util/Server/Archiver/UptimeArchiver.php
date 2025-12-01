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
 *              Jérôme Cabanis <http://lauraly.com>
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

/**
 * The archiver class moves active data from the uptime table to the history table.
 *
 * Because the uptime table has a record for every single run of the status-check,
 * it will grow very large over time. For this reason, uptime records are only kept for a limited time
 * to provide detailed statistics. After that, the archiver comes in and saves the averages per day
 * in the history table. That way we can always show statistics regarding average latency and failed checks per day,
 * but we only need 1 record per server per day.
 *
 * @see \psm\Util\Updater\Autorun
 */
namespace psm\Util\Server\Archiver;
use psm\Service\Database;

class UptimeArchiver implements ArchiverInterface
{

    /**
     * Database service
     * @var \psm\Service\Database $db
     */
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    /**
     * Archive all server status records older than (X) based on config.
	 * quarterly = up to last 3 months
	 * monthly = up to last 1 month
	 * default / weekly = up to 1 week
     *
     * Archiving means calculating averages per day, and storing 1 single
     * history row for each day for each server.
     *
     * @param int $server_id
     */
    public function archive($server_id = null)
    {
		if(PSM_UPTIME_ARCHIVE == 'quarterly'){
			$latest_date = new \DateTime('-3 month 0:0:0');
		}else if(PSM_UPTIME_ARCHIVE == 'monthly'){
			$latest_date = new \DateTime('-1 month 0:0:0');
		}else{
			$latest_date = new \DateTime('-1 week 0:0:0');
		}

        // Lock tables to prevent simultaneous archiving (by other sessions or the cron job)
        try {
            $this->db->pdo()->exec('LOCK TABLES ' . PSM_DB_PREFIX .
                'servers_uptime WRITE, ' . PSM_DB_PREFIX . 'servers_history WRITE');
            $locked = true;
        } catch (\PDOException $e) {
            // user does not have lock rights, ignore
            $locked = false;
        }

        $latest_date_str = $latest_date->format('Y-m-d 00:00:00');

        $sql_where_server = $this->createSQLWhereServer($server_id);

        $records = $this->db->execute(
            "SELECT DATE(`date`) AS `day`, `server_id`,
                                MIN(`latency`) AS `latency_min`, AVG(`latency`) AS `latency_avg`, MAX(`latency`) AS `latency_max`,
                                COUNT(*) AS `checks_total`, SUM(CASE WHEN `status` = 0 THEN 1 ELSE 0 END) AS `checks_failed`
                                FROM `" . PSM_DB_PREFIX . "servers_uptime`
                                WHERE {$sql_where_server} `date` < :latest_date
                                GROUP BY `day`, `server_id`
                                ORDER BY `day` ASC",
            array('latest_date' => $latest_date_str)
        );

        if (!empty($records)) {
            $histories = array();
            foreach ($records as $record) {
                $histories[] = array(
                    'date' => $record['day'],
                    'server_id' => (int) $record['server_id'],
                    'latency_min' => (float) $record['latency_min'],
                    'latency_avg' => (float) $record['latency_avg'],
                    'latency_max' => (float) $record['latency_max'],
                    'checks_total' => (int) $record['checks_total'],
                    'checks_failed' => (int) $record['checks_failed'],
                );
            }

            // Save all
            $this->db->insertMultiple(PSM_DB_PREFIX . 'servers_history', $histories);

            // now remove all records from the uptime table
            $this->db->execute(
                "DELETE FROM `" . PSM_DB_PREFIX . "servers_uptime` WHERE {$sql_where_server} `date` < :latest_date",
                array('latest_date' => $latest_date_str),
                false
            );
        }

        if ($locked) {
            $this->db->exec('UNLOCK TABLES');
        }

        return true;
    }

    public function cleanup(\DateTime $retention_date, $server_id = null)
    {
        $sql_where_server = $this->createSQLWhereServer($server_id);
        $this->db->execute(
            "DELETE FROM `" . PSM_DB_PREFIX . "servers_history` WHERE {$sql_where_server} `date` < :latest_date",
            array('latest_date' => $retention_date->format('Y-m-d 00:00:00')),
            false
        );
        return true;
    }

    protected function createSQLWhereServer($server_id)
    {
        $sql_where_server = ($server_id !== null)
                // this is obviously not the cleanest way to implement this when using paramter binding.. sorry.
                ? ' `server_id` = ' . intval($server_id) . ' AND '
                : '';

        return $sql_where_server;
    }
}
