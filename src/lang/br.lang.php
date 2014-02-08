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
 * @author      Luiz Alberto S. Ribeiro <madeinnordeste@gmail.com>
 * @copyright   Copyright (c) 2008-2014 Pepijn Over <pep@neanderthal-technology.com>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://phpservermon.neanderthal-technology.com/
 **/

$sm_lang = array(
    'system' => array(
        'title' => 'Server Monitor',
        'servers' => 'Servidores',
        'users' => 'Usuários',
        'log' => 'Log',
		'status' => 'Status',
        'update' => 'Atualização',
        'config' => 'Configuração',
        'help' => 'Ajuda',
		'install' => 'Install',
        'action' => 'Ação',
        'save' => 'Salvar',
        'edit' => 'Editar',
        'delete' => 'Excluir',
        'deleted' => 'Registro excluído',
        'date' => 'Data',
        'message' => 'Mensagem',
        'yes' => 'Sim',
        'no' => 'Não',
        'edit' => 'Editar',
        'insert' => 'Inserir',
        'add_new' => 'Adicionar novo?',
        'update_available' => 'Uma atualização disponível em <a href="http://phpservermon.sourceforge.net" target="_blank">http://phpservermon.sourceforge.net</a>.',
        'back_to_top' => 'Voltar ao topo',
    ),
    'users' => array(
        'user' => 'usuário',
        'name' => 'Nome',
        'mobile' => 'Celular',
        'email' => 'Email',
        'updated' => 'Usuário atualizado.',
        'inserted' => 'Usuário adicionado.',
    ),
    'log' => array(
        'title' => 'Entradas do Log',
        'type' => 'Tipo',
        'status' => 'Status',
        'email' => 'Email',
        'sms' => 'SMS',
    ),
    'servers' => array(
        'server' => 'Servidor',
        'label' => 'Etiqueta',
        'domain' => 'Domínio/IP',
        'port' => 'Porta',
        'type' => 'Tipo',
		'pattern' => 'Search string/pattern',
        'last_check' => 'Última verificação',
        'last_online' => 'Última vez online',
        'monitoring' => 'Monitoramento',
        'send_email' => 'Enviar Email',
        'send_sms' => 'Enviar SMS',
        'updated' => 'Servidor atualizado.',
        'inserted' => 'Servidor adicionar.',
        'rtime' => 'Tempo de resposta',
    ),
    'config' => array(
        'general' => 'Geral',
        'language' => 'Idioma',
        'language_en' => 'Inglês',
        'language_nl' => 'Holandês',
        'language_fr' => 'Francês',
        'language_de' => 'Alemão',
        'language_kr' => 'Koreano',
        'language_br' => 'Portugês - Brasil',
        'show_update' => 'verificar atualizações semanalmente?',
        'email_status' => 'Habilitar envio de email?',
        'email_from_email' => 'Endereço do envio de email',
        'email_from_name' => 'Nome do envio de email',
        'sms_status' => 'Habilitar o envio de mensagem de texto?',
        'sms_gateway' => 'Gateway para o uso de envio de mensagens',
        'sms_gateway_mosms' => 'Mosms',
        'sms_gateway_mollie' => 'Mollie',
        'sms_gateway_spryng' => 'Spryng',
        'sms_gateway_inetworx' => 'Inetworx',
        'sms_gateway_clickatell' => 'Clickatell',
		'sms_gateway_textmarketer' => 'Textmarketer',
        'sms_gateway_username' => 'Usuário do Gateway',
        'sms_gateway_password' => 'Senha do Gateway',
        'sms_from' => 'Número de telefone de envio',
        'alert_type' => 'Selecione como você gostaria de ser notificado.<br/>',
        'alert_type_description' => '<b>Mudança de Status:</b> '.
            'Você receberá uma notificação quando o seridor tive uma mudança de status. De online -> offline ou offline -> online.<br/>'.
            '<br /><b>Offline:</b> '.
            'Você receberá uma notificação quando o servidor fica OFFLINE (Pela primeira vez). Por exemplo, '.
            'A cronjob é a cada 15 minutos e seu servidor caiu em 1:00 e permanece offline até 6 am. '.
            'Você receberá uma notificação a 1:00 apenas<br/>'.
            '<br><b>Sempre:</b> '.
            'Você receberá uma notificação toda vez que o script é executado e um site esta offline, mesmo se o site tenha ficado '.
            'offline por horas.',
        'alert_type_status' => 'Mudança de Status',
        'alert_type_offline' => 'Offline',
        'alert_type_always' => 'Sempre',
        'log_status' => 'Log status<br/><div class="small">Se o status de registro é definido como TRUE, o monitor irá registrar o evento sempre que as configurações de notificação forem passadas</div>',
        'log_email' => 'Registrar no Log os envios de email feitos pelo script?',
        'log_sms' => 'Registrar no Log os envios de mensagens de texto feitos pelo script?',
        'updated' => 'A configuração foi atualizada.',
        'settings_email' => 'Configuração de email',
        'settings_sms' => 'Configuração de mensagens de texto',
        'settings_notification' => 'Configuração de notificações',
        'settings_log' => 'Configuração de Logs',
        'auto_refresh_servers' =>
            'Atualizar automaticamente a página de servidores<br/>'.
            '<div class="small">'.
            'Tempo em segundos, Se 0 a página não será atualizada.'.
            '</div>',
    ),
    // for newlines in the email messages use <br/>
    'notifications' => array(
        'off_sms' => 'Servidor \'%LABEL%\' está OFFLINE: ip=%IP%, porta=%PORT%. Erro=%ERROR%',
        'off_email_subject' => 'IMPORTANTE: Servidor \'%LABEL%\' está OFFLINE',
        'off_email_body' => "Falha ao conectar ao servidor:<br/><br/>Servidor: %LABEL%<br/>IP: %IP%<br/>Porta: %PORT%<br/>Erro: %ERROR%<br/>Data: %DATE%",
        'on_sms' => 'Servidor \'%LABEL%\' esta ONLINE: ip=%IP%, porta=%PORT%',
        'on_email_subject' => 'IMPORTANTE: Servidor \'%LABEL%\' esta ONLINE',
        'on_email_body' => "Servidor '%LABEL%' esta ONLINE novamente:<br/><br/>Servidor: %LABEL%<br/>IP: %IP%<br/>Porta: %PORT%<br/>Data: %DATE%",
    ),
);

?>