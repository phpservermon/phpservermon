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
	'name' => 'Français - French',
	'system' => array(
		'title' => 'Server Monitor',
		'install' => 'Installer',
		'action' => 'Action',
		'save' => 'Enregistrer',
		'edit' => 'Editer',
		'delete' => 'Supprimer',
		'deleted' => 'L\'enregistrement a été supprimé',
		'date' => 'Date',
		'message' => 'Message',
		'yes' => 'Oui',
		'no' => 'Non',
		'edit' => 'Editer',
		'insert' => 'Nouveau',
		'add_new' => 'Nouveau',
		'update_available' => 'Une nouvelle version ({version}) est disponible à l\'adresse <a href="http://www.phpservermonitor.org" target="_blank">http://www.phpservermonitor.org</a>.',
		'back_to_top' => 'Haut de page',
		'go_back' => 'Retour',
		// date/time format according the strftime php function format parameter http://php.net/manual/function.strftime.php
		'short_day_format' => 'Le %e %B',
		'long_day_format' => 'Le %e %B %Y',
		'yesterday_format' => 'Hier à %kh%M',
		'other_day_format' => '%A à %kh%M',
		'never' => 'Jamais',
		'hours_ago' => 'Il y a %d heures',
		'an_hour_ago' => 'Il y a une heure',
		'minutes_ago' => 'Il y a %d minutes',
		'a_minute_ago' => 'Il y a une minute',
		'seconds_ago' => 'Il y a %d secondes',
		'a_second_ago' => 'Il y a une seconde',
	),
	'menu' => array(
		'config' => 'Configuration',
		'server' => 'Serveurs',
		'server_log' => 'Événements',
		'server_status' => 'États',
		'server_update' => 'Mise à jour',
		'user' => 'Utilisateurs',
		'help' => 'Aide',
	),
	'users' => array(
		'user' => 'Utilisateur',
		'name' => 'Nom',
		'user_name' => 'Nom d\'utilisateur',
		'password' => 'Mot de passe',
		'password_repeat' => 'Répéter le mot de passe',
		'password_leave_blank' => 'Laisser vide pour ne pas le modifier',
		'level' => 'Niveau',
		'level_10' => 'Administrateur',
		'level_20' => 'Utilisateur',
		'level_description' => 'Les <b>Administrateurs</b> ont un accès total. Ils peuvent gérer les serveurs, les utilisateurs et éditer la configuration globale.<br/>Les <b>Utilisateurs</b> ne peuvent que voir et mettre à jour les serveurs qui leur ont été assignés.',
		'mobile' => 'Numéro de téléphone',
		'email' => 'Email',
		'updated' => 'Utilisateur mis à jour.',
		'inserted' => 'Utilisateur ajouté.',
		'profile' => 'Profil',
		'profile_updated' => 'Votre profil a été mis à jour.',
		'error_user_name_bad_length' => 'Le nom d\'utilisateur doit avoir entre 2 et 64 caractères.',
		'error_user_name_invalid' => 'Le nom d\'utilisateur ne peut contenir que des caractères alphabetiques (a-z, A-Z), des chiffres (0-9) ou underscore (_).',
		'error_user_name_exists' => 'Ce nom d\'utilisateur existe déjà.',
		'error_user_email_bad_length' => 'L\'adresse email doit avoir entre 5 et 255 caractères.',
		'error_user_email_invalid' => 'L\'adresse email n\'est pas valide.',
		'error_user_level_invalid' => 'Le niveau d\'utilisateur n\'est pas valide.',
		'error_user_no_match' => 'L\'utilisateur n\'a pas été trouvé dans la base de donnée.',
		'error_user_password_invalid' => 'Le mot de passe n\'est pas valide.',
		'error_user_password_no_match' => 'Le mot de passe est incorrect.',
	),
	'log' => array(
		'title' => 'Événements',
		'type' => 'Type',
		'status' => 'État',
		'email' => 'email',
		'sms' => 'SMS',
	),
	'servers' => array(
		'server' => 'Serveur',
		'label' => 'Description',
		'domain' => 'Domaine/IP',
		'port' => 'Port',
		'type' => 'Type',
		'type_website' => 'Site Web',
		'type_service' => 'Service',
		'pattern' => 'Rechercher un texte/motif',
		'pattern_description' => 'Si ce texte n\'est par retrouvé sur le site web, le serveur est marqué hors-service. Les expressions réguliaires sont autorisées.',
		'last_check' => 'Dernière vérification',
		'last_online' => 'Dernière fois OK',
		'monitoring' => 'Serveillé',
		'send_email' => 'Envoyer un email',
		'send_sms' => 'Envoyer un SMS',
		'updated' => 'Serveur mis à jour.',
		'inserted' => 'Serveur ajouté.',
		'latency' => 'Temps de réponse',
		'latency_max' => 'Temps de réponse maximum',
		'latency_min' => 'Temps de réponse minimum',
		'latency_avg' => 'Temps de réponse moyen',
		'year' => 'Année',
		'month' => 'Mois',
		'week' => 'Semaine',
		'day' => 'Jour',
		'hour' => 'Heure',
		'warning_threshold' => 'Seuil d\'alerte',
		'warning_threshold_description' => 'Nombre d\'échecs de connexion avant que le serveur soit marqué hors-service.',
		'chart_last_week' => 'La dernière semaine',
		'chart_history' => 'Historique',
		// Charts date format according jqPlot date format  http://www.jqplot.com/docs/files/plugins/jqplot-dateAxisRenderer-js.html
		'chart_day_format' => '%d/%m/%Y',
		'chart_long_date_format' => '%d/%m/%Y %H:%M:%S',
		'chart_short_date_format' => '%d/%m %H:%M',
		'chart_short_time_format' => '%H:%M',
	),
	'config' => array(
		'general' => 'Général',
		'language' => 'Langue',
		'show_update' => 'Vérifier les nouvelles mise à jour chaque semaines',
		'email_status' => 'Autoriser l\'envoi de mail',
		'email_from_email' => 'Adresse de l\'expéditeur',
		'email_from_name' => 'Nom de l\'expéditeur',
		'email_smtp' => 'Utiliser un serveur SMTP',
		'email_smtp_host' => 'Adresse serveur SMTP',
		'email_smtp_port' => 'Port SMTP',
		'email_smtp_username' => 'Nom utilisateur SMTP',
		'email_smtp_password' => 'Mot de passe SMTP',
		'email_smtp_noauth' => 'Laisser vide si pas d\'authentication',
		'sms_status' => 'Autoriser l\'envoi de SMS',
		'sms_gateway' => 'Passerelle à utiliser pour l\'envoi de SMS',
		'sms_gateway_mosms' => 'Mosms',
		'sms_gateway_mollie' => 'Mollie',
		'sms_gateway_spryng' => 'Spryng',
		'sms_gateway_inetworx' => 'Inetworx',
		'sms_gateway_clickatell' => 'Clickatell',
        'sms_gateway_textmarketer' => 'Textmarketer',
		'sms_gateway_username' => 'Nom utilisateur de la passerelle',
		'sms_gateway_password' => 'Mot de passe de la passerelle',
		'sms_from' => 'SMS de l\'expéditeur',
		'alert_type' => 'Choisissez quand vous souhaitez être notifié.<br/>',
		'alert_type_description' => '<b>Changement d\'état : </b>'.
			'Vous recevez une notification chaque fois que le serveur change d\'état. C\'est-à-dire passe de l\'état OK à HORS SERVICE ou de HORS SERVICE à OK.<br/>'.
			 '<br/><b>Hors service : </b>'.
			'Vous ne recevez une notification que quand le serveur passe de l\'état OK à HORS SERVICE. Par exemple, '.
			'Votre tache planifiée s\'exécute toute les 15 minutes et votre serveur passe à l\'état HORS SERVICE à 1 heure du matin et le reste jusqu\'à 6 heures du matin.'.
			'Vous ne recevez qu\'une seule notification à 1 heure du matin.<br/>'.
			'<br/><b>Toujours : </b>'.
			'Vous recevez une notification à chaque exécution de la tache planifiée si le serveur est à l\'état HORS SERVICE ',
		'alert_type_status' => 'Changement d\'état',
		'alert_type_offline' => 'Hors service',
		'alert_type_always' => 'Toujours',
		'log_status' => 'Etat des événements<br/><div class="small">Si l\'option est activée, un événement est enregistré chaque fois qu\'une notification a lieu</div>',
		'log_email' => 'Enregistrer tout les emails envoyés',
		'log_sms' => 'Enregistrer tout les SMS envoyé',
		'updated' => 'La configuration a été mise à jour.',
		'settings_email' => 'Configuration email',
		'settings_sms' => 'Configuration SMS',
		'settings_notification' => 'Configuration des notifications',
		'settings_log' => 'Configuration des événements',
		'auto_refresh_servers' =>
			'Auto-rachaîchissement de la page serveurs<br/>'.
			'<div class="small">'.
			'Temps en secondes. Si 0, la page n\'est pas rafraîchie.'.
			'</div>',
	),
	// for newlines in the email messages use <br/>
	'notifications' => array(
		'off_sms' => 'Le Serveur \'%LABEL%\' est HORS SERVICE: IP=%IP%, Port=%PORT%. Erreur=%ERROR%',
		'off_email_subject' => 'IMPORTANT: Le Serveur \'%LABEL%\' est HORS SERVICE',
		'off_email_body' => "Impossible de se connecter au serveur suivant:<br/><br/>Serveur: %LABEL%<br/>IP: %IP%<br/>Port: %PORT%<br/>Erreur: %ERROR%<br/>Date: %DATE%",
		'on_sms' => 'Le Serveur \'%LABEL%\' est OK: IP=%IP%, Port=%PORT%',
		'on_email_subject' => 'IMPORTANT: Le Serveur \'%LABEL%\' est OK',
		'on_email_body' => "Le Serveur '%LABEL%' est de nouveau OK:<br/><br/>Serveur: %LABEL%<br/>IP: %IP%<br/>Port: %PORT%<br/>Date: %DATE%",
	),
	'login' => array(
		'welcome_usermenu' => 'Bonjour %user_name%',
		'title_sign_in' => 'Connectez vous SVP',
		'title_forgot' => 'Mot de passe oublié ?',
		'title_reset' => 'Réinitialisation du mot de passe',
		'submit' => 'Envoyer',
		'remember_me' => 'Se vouvenir de moi',
		'login' => 'Connexion',
		'logout' => 'Déconnexion',
		'username' => 'Nom',
		'password' => 'Mot de passe',
		'password_repeat' => 'Répéter le mot de passe',
		'password_forgot' => 'Mot de passe oublié ?',
		'password_reset' => 'Réinitialiser le mot de passe',
		'password_reset_email_subject' => 'Réinitialisation du mot de passe pour PHP Server Monitor',
		'password_reset_email_body' => 'Cliquez sur le lien ci-dessous pour réinitialiser votre mot de passe. Veuillez noter qu\'il expire dans une heure.<br/><br/>%link%',
		'error_user_incorrect' => 'Nom d\'utilisateur invalide.',
		'error_login_incorrect' => 'Informations incorrectes.',
		'error_login_passwords_nomatch' => 'Mot de passe invalide.',
		'error_reset_invalid_link' => 'Le lien d\initialisation du mot de passe n\'est pas valide.',
		'success_password_forgot' => 'Un email vous a été envoyé pour réinitialiser votre mot de passe.',
		'success_password_reset' => 'Votre mot de passe a été réinitialisé.',
	),
);
