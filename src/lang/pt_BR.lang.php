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
 * @link        http://www.phpservermonitor.org/
 **/

$sm_lang = array(
	'name' => 'Português - Brazilian portuguese',
    'system' => array(
        'title' => 'Server Monitor',
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
        'add_new' => 'Adicionar novo',
        'update_available' => 'Uma atualização ({version}) disponível em <a href="http://www.phpservermonitor.org" target="_blank">http://www.phpservermonitor.org</a>.',
        'back_to_top' => 'Voltar ao topo',
		'go_back' => 'Go back',
		// date/time format according the strftime php function format parameter http://php.net/manual/function.strftime.php
		'short_day_format' => '%B %e',
		'long_day_format' => '%B %e, %Y',
		'yesterday_format' => 'Yesterday at %k:%M',
		'other_day_format' => '%A at %k:%M',
		'never' => 'Never',
		'hours_ago' => '%d hours ago',
		'an_hour_ago' => 'about an hour ago',
		'minutes_ago' => '%d minutes ago',
		'a_minute_ago' => 'about a minute ago',
		'seconds_ago' => '%d seconds ago',
		'a_second_ago' => 'a second ago',
    ),
	'menu' => array(
		'config' => 'Configuração',
		'server' => 'Servidores',
		'server_log' => 'Log',
		'server_status' => 'Status',
		'server_update' => 'Atualização',
		'user' => 'Usuários',
		'help' => 'Ajuda',
	),
    'users' => array(
        'user' => 'usuário',
        'name' => 'Nome',
		'user_name' => 'Username',
		'password' => 'Password',
		'password_repeat' => 'Password repeat',
		'password_leave_blank' => 'Leave blank to keep unchanged',
		'level' => 'Level',
		'level_10' => 'Administrator',
		'level_20' => 'User',
		'level_description' => '<b>Administrators</b> have full access: they can manage servers, users and edit the global configuration.<br/><b>Users</b> can only view and run the updater for the servers that have been assigned to them.',
        'mobile' => 'Celular',
        'email' => 'Email',
        'updated' => 'Usuário atualizado.',
        'inserted' => 'Usuário adicionado.',
		'profile' => 'Profile',
		'profile_updated' => 'Your profile has been updated.',
		'error_user_name_bad_length' => 'Usernames must be between 2 and 64 characters.',
		'error_user_name_invalid' => 'It may only contain alphabetic characters (a-z, A-Z), digits (0-9) and underscores (_).',
		'error_user_name_exists' => 'The given username already exists in the database.',
		'error_user_email_bad_length' => 'Email addresses must be between 5 and 255 characters.',
		'error_user_email_invalid' => 'The email address is invalid.',
		'error_user_level_invalid' => 'The given user level is invalid.',
		'error_user_no_match' => 'The user could not be found in the database.',
		'error_user_password_invalid' => 'The entered password is invalid.',
		'error_user_password_no_match' => 'The entered passwords do not match.',
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
		'type_website' => 'Website',
		'type_service' => 'Service',
		'pattern' => 'Search string/pattern',
		'pattern_description' => 'If this pattern is not found on the website, the server will be marked offline. Regular expressions are allowed.',
        'last_check' => 'Última verificação',
        'last_online' => 'Última vez online',
        'monitoring' => 'Monitoramento',
        'send_email' => 'Enviar Email',
        'send_sms' => 'Enviar SMS',
        'updated' => 'Servidor atualizado.',
        'inserted' => 'Servidor adicionar.',
        'latency' => 'Tempo de resposta',
		'latency_max' => 'Latency (maximum)',
		'latency_min' => 'Latency (minimum)',
		'latency_avg' => 'Latency (average)',
		'year' => 'Year',
		'month' => 'Month',
		'week' => 'Week',
		'day' => 'Day',
		'hour' => 'Hour',
		'warning_threshold' => 'Warning threshold',
		'warning_threshold_description' => 'Number of failed checks required before it is marked offline.',
		'chart_last_week' => 'Last week',
		'chart_history' => 'History',
		// Charts date format according jqPlot date format  http://www.jqplot.com/docs/files/plugins/jqplot-dateAxisRenderer-js.html
		'chart_day_format' => '%d/%m/%Y',
		'chart_long_date_format' => '%d/%m/%Y %H:%M:%S',
		'chart_short_date_format' => '%d/%m %H:%M',
		'chart_short_time_format' => '%H:%M',
    ),
    'config' => array(
        'general' => 'Geral',
        'language' => 'Idioma',
        'show_update' => 'verificar atualizações semanalmente?',
        'email_status' => 'Habilitar envio de email?',
        'email_from_email' => 'Endereço do envio de email',
        'email_from_name' => 'Nome do envio de email',
		'email_smtp' => 'Enable SMTP',
		'email_smtp_host' => 'SMTP host',
		'email_smtp_port' => 'SMTP port',
		'email_smtp_username' => 'SMTP username',
		'email_smtp_password' => 'SMTP password',
		'email_smtp_noauth' => 'Leave blank for no authentication',
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
	'login' => array(
		'welcome_usermenu' => 'Welcome, %user_name%',
		'title_sign_in' => 'Please sign in',
		'title_forgot' => 'Forgot your password?',
		'title_reset' => 'Reset your password',
		'submit' => 'Submit',
		'remember_me' => 'Remember me',
		'login' => 'Login',
		'logout' => 'Logout',
		'username' => 'Username',
		'password' => 'Password',
		'password_repeat' => 'Repeat password',
		'password_forgot' => 'Forgot password?',
		'password_reset' => 'Reset password',
		'password_reset_email_subject' => 'Reset your password for PHP Server Monitor',
		'password_reset_email_body' => 'Please use the following link to reset your password. Please note it expires in 1 hour.<br/><br/>%link%',
		'error_user_incorrect' => 'The provided username could not be found.',
		'error_login_incorrect' => 'The information is incorrect.',
		'error_login_passwords_nomatch' => 'The provided passwords do not match.',
		'error_reset_invalid_link' => 'The reset link you provided is invalid.',
		'success_password_forgot' => 'An email has been sent to you with information how to reset your password.',
		'success_password_reset' => 'Your password has been reset successfully. Please login.',
	),
);
