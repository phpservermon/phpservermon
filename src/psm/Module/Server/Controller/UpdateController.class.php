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
 * @author      Michael Greenhill
 * @author      Pepijn Over <pep@neanderthal-technology.com>
 * @copyright   Copyright (c) 2008-2014 Pepijn Over <pep@neanderthal-technology.com>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 * @since		phpservermon 3.0.0
 **/

namespace psm\Module\Server\Controller;
use psm\Module\AbstractController;
use psm\Service\Database;
use psm\Service\Template;

class UpdateController extends AbstractController {

	function __construct(Database $db, Template $tpl) {
		parent::__construct($db, $tpl);

		$this->setActions('index', 'index');
	}

	protected function executeIndex() {
		$autorun = new \psm\Util\Updater\Autorun($this->db);
		$autorun->setUser($this->user);
		$autorun->run();

		header('Location: ' . psm_build_url(array(
			'mod' => 'server_status'
		), true, false));
		die();
	}

}
