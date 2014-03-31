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
 * @author      Pepijn Over <pep@neanderthal-technology.com>
 * @copyright   Copyright (c) 2008-2014 Pepijn Over <pep@neanderthal-technology.com>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

$sm_lang = array(
	'name' => 'Nederlands - Dutch',
	'system' => array(
		'title' => 'Server Monitor',
		'install' => 'Install',
		'action' => 'Actie',
		'save' => 'Opslaan',
		'edit' => 'Wijzig',
		'delete' => 'Verwijder',
		'deleted' => 'Record is verwijderd',
		'date' => 'Datum',
		'message' => 'Bericht',
		'yes' => 'Ja',
		'no' => 'Nee',
		'edit' => 'Wijzig',
		'insert' => 'Voeg toe',
		'add_new' => 'Voeg toe',
		'update_available' => 'Een nieuwe update ({version}) is beschikbaar op <a href="http://www.phpservermonitor.org" target="_blank">http://www.phpservermonitor.org</a>.',
		'back_to_top' => 'Terug naar boven',
		'go_back' => 'Terug',
		// date/time format according the strftime php function format parameter http://php.net/manual/function.strftime.php
		'short_day_format' => '%B %e',
		'long_day_format' => '%B %e, %Y',
		'yesterday_format' => 'Gisteren om %k:%M',
		'other_day_format' => '%A om %k:%M',
		'never' => 'Nooit',
		'hours_ago' => '%d uren geleden',
		'an_hour_ago' => 'een uur geleden',
		'minutes_ago' => '%d minuten geleden',
		'a_minute_ago' => 'een minuut geleden',
		'seconds_ago' => '%d seconden geleden',
		'a_second_ago' => 'een seconde geleden',
	),
	'menu' => array(
		'config' => 'Config',
		'server' => 'Servers',
		'server_log' => 'Log',
		'server_status' => 'Status',
		'server_update' => 'Update',
		'user' => 'Gebruikers',
		'help' => 'Help',
	),
	'users' => array(
		'user' => 'gebruiker',
		'name' => 'Naam',
		'user_name' => 'Gebruikersnaam',
		'password' => 'Wachtwoord',
		'password_repeat' => 'Herhaal wachtwoord',
		'password_leave_blank' => 'Laat leeg om niet te wijzigen',
		'level' => 'Level',
		'level_10' => 'Beheerder',
		'level_20' => 'Gebruiker',
		'level_description' => '<b>Beheerders</b> hebben volledige toegang: ze kunnen servers en gebruiker beheren en de globale configuratie aanpassen.<br/><b>Gebruikers</b> kunnen alleen de servers bekijken en op fouten testen die aan hun zijn toegewezen.',
		'mobile' => 'Mobiel',
		'email' => 'Email',
		'updated' => 'Gebruiker gewijzigd.',
		'inserted' => 'Gebruiker toegevoegd.',
		'profile' => 'Profiel',
		'profile_updated' => 'Je profiel is bijgewerkt.',
		'error_user_name_bad_length' => 'Een gebruikersnaam moet tussen de 2 en 64 tekens zijn.',
		'error_user_name_invalid' => 'Een gebruikersnaam mag alleen alfabetische tekens (a-z, A-Z), cijfers (0-9) en underscores (_) bevatten.',
		'error_user_name_exists' => 'De opgegeven gebruikersnaam bestaat al.',
		'error_user_email_bad_length' => 'Een email adres moet tussen de 5 en 255 tekens zijn.',
		'error_user_email_invalid' => 'Het email adres is ongeldig.',
		'error_user_level_invalid' => 'Het gebruikersniveau is ongeldig.',
		'error_user_no_match' => 'De gebruiker kon niet worden toegevoegd aan de database.',
		'error_user_password_invalid' => 'Het ingevulde wachtwoord is ongeldig.',
		'error_user_password_no_match' => 'De ingevulde wachtwoorden komen niet overeen.',
	),
	'log' => array(
		'title' => 'Log entries',
		'type' => 'Type',
		'status' => 'Status',
		'email' => 'Email',
		'sms' => 'SMS',
	),
	'servers' => array(
		'server' => 'Server',
		'label' => 'Label',
		'domain' => 'Domein/IP',
		'port' => 'Poort',
		'type' => 'Type',
		'type_website' => 'Website',
		'type_service' => 'Service',
		'pattern' => 'Zoek voor tekst/regex',
		'pattern_description' => 'Als dit patroon niet gevonden wordt op de website, zal de server als offline gemarkeerd worden. Regular expressions zijn toegestaan.',
		'last_check' => 'Laatst gecontroleerd',
		'last_online' => 'Laatst online',
		'monitoring' => 'Monitoring',
		'send_email' => 'Stuur email',
		'send_sms' => 'Stuur SMS',
		'updated' => 'Server gewijzigd.',
		'inserted' => 'Server toegevoegd.',
		'latency' => 'Response tijd',
		'latency_max' => 'Latency (maximum)',
		'latency_min' => 'Latency (minimum)',
		'latency_avg' => 'Latency (average)',
		'year' => 'Year',
		'month' => 'Month',
		'week' => 'Week',
		'day' => 'Day',
		'hour' => 'Hour',
		'warning_threshold' => 'Warning threshold',
		'warning_threshold_description' => 'Aantal mislukte pogingen voordat de server als offline gemarkeerd wordt.',
		'chart_last_week' => 'Last week',
		'chart_history' => 'History',
		// Charts date format according jqPlot date format  http://www.jqplot.com/docs/files/plugins/jqplot-dateAxisRenderer-js.html
		'chart_day_format' => '%d-%m-%Y',
		'chart_long_date_format' => '%d-%m-%Y %H:%M:%S',
		'chart_short_date_format' => '%d-%m %H:%M',
		'chart_short_time_format' => '%H:%M',
	),
	'config' => array(
		'general' => 'Algemeen',
		'language' => 'Taal',
		'show_update' => 'Check for new updates weekly?',
		'email_status' => 'Sta email berichten toe?',
		'email_from_email' => 'Email van adres',
		'email_from_name' => 'Email van naam',
		'email_smtp' => 'SMTP gebruiken',
		'email_smtp_host' => 'SMTP host',
		'email_smtp_port' => 'SMTP poort',
		'email_smtp_username' => 'SMTP gebruikersnaam',
		'email_smtp_password' => 'SMTP wachtwoord',
		'email_smtp_noauth' => 'Laat leeg voor geen authenticatie',
		'sms_status' => 'Sta SMS berichten toe?',
		'sms_gateway' => 'Gateway voor het sturen van SMS',
		'sms_gateway_mosms' => 'Mosms',
		'sms_gateway_mollie' => 'Mollie',
		'sms_gateway_spryng' => 'Spryng',
		'sms_gateway_inetworx' => 'Inetworx',
		'sms_gateway_clickatell' => 'Clickatell',
        'sms_gateway_textmarketer' => 'Textmarketer',
		'sms_gateway_username' => 'Gateway gebruikersnaam',
		'sms_gateway_password' => 'Gateway wachtwoord',
		'sms_from' => 'Telefoonnummer afzender',
		'alert_type' => 'Selecteer wanneer je een notificatie wilt.<br/>',
		'alert_type_description' => '<b>Status change:</b> '.
			'Je ontvangt alleen bericht wanneer een server van status verandert. Dus van online -> offline of offline -> online.<br/>'.
			 '<br /><b>Offline</b>'.
			'Je ontvangt bericht wanneer een server offline gaat voor de *EERSTE KEER*. Bijvoorbeeld, '.
			'je cronjob draait iedere 15 min en je server gaat down om 01:00 en blijft offline tot 06:00. '.
			'Je krijgt 1 bericht om 01:00 en dat is het.<br/>'.
			'<br/><b>Altijd</b>'.
			'Je krijgt een bericht elke keer dat het script draait en een website is down, ook al is de site al een paar uur offline.',
		'alert_type_status' => 'Status verandering',
		'alert_type_offline' => 'Offline',
		'alert_type_always' => 'Altijd',
		'log_status' => 'Log status<br/><div class="small">Als de log status op TRUE staat, zal de monitor een log aanmaken elke keer dat hij door de notificatie instellingen komt</div>',
		'log_email' => 'Log emails verstuurd bij het script?',
		'log_sms' => 'Log sms berichten verstuurd bij het script?',
		'updated' => 'De configuratie is gewijzigd.',
		'settings_email' => 'Email instellingen',
		'settings_sms' => 'SMS instellingen',
		'settings_notification' => 'Notificatie instellingen',
		'settings_log' => 'Log instellingen',
		'auto_refresh_servers' =>
			'Auto-refresh servers pagina<br/>'.
			'<div class="small">'.
			'Tijd in seconden, als de tijd 0 is wordt de pagina niet ververst.'.
			'</div>',
	),
	// for newlines in the email messages use <br/>
	'notifications' => array(
		'off_sms' => 'Server %LABEL% is DOWN: ip=%IP%, poort=%PORT%. Fout=%ERROR%',
		'off_email_subject' => 'BELANGRIJK: Server %LABEL% is DOWN',
		'off_email_body' => "De server kon niet worden bereikt:<br/><br/>Server: %LABEL%<br/>IP: %IP%<br/>Poort: %PORT%<br/>Fout: %ERROR%<br/>Datum: %DATE%",
		'on_sms' => 'Server %LABEL% is RUNNING: ip=%IP%, poort=%PORT%',
		'on_email_subject' => 'BELANGRIJK: Server %LABEL% is RUNNING',
		'on_email_body' => "Server %LABEL% is weer online:<br/><br/>Server: %LABEL%<br/>IP: %IP%<br/>Poort: %PORT%<br/>Datum: %DATE%",
	),
	'login' => array(
		'welcome_usermenu' => 'Welkom, %user_name%',
		'title_sign_in' => 'Log in',
		'title_forgot' => 'Wachtwoord vergeten?',
		'title_reset' => 'Herstel wachtwoord',
		'submit' => 'Sla op',
		'remember_me' => 'Onthoud mij',
		'login' => 'Login',
		'logout' => 'Uitloggen',
		'username' => 'Gebruikersnaam',
		'password' => 'Wachtwoord',
		'password_repeat' => 'Herhaal wachtwoord',
		'password_forgot' => 'Wachtwoord vergeten?',
		'password_reset' => 'Wachtwoord herstellen',
		'password_reset_email_subject' => 'Wijzig je wachtwoord voor PHP Server Monitor',
		'password_reset_email_body' => 'Gebruik de onderstaande link om uw wachtwoord te wijzigen. Let op, deze link verloopt na 1 uur.<br/><br/>%link%',
		'error_user_incorrect' => 'De opgegeven gebruikersnaam is onjuist.',
		'error_login_incorrect' => 'De informatie is niet juist.',
		'error_login_passwords_nomatch' => 'De ingevulde wachtwoorden komen niet overeen.',
		'error_reset_invalid_link' => 'De reset link is ongeldig.',
		'success_password_forgot' => 'Er is een mail verstuurd met informatie om je wachtwoord aan te passen.',
		'success_password_reset' => 'Je wachtwoord is aangepast. Je kunt nu inloggen.',
	),
);
