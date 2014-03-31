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
 **/

namespace psm\Module\Server\Controller;
use psm\Service\Database;
use psm\Service\Template;

/**
 * Status module
 */
class StatusController extends AbstractServerController {

	function __construct(Database $db, Template $tpl) {
		parent::__construct($db, $tpl);

		$this->setActions(array('index'), 'index');
	}

	/**
	 * Prepare the template to show a list of all servers
	 * @todo move the background colurs to the config
	 */
	protected function executeIndex() {
		$this->setTemplateId('server_status', 'server/status.tpl.html');
		$this->addFooter(false);

		// get the active servers from database
		$servers = $this->getServers();

		$offline = array();
		$online = array();

		$tpl_data = array(
			'bg' => '#000000',
			'offline_bg' => '#a00000',
			'offline_fg' => '#f7cece',
			'online_bg' => '#53a000',
			'online_fg' => '#d8f7ce',
			'warning_bg' => '#FAA732',
			'warning_fg' => '#F3F3B1',
			'label_last_check' => psm_get_lang('servers', 'last_check'),
			'label_last_online' => psm_get_lang('servers', 'last_online'),
			'label_rtime' => psm_get_lang('servers', 'latency'),
		);
		$this->tpl->addTemplateData($this->getTemplateId(), $tpl_data);

		foreach ($servers as $server) {
			if($server['active'] == 'no') {
				continue;
			}
			$server['last_checked_nice'] = psm_timespan($server['last_check']);
			$server['last_online_nice'] = psm_timespan($server['last_online']);
			$server['url_view'] = psm_build_url(array('mod' => 'server', 'action' => 'view', 'id' => $server['server_id'], 'back_to' => 'server_status'));

			if ($server['status'] == "off") {
				$offline[$server['server_id']] = $server;
			} elseif($server['warning_threshold_counter'] > 0) {
				$server['class_warning'] = 'warning';
				$offline[$server['server_id']] = $server;
			} else {
				$online[$server['server_id']] = $server;
			}
		}

		// add servers to template
		$this->tpl->addTemplateDataRepeat($this->getTemplateId(), 'servers_offline', $offline);
		$this->tpl->addTemplateDataRepeat($this->getTemplateId(), 'servers_online', $online);

		// check if we need to add the auto refresh
		$auto_refresh = psm_get_conf('auto_refresh_servers');
		if(intval($auto_refresh) > 0) {
			// add it
			$this->tpl->newTemplate('main_auto_refresh', 'main.tpl.html');
			$this->tpl->addTemplateData('main_auto_refresh', array('seconds' => $auto_refresh));
			$this->tpl->addTemplateData('main', array('auto_refresh' => $this->tpl->getTemplate('main_auto_refresh')));
		}
	}

	protected function createHTMLLabels() {
		$this->tpl->addTemplateData(
			$this->getTemplateId(),
			array(
				'subtitle' => psm_get_lang('menu', 'server_status'),
			)
		);

		return parent::createHTMLLabels();
	}
}
