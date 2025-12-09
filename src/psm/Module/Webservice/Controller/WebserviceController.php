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
        $this->setActions(array('login', 'logout'), 'login');

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
}
