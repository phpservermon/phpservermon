<?php

namespace psm\Module\Consult\Controller;

use psm\Module\AbstractController;
use psm\Module\Consult\Controller\AbstractConsultServerController;
use psm\Module\Server\Controller\AbstractServerController;
use psm\Service\Database;

class ConsultController extends AbstractConsultServerController
{
    public $server_id;
    public $ip;
    public $id;

    function __construct(Database $db, \Twig_Environment $twig)
    {
        parent::__construct($db, $twig);
        $this->ip = isset($_GET['ip']) ? $_GET['ip'] : "";
        $this->setActions(array(
            'view',
        ), 'index');
        $this->setMinUserLevelRequiredForAction(PSM_USER_ANONYMOUS, []);
        $this->setMinUserLevelRequired(PSM_USER_ANONYMOUS);
    }

    protected function executeView()
    {
        $sql = 'SELECT server_id  FROM ' . PSM_DB_PREFIX . 'servers WHERE label = "' . $this->ip . '"';
        $server_id = $this->db->query($sql);

        if (empty($server_id)) {
            $tpl_data = $this->getError();
            return $this->twig->render('module/error/401.tpl.html', $tpl_data);
        } else
            $id = $server_id[0]['server_id'];
            $this->id = $id;
            $server = $this->getServers($this->id);
            $tpl_data = $this->getLabels();
            $tpl_data = array_merge($tpl_data, $this->formatServer($server));
            $history = new \psm\Util\Server\HistoryGraph($this->db, $this->twig);
            $tpl_data['html_history'] = $history->createHTML($this->id);
            $sidebar = new \psm\Util\Module\Sidebar($this->twig);
            $this->setSidebar($sidebar);
            return $this->twig->render('module/consult/consult.tpl.html', $tpl_data);
    }

    protected function getError()
    {
        return array(
            'label_title' => "Erreur",
            'label_description' => "Vous n'avez pas saisi la bonne adresse !"
        );
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
            'label_send_pushover' => psm_get_lang('servers', 'send_pushover'),
            'label_telegram' => psm_get_lang('servers', 'telegram'),
            'label_jabber' => psm_get_lang('servers', 'jabber'),
            'label_pushover' => psm_get_lang('servers', 'pushover'),
            'label_send_telegram' => psm_get_lang('servers', 'send_telegram'),
            'label_send_jabber' => psm_get_lang('servers', 'send_jabber'),
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
            'label_seconds' => psm_get_lang('config', 'seconds'),
            'label_online' => psm_get_lang('servers', 'online'),
            'label_offline' => psm_get_lang('servers', 'offline'),
            'label_ok' => psm_get_lang('system', 'ok'),
            'label_bad' => psm_get_lang('system', 'bad'),
            'default_value_timeout' => PSM_CURL_TIMEOUT,
            'label_settings' => psm_get_lang('system', 'settings'),
            'label_output' => psm_get_lang('servers', 'output'),
            'label_search' => psm_get_lang('system', 'search'),
        );
    }
}