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
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

$sm_lang = array(
    'name' => 'Português - Brazilian Portuguese',
    'locale' => array(
        '0' => 'pt_BR.UTF-8',
        '1' => 'pt_BR',
        '2' => 'portuguese-brazilian',
    ),
    'locale_tag' => 'BR',
    'locale_dir' => 'ltr',
    'system' => array(
        'title' => 'Server Monitor',
        'install' => 'Instalar',
        'action' => 'Ação',
        'save' => 'Salvar',
        'edit' => 'Editar',
        'delete' => 'Excluir',
        'date' => 'Data',
        'message' => 'Mensagem',
        'yes' => 'Sim',
        'no' => 'Não',
        'insert' => 'Inserir',
        'add_new' => 'Adicionar novo',
        'update_available' => 'Uma atualização ({version}) disponível em <a
 href="https://github.com/phpservermon/phpservermon/releases/latest" target="_blank"
 rel="noopener">http://www.phpservermonitor.org</a>.',
        'back_to_top' => 'Voltar ao topo',
        'go_back' => 'Voltar',
        'ok' => 'OK',
        'cancel' => 'Cancel',
        'short_day_format' => '%e %m',
        'long_day_format' => '%e/%m/%Y',
        'yesterday_format' => 'Ontem as %k:%M',
        'other_day_format' => '%A at %k:%M',
        'never' => 'Nunca',
        'hours_ago' => '%d horas atrás',
        'an_hour_ago' => 'cerca de uma hora atrás',
        'minutes_ago' => '%d minutos atrás',
        'a_minute_ago' => 'cerca de um minuto atrás',
        'seconds_ago' => '%d segundos atrás',
        'a_second_ago' => 'um segundo atrás',
        'seconds' => 'segundos',
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
        'user' => 'Usuário',
        'name' => 'Nome',
        'user_name' => 'Username',
        'password' => 'Senha',
        'password_repeat' => 'Repetir senha',
        'password_leave_blank' => 'Deixe em branco para não modificar',
        'level' => 'Nível',
        'level_10' => 'Administrador',
        'level_20' => 'Usuário',
        'level_description' => '<b>Administradores</b> Tem total acesso: podem gerenciar servidores, usuários e
 configurações globais.<br><b>Usuários</b> só podem executar atualizações para
 servidores que lhe foram atribuídos.',
        'mobile' => 'Celular',
        'email' => 'Email',
        'pushover' => 'Pushover',
        'pushover_description' => 'Pushover para enviar notificações em real-tome. Veja <a
 href="https://pushover.net/" target="_blank">o website</a> para mais informações.',
        'pushover_key' => 'Pushover Key',
        'pushover_device' => 'Pushover Device',
        'pushover_device_description' => 'Nome do Device para enviar a mensagem. Deixe em branco para enviar a todos
 os Devices.',
        'delete_title' => 'Excluir Usuário',
        'delete_message' => 'Tem certeza que deseja excluir o usuário \'%1\'?',
        'deleted' => 'Usuário excluído.',
        'updated' => 'Usuário atualizado.',
        'inserted' => 'Usuário adicionado.',
        'profile' => 'Perfil',
        'profile_updated' => 'Seu perfil foi atualizado.',
        'error_user_name_bad_length' => 'Usernames deve conter entre 2 e 64 caracteres.',
        'error_user_name_invalid' => 'Só pode conter caracteres alfabéticos (a-z, A-Z), dígitos (0-9), pontos (.) e
 underscores (_).',
        'error_user_name_exists' => 'O nome de usuário(username) já existe no banco de dados',
        'error_user_email_bad_length' => 'Email deve conter entre 5 e 255 caracteres.',
        'error_user_email_invalid' => 'O endereço de email é inválido.',
        'error_user_level_invalid' => 'O Nível de usuário é inválido.',
        'error_user_no_match' => 'O usuário não pode ser encontrado no banco de dados.',
        'error_user_password_invalid' => 'A senha informada é inválida.',
        'error_user_password_no_match' => 'A senha informada não combina.',
    ),
    'log' => array(
        'title' => 'Entradas do Log',
        'type' => 'Tipo',
        'status' => 'Status',
        'email' => 'Email',
        'sms' => 'SMS',
        'pushover' => 'Pushover',
        'no_logs' => 'Sem logs',
        'clear' => 'Log clara',
        'delete_title' => 'Log clara',
        'delete_message' => 'Tem certeza de que deseja excluir <b>todos</b> os logs?',
    ),
    'servers' => array(
        'server' => 'Servidor',
        'status' => 'Status',
        'label' => 'Etiqueta',
        'domain' => 'Domínio/IP',
        'timeout' => 'Timeout',
        'timeout_description' => 'Segundos para aguardar a resposta do servidor.',
        'port' => 'Porta',
        'type' => 'Tipo',
        'type_website' => 'Website',
        'type_service' => 'Service',
        'pattern' => 'Pesquisa palavra/padrão',
        'pattern_description' => 'Se esse padrão não for encontrado no site, o servidor será marcado offline. As
 expressões regulares são permitidas.',
        'last_check' => 'Última verificação',
        'last_online' => 'Última vez online',
        'last_offline' => 'Última vez offline',
        'monitoring' => 'Monitoramento',
        'no_monitoring' => 'Sem monitoring',
        'email' => 'Email',
        'send_email' => 'Enviar Email',
        'sms' => 'SMS',
        'send_sms' => 'Enviar SMS',
        'pushover' => 'Pushover',
        'users' => 'Usuários',
        'delete_title' => 'Exluir Servidor',
        'delete_message' => 'Tem certeza que deseja excluir o servidor \'%1\'?',
        'deleted' => 'Servidor excluído.',
        'updated' => 'Servidor atualizado.',
        'inserted' => 'Servidor adicionar.',
        'latency' => 'Tempo de resposta',
        'latency_max' => 'Latência (máxima)',
        'latency_min' => 'Latência (minima)',
        'latency_avg' => 'Latência (média)',
        'uptime' => 'Uptime',
        'year' => 'Ano',
        'month' => 'Mês',
        'week' => 'Semana',
        'day' => 'Dia',
        'hour' => 'Hora',
        'warning_threshold' => 'Limite de Aviso',
        'warning_threshold_description' => 'Número de verificações que falharam antes de ser marcado offline.',
        'chart_last_week' => 'Última semana',
        'chart_history' => 'Histórico',
        'chart_day_format' => '%d/%m/%Y',
        'chart_long_date_format' => '%d/%m/%Y %H:%M:%S',
        'chart_short_date_format' => '%d/%m %H:%M',
        'chart_short_time_format' => '%H:%M',
        'warning_notifications_disabled_sms' => 'Notificações SMS estão desabilitadas.',
        'warning_notifications_disabled_email' => 'Notificações por email estão desabilitadas.',
        'warning_notifications_disabled_pushover' => 'Notificações por Pushover estão desabilitadas.',
        'error_server_no_match' => 'Servidor não encontrado.',
        'error_server_label_bad_length' => 'A etiqueta deve ter entre 1 e 255 caracteres.',
        'error_server_ip_bad_length' => 'O domínio / IP deve ter entre 1 e 255 caracteres.',
        'error_server_ip_bad_service' => 'O IP não é válido.',
        'error_server_ip_bad_website' => 'A URL não é válida.',
        'error_server_type_invalid' => 'O tipo de servidor selecionado não é valido.',
        'error_server_warning_threshold_invalid' => 'O limite de aviso deve ser um número inteiro maior que 0.',
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
        'email_smtp_security' => 'SMTP security',
        'email_smtp_security_none' => 'None',
        'email_smtp_username' => 'SMTP username',
        'email_smtp_password' => 'SMTP password',
        'email_smtp_noauth' => 'Deixe em branco para nenhuma autenticação',
        'sms_status' => 'Habilitar o envio de mensagem de texto?',
        'sms_gateway' => 'Gateway para o uso de envio de mensagens',
        'sms_gateway_username' => 'Usuário do Gateway',
        'sms_gateway_password' => 'Senha do Gateway',
        'sms_from' => 'Número de telefone de envio',
        'pushover_status' => 'Habilitar envio de mensagens Pushover',
        'pushover_description' => 'Pushover é um serviço de notificações em tempo real. Veja <a
 href="https://pushover.net/" target="_blank">o website</a> para mais informações.',
        'pushover_clone_app' => 'Clique aqui para criar sua app Pushover',
        'pushover_api_token' => 'Pushover App API Token',
        'pushover_api_token_description' => 'Before you can use Pushover, you need to <a href="%1$s" target="_blank"
 rel="noopener">register an App</a> at their website and enter the App API
 Token here.',
        'alert_type' => 'Selecione como você gostaria de ser notificado.',
        'alert_type_description' => '<b>Mudança de Status:</b> Você receberá uma notificação quando o seridor
 tive uma mudança de status. De online -> offline ou offline -> online.<br><br
 /><b>Offline:</b> Você receberá uma notificação quando o servidor fica
 OFFLINE (Pela primeira vez). Por exemplo, A cronjob é a cada 15 minutos e seu
 servidor caiu em 1:00 e permanece offline até 6 am. Você receberá uma
 notificação a 1:00 apenas<br><br><b>Sempre:</b> Você receberá uma
 notificação toda vez que o script é executado e um site esta offline, mesmo se
 o site tenha ficado offline por horas.',
        'alert_type_status' => 'Mudança de Status',
        'alert_type_offline' => 'Offline',
        'alert_type_always' => 'Sempre',
        'log_status' => 'Log status',
        'log_status_description' => 'Se o status de registro é definido como TRUE, o monitor irá registrar o evento
 sempre que as configurações de notificação forem passadas.',
        'log_email' => 'Registrar no Log os envios de email feitos pelo script?',
        'log_sms' => 'Registrar no Log os envios de mensagens de texto feitos pelo script?',
        'log_pushover' => 'Log pushover messages sent by the script',
        'updated' => 'A configuração foi atualizada.',
        'tab_email' => 'Email',
        'tab_sms' => 'Texto',
        'tab_pushover' => 'Pushover',
        'settings_email' => 'Configuração de email',
        'settings_sms' => 'Configuração de mensagens de texto',
        'settings_pushover' => 'Pushover settings',
        'settings_notification' => 'Configuração de notificações',
        'settings_log' => 'Configuração de Logs',
        'auto_refresh' => 'Atualizar automaticamente',
        'auto_refresh_description' => 'Atualizar automaticamente a página de servidores.<br><span class="small">Tempo
 em segundos, Se 0 a página não será atualizada.</span>',
        'test' => 'Teste',
        'test_email' => 'Um e-mail será enviado para o endereço especificado em seu perfil de usuário.',
        'test_sms' => 'Um SMS será enviado para o número de telefone especificado em seu perfil de usuário.',
        'test_pushover' => 'A notificação Pushover será enviado para a chave de usuário / dispositivo especificado
 em seu perfil de usuário.',
        'send' => 'Enviar',
        'test_subject' => 'Teste',
        'test_message' => 'Mensagem de Teste',
        'email_sent' => 'Email enviado',
        'email_error' => 'Erro no envio do email',
        'sms_sent' => 'Sms enviado',
        'sms_error' => 'Error no envio do SMS. %s',
        'sms_error_nomobile' => 'Não foi possível enviar SMS de teste: nenhum número de telefone válido encontrado
 em seu perfil.',
        'pushover_sent' => 'Notificação Pushover enviada',
        'pushover_error' => 'Um erro foi encontrado ao enviar a notificação Pushover: %s',
        'pushover_error_noapp' => 'Não foi possível enviar a notificação de teste: não foi encontrada a APP API
 token do Pushover na configuração global.',
        'pushover_error_nokey' => 'Não foi possível enviar a notificação de teste: não foi encontrada a Pushover
 Key no seu perfil.',
        'log_retention_period' => 'Período de retenção do Log',
        'log_retention_period_description' => 'Número de dias para manter os registros de notificações e arquivos
 de tempo de atividade do servidor. Digite 0 para desativar a limpeza de
 registro.',
        'log_retention_days' => 'dias',
    ),
    'notifications' => array(
        'off_sms' => 'Servidor \'%LABEL%\' está OFFLINE: ip=%IP%, porta=%PORT%. Erro=%ERROR%',
        'off_email_subject' => 'IMPORTANTE: Servidor \'%LABEL%\' está OFFLINE',
        'off_email_body' => 'Falha ao conectar ao servidor:<br><br>Servidor: %LABEL%<br>IP: %IP%<br>Porta:
 %PORT%<br>Erro: %ERROR%<br>Data: %DATE%',
        'off_pushover_title' => 'Servidor \'%LABEL%\' está OFFLINE',
        'off_pushover_message' => 'Falha ao conectar ao servidor:<br><br>Servidor: %LABEL%<br>IP: %IP%<br>Porta:
 %PORT%<br>Erro: %ERROR%<br>Data: %DATE%',
        'on_sms' => 'Servidor \'%LABEL%\' esta ONLINE: ip=%IP%, porta=%PORT%, it was down for %LAST_OFFLINE_DURATION%',
        'on_email_subject' => 'IMPORTANTE: Servidor \'%LABEL%\' esta ONLINE',
        'on_email_body' => 'Servidor \'%LABEL%\' esta ONLINE novamente, it was down for
 %LAST_OFFLINE_DURATION%:<br><br>Servidor: %LABEL%<br>IP: %IP%<br>Porta: %PORT%<br>Data:
 %DATE%',
        'on_pushover_title' => 'Servidor \'%LABEL%\' esta ONLINE',
        'on_pushover_message' => 'Servidor \'%LABEL%\' esta ONLINE novamente, it was down for
 %LAST_OFFLINE_DURATION%:<br><br>Servidor: %LABEL%<br>IP: %IP%<br>Porta:
 %PORT%<br>Data: %DATE%',
    ),
    'login' => array(
        'welcome_usermenu' => 'Bem vindo, %user_name%',
        'title_sign_in' => 'Por favor efetue login',
        'title_forgot' => 'Perdeu sua senha?',
        'title_reset' => 'Redefinir senha',
        'submit' => 'Enviar',
        'remember_me' => 'Lembrar',
        'login' => 'Login',
        'logout' => 'Logout',
        'username' => 'Username',
        'password' => 'Senha',
        'password_repeat' => 'Repetir Senha',
        'password_forgot' => 'Perdeu a senha?',
        'password_reset' => 'Redefinir senha',
        'password_reset_email_subject' => 'Redefinir sua senha para PHP Server Monitor',
        'password_reset_email_body' => 'Por favor use o link para redefinir sua senha. Este link irá expirar em 1
 hora.<br><br>%link%',
        'error_user_incorrect' => 'O username não pode ser encontrado.',
        'error_login_incorrect' => 'As informações são incorretas.',
        'error_login_passwords_nomatch' => 'A senha informada não é válida.',
        'error_reset_invalid_link' => 'O link para redefinição de senha é inválido.',
        'success_password_forgot' => 'Um email foi enviado para você com as instruções de redefinição de senha.',
        'success_password_reset' => 'Sua senha foi redefinida com sucesso. Por favor faça login.',
    ),
    'error' => array(
        '401_unauthorized' => 'Não autorizado',
        '401_unauthorized_description' => 'Você não tem autorização para ver esta página.',
    ),
);
