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
 * @author      Pepijn Over <pep@peplab.net>
 * @copyright   Copyright (c) 2008-2015 Pepijn Over <pep@peplab.net>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

$sm_lang = array(
	'name' => 'Nederlands - Dutch',
	'locale' => array('nl_NL.UTF-8', 'nl_NL', 'dutch'),
	'system' => array(
		'title' => 'Server Monitor',
		'install' => 'Intalleren',
		'action' => 'Actie',
		'save' => 'Opslaan',
		'edit' => 'Wijzig',
		'delete' => 'Verwijder',
		'date' => 'Datum',
		'message' => 'Bericht',
		'yes' => 'Ja',
		'no' => 'Nee',
		'insert' => 'Voeg toe',
		'add_new' => 'Voeg toe',
		'update_available' => 'Een nieuwe update ({version}) is beschikbaar op <a href="http://www.phpservermonitor.org" target="_blank">http://www.phpservermonitor.org</a>.',
		'back_to_top' => 'Terug naar boven',
		'go_back' => 'Terug',
		'ok' => 'OK',
		'cancel' => 'Cancel',
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
		'year' => 'year',
		'years' => 'years',
		'month' => 'month',
		'months' => 'months',
		'day' => 'day',
		'days' => 'days',
		'hour' => 'hour',
		'hours' => 'hours',
		'minute' => 'minute',
		'minutes' => 'minutes',
		'second' => 'second',
		'seconds' => 'seconds',
	),
	'menu' => array(
		'config' => 'Configuratie',
		'server' => 'Servers',
		'server_log' => 'Log',
		'server_status' => 'Status',
		'server_update' => 'Update',
		'user' => 'Gebruikers',
		'help' => 'Help',
	),
	'users' => array(
		'user' => 'Gebruiker',
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
		'pushover' => 'Pushover',
		'pushover_description' => 'Pushover is een dienst die het gemakkelijk maakt om real-time notificaties te ontvangen. Zie <a href="https://pushover.net/">hun website</a> voor meer informatie.',
		'pushover_key' => 'Pushover Key',
		'pushover_device' => 'Pushover Device',
		'pushover_device_description' => 'Apparaat waar de berichten naar toe gaan. Laat leeg voor alle apparaten.',
		'delete_title' => 'Verwijder gebruiker',
		'delete_message' => 'Weet je zeker dat je deze gebruiker wilt verwijderen: \'%1\'?',
		'deleted' => 'Gebruiker verwijderd.',
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
		'pushover' => 'Pushover',
		'no_logs' => 'No logs',
	),
	'servers' => array(
		'server' => 'Server',
		'status' => 'Status',
		'label' => 'Label',
		'domain' => 'Domein/IP',
		'timeout' => 'Timeout',
		'timeout_description' => 'Aantal seconden te wachten op een reactie van de server.',
		'port' => 'Poort',
		'type' => 'Type',
		'type_website' => 'Website',
		'type_service' => 'Service',
		'pattern' => 'Zoek voor tekst/regex',
		'pattern_description' => 'Als dit patroon niet gevonden wordt op de website, zal de server als offline gemarkeerd worden. Regular expressions zijn toegestaan.',
		'last_check' => 'Laatst gecontroleerd',
		'last_online' => 'Laatst online',
		'last_offline' => 'Laatst offline',
		'monitoring' => 'Monitoring',
		'no_monitoring' => 'No monitoring',
		'email' => 'Email',
		'send_email' => 'Stuur email',
		'sms' => 'SMS',
		'send_sms' => 'Stuur SMS',
		'pushover' => 'Pushover',
		'users' => 'Gebruikers',
		'delete_title' => 'Verwijder server',
		'delete_message' => 'Weet je zeker dat je deze server wilt verwijderen: \'%1\'?',
		'deleted' => 'Server verwijderd.',
		'updated' => 'Server gewijzigd.',
		'inserted' => 'Server toegevoegd.',
		'latency' => 'Response tijd',
		'latency_max' => 'Latency (maximum)',
		'latency_min' => 'Latency (minimum)',
		'latency_avg' => 'Latency (gemiddeld)',
		'uptime' => 'Uptime',
		'year' => 'Jaar',
		'month' => 'Maand',
		'week' => 'Week',
		'day' => 'Dag',
		'hour' => 'Uur',
		'warning_threshold' => 'Warning threshold',
		'warning_threshold_description' => 'Aantal mislukte pogingen voordat de server als offline gemarkeerd wordt.',
		'chart_last_week' => 'Afgelopen week',
		'chart_history' => 'Geschiedenis',
		// Charts date format according jqPlot date format  http://www.jqplot.com/docs/files/plugins/jqplot-dateAxisRenderer-js.html
		'chart_day_format' => '%d-%m-%Y',
		'chart_long_date_format' => '%d-%m-%Y %H:%M:%S',
		'chart_short_date_format' => '%d-%m %H:%M',
		'chart_short_time_format' => '%H:%M',
		'warning_notifications_disabled_sms' => 'SMS notificaties zijn uitgeschakeld.',
		'warning_notifications_disabled_email' => 'Email notificaties zijn uitgeschakeld.',
		'warning_notifications_disabled_pushover' => 'Pushover notificaties zijn uitgeschakeld.',
		'error_server_no_match' => 'Server niet gevonden.',
		'error_server_label_bad_length' => 'Het label moet tussen de 1 en 255 karakters lang zijn.',
		'error_server_ip_bad_length' => 'Het domein / IP moet tussen de 1 en 255 karakters lang zijn.',
		'error_server_ip_bad_service' => 'Het IP adres is ongeldig.',
		'error_server_ip_bad_website' => 'De website URL is ongeldig.',
		'error_server_type_invalid' => 'Het geselecteerde server type is ongeldig.',
		'error_server_warning_threshold_invalid' => 'De warning threshold moet een numerieke waarde zijn groter dan 0.',
	),
	'config' => array(
		'general' => 'Algemeen',
		'language' => 'Taal',
		'show_update' => 'Controleer wekelijks voor updates?',
		'email_status' => 'Sta email berichten toe?',
		'email_from_email' => 'Email van adres',
		'email_from_name' => 'Email van naam',
		'email_smtp' => 'SMTP gebruiken',
		'email_smtp_host' => 'SMTP host',
		'email_smtp_port' => 'SMTP poort',
		'email_smtp_security' => 'SMTP beveiliging',
		'email_smtp_security_none' => 'Geen',
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
		'sms_gateway_smsglobal' => 'SMSGlobal',
		'sms_gateway_smsit' => 'Smsit',
		'sms_gateway_freevoipdeal' => 'FreeVoipDeal',
		'sms_gateway_username' => 'Gateway gebruikersnaam',
		'sms_gateway_password' => 'Gateway wachtwoord',
		'sms_from' => 'Telefoonnummer afzender',
		'pushover_status' => 'Sta Pushover berichten toe?',
		'pushover_description' => 'Pushover is een dienst die het gemakkelijk maakt om real-time notificaties te ontvangen. Zie <a href="https://pushover.net/">hun website</a> voor meer informatie.',
		'pushover_clone_app' => 'Klik hier om je Pushover app te maken',
		'pushover_api_token' => 'Pushover App API Token',
		'pushover_api_token_description' => 'Voordat je Pushover kunt gebruiken moet je een <a href="%1$s" target="_blank">App registreren</a> via hun website, en daarvan de App API Token hier invullen.',
		'alert_type' => 'Selecteer wanneer je een notificatie wilt',
		'alert_type_description' => '<b>Status change:</b> '.
			'Je ontvangt alleen bericht wanneer een server van status verandert. Dus van online -> offline of offline -> online.<br/>'.
			 '<br /><b>Offline:</b> '.
			'Je ontvangt bericht wanneer een server offline gaat voor de *EERSTE KEER*. Bijvoorbeeld, '.
			'je cronjob draait iedere 15 min en je server gaat down om 01:00 en blijft offline tot 06:00. '.
			'Je krijgt 1 bericht om 01:00 en dat is het.<br/>'.
			'<br/><b>Altijd:</b> '.
			'Je krijgt een bericht elke keer dat het script draait en een website is down, ook al is de site al een paar uur offline.',
		'alert_type_status' => 'Status verandering',
		'alert_type_offline' => 'Offline',
		'alert_type_always' => 'Altijd',
		'log_status' => 'Log status',
		'log_status_description' => 'Als de log status aan staat, zal de monitor een log aanmaken elke keer dat hij door de notificatie instellingen komt.',
		'log_email' => 'Log emails verstuurd bij het script?',
		'log_sms' => 'Log sms berichten verstuurd bij het script?',
		'log_pushover' => 'Log Pushover berichten verstuurd bij het script?',
		'updated' => 'De configuratie is gewijzigd.',
		'tab_email' => 'Email',
		'tab_sms' => 'SMS',
		'tab_pushover' => 'Pushover',
		'settings_email' => 'Email instellingen',
		'settings_sms' => 'SMS instellingen',
		'settings_pushover' => 'Pushover instellingen',
		'settings_notification' => 'Notificatie instellingen',
		'settings_log' => 'Log instellingen',
		'auto_refresh' => 'Auto-refresh',
		'auto_refresh_servers' =>
			'Auto-refresh servers pagina.<br/>'.
			'<span class="small">'.
			'Tijd in seconden, als de tijd 0 is wordt de pagina niet ververst.'.
			'</span>',
		'seconds' => 'seconden',
		'test' => 'Test',
		'test_email' => 'Er zal een email verstuurd worden naar het email adres in je profiel.',
		'test_sms' => 'Er zal een SMS verstuurd worden naar het telefoonnummer in je profiel.',
		'test_pushover' => 'Er zal een Pushover notificatie verstuurd worden naar de user key/device in je profiel.',
		'send' => 'Verstuur',
		'test_subject' => 'Test',
		'test_message' => 'Test bericht',
		'email_sent' => 'Email verzonden',
		'email_error' => 'Er is een fout opgetreden tijdens het verzenden',
		'sms_sent' => 'SMS verzonden',
		'sms_error' => 'Er is een fout opgetreden tijdens het verzenden',
		'sms_error_nomobile' => 'Kan test SMS niet verzenden: er is geen telefoonnummer ingevuld in je profiel.',
		'pushover_sent' => 'Pushover notificatie verzonden',
		'pushover_error' => 'De volgende fout is opgetreden bij het versturen van de Pushover notificatie: %s',
		'pushover_error_noapp' => 'Kan test notificatie niet verzenden: er is geen Pushover App API token gevonden in de algemene configuratie.',
		'pushover_error_nokey' => 'Kan test notificatie niet verzenden: er is geen Pushover key gevonden in je profiel.',
		'log_retention_period' => 'Log retentie periode',
		'log_retention_period_description' => 'Aantal dagen dat logs van notificaties en archieven van server uptime worden bewaard. Vul 0 in om log opruiming uit te zetten.',
		'log_retention_days' => 'dagen',
	),
	// for newlines in the email messages use <br/>
	'notifications' => array(
		'off_sms' => 'Server %LABEL% is DOWN: ip=%IP%, poort=%PORT%. Fout=%ERROR%',
		'off_email_subject' => 'BELANGRIJK: Server %LABEL% is DOWN',
		'off_email_body' => "De server kon niet worden bereikt:<br/><br/>Server: %LABEL%<br/>IP: %IP%<br/>Poort: %PORT%<br/>Fout: %ERROR%<br/>Datum: %DATE%",
		'off_pushover_title' => 'Server %LABEL% is DOWN',
		'off_pushover_message' => "De server kon niet worden bereikt:<br/><br/>Server: %LABEL%<br/>IP: %IP%<br/>Poort: %PORT%<br/>Fout: %ERROR%<br/>Datum: %DATE%",
		'on_sms' => 'Server %LABEL% is RUNNING: ip=%IP%, poort=%PORT%',
		'on_email_subject' => 'BELANGRIJK: Server %LABEL% is RUNNING',
		'on_email_body' => "Server %LABEL% is weer online:<br/><br/>Server: %LABEL%<br/>IP: %IP%<br/>Poort: %PORT%<br/>Datum: %DATE%",
		'on_pushover_title' => 'Server %LABEL% is RUNNING',
		'on_pushover_message' => "Server %LABEL% is weer online:<br/><br/>Server: %LABEL%<br/>IP: %IP%<br/>Poort: %PORT%<br/>Datum: %DATE%",
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
		'password_reset_email_body' => 'Gebruik de onderstaande link om je wachtwoord te wijzigen. Let op, deze link verloopt na 1 uur.<br/><br/>%link%',
		'error_user_incorrect' => 'De opgegeven gebruikersnaam is onjuist.',
		'error_login_incorrect' => 'De informatie is niet juist.',
		'error_login_passwords_nomatch' => 'De ingevulde wachtwoorden komen niet overeen.',
		'error_reset_invalid_link' => 'De reset link is ongeldig.',
		'success_password_forgot' => 'Er is een mail verstuurd met informatie om je wachtwoord aan te passen.',
		'success_password_reset' => 'Je wachtwoord is aangepast. Je kunt nu inloggen.',
	),
	'error' => array(
		'401_unauthorized' => 'Unauthorized',
		'401_unauthorized_description' => 'U heeft niet de juiste bevoegdheden om deze pagina te bekijken.',
	),
);
