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
 * */
/**
 * Server module. List all servers, return list as JSON.
 */

namespace psm\Module\Server\Controller;

use psm\Service\Database;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;

/**
 * Description of ApiStatusController
 *
 * @author Matej Kminek <matej.kminek@attendees.eu>, 24. 11. 2019
 */
class ApiStatusController extends AbstractServerController {

	/**
	 * Current server id
	 * @var int|\PDOStatement $server_id
	 */
	protected $server_id;

        function __construct(Database $db, Twig_Environment $twig) {
		parent::__construct($db, $twig);

                $this->server_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
                
		$this->setActions(array('detail', 'list'), 'list');
	}
        
        /**
         * Prepare the view template
         */
        protected function executeList() {
                $server = $this->getServers();

                return new JsonResponse($server, Response::HTTP_OK);
        }
        
        /**
         * Prepare the view template
         */
        protected function executeDetail() {
                var_dump($this->server_id);
                if(empty($this->server_id)){
                        return new JsonResponse("Not found", Response::HTTP_NOT_FOUND);
                }
                
                $server = $this->getServers($this->server_id);

                if (empty($server)) {
                        return $this->runAction('index');
                }

                return new JsonResponse($server, Response::HTTP_OK);
        }

}
