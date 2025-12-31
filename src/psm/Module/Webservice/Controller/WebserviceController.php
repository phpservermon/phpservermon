<?php

/**
 * REMITK MONITORING
 * Monitor your servers and websites.
 *
 * This file is part of REMITK MONITORING.
 * REMITK MONITORING is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * REMITK MONITORING is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with REMITK MONITORING.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package     phpservermon
 * @author      Pepijn Over <pep@mailbox.org>
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 */

namespace psm\Module\Webservice\Controller;

use psm\Module\AbstractController;
use psm\Service\Database;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class WebserviceController extends AbstractController
{
    public function __construct(Database $db, \Twig\Environment $twig)
    {
        parent::__construct($db, $twig);

        $this->setMinUserLevelRequired(PSM_USER_ANONYMOUS);
        $this->setActions(array('login', 'logout', 'status'), 'login');

        $this->addFooter(false);
        $this->addMenu(false);
    }

    public function isCsrfProtectionRequired()
    {
        return false;
    }

    protected function executeLogin()
    {
        $request = Request::createFromGlobals();

        if ($request->getMethod() !== 'POST') {
            return new JsonResponse(
                array(
                    'success' => false,
                    'message' => 'Only POST requests are allowed.',
                ),
                405
            );
        }

        $username = $request->get('user_name', $request->get('username'));
        $password = $request->get('user_password', $request->get('password'));

        if (empty($username) || empty($password)) {
            return new JsonResponse(
                array(
                    'success' => false,
                    'message' => 'Username and password are required.',
                ),
                400
            );
        }

        $result = $this->getUser()->loginWithPostData($username, $password, false);

        if ($result) {
            $session = $this->getUser()->getSession();

            return new JsonResponse(
                array(
                    'success' => true,
                    'message' => 'Login successful.',
                    'keyword' => 'logged_in',
                    'session_id' => $session->getId(),
                )
            );
        }

        return new JsonResponse(
            array(
                'success' => false,
                'message' => 'Login failed.',
            ),
            401
        );
    }

    protected function executeLogout()
    {
        $request = Request::createFromGlobals();

        if ($request->getMethod() !== 'POST') {
            return new JsonResponse(
                array(
                    'success' => false,
                    'message' => 'Only POST requests are allowed.',
                ),
                405
            );
        }

        $this->getUser()->doLogout();

        return new JsonResponse(
            array(
                'success' => true,
                'message' => 'Logged out.',
            )
        );
    }

    protected function executeStatus()
    {
        $request = Request::createFromGlobals();

        if ($request->getMethod() !== 'GET') {
            return new JsonResponse(
                array(
                    'success' => false,
                    'message' => 'Only GET requests are allowed.',
                ),
                405
            );
        }

        if (!$this->getUser()->isLoggedIn()) {
            return new JsonResponse(
                array(
                    'success' => false,
                    'message' => 'Authentication required.',
                ),
                401
            );
        }

        $serverId = $request->get('server_id');

        $servers = $this->getServersForApi($serverId);

        return new JsonResponse(
            array(
                'success' => true,
                'servers' => $servers,
            )
        );
    }

    /**
     * Fetch server status data for the authenticated user.
     *
     * @param int|null $serverId
     * @return array
     */
    protected function getServersForApi($serverId = null)
    {
        $sqlJoin = '';
        $sqlWhere = '';

        if ($this->getUser()->getUserLevel() > PSM_USER_ADMIN) {
            $sqlJoin = "JOIN `" . PSM_DB_PREFIX . "users_servers` AS `us` ON (" .
                "`us`.`user_id` = :user_id AND `us`.`server_id` = `s`.`server_id`
            )";
        }

        $parameters = array();

        if ($serverId !== null) {
            $sqlWhere = 'WHERE `s`.`server_id` = :server_id ';
            $parameters[':server_id'] = intval($serverId);
        }

        if ($this->getUser()->getUserLevel() > PSM_USER_ADMIN) {
            $parameters[':user_id'] = $this->getUser()->getUserId();
        }

        $sql = "SELECT
                    `s`.`server_id`,
                    `s`.`label`,
                    `s`.`type`,
                    `s`.`status`,
                    `s`.`last_check`,
                    `s`.`last_online`,
                    `s`.`last_offline`,
                    `s`.`rtime`,
                    `s`.`ssl_cert_expiry_days`,
                    `s`.`ssl_cert_expired_time`,
                    `s`.`warning_threshold_counter`
                FROM `" . PSM_DB_PREFIX . "servers` AS `s`
                {$sqlJoin}
                {$sqlWhere}
                ORDER BY `active` ASC, `status` DESC, `label` ASC";

        if (empty($parameters)) {
            $servers = $this->db->query($sql);
        } else {
            $servers = $this->db->execute($sql, $parameters);
        }

        foreach ($servers as &$server) {
            $server['last_check'] = intval($server['last_check']);
            $server['last_online'] = intval($server['last_online']);
            $server['last_offline'] = intval($server['last_offline']);
            $server['rtime'] = $server['rtime'] === null ? null : (float)$server['rtime'];
            $server['ssl_cert_expiry_days'] = $server['ssl_cert_expiry_days'] === null
                ? null
                : intval($server['ssl_cert_expiry_days']);
            $server['warning_threshold_counter'] = intval($server['warning_threshold_counter']);
        }

        return $servers;
    }
}
