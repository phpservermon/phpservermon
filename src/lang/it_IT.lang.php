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
 * @author      Marco Gargani <http://www.marcogargani.it>
 * @copyright   Copyright (c) 2008-2014 Pepijn Over <pep@neanderthal-technology.com>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

$sm_lang = array(
	'name' => 'Italiano - Italian',
	'locale' => array('it_IT.UTF-8', 'it_IT', 'italian', 'ita'),
	'system' => array(
		'title' => 'Server Monitor',
		'install' => 'Install',
		'action' => 'Azione',
		'save' => 'Salva',
		'edit' => 'Modifica',
		'delete' => 'Elimina',
		'date' => 'Data',
		'message' => 'Messaggio',
		'yes' => 'Sì',
		'no' => 'No',
		'insert' => 'Inserisci',
		'add_new' => 'Aggiungi Nuovo?',
		'update_available' => 'Un nuovo aggiornamento ({version}) è disponibile su <a href="http://www.phpservermonitor.org" target="_blank">http://www.phpservermonitor.org</a>.',
		'back_to_top' => 'Back to top',
		'go_back' => 'Go back',
		'ok' => 'OK',
		'cancel' => 'Cancel',
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
		'config' => 'Configurazione',
		'server' => 'Servers',
		'server_log' => 'Log',
		'server_status' => 'Status',
		'server_update' => 'Aggiorna',
		'user' => 'Utenti',
		'help' => 'Aiuto',
	),
	'users' => array(
		'user' => 'Utente',
		'name' => 'Nome',
		'user_name' => 'Username',
		'password' => 'Password',
		'password_repeat' => 'Password repeat',
		'password_leave_blank' => 'Leave blank to keep unchanged',
		'level' => 'Level',
		'level_10' => 'Administrator',
		'level_20' => 'User',
		'level_description' => '<b>Administrators</b> have full access: they can manage servers, users and edit the global configuration.<br/><b>Users</b> can only view and run the updater for the servers that have been assigned to them.',
		'mobile' => 'Cellulare',
		'email' => 'Email',
		'delete_title' => 'Delete User',
		'delete_message' => 'Are you sure you want to delete user \'%1\'?',
		'deleted' => 'User deleted.',
		'updated' => 'Utente aggiornato.',
		'inserted' => 'Utente aggiunto.',
		'profile' => 'Profile',
		'profile_updated' => 'Your profile has been updated.',
		'error_user_name_bad_length' => 'Usernames must be between 2 and 64 characters.',
		'error_user_name_invalid' => 'The username may only contain alphabetic characters (a-z, A-Z), digits (0-9) and underscores (_).',
		'error_user_name_exists' => 'The given username already exists in the database.',
		'error_user_email_bad_length' => 'Email addresses must be between 5 and 255 characters.',
		'error_user_email_invalid' => 'The email address is invalid.',
		'error_user_level_invalid' => 'The given user level is invalid.',
		'error_user_no_match' => 'The user could not be found in the database.',
		'error_user_password_invalid' => 'The entered password is invalid.',
		'error_user_password_no_match' => 'The entered passwords do not match.',
	),
	'log' => array(
		'title' => 'Righe log',
		'type' => 'Tipo',
		'status' => 'Stato',
		'email' => 'Email',
		'sms' => 'SMS',
		'no_logs' => 'No logs',
	),
	'servers' => array(
		'server' => 'Server',
		'status' => 'Status',
		'label' => 'Nome',
		'domain' => 'Dominio/IP',
		'port' => 'Porta',
		'type' => 'Tipo',
		'type_website' => 'Website',
		'type_service' => 'Service',
		'type_ping' => 'Ping',
		'pattern' => 'Search string/pattern',
		'pattern_description' => 'If this pattern is not found on the website, the server will be marked offline. Regular expressions are allowed.',
		'last_check' => 'Ultimo Controllo',
		'last_online' => 'Ultima volta Online',
		'monitoring' => 'Sotto Controllo',
		'no_monitoring' => 'No monitoring',
		'email' => 'Email',
		'send_email' => 'Invia Email',
		'sms' => 'SMS',
		'send_sms' => 'Invia SMS',
		'delete_title' => 'Delete Server',
		'delete_message' => 'Are you sure you want to delete server \'%1\'?',
		'deleted' => 'Server deleted.',
		'updated' => 'Server aggiornato.',
		'inserted' => 'Server aggiunto.',
		'latency' => 'Tempo di risposta',
		'latency_max' => 'Tempo di risposta (maximum)',
		'latency_min' => 'Tempo di risposta (minimum)',
		'latency_avg' => 'Tempo di risposta (average)',
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
		'chart_day_format' => '%Y-%m-%d',
		'chart_long_date_format' => '%Y-%m-%d %H:%M:%S',
		'chart_short_date_format' => '%m/%d %H:%M',
		'chart_short_time_format' => '%H:%M',
	),
	'config' => array(
		'general' => 'Generale',
		'language' => 'Linguaggio',
		'show_update' => 'Controllare settimanalmente per nuovi aggiornamenti?',
		'email_status' => 'Permetti invio email?',
		'email_from_email' => 'Indirizzo Email mittente',
		'email_from_name' => 'Nome Email mittente',
		'email_smtp' => 'Enable SMTP',
		'email_smtp_host' => 'SMTP host',
		'email_smtp_port' => 'SMTP port',
		'email_smtp_username' => 'SMTP username',
		'email_smtp_password' => 'SMTP password',
		'email_smtp_noauth' => 'Leave blank for no authentication',
		'sms_status' => 'Permetti invio SMS?',
		'sms_gateway' => 'Gateway da usare per inviare SMS',
		'sms_gateway_mosms' => 'Mosms',
		'sms_gateway_mollie' => 'Mollie',
		'sms_gateway_spryng' => 'Spryng',
		'sms_gateway_inetworx' => 'Inetworx',
		'sms_gateway_clickatell' => 'Clickatell',
        'sms_gateway_textmarketer' => 'Textmarketer',
		'sms_gateway_smsit' => 'Smsit',
		'sms_gateway_username' => 'Nome Utente Gateway',
		'sms_gateway_password' => 'Password Gateway',
		'sms_from' => 'Numero di telefono del mittente',
		'alert_type' => 'Seleziona quando vuoi essere notificato.<br/>',
        'alert_type_description' => '<b>Cambio di Stato:</b> '.
		    'Riceverai una notifica solo quando un server cambierà stato. Quindi da online -> offline oppure da offline -> online.<br/>'.
		    '<br /><b>Offline:</b> '.
		    'Riceverai una notifica solo quando un server andrà offline *SOLO LA PRIMA VOLTA*. Per esempio, '.
		    'Se il tuo cronjob è impostato per controllare ogni 15 min e il tuo server andrà offline dalle 2AM alle 6AM. '.
		    'Riceverai una sola notifica alle 2AM e nient\'altro.<br/>'.
		    '<br><b>Sempre:</b> '.
		    'Riceverai una notifica ogni volta che lo script troverà un server down anche se è stato offline per ore.',
		'alert_type_status' => 'Cambio di Stato',
		'alert_type_offline' => 'Offline',
		'alert_type_always' => 'Sempre',
		'log_status' => 'Stato Log',
		'log_status_description' => 'Se lo Stato Log è impostato su VERO, il monitor registrerà nel log gli eventi appena le notifiche verranno inviate.',
		'log_email' => 'Registra email inviate dallo script.',
		'log_sms' => 'Registra SMS inviati dallo script.',
		'updated' => 'La configurazione è stato aggiornata.',
		'nochanges' => 'The configuration didn\'t change.',
		'tab_email' => 'Email',
		'tab_sms' => 'SMS',
		'tab_log' => 'Log',
		'settings_email' => 'Impostazioni Email',
		'settings_sms' => 'Impostazioni SMS',
		'settings_notification' => 'Impostazioni Notifiche',
		'settings_log' => 'Impostazioni Log',
		'auto_refresh' => 'Auto-Aggiorna pagina servers',
		'auto_refresh_servers' =>
			'Auto-Aggiorna pagina servers.<br/>'.
			'<span class="small">'.
			'Tempo in secondi, se impostato a 0 la pagina non si aggiornerà.'.
			'</span>',
		'seconds' => 'seconds',
		'test' => 'Test',
		'test_email' => 'An email will be sent to the address specified in your user profile.',
		'test_sms' => 'An SMS will be sent to the phone number specified in your user profile.',
		'send' => 'Send',
		'test_message' => 'Test message',
		'email_sent' => 'Email sent',
		'email_error' => 'Error in email sending',
		'sms_sent' => 'Sms sent',
		'sms_error' => 'Error in sms sending',
	),
	// for newlines in the email messages use <br/>
	'notifications' => array(
		'off_sms' => 'Server \'%LABEL%\' è DOWN: ip=%IP%, porta=%PORT%. Errore=%ERROR%',
		'off_email_subject' => 'IMPORTANTE: Server \'%LABEL%\' è DOWN',
		'off_email_body' => "Impossibile connettersi al seguente server:<br/><br/>Server: %LABEL%<br/>IP: %IP%<br/>Porta: %PORT%<br/>Errore: %ERROR%<br/>Data: %DATE%",
		'on_sms' => 'Server \'%LABEL%\' è ATTIVO: ip=%IP%, porta=%PORT%',
		'on_email_subject' => 'IMPORTANTE: Server \'%LABEL%\' è ATTIVO',
		'on_email_body' => "Server '%LABEL%' è di nuovo attivo:<br/><br/>Server: %LABEL%<br/>IP: %IP%<br/>Porta: %PORT%<br/>Data: %DATE%",
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
