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
 * @since       phpservermon 3.1
 **/

namespace psm\Util\Server;

/**
 * Makes sure all data of servers is being archived properly or removed if necessary.
 */
class ArchiveManager
{

    /**
     * Available archiver utils.
     * @var array $archivers
     */
    protected $archivers = array();

    /**
     * Database service
     * @var \psm\Service\Database $db
     */
    protected $db;

    /**
     * Retention period
     * @var \DateInterval|bool $retention_period false if cleanup is disabled
     * @see setRetentionPeriod()
     */
    protected $retention_period;

    public function __construct(\psm\Service\Database $db)
    {
        $this->db = $db;

        $this->setRetentionPeriod(psm_get_conf('log_retention_period', 365));

        $this->archivers[] = new Archiver\UptimeArchiver($db);
        $this->archivers[] = new Archiver\LogsArchiver($db);
    }

    /**
     * Archive one or more servers.
     * @param int $server_id
     * @return boolean
     */
    public function archive($server_id = null)
    {
        $result = true;
        foreach ($this->archivers as $archiver) {
            if (!$archiver->archive($server_id)) {
                $result = false;
            }
        }
        return $result;
    }

    /**
     * Cleanup old records for one or more servers
     * @param int $server_id
     * @return boolean
     */
    public function cleanup($server_id = null)
    {
        $result = true;
        if (!$this->retention_period) {
            // cleanup is disabled
            return $result;
        }
        $retdate = new \DateTime();
        $retdate->sub($this->retention_period);

        foreach ($this->archivers as $archiver) {
            if (!$archiver->cleanup($retdate, $server_id)) {
                $result = false;
            }
        }
        return $result;
    }

    /**
     * Set retention period for this archive run.
     *
     * Set period to 0 to disable cleanup altogether.
     * @param \DateInterval|int $period \DateInterval object or number of days (int)
     * @return \psm\Util\Server\ArchiveManager
     */
    public function setRetentionPeriod($period)
    {
        if (is_object($period) && $period instanceof \DateInterval) {
            $this->retention_period = $period;
        } elseif (intval($period) == 0) {
            // cleanup disabled
            $this->retention_period = false;
        } else {
            $this->retention_period = new \DateInterval('P' . intval($period) . 'D');
        }
        return $this;
    }
}
