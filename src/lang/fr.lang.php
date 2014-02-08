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
 * @author      David Ribeiro
 * @copyright   Copyright (c) 2008-2014 Pepijn Over <pep@neanderthal-technology.com>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://phpservermon.neanderthal-technology.com/
 **/

$sm_lang = array(
	'system' => array(
		'title' => 'Serveur de Supervision',
		'servers' => 'Serveurs',
		'users' => 'Utilisateurs',
		'log' => 'Evenements',
		'status' => 'Status',
		'update' => 'Mise &agrave; jour',
		'config' => 'Configuration',
		'help' => 'Aide',
		'install' => 'Install',
		'action' => 'Action',
		'save' => 'Enregistrer',
		'edit' => 'Editer',
		'delete' => 'Effacer',
		'deleted' => 'L enregistrement a ete effac&eacute;',
		'date' => 'Date',
		'message' => 'Message',
		'yes' => 'Oui',
		'no' => 'Non',
		'edit' => 'Editer',
		'insert' => 'Inserer',
		'add_new' => 'Rajouter un nouveau serveur?',
		'update_available' => 'Une nouvelle version est disponible &agrave; l adresse <a href="http://phpservermon.sourceforge.net" target="_blank">http://phpservermon.sourceforge.net</a>.',
		'back_to_top' => 'Haut de page',
	),
	'users' => array(
		'user' => 'Utilisateur',
		'name' => 'Nom',
		'mobile' => 'Mobile',
		'email' => 'Email',
		'updated' => 'Utilisateur mis &agrave; jour.',
		'inserted' => 'Utilisateur ajout&eacute;.',
	),
	'log' => array(
		'title' => 'Evenements',
		'type' => 'Type',
		'status' => 'Etat',
		'email' => 'Email',
		'sms' => 'SMS',
	),
	'servers' => array(
		'server' => 'Serveur',
		'label' => 'Description',
		'domain' => 'Domaine/IP',
		'port' => 'Port',
		'type' => 'Type',
		'pattern' => 'Search string/pattern',
		'last_check' => 'Derni&egrave;re v&eacute;rification',
		'last_online' => 'Derni&egrave;re fois OK',
		'monitoring' => 'Supervision',
		'send_email' => 'Envoyer un Email',
		'send_sms' => 'Envoyer un SMS',
		'updated' => 'Serveur mis &agrave; jour.',
		'inserted' => 'Serveur ajout&eacute;.',
		'rtime' => 'Temps de r&acute;ponse',
	),
	'config' => array(
		'general' => 'General',
		'language' => 'Langue',
		'language_en' => 'English',
		'language_nl' => 'Dutch',
		'language_fr' => 'Francais',
		'language_de' => 'German',
		'language_kr' => 'Korean',
		'language_br' => 'Portuguese - Brazilian',
		'show_update' => 'V&eacute;rifier les nouvelles mis &agrave; jour hebdomadairement?',
		'email_status' => 'Autoriser l envoi de mail?',
		'email_from_email' => 'Exp&eacute;diteur',
		'email_from_name' => 'Nom de l exp&eacute;diteur',
		'sms_status' => 'Autoriser l envoi de SMS?',
		'sms_gateway' => 'Passerelle &agrave; utiliser pour l envoi de SMS',
		'sms_gateway_mosms' => 'Mosms',
		'sms_gateway_mollie' => 'Mollie',
		'sms_gateway_spryng' => 'Spryng',
		'sms_gateway_inetworx' => 'Inetworx',
		'sms_gateway_clickatell' => 'Clickatell',
        'sms_gateway_textmarketer' => 'Textmarketer',
		'sms_gateway_username' => 'Utilisateur sur la passerelle',
		'sms_gateway_password' => 'Mot de passe sur la passerelle',
		'sms_from' => 'SMS de l exp&eacute;diteur',
		'alert_type' => 'Choisissez quand vous souhaitez etre notifi&eacute;.<br/>',
		'alert_type_description' => '<b>Changement de statut: </b>'.
			'Vous recevrez une notification quand le serveur changera de statut. Cest-&agrave;-dire de l etat OK vers NOK ou NOK vers OK.<br/>'.
			 '<br/><b>Eteint: </b>'.
			'Vous recevrez une notification quand le serveur passera au statut ETEINT *uniquement la premi&egrave;re fois*. Par exemple, '.
			'Votre tache planifi&eacute;e s execute toute les 15 minutes et votre serveur entre dans le statut ETEINT &agrave; 1 heure du matin et il le reste jusqu &agrave; 6 heures du matin. '.
			'Vous recevrez une seule notification &agrave; 1 heure du matin et uniquement celle-ci.<br/>'.
			'<br/><b>Toujours: </b>'.
			'Vous recevrez une notification &agrave; chaque passage de la tache planifi&eacute;e si le site est en statut ETEINT ',

		'alert_type_status' => 'Changement de statut',
		'alert_type_offline' => 'Eteint',
		'alert_type_always' => 'Toujours',
		'log_status' => 'Etat des &eacute;venements<br/><div class="small">Si l etat des evenements est param&eacute;tr&eacute; &agrave; VRAI, tous les enregistrements seront enregistr&eacute;s jusqu au changement d etat</div>',
		'log_email' => 'Enregistrer tout les emails envoy&eacute;s par la tache planifi&eacute;e?',
		'log_sms' => 'Enregistrer tout les SMS envoy&eacute;s par la tache planifi&eacute;e?',
		'updated' => 'La configuration a bien e&eacute;t&eacute; mis &agrave; jour.',
		'settings_email' => 'Configuration mail',
		'settings_sms' => 'Configuration SMS',
		'settings_notification' => 'Configuration des notifications',
		'settings_log' => 'Configuration des &eacute;venements',
		'auto_refresh_servers' =>
			'Auto-refresh servers page<br/>'.
			'<div class="small">'.
			'Time in seconds, if 0 the page won\'t refresh.'.
			'</div>',
	),
	// for newlines in the email messages use <br/>
	'notifications' => array(
		'off_sms' => 'Le Serveur \'%LABEL%\' est ETEINT: IP=%IP%, Port=%PORT%. Erreur=%ERROR%',
		'off_email_subject' => 'IMPORTANT: Le Serveur \'%LABEL%\' est ETEINT',
		'off_email_body' => "Impossible de v&eacute;rifier le serveur suivant:<br/><br/>Serveur: %LABEL%<br/>IP: %IP%<br/>Port: %PORT%<br/>Erreur: %ERROR%<br/>Date: %DATE%",
		'on_sms' => 'Le Serveur \'%LABEL%\' est OK: IP=%IP%, Port=%PORT%',
		'on_email_subject' => 'IMPORTANT: Le Serveur \'%LABEL%\' est OK',
		'on_email_body' => "Le Serveur '%LABEL%' est de nouveau OK:<br/><br/>Serveur: %LABEL%<br/>IP: %IP%<br/>Port: %PORT%<br/>Date: %DATE%",
	),
);

?>