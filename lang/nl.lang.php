<?php

/*
 * PHP Server Monitor v2.0.1
 * Monitor your servers with error notification
 * http://phpservermon.sourceforge.net/
 *
 * Copyright (c) 2008-2011 Pepijn Over (ipdope@users.sourceforge.net)
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
 */

$sm_lang = array(
	'system' => array(
		'title' => 'Server Monitor',
		'servers' => 'servers',
		'users' => 'gebruikers',
		'log' => 'log',
		'update' => 'update',
		'config' => 'config',
		'help' => 'help',
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
		'add_new' => 'Voeg toe?',
		'update_available' => 'Een nieuwe update is beschikbaar op <a href="http://phpservermon.sourceforge.net" target="_blank">http://phpservermon.sourceforge.net</a>.',
	),
	'users' => array(
		'user' => 'gebruiker',
		'name' => 'Naam',
		'mobile' => 'Mobiel',
		'email' => 'Email',
		'updated' => 'Gebruiker gewijzigd.',
		'inserted' => 'Gebruiker toegevoegd.',
	),
	'log' => array(
		'title' => 'Log entries',
		'type' => 'Type',
		'status' => 'status',
		'email' => 'email',
		'sms' => 'sms',
	),
	'servers' => array(
		'server' => 'Server',
		'label' => 'Label',
		'domain' => 'Domein/IP',
		'port' => 'Poort',
		'type' => 'Type',
		'last_check' => 'Laatst gecontroleerd',
		'last_online' => 'Laatst online',
		'monitoring' => 'Monitoring',
		'send_email' => 'Stuur email',
		'send_sms' => 'Stuur SMS',
		'updated' => 'Server gewijzigd.',
		'inserted' => 'Server toegevoegd.',
		'rtime' => 'Response tijd',
	),
	'config' => array(
		'general' => 'Algemeen',
		'language' => 'Taal',
		'show_update' => 'Check for new updates weekly?',
		'english' => 'Engels',
		'dutch' => 'Nederlands',
		'french' => 'Frans',
		'german' => 'Duits',
		'email_status' => 'Sta email berichten toe?',
		'email_from_email' => 'Email van adres',
		'email_from_name' => 'Email van naam',
		'sms_status' => 'Sta SMS berichten toe?',
		'sms_gateway' => 'Gateway voor het sturen van SMS',
		'sms_gateway_mollie' => 'Mollie',
		'sms_gateway_spryng' => 'Spryng',
		'sms_gateway_inetworx' => 'Inetworx',
		'sms_gateway_clickatell' => 'Clickatell',
		'sms_gateway_username' => 'Gateway gebruikersnaam',
		'sms_gateway_password' => 'Gateway wachtwoord',
		'sms_from' => 'Telefoonnummer afzender',
		'alert_type' =>
			'Selecteer wanneer je een notificatie wilt.<br/>'.
			'<div class="small">'.
 			'1) Status verandering<br/>'.
			'Je ontvangt alleen bericht wanneer een server van status verandert. Dus van online -> offline of offline -> online.<br/>'.
			 '2) Offline<br/>'.
			'Je ontvangt bericht wanneer een server offline gaat voor de *EERSTE KEER*. Bijvoorbeeld, '.
			'je cronjob draait iedere 15 min en je server gaat down om 01:00 en blijft offline tot 06:00. '.
			'Je krijgt 1 bericht om 01:00 en dat is het.<br/>'.
			'3) Altijd<br/>'.
			'Je krijgt een bericht elke keer dat het script draait en een website is down, ook al is de site al een paar uur offline.'.
			'</div>',

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
);

?>