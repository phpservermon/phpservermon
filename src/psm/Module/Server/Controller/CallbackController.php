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
 * @link        http://www.phpservermonitor.org/
 **/

namespace psm\Module\Server\Controller;

use psm\Module\AbstractController;
use psm\Service\Database;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CallbackController extends AbstractController
{

    public function __construct(Database $db, \Twig\Environment $twig)
    {
        parent::__construct($db, $twig);

        $this->setActions('index', 'index');
        $this->setMinUserLevelRequired(PSM_USER_ANONYMOUS);
        $this->addFooter(false);
        $this->addMenu(false);
    }

    protected function executeIndex()
    {
        $request = Request::createFromGlobals();
        if ($request->getMethod() !== 'GET') {
            return new Response('Method Not Allowed', 405, array('Allow' => 'GET'));
        }

        $token = trim((string) psm_GET('token', ''));

        if ($token === '' || strlen($token) > 128) {
            return new Response('Invalid callback token.', 400);
        }

        $server = $this->db->selectRow(
            PSM_DB_PREFIX . 'servers',
            array(
                'type' => 'callback',
                'callback_token' => $token,
            ),
            array('server_id')
        );

        if (empty($server)) {
            return new Response('Callback endpoint not found.', 404);
        }

        $this->db->save(
            PSM_DB_PREFIX . 'servers',
            array(
                'callback_last_call' => date('Y-m-d H:i:s'),
            ),
            array('server_id' => $server['server_id'])
        );

        return new JsonResponse(array('status' => 'ok'));
    }
}
