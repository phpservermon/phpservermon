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
 * @link        http://www.phpservermonitor.org/
 **/

$sm_lang = array(
	'system' => array(
		'title' => 'Serveur de Supervision',
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
		'go_back' => 'Go back',
	),
	'menu' => array(
		'config' => 'Configuration',
		'server' => 'Serveurs',
		'server_log' => 'Evenements',
		'server_status' => 'Status',
		'server_update' => 'Mise &agrave; jour',
		'user' => 'Utilisateurs',
		'help' => 'Aide',
	),
	'users' => array(
		'user' => 'Utilisateur',
		'name' => 'Nom',
		'user_name' => 'Username',
		'password' => 'Password',
		'password_repeat' => 'Password repeat',
		'password_leave_blank' => 'Leave blank to keep unchanged',
		'level' => 'Level',
		'level_10' => 'Administrator',
		'level_20' => 'User',
		'mobile' => 'Mobile',
		'email' => 'Email',
		'updated' => 'Utilisateur mis &agrave; jour.',
		'inserted' => 'Utilisateur ajout&eacute;.',
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
		'language_bg' => 'Bulgarian',
		'language_nl' => 'Dutch',
		'language_fr' => 'Francais',
		'language_de' => 'German',
		'language_kr' => 'Korean',
		'language_br' => 'Portuguese - Brazilian',
		'show_update' => 'V&eacute;rifier les nouvelles mis &agrave; jour hebdomadairement?',
		'email_status' => 'Autoriser l envoi de mail?',
		'email_from_email' => 'Exp&eacute;diteur',
		'email_from_name' => 'Nom de l exp&eacute;diteur',
		'email_smtp' => 'Enable SMTP',
		'email_smtp_host' => 'SMTP host',
		'email_smtp_port' => 'SMTP port',
		'email_smtp_username' => 'SMTP username',
		'email_smtp_password' => 'SMTP password',
		'email_smtp_noauth' => 'Leave blank for no authentication',
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
