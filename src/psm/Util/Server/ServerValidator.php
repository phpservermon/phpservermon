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
 * @since       phpservermon 3.1.0
 **/

namespace psm\Util\Server;

/**
 * The ServerValidator helps you to check input data for servers.
 */
class ServerValidator
{

    /**
     * Database service
     * @var \psm\Service\Database $db
     */
    protected $db;

    public function __construct(\psm\Service\Database $db)
    {
        $this->db = $db;
    }

    /**
     * Check if the server id exists
     * @param int|\PDOStatement $server_id
     * @return boolean
     * @throws \InvalidArgumentException
     */
    public function serverId($server_id)
    {
        $server = $this->db->selectRow(PSM_DB_PREFIX . 'servers', array('server_id' => $server_id), array('server_id'));

        if (empty($server)) {
            throw new \InvalidArgumentException('server_no_match');
        }
        return true;
    }

    /**
     * Check label
     * @param string $label
     * @return boolean
     * @throws \InvalidArgumentException
     */
    public function label($label)
    {
        $label = trim($label);
        if (empty($label) || strlen($label) > 255) {
            throw new \InvalidArgumentException('server_label_bad_length');
        }
        return true;
    }

    /**
     * Check server domain/ip
     * @param string $value
     * @param string $type if given, it can be checked for "website"/"ip"
     * @return boolean
     * @throws \InvalidArgumentException
     */
    public function ip($value, $type = null)
    {
        $value = trim($value);

        if (empty($value) || strlen($value) > 255) {
            throw new \InvalidArgumentException('server_ip_bad_length');
        }

        switch ($type) {
            case 'website':
                // url regex as per https://stackoverflow.com/a/3809435
                // Regex looks a bit weird, but otherwise it's more then 120 characters
                if (
                    !preg_match_all(
                        "/(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\." .
                        "[a-z]{2,12}\b([-a-zA-Z0-9@:%_\+.~#?&\/\/=]*)/",
                        $value
                    )
                ) {
                    throw new \InvalidArgumentException('server_ip_bad_website');
                }
                break;
            case 'service':
            case 'ping':
                if (
                    !filter_var($value, FILTER_VALIDATE_IP)
                    // domain regex as per
                    // http://stackoverflow.com/questions/106179/regular-expression-to-match-hostname-or-ip-address
                    // Regex looks a bit weird, but otherwise it's more then 120 characters
                    && !preg_match(
                        "/^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*" .
                        "([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])$/",
                        $value
                    )
                ) {
                    throw new \InvalidArgumentException('server_ip_bad_service');
                }
                break;
        }

        return true;
    }

    /**
     * Check server type
     * @param string $type
     * @return boolean
     * @throws \InvalidArgumentException
     */
    public function type($type)
    {
        if (!in_array($type, array('ping', 'service', 'website'))) {
            throw new \InvalidArgumentException('server_type_invalid');
        }
        return true;
    }

    /**
     * Check warning threshold
     * @param int $value
     * @return boolean
     * @throws \InvalidArgumentException
     */
    public function warningThreshold($value)
    {
        if (!is_numeric($value) || intval($value) == 0) {
            throw new \InvalidArgumentException('server_warning_threshold_invalid');
        }
        return true;
    }

    /**
     * Check SSL expiry days
     * @param int $value
     * @return boolean
     * @throws \InvalidArgumentException
     */
    public function sslCertExpiryDays($value)
    {
        if (!is_numeric($value) || $value < 0) {
            throw new \InvalidArgumentException('server_ssl_cert_expiry_days');
        }
        return true;
    }
}
