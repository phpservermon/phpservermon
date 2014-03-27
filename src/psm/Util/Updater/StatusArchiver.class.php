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
namespace psm\Util\Updater;
use psm\Service\Database;

class StatusArchiver {

	/**
	 * Database service
	 * @var \psm\Service\Database $db
	 */
	protected $db;

	function __construct(Database $db) {
		$this->db = $db;
	}

	/**
	 * Archive the active records of a server before a certain date.
	 *
	 * Archiving means calculating averages per day, and storing 1 single
	 * history row for each day for this server.
	 *
	 * @param int $server_id
	 * @param \DateTime $date_before archive all records before this date
	 */
	public function archive($server_id, \DateTime $date_before) {
		// get all uptime records for this server
		$q_records = $this->db->pdo()->prepare("
			SELECT `date`,`status`,`latency`
			FROM `".PSM_DB_PREFIX."servers_uptime`
			WHERE `server_id` = :server_id AND `date` < :latest_date
		");
		$q_records->execute(array(
			'server_id' => $server_id,
			'latest_date' => $date_before->format('Y-m-d 00:00:00'),
		));
		$records = $q_records->fetchAll();

		if(empty($records)) {
			return false;
		}

		$data_by_day = array();

		// first group all records by day
		foreach($records as $record) {
			$day = date('Y-m-d', strtotime($record['date']));
			if(!isset($data_by_day[$day])) {
				$data_by_day[$day] = array();
			}
			$data_by_day[$day][] = $record;
		}

		// now lets sort out and save the history day by day
		foreach($data_by_day as $day => $day_records) {
			$history = $this->getHistoryForDay($day, $day_records);
			$history['server_id'] = $server_id;

			// store the history for this day in the history table
			$this->db->save(PSM_DB_PREFIX.'servers_history', $history);
		}

		// now remove all records from the uptime table
		$q_records_cleanup = $this->db->pdo()->prepare("
			DELETE FROM `".PSM_DB_PREFIX."servers_uptime`
			WHERE `server_id` = :server_id AND `date` < :latest_date
		");
		$q_records_cleanup->execute(array(
			'server_id' => $server_id,
			'latest_date' => $date_before->format('Y-m-d 00:00:00'),
		));
	}

	/**
	 * Build a history array for a certain day and its records
	 * @param string $day
	 * @param array $day_records
	 * @return array
	 */
	protected function getHistoryForDay($day, $day_records) {
		$latencies = array();
		$checks_failed = 0;

		foreach($day_records as $day_record) {
			$latencies[] = $day_record['latency'];

			if($day_record['status'] == 0) {
				$checks_failed++;
			}
		}
		sort($latencies, SORT_NUMERIC);

		$history = array(
			'date' => $day,
			'latency_min' => min($latencies),
			'latency_avg' => array_sum($latencies) / count($latencies),
			'latency_max' => max($latencies),
			'checks_total' => count($day_records),
			'checks_failed' => $checks_failed,
		);
		return $history;
	}
}