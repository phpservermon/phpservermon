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
 * @link        http://phpservermon.neanderthal-technology.com/
 **/

namespace psm\Module;
use psm\Service\Database;
use psm\Service\Template;

/**
 * Status module
 */
class Status extends AbstractModule {

	function __construct(Database $db, Template $tpl) {
		parent::__construct($db, $tpl);

		$this->setActions('index', 'index');
	}

	/**
	 * Prepare the template to show a list of all servers
	 * @todo move the background colurs to the config
	 */
	protected function executeIndex() {
		$this->setTemplateId('status', 'status.tpl.html');
		$this->addFooter(false);

		// get the active servers from database
		$servers = $this->db->select(
			PSM_DB_PREFIX.'servers',
			array('active' => 'yes'),
			array('server_id', 'label', 'status', 'last_online', 'last_check', 'rtime')
		);

		$offline = array();
		$online = array();

		$tpl_data = array(
			'bg' => '#000000',
			'offline_bg' => '#a00000',
			'offline_fg' => '#f7cece',
			'online_bg' => '#53a000',
			'online_fg' => '#d8f7ce',
			'label_last_check' => psm_get_lang('servers', 'last_check'),
			'label_last_online' => psm_get_lang('servers', 'last_online'),
			'label_rtime' => psm_get_lang('servers', 'rtime'),
		);
		$this->tpl->addTemplateData($this->getTemplateId(), $tpl_data);

		foreach ($servers as $server) {
			$server['last_checked_nice'] = psm_timespan($server['last_check']);
			$server['last_online_nice'] = psm_timespan($server['last_online']);

			if ($server['status'] == "off") {
				$offline[$server['server_id']] = $server;
			} else {
				$online[$server['server_id']] = $server;
			}
		}

		// add servers to template
		$this->tpl->addTemplateDataRepeat($this->getTemplateId(), 'servers_offline', $offline);
		$this->tpl->addTemplateDataRepeat($this->getTemplateId(), 'servers_online', $online);
		// add refresh (bit overkill perhaps to do it this way..?)
		$this->tpl->newTemplate('main_auto_refresh', 'main.tpl.html');
		$this->tpl->addTemplateData('main_auto_refresh', array('seconds' => 30));
		$this->tpl->addTemplateData('main', array('auto_refresh' => $this->tpl->getTemplate('main_auto_refresh')));
	}
}

?>