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
 **/

namespace psm\Module\Server\Controller;

use psm\Service\Database;

/**
 * Server module. Add/edit/delete servers, show a list of all servers etc.
 */
class ServerController extends AbstractServerController
{

    /**
     * Current server id
     * @var int|\PDOStatement $server_id
     */
    protected $server_id;

    public function __construct(Database $db, \Twig_Environment $twig)
    {
        parent::__construct($db, $twig);

        $this->server_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        $this->setCSRFKey('server');
        $this->setActions(array(
            'index', 'edit', 'save', 'delete', 'view',
        ), 'index');

        // make sure only admins are allowed to edit/delete servers:
        $this->setMinUserLevelRequiredForAction(PSM_USER_ADMIN, array(
            'delete', 'edit', 'save'
        ));
        $this->twig->addGlobal('subtitle', psm_get_lang('menu', 'server'));
    }

    /**
     * Prepare the template to show a list of all servers
     */
    protected function executeIndex()
    {
        $tpl_data = $this->getLabels();
        $tpl_data['user_level'] = $this->getUser()->getUserLevel();
        $sidebar = new \psm\Util\Module\Sidebar($this->twig);
        $this->setSidebar($sidebar);

        // check if user is admin, in that case we add the buttons
        if ($this->getUser()->getUserLevel() == PSM_USER_ADMIN) {
            $modal = new \psm\Util\Module\Modal($this->twig, 'delete', \psm\Util\Module\Modal::MODAL_TYPE_DANGER);
            $this->addModal($modal);
            $modal->setTitle(psm_get_lang('servers', 'delete_title'));
            $modal->setMessage(psm_get_lang('servers', 'delete_message'));
            $modal->setOKButtonLabel(psm_get_lang('system', 'delete'));

            $sidebar->addButton(
                'add_new',
                psm_get_lang('system', 'add_new'),
                psm_build_url(array('mod' => 'server', 'action' => 'edit')),
                'plus',
                'success',
                psm_get_lang('system', 'add_new')
            );
        }

        $sidebar->addButton(
            'update',
            psm_get_lang('menu', 'server_update'),
            psm_build_url(array('mod' => 'server_update')),
            'sync-alt',
            'primary',
            psm_get_lang('menu', 'server_update')
        );

        $icons = array(
            'email' => 'icon-envelope',
            'sms' => 'icon-mobile',
            'discord' => 'icon-discord',
            'pushover' => 'icon-pushover',
            'webhook' => 'icon-webhook',
            'telegram' => 'icon-telegram',
            'jabber' => 'icon-jabber'
        );

        $servers = $this->getServers();
        $server_count = count($servers);

        for ($x = 0; $x < $server_count; $x++) {
            if ($servers[$x]['type'] == 'website') {
                // add link to label
                $ip = $servers[$x]['ip'];
                $servers[$x]['ip'] = '<a href="' . $servers[$x]['ip'] .
                    '" target="_blank" rel="noopener">' . $ip . '</a>';
            }
            if ($servers[$x]['type'] == 'ping') {
                $servers[$x]['port'] = '';
            }
            if (($servers[$x]['active'] == 'yes')) {
                $servers[$x]['active_title'] = psm_get_lang('servers', 'monitoring');
            } else {
                $servers[$x]['active_title'] = psm_get_lang('servers', 'no_monitoring');
            }

            $servers[$x] = $this->formatServer($servers[$x]);
        }
        $tpl_data['servers'] = $servers;

        $tpl_data['config']['email'] = psm_get_conf('email_status');
        $tpl_data['config']['sms'] = psm_get_conf('sms_status');
        $tpl_data['config']['discord'] = psm_get_conf('discord_status');
        $tpl_data['config']['webhook'] = psm_get_conf('webhook_status');
        $tpl_data['config']['pushover'] = psm_get_conf('pushover_status');
        $tpl_data['config']['telegram'] = psm_get_conf('telegram_status');

        return $this->twig->render('module/server/server/list.tpl.html', $tpl_data);
    }

    /**
     * Prepare the template to show the update screen for a single server
     */
    protected function executeEdit()
    {
        $back_to = isset($_GET['back_to']) ? $_GET['back_to'] : '';

        $modal = new \psm\Util\Module\Modal($this->twig, 'delete', \psm\Util\Module\Modal::MODAL_TYPE_DANGER);
        $this->addModal($modal);
        $modal->setTitle(psm_get_lang('servers', 'delete_title'));
        $modal->setMessage(psm_get_lang('servers', 'delete_message'));
        $modal->setOKButtonLabel(psm_get_lang('system', 'delete'));

        $tpl_data = $this->getLabels();
        $tpl_data['edit_server_id'] = $this->server_id;
        $tpl_data['url_save'] = psm_build_url(array(
            'mod' => 'server',
            'action' => 'save',
            'id' => $this->server_id,
            'back_to' => $back_to,
        ));
        $tpl_data['url_delete'] = psm_build_url(array(
            'mod' => 'server',
            'action' => 'delete',
            'id' => $this->server_id,
        ));

        // depending on where the user came from, add the go back url:
        if ($back_to == 'view' && $this->server_id > 0) {
            $tpl_data['url_go_back'] = psm_build_url(
                array('mod' => 'server', 'action' => 'view', 'id' => $this->server_id)
            );
        } else {
            $tpl_data['url_go_back'] = psm_build_url(array('mod' => 'server'));
        }

        $tpl_data['users'] = $this->db->select(PSM_DB_PREFIX . 'users', null, array('user_id', 'name'), '', 'name');

        foreach ($tpl_data['users'] as &$user) {
            $user['id'] = $user['user_id'];
            unset($user['user_id']);
            $user['label'] = $user['name'];
            unset($user['name']);
        }

        switch ($this->server_id) {
            case 0:
                // insert mode
                $tpl_data['titlemode'] = psm_get_lang('system', 'insert');
                $tpl_data['edit_value_warning_threshold'] = '1';

                $edit_server = $_POST;
                break;
            default:
                // edit mode
                // get server entry
                $edit_server = $this->getServers($this->server_id);
                if (empty($edit_server)) {
                    $this->addMessage(psm_get_lang('servers', 'error_server_no_match'), 'error');
                    return $this->runAction('index');
                }
                $tpl_data['titlemode'] = psm_get_lang('system', 'edit') . ' ' . $edit_server['label'];

                $user_idc_selected = $this->getServerUsers($this->server_id);
                foreach ($tpl_data['users'] as &$user) {
                    if (in_array($user['id'], $user_idc_selected)) {
                        $user['edit_selected'] = 'selected="selected"';
                    }
                }

                break;
        }

        if (!empty($edit_server)) {
            // attempt to prefill previously posted fields
            foreach ($edit_server as $key => $value) {
                $edit_server[$key] = psm_POST($key, $value);
            }

            $tpl_data = array_merge($tpl_data, array(
                'edit_value_label' => $edit_server['label'],
                'edit_value_ip' => $edit_server['ip'],
                'edit_value_port' => $edit_server['port'],
                'edit_value_request_method' => $edit_server['request_method'],
                'edit_value_post_field' => $edit_server['post_field'],
                'edit_value_timeout' => $edit_server['timeout'],
                'edit_value_pattern' => $edit_server['pattern'],
                'edit_pattern_selected_' . $edit_server['pattern_online'] => 'selected="selected"',
                'edit_redirect_check_selected_' . $edit_server['redirect_check'] => 'selected="selected"',
                'edit_value_allow_http_status' => $edit_server['allow_http_status'],
                'edit_value_header_name' => $edit_server['header_name'],
                'edit_value_header_value' => $edit_server['header_value'],
                'edit_value_warning_threshold' => $edit_server['warning_threshold'],
                'edit_value_website_username' => $edit_server['website_username'],
                'edit_value_website_password' => empty($edit_server['website_password']) ? '' :
                    sha1($edit_server['website_password']),
                'edit_value_ssl_cert_expiry_days' => $edit_server['ssl_cert_expiry_days'],
                'edit_type_selected_' . $edit_server['type'] => 'selected="selected"',
                'edit_active_selected' => $edit_server['active'],
                'edit_email_selected' => $edit_server['email'],
                'edit_sms_selected' => $edit_server['sms'],
                'edit_discord_selected' => $edit_server['discord'],
                'edit_webhook_selected' => $edit_server['webhook'],
                'edit_pushover_selected' => $edit_server['pushover'],
                'edit_telegram_selected' => $edit_server['telegram'],
                'edit_jabber_selected' => $edit_server['jabber'],
            ));
        }

        $notifications = array('email', 'sms', 'pushover', 'discord', 'webhook', 'telegram', 'jabber');
        foreach ($notifications as $notification) {
            if (psm_get_conf($notification . '_status') == 0) {
                $tpl_data['warning_' . $notification] = true;
                $tpl_data['label_warning_' . $notification] = psm_get_lang(
                    'servers',
                    'warning_notifications_disabled_' . $notification
                );
            } else {
                $tpl_data['warning_' . $notification] = false;
            }
        }

        return $this->twig->render('module/server/server/update.tpl.html', $tpl_data);
    }

    /**
     * Executes the saving of one of the servers
     */
    protected function executeSave()
    {
        if (empty($_POST)) {
            // dont process anything if no data has been posted
            return $this->executeIndex();
        }

        // We need the server id to encrypt the password. Encryption will be done after the server is added
        $encrypted_password = '';

        if (!empty($_POST['website_password'])) {
            $new_password = psm_POST('website_password');

            if ($this->server_id > 0) {
                $edit_server = $this->getServers($this->server_id);
                $hash = sha1($edit_server['website_password']);

                if ($new_password == $hash) {
                    $encrypted_password = $edit_server['website_password'];
                } else {
                    $encrypted_password = psm_password_encrypt(strval($this->server_id) .
                        psm_get_conf('password_encrypt_key'), $new_password);
                }
            }
        }

        $clean = array(
            'label' => trim(strip_tags(psm_POST('label', ''))),
            'ip' => trim(strip_tags(psm_POST('ip', ''))),
            'timeout' => (isset($_POST['timeout']) && intval($_POST['timeout']) > 0) ? intval($_POST['timeout']) : 10,
            'website_username' => psm_POST('website_username'),
            'website_password' => $encrypted_password,
            'port' => intval(psm_POST('port', 0)),
            'request_method' => empty(psm_POST('request_method')) ? null : psm_POST('request_method'),
            'post_field' => empty(psm_POST('post_field')) ? null : psm_POST('post_field'),
            'type' => psm_POST('type', ''),
            'pattern' => psm_POST('pattern', ''),
            'pattern_online' => in_array($_POST['pattern_online'], array('yes', 'no')) ?
                $_POST['pattern_online'] : 'yes',
            'redirect_check' => in_array($_POST['redirect_check'], array('ok', 'bad')) ?
                $_POST['redirect_check'] : 'bad',
            'allow_http_status' => psm_POST('allow_http_status', ''),
            'header_name' => psm_POST('header_name', ''),
            'header_value' => psm_POST('header_value', ''),
            'warning_threshold' => intval(psm_POST('warning_threshold', 0)),
            'ssl_cert_expiry_days' => intval(psm_POST('ssl_cert_expiry_days', 1)),
            'active' => in_array($_POST['active'], array('yes', 'no')) ? $_POST['active'] : 'no',
            'email' => in_array($_POST['email'], array('yes', 'no')) ? $_POST['email'] : 'no',
            'sms' => in_array($_POST['sms'], array('yes', 'no')) ? $_POST['sms'] : 'no',
            'discord' => in_array($_POST['discord'], array('yes', 'no')) ? $_POST['discord'] : 'no',
            'pushover' => in_array($_POST['pushover'], array('yes', 'no')) ? $_POST['pushover'] : 'no',
            'webhook' => in_array($_POST['webhook'], array('yes', 'no')) ? $_POST['webhook'] : 'no',
            'telegram' => in_array($_POST['telegram'], array('yes', 'no')) ? $_POST['telegram'] : 'no',
            'jabber' => in_array($_POST['jabber'], array('yes', 'no')) ? $_POST['jabber'] : 'no',
        );
        // make sure websites start with http://
        if (
            $clean['type'] == 'website' &&
                substr($clean['ip'], 0, 4) != 'http' &&
                substr($clean['ip'], 0, 3) != 'rdp'
        ) {
            $clean['ip'] = 'http://' . $clean['ip'];
        }

        if ($clean['request_method'] == null) {
            $clean['post_field'] = null;
        }

        // validate the lot
        $server_validator = new \psm\Util\Server\ServerValidator($this->db);

        // format port from http, https or rdp url
        if ($clean['type'] == 'website') {
            $tmp = parse_url($clean["ip"]);
            if (isset($tmp["port"])) {
                $clean["port"] = $tmp["port"];
            } elseif ($tmp["scheme"] === "https") {
                $clean["port"] = 443;
            } elseif ($tmp["scheme"] === "http") {
                $clean["port"] = 80;
            } elseif ($tmp["scheme"] === "rdp") {
                $clean["port"] = 3389;
            }
        }

        try {
            if ($this->server_id > 0) {
                $server_validator->serverId($this->server_id);
            }
            $server_validator->label($clean['label']);
            $server_validator->type($clean['type']);
            $server_validator->ip($clean['ip'], $clean['type']);
            $server_validator->warningThreshold($clean['warning_threshold']);
            $server_validator->sslCertExpiryDays($clean['ssl_cert_expiry_days']);
        } catch (\InvalidArgumentException $ex) {
            $this->addMessage(psm_get_lang('servers', 'error_' . $ex->getMessage()), 'error');
            return $this->executeEdit();
        }

        // check for edit or add
        if ($this->server_id > 0) {
            // edit
            $this->db->save(
                PSM_DB_PREFIX . 'servers',
                $clean,
                array('server_id' => $this->server_id)
            );
            $this->addMessage(psm_get_lang('servers', 'updated'), 'success');
        } else {
            // add
            $clean['status'] = 'on';
            $this->server_id = $this->db->save(PSM_DB_PREFIX . 'servers', $clean);

            // server has been added, re-encrypt
            if (!empty($_POST['website_password'])) {
                $cleanWebsitePassword = array(
                    'website_password' => psm_password_encrypt(
                        strval($this->server_id) . psm_get_conf('password_encrypt_key'),
                        psm_POST('website_password')
                    ),
                );

                $this->db->save(
                    PSM_DB_PREFIX . 'servers',
                    $cleanWebsitePassword,
                    array('server_id' => $this->server_id)
                );
            }

            $this->addMessage(psm_get_lang('servers', 'inserted'), 'success');
        }

        // update users
        $user_idc = psm_POST('user_id', array());
        $user_idc_save = array();

        foreach ($user_idc as $user_id) {
            $user_idc_save[] = array(
                'user_id' => intval($user_id),
                'server_id' => intval($this->server_id),
            );
        }
        $this->db->delete(PSM_DB_PREFIX . 'users_servers', array('server_id' => $this->server_id));
        if (!empty($user_idc_save)) {
            // add all new users
            $this->db->insertMultiple(PSM_DB_PREFIX . 'users_servers', $user_idc_save);
        }

        $back_to = isset($_GET['back_to']) ? $_GET['back_to'] : 'index';
        if ($back_to == 'view') {
            return $this->runAction('view');
        } else {
            return $this->runAction('index');
        }
    }

    /**
     * Executes the deletion of one of the servers
     */
    protected function executeDelete()
    {
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            // do delete
            $res = $this->db->delete(PSM_DB_PREFIX . 'servers', array('server_id' => $id));

            if ($res === 1) {
                $this->db->delete(PSM_DB_PREFIX . 'log', array('server_id' => $id));
                $this->db->delete(PSM_DB_PREFIX . 'users_servers', array('server_id' => $id));
                $this->db->delete(PSM_DB_PREFIX . 'servers_uptime', array('server_id' => $id));
                $this->db->delete(PSM_DB_PREFIX . 'servers_history', array('server_id' => $id));
            }
            $this->addMessage(psm_get_lang('servers', 'deleted'), 'success');
        }
        return $this->runAction('index');
    }

    /**
     * Prepare the view template
     */
    protected function executeView()
    {
        if ($this->server_id == 0) {
            return $this->runAction('index');
        }
        $server = $this->getServers($this->server_id);

        if (empty($server)) {
            return $this->runAction('index');
        }

        $tpl_data = $this->getLabels();
        $tpl_data = array_merge($tpl_data, $this->formatServer($server));

        // create history HTML
        $history = new \psm\Util\Server\HistoryGraph($this->db, $this->twig);
        $tpl_data['html_history'] = $history->createHTML($this->server_id);

        $sidebar = new \psm\Util\Module\Sidebar($this->twig);
        $this->setSidebar($sidebar);

        // check which module the user came from, and add a link accordingly
        $back_to = isset($_GET['back_to']) && ($_GET['back_to'] == 'server_status' || $_GET['back_to'] == 'user') ?
            $_GET['back_to'] : 'server';
        $sidebar->addButton(
            'go_back',
            psm_get_lang('system', 'go_back'),
            psm_build_url(array('mod' => $back_to)),
            'angle-left',
            'link',
            psm_get_lang('system', 'go_back')
        );

        // add edit/delete buttons for admins
        if ($this->getUser()->getUserLevel() == PSM_USER_ADMIN) {
            $tpl_data['has_admin_actions'] = true;
            $tpl_data['url_edit'] = psm_build_url(
                array('mod' => 'server', 'action' => 'edit', 'id' => $this->server_id, 'back_to' => 'view')
            );

            $modal = new \psm\Util\Module\Modal($this->twig, 'delete', \psm\Util\Module\Modal::MODAL_TYPE_DANGER);
            $this->addModal($modal);
            $modal->setTitle(psm_get_lang('servers', 'delete_title'));
            $modal->setMessage(psm_get_lang('servers', 'delete_message'));
            $modal->setOKButtonLabel(psm_get_lang('system', 'delete'));

            $sidebar->addButton(
                'edit',
                psm_get_lang('system', 'edit'),
                psm_build_url(
                    array('mod' => 'server', 'action' => 'edit', 'id' => $this->server_id, 'back_to' => 'view')
                ),
                'edit',
                'primary',
                psm_get_lang('system', 'edit')
            );
        }

        // add all available servers to the menu
        $servers = $this->getServers();
        $tpl_data['options'] = array();
        foreach ($servers as $i => $server_available) {
            $tpl_data['options'][] = array(
                'class_active' => ($server_available['server_id'] == $this->server_id) ? 'active' : '',
                'url' => psm_build_url(
                    array('mod' => 'server', 'action' => 'view', 'id' => $server_available['server_id'])
                ),
                'label' => $server_available['label'],
            );
        }
                
        $tpl_data['last_output_truncated'] = $tpl_data['last_output'];
        $tpl_data['last_error_output_truncated'] = $tpl_data['last_error_output'];
                
        if (strlen($tpl_data['last_output']) > 255) {
            $tpl_data['last_output_truncated'] = substr($tpl_data['last_output'], 0, 255) . '...';
        }
                
        if (strlen($tpl_data['last_error_output']) > 255) {
            $tpl_data['last_error_output_truncated'] = substr($tpl_data['last_error_output'], 0, 255) . '...';
        }

        // fetch server status logs
        $log_entries = $this->getServerLogs($this->server_id);
        for ($x = 0; $x < count($log_entries); $x++) {
            $record = &$log_entries[$x];
            $record['datetime_format'] = psm_date($record['datetime']);
        }

        $tpl_data['log_entries'] = $log_entries;
                
        return $this->twig->render('module/server/server/view.tpl.html', $tpl_data);
    }

    protected function getLabels()
    {
        return array(
            'label_label' => psm_get_lang('servers', 'label'),
            'label_status' => psm_get_lang('servers', 'status'),
            'label_domain' => psm_get_lang('servers', 'domain'),
            'label_timeout' => psm_get_lang('servers', 'timeout'),
            'label_timeout_description' => psm_get_lang('servers', 'timeout_description'),
            'label_authentication_settings' => psm_get_lang('servers', 'authentication_settings'),
            'label_optional' => psm_get_lang('servers', 'optional'),
            'label_website_username' => psm_get_lang('servers', 'website_username'),
            'label_website_username_description' => psm_get_lang('servers', 'website_username_description'),
            'label_website_password' => psm_get_lang('servers', 'website_password'),
            'label_website_password_description' => psm_get_lang('servers', 'website_password_description'),
            'label_fieldset_monitoring' => psm_get_lang('servers', 'fieldset_monitoring'),
            'label_fieldset_permissions' => psm_get_lang('servers', 'fieldset_permissions'),
            'label_permissions' => psm_get_lang('servers', 'permissions'),
            'label_port' => psm_get_lang('servers', 'port'),
            'label_custom_port' => psm_get_lang('servers', 'custom_port'),
            'label_popular_ports' => psm_get_lang('servers', 'popular_ports'),
            'label_request_method' => psm_get_lang('servers', 'request_method'),
            'label_custom_request_method' => psm_get_lang('servers', 'custom_request_method'),
            'label_popular_request_methods' => psm_get_lang('servers', 'popular_request_methods'),
            'label_post_field' => psm_get_lang('servers', 'post_field'),
            'label_post_field_description' => psm_get_lang('servers', 'post_field_description'),
            'label_none' => psm_get_lang('system', 'none'),
            'label_please_select' => psm_get_lang('servers', 'please_select'),
            'label_type' => psm_get_lang('servers', 'type'),
            'label_website' => psm_get_lang('servers', 'type_website'),
            'label_service' => psm_get_lang('servers', 'type_service'),
            'label_ping' => psm_get_lang('servers', 'type_ping'),
            'label_pattern' => psm_get_lang('servers', 'pattern'),
            'label_pattern_description' => psm_get_lang('servers', 'pattern_description'),
            'label_pattern_online' => psm_get_lang('servers', 'pattern_online'),
            'label_pattern_online_description' => psm_get_lang('servers', 'pattern_online_description'),
            'label_redirect_check' => psm_get_lang('servers', 'redirect_check'),
            'label_redirect_check_description' => psm_get_lang('servers', 'redirect_check_description'),
            'label_allow_http_status' => psm_get_lang('servers', 'allow_http_status'),
            'label_allow_http_status_description' => psm_get_lang('servers', 'allow_http_status_description'),
            'label_header_name' => psm_get_lang('servers', 'header_name'),
            'label_header_value' => psm_get_lang('servers', 'header_value'),
            'label_header_name_description' => psm_get_lang('servers', 'header_name_description'),
            'label_header_value_description' => psm_get_lang('servers', 'header_value_description'),
            'label_last_check' => psm_get_lang('servers', 'last_check'),
            'label_rtime' => psm_get_lang('servers', 'latency'),
            'label_last_online' => psm_get_lang('servers', 'last_online'),
            'label_last_offline' => psm_get_lang('servers', 'last_offline'),
            'label_last_output' => psm_get_lang('servers', 'last_output'),
            'label_last_error' => psm_get_lang('servers', 'last_error'),
            'label_last_error_output' => psm_get_lang('servers', 'last_error_output'),
            'label_monitoring' => psm_get_lang('servers', 'monitoring'),
            'label_email' => psm_get_lang('servers', 'email'),
            'label_send_email' => psm_get_lang('servers', 'send_email'),
            'label_sms' => psm_get_lang('servers', 'sms'),
            'label_send_sms' => psm_get_lang('servers', 'send_sms'),
            'label_discord' => psm_get_lang('servers', 'discord'),
            'label_send_discord' => psm_get_lang('servers', 'send_discord'),
            'label_pushover' => psm_get_lang('servers', 'pushover'),
            'label_send_pushover' => psm_get_lang('servers', 'send_pushover'),
            'label_send_webhook' => psm_get_lang('servers', 'send_webhook'),
            'label_telegram' => psm_get_lang('servers', 'telegram'),
            'label_jabber' => psm_get_lang('servers', 'jabber'),
            'label_send_jabber' => psm_get_lang('servers', 'send_jabber'),
            'label_webhook' => psm_get_lang('servers', 'webhook'),
            'label_pushover' => psm_get_lang('servers', 'pushover'),
            'label_send_telegram' => psm_get_lang('servers', 'send_telegram'),
            'label_users' => psm_get_lang('servers', 'users'),
            'label_warning_threshold' => psm_get_lang('servers', 'warning_threshold'),
            'label_warning_threshold_description' => psm_get_lang('servers', 'warning_threshold_description'),
            'label_ssl_cert_expiry_days' => psm_get_lang('servers', 'ssl_cert_expiry_days'),
            'label_ssl_cert_expiry_days_description' => psm_get_lang('servers', 'ssl_cert_expiry_days_description'),
            'label_action' => psm_get_lang('system', 'action'),
            'label_save' => psm_get_lang('system', 'save'),
            'label_go_back' => psm_get_lang('system', 'go_back'),
            'label_edit' => psm_get_lang('system', 'edit'),
            'label_delete' => psm_get_lang('system', 'delete'),
            'label_view' => psm_get_lang('system', 'view'),
            'label_yes' => psm_get_lang('system', 'yes'),
            'label_no' => psm_get_lang('system', 'no'),
            'label_add_new' => psm_get_lang('system', 'add_new'),
            'label_seconds' => psm_get_lang('system', 'seconds'),
            'label_milliseconds' => psm_get_lang('system', 'milliseconds'),
            'label_online' => psm_get_lang('servers', 'online'),
            'label_offline' => psm_get_lang('servers', 'offline'),
            'label_ok' => psm_get_lang('system', 'ok'),
            'label_bad' => psm_get_lang('system', 'bad'),
            'default_value_timeout' => PSM_CURL_TIMEOUT,
            'label_settings' => psm_get_lang('system', 'settings'),
            'label_output' => psm_get_lang('servers', 'output'),
            'label_search' => psm_get_lang('system', 'search'),
            'label_log_title' => psm_get_lang('log', 'title'),
            'label_log_no_logs' => psm_get_lang('log', 'no_logs'),
            'label_date' => psm_get_lang('system', 'date'),
            'label_message' => psm_get_lang('system', 'message'),
        );
    }

    /**
     * Get all user ids for a server
     * @param int $server_id
     * @return array with ids only
     */
    protected function getServerUsers($server_id)
    {
        $users = $this->db->select(
            PSM_DB_PREFIX . 'users_servers',
            array('server_id' => $server_id),
            array('user_id')
        );
        $result = array();
        foreach ($users as $user) {
            $result[] = $user['user_id'];
        }
        return $result;
    }

    /**
     * Get logs for a server
     * @param int $server_id
     * @param string $type status/email/sms
     * @return \PDOStatement array
     */
    protected function getServerLogs($server_id, $type = 'status')
    {
        $sql_join = '';
        if ($this->getUser()->getUserLevel() > PSM_USER_ADMIN) {
            // restrict by user_id
            $sql_join = "JOIN `" . PSM_DB_PREFIX . "users_servers` AS `us` ON (
						`us`.`user_id`={$this->getUser()->getUserId()}
						AND `us`.`server_id`=`servers`.`server_id`
						)";
        }
        $entries = $this->db->query(
            'SELECT ' .
            '`servers`.`label`, ' .
            '`servers`.`ip`, ' .
            '`servers`.`port`, ' .
            '`servers`.`type` AS server_type, ' .
            '`log`.`log_id`, ' .
            '`log`.`type`, ' .
            '`log`.`message`, ' .
            '`log`.`datetime` ' .
            'FROM `' . PSM_DB_PREFIX . 'log` AS `log` ' .
            'JOIN `' . PSM_DB_PREFIX . 'servers` AS `servers` ON (`servers`.`server_id`=`log`.`server_id`) ' .
            $sql_join .
            'WHERE `log`.`type`=\'' . $type . '\' ' .
            'AND `log`.`server_id`=' . $server_id . ' ' .
            'ORDER BY `datetime` DESC ' .
            'LIMIT 0,20'
        );

        return $entries;
    }
}
