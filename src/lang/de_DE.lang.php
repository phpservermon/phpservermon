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
 * @author      Brunbaur Herbert
 * @copyright   Copyright (c) 2008-2014 Pepijn Over <pep@neanderthal-technology.com>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

$sm_lang = array(
	'name' => 'Deutsch - German',
	'system' => array(
		'title' => 'Server Monitor',
		'install' => 'Install',
		'action' => 'Aktion',
		'save' => 'Speichern',
		'edit' => 'Bearbeiten',
		'delete' => 'L&ouml;schen',
		'deleted' => 'Eintrag wurde gel&ouml;scht',
		'date' => 'Datum',
		'message' => 'Meldung',
		'yes' => 'Ja',
		'no' => 'Nein',
		'edit' => 'Bearbeiten',
		'insert' => 'Einf&uuml;gen',
		'add_new' => 'Neuen Eintrag erstellen',
		'update_available' => 'Ein neues Update ({version}) ist verf&uuml;gbar auf <a href="http://www.phpservermonitor.org" target="_blank">http://www.phpservermonitor.org</a>.',
		'back_to_top' => 'Back to top',
		'go_back' => 'Go back',
		// date/time format according the strftime php function format parameter http://php.net/manual/function.strftime.php
		'short_day_format' => '%B %e',
		'long_day_format' => '%B %e, %Y',
		'yesterday_format' => 'Gestern um %k:%M',
		'other_day_format' => '%A um %k:%M',
		'never' => 'Never',
		'hours_ago' => '%d hours ago',
		'an_hour_ago' => 'about an hour ago',
		'minutes_ago' => '%d minutes ago',
		'a_minute_ago' => 'about a minute ago',
		'seconds_ago' => '%d seconds ago',
		'a_second_ago' => 'a second ago',
	),
	'menu' => array(
		'config' => 'Einstellungen',
		'server' => 'Server',
		'server_log' => 'Log',
		'server_status' => 'Status',
		'server_update' => 'Updates',
		'user' => 'Benutzer',
		'help' => 'Hilfe',
	),
	'users' => array(
		'user' => 'Benutzer',
		'name' => 'Name',
		'user_name' => 'Username',
		'password' => 'Password',
		'password_repeat' => 'Password repeat',
		'password_leave_blank' => 'Leave blank to keep unchanged',
		'level' => 'Level',
		'level_10' => 'Administrator',
		'level_20' => 'User',
		'level_description' => '<b>Administrators</b> have full access: they can manage servers, users and edit the global configuration.<br/><b>Users</b> can only view and run the updater for the servers that have been assigned to them.',
		'mobile' => 'Mobil',
		'email' => 'Email',
		'updated' => 'Benutzer bearbeitet.',
		'inserted' => 'Benutzer eingetragen.',
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
		'title' => 'Log Eintr&auml;ge',
		'type' => 'Type',
		'status' => 'Status',
		'email' => 'Email',
		'sms' => 'SMS',
	),
	'servers' => array(
		'server' => 'Server',
		'label' => 'Beschriftung',
		'domain' => 'Domain/IP',
		'port' => 'Port',
		'type' => 'Type',
		'type_website' => 'Website',
		'type_service' => 'Service',
		'pattern' => 'Search string/pattern',
		'pattern_description' => 'If this pattern is not found on the website, the server will be marked offline. Regular expressions are allowed.',
		'last_check' => 'Letzter Check',
		'last_online' => 'Letztes mal Online',
		'monitoring' => 'Monitoring',
		'send_email' => 'Email',
		'send_sms' => 'SMS',
		'updated' => 'Server aktualisiert.',
		'inserted' => 'Server eingetragen.',
		'latency' => 'Antwortzeit',
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
		'chart_day_format' => '%d.%m.%Y',
		'chart_long_date_format' => '%d.%m.%Y %H:%M:%S',
		'chart_short_date_format' => '%d.%m %H:%M',
		'chart_short_time_format' => '%H:%M',
	),
	'config' => array(
		'general' => 'General',
		'language' => 'Sprache',
		'show_update' => 'Updats w&ouml;chentlich pr&uuml;fen?',
		'email_status' => 'Email senden erlauben?',
		'email_from_email' => 'Email from address',
		'email_from_name' => 'Email from name',
		'email_smtp' => 'Enable SMTP',
		'email_smtp_host' => 'SMTP host',
		'email_smtp_port' => 'SMTP port',
		'email_smtp_username' => 'SMTP username',
		'email_smtp_password' => 'SMTP password',
		'email_smtp_noauth' => 'Leave blank for no authentication',
		'sms_status' => 'SMS Nachricht senden erlauben?',
		'sms_gateway' => 'SMS Gateway',
		'sms_gateway_mosms' => 'Mosms',
		'sms_gateway_mollie' => 'Mollie',
		'sms_gateway_spryng' => 'Spryng',
		'sms_gateway_inetworx' => 'Inetworx',
        'sms_gateway_clickatell' => 'Clickatell',
        'sms_gateway_textmarketer' => 'Textmarketer',
		'sms_gateway_username' => 'Gateway Benutzername',
		'sms_gateway_password' => 'Gateway Passwort',
		'sms_from' => 'SMS Sendernummer',
		'alert_type' => 'Wann m&ouml;chten Sie benachrichtig werden?<br/>',
		'alert_type_description' => '<b>Status ge&auml;ndert:</b> '.
			'...  wenn sich der Status &auml;ndert<br/>'.
			'z.B. online -> offline oder offline -> online.<br/>'.
			 '<br/><b>Offline: </b>'.
			'Sie bekommen eine Benachrichtigung, wenn ein Server Offline ist.<br/>'.
			'Es wird nur eine Mitteilung versendet.<br/>'.
			'<br/><b>Immer: </b>'.
			'Sie werden jedesmal wenn der CronJob oder das Script ausgef&uuml;hrt wird benachrichtigt,<br>'.
			'auch wenn der Dienst mehreres Stunden offline ist',
		'alert_type_status' => 'Status ge&auml;ndert',
		'alert_type_offline' => 'Offline',
		'alert_type_always' => 'Immer',
		'log_status' => 'Log Status<br/><div class="small">Ist der Log Status auf TRUE (ein Hacken) gesetzt, wird jeder Status protokolliert</div>',
		'log_email' => 'Email Log per Script senden?',
		'log_sms' => 'SMS Log per Script senden?',
		'updated' => 'Die Einstellungen wurden gespeichert.',
		'settings_email' => 'Email',
		'settings_sms' => 'SMS Nachricht',
		'settings_notification' => 'Benachrichtigung',
		'settings_log' => 'Log',
		'auto_refresh_servers' =>
			'Auto-refresh servers page<br/>'.
			'<div class="small">'.
			'Time in seconds, if 0 the page won\'t refresh.'.
			'</div>',
	),
	// for newlines in the email messages use <br/>
	'notifications' => array(
		'off_sms' => 'Server \'%LABEL%\' ist Offline: ip=%IP%, port=%PORT%. Fehler=%ERROR%',
		'off_email_subject' => 'Wichtig: Server \'%LABEL%\' ist Offline',
		'off_email_body' => "Kann keine Verbindung zum Server aufbauen:<br/><br/>Server: %LABEL%<br/>IP: %IP%<br/>Port: %PORT%<br/>Fehler: %ERROR%<br/>Datum: %DATE%",
		'on_sms' => 'Server \'%LABEL%\' ist wieder Online: ip=%IP%, port=%PORT%',
		'on_email_subject' => 'Wichtig: Server \'%LABEL%\' ist wieder Online',
		'on_email_body' => "Server '%LABEL%' l&auml;uft wieder:<br/><br/>Server: %LABEL%<br/>IP: %IP%<br/>Port: %PORT%<br/>Datum: %DATE%",
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
