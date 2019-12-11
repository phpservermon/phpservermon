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
     * Archive all server status records older than 1 week.
     *
     * Archiving means calculating averages per day, and storing 1 single
     * history row for each day for each server.
     *
     * @param int $server_id
     */
    public function archive($server_id = null)
    {
        $latest_date = new \DateTime('-1 week 0:0:0');

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
            "SELECT `server_id`,`date`,`status`,`latency`
				FROM `" . PSM_DB_PREFIX . "servers_uptime`
				WHERE {$sql_where_server} `date` < :latest_date",
            array('latest_date' => $latest_date_str)
        );

        if (!empty($records)) {
            // first group all records by day and server_id
            $data_by_day = array();
            foreach ($records as $record) {
                $server_id = (int) $record['server_id'];
                $day = date('Y-m-d', strtotime($record['date']));
                if (!isset($data_by_day[$day][$server_id])) {
                    $data_by_day[$day][$server_id] = array();
                }
                $data_by_day[$day][$server_id][] = $record;
            }

            // now get history data day by day
            $histories = array();
            foreach ($data_by_day as $day => $day_records) {
                foreach ($day_records as $server_id => $server_day_records) {
                    $histories[] = $this->getHistoryForDay($day, $server_id, $server_day_records);
                }
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

    /**
     * Build a history array for a day records
     * @param string $day
     * @param int $server_id
     * @param array $day_records
     * @return array
     */
    protected function getHistoryForDay($day, $server_id, $day_records)
    {
        $latencies = array();
        $checks_failed = 0;

        foreach ($day_records as $day_record) {
            $latencies[] = $day_record['latency'];

            if ($day_record['status'] == 0) {
                $checks_failed++;
            }
        }
        sort($latencies, SORT_NUMERIC);

        $history = array(
            'date' => $day,
            'server_id' => $server_id,
            'latency_min' => min($latencies),
            'latency_avg' => array_sum($latencies) / count($latencies),
            'latency_max' => max($latencies),
            'checks_total' => count($day_records),
            'checks_failed' => $checks_failed,
        );
        return $history;
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
