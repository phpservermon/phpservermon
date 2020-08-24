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
 * @author      Pepijn Over <pep@mailbox.org>
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

namespace psm\Module\Server\Controller;

use psm\Service\Database;

/**
 * Status module
 */
class StatusController extends AbstractServerController
{

    public function __construct(Database $db, \Twig_Environment $twig)
    {
        parent::__construct($db, $twig);

        $this->setCSRFKey('status');
        $this->setActions(array('index', 'saveLayout'), 'index');
    }

    /**
     * Prepare the template to show a list of all servers
     */
    protected function executeIndex()
    {
        // set background color to black
        $this->black_background = true;
        $this->twig->addGlobal('subtitle', psm_get_lang('menu', 'server_status'));

        // add header accessories
        $layout = $this->getUser()->getUserPref('status_layout', 0);
        $layout_data = array(
            'label_none' => psm_get_lang('system', 'none'),
            'label_last_check' => psm_get_lang('servers', 'last_check'),
            'label_last_online' => psm_get_lang('servers', 'last_online'),
            'label_last_offline' => psm_get_lang('servers', 'last_offline'),
            'label_online' => psm_get_lang('servers', 'online'),
            'label_offline' => psm_get_lang('servers', 'offline'),
            'label_rtime' => psm_get_lang('servers', 'latency'),
            'block_layout_active' => ($layout == 0) ? 'active' : '',
            'list_layout_active' => ($layout != 0) ? 'active' : '',
            'label_add_server' => psm_get_lang('system', 'add_new'),
            'layout' => $layout,
            'url_save' => psm_build_url(array('mod' => 'server', 'action' => 'edit')),
        );
        $this->setHeaderAccessories($this->twig->render('module/server/status/header.tpl.html', $layout_data));

        $this->addFooter(false);

        // get the active servers from database
        $servers = $this->getServers();

        $layout_data['servers_offline'] = array();
        $layout_data['servers_warning'] = array();
        $layout_data['servers_online'] = array();

        foreach ($servers as $server) {
            if ($server['active'] == 'no') {
                continue;
            }
            $server['last_checked_nice'] = psm_timespan($server['last_check']);
            $server['last_online_nice'] = psm_timespan($server['last_online']);
            $server['last_offline_nice'] = psm_timespan($server['last_offline']);
            $server['last_offline_duration_nice'] = "";
            if ($server['last_offline_nice'] != psm_get_lang('system', 'never')) {
                $server['last_offline_duration_nice'] = "(" . $server['last_offline_duration'] . ")";
            }
            $server['url_view'] = psm_build_url(
                array('mod' => 'server', 'action' => 'view', 'id' => $server['server_id'], 'back_to' => 'server_status')
            );

            if ($server['status'] == "off") {
                $layout_data['servers_offline'][] = $server;
            } elseif ($server['warning_threshold_counter'] > 0) {
                $layout_data['servers_warning'][] = $server;
            } elseif ($server['ssl_cert_expired_time'] !== null && $server['ssl_cert_expiry_days'] > 0) {
                $layout_data['servers_warning'][] = $server;
            } else {
                $layout_data['servers_online'][] = $server;
            }
        }

        $auto_refresh_seconds = psm_get_conf('auto_refresh_servers');
        if (intval($auto_refresh_seconds) > 0) {
            $this->twig->addGlobal('auto_refresh', true);
            $this->twig->addGlobal('auto_refresh_seconds', $auto_refresh_seconds);
        }

        if ($this->isXHR() || isset($_SERVER["HTTP_X_REQUESTED_WITH"])) {
            $this->xhr = true;
            //disable auto refresh in ajax return html
            $layout_data["auto_refresh"] = 0;
        }

        return $this->twig->render('module/server/status/index.tpl.html', $layout_data);
    }

    protected function executeSaveLayout()
    {
        if ($this->isXHR()) {
            $layout = psm_POST('layout', 0);
            $this->getUser()->setUserPref('status_layout', $layout);

            $response = new \Symfony\Component\HttpFoundation\JsonResponse();
            $response->setData(array(
                'layout' => $layout,
            ));
            return $response;
        }
    }
}
