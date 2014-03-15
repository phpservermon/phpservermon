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
		'title' => 'Surveillance de serveurs',
		'servers' => 'Serveurs',
		'users' => 'Utilisateurs',
		'log' => 'Événements',
		'status' => 'État',
		'update' => 'Mise à jour',
		'config' => 'Configuration',
		'help' => 'Aide',
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
		'update_available' => 'Une nouvelle version est disponible à l\'adresse <a href="http://phpservermon.sourceforge.net" target="_blank">http://phpservermon.sourceforge.net</a>.',
		'back_to_top' => 'Haut de page',
	),
	'users' => array(
		'user' => 'Utilisateur',
		'name' => 'Nom',
		'mobile' => 'Mobile',
		'email' => 'Email',
		'updated' => 'Utilisateur mis à jour.',
		'inserted' => 'Utilisateur ajouté.',
	),
	'log' => array(
		'title' => 'Evenements',
		'type' => 'Type',
		'status' => 'État',
		'email' => 'Email',
		'sms' => 'SMS',
	),
	'servers' => array(
		'server' => 'Serveur',
		'label' => 'Description',
		'domain' => 'Domaine/IP',
		'port' => 'Port',
		'type' => 'Type',
		'pattern' => 'Rechercher un texte/motif',
		'last_check' => 'Dernière vérification',
		'last_online' => 'Dernière fois OK',
		'monitoring' => 'Surveillé',
		'send_email' => 'Envoyer des eMails',
		'send_sms' => 'Envoyer des SMS',
		'updated' => 'Serveur mis à jour.',
		'inserted' => 'Serveur ajouté.',
		'rtime' => 'Temps de réponse',
	),
	'config' => array(
		'general' => 'Général',
		'language' => 'Langue',
		'language_en' => 'English',
		'language_nl' => 'Dutch',
		'language_fr' => 'Français',
		'language_de' => 'German',
		'language_kr' => 'Korean',
		'language_br' => 'Portuguese - Brazilian',
		'show_update' => 'Vérifier les nouvelles mis à jour chaque semaines',
		'email_status' => 'Autoriser l\'envoi de mail',
		'email_from_email' => 'Email de l\'expéditeur',
		'email_from_name' => 'Nom de l\'expéditeur',
		'sms_status' => 'Autoriser l\'envoi de SMS',
		'sms_gateway' => 'Passerelle à utiliser pour l\'envoi de SMS',
		'sms_gateway_mosms' => 'Mosms',
		'sms_gateway_mollie' => 'Mollie',
		'sms_gateway_spryng' => 'Spryng',
		'sms_gateway_inetworx' => 'Inetworx',
		'sms_gateway_clickatell' => 'Clickatell',
        'sms_gateway_textmarketer' => 'Textmarketer',
		'sms_gateway_username' => 'Nom utilisateur de la passerelle',
		'sms_gateway_password' => 'Mot de passe utilisateur de la passerelle',
		'sms_from' => 'SMS de l\'expéditeur',
		'alert_type' => 'Choisissez quand vous souhaitez être notifié.<br/>',
		'alert_type_description' => '<b>Changement d\'état : </b>'.
			'Vous recevrez une notification quand le serveur changera d\'état. C\'est-à-dire de l\'état OK à HORS SERVICE ou de HORS SERVICE à OK.<br/>'.
			 '<br/><b>Hors service : </b>'.
			'Vous recevrez une notification quand le serveur passera à l\'état OK à HORS SERVICE. Par exemple, '.
			'Votre tache planifiée s\'exécute toute les 15 minutes et votre serveur entre dans l\'état HORS SERVICE à 1 heure du matin et le reste jusqu\'à 6 heures du matin.'.
			'Vous ne recevrez qu\'une seule notification à 1 heure du matin.<br/>'.
			'<br/><b>Toujours : </b>'.
			'Vous recevrez une notification à chaque exécution de la tache planifiée si le serveur est à l\'état HORS SERVICE ',

		'alert_type_status' => 'Changement d\'état',
		'alert_type_offline' => 'Hors service',
		'alert_type_always' => 'Toujours',
		'log_status' => 'Etat des événements<br/><div class="small">Si l\'option est activée, un événement est enregistré chaque fois qu\'une notification a lieu</div>',
		'log_email' => 'Enregistrer tout les emails envoyés',
		'log_sms' => 'Enregistrer tout les SMS envoyés',
		'updated' => 'La configuration a été mise à jour.',
		'settings_email' => 'Configuration mail',
		'settings_sms' => 'Configuration SMS',
		'settings_notification' => 'Configuration des notifications',
		'settings_log' => 'Configuration des événements',
		'auto_refresh_servers' =>
			'Auto-rachaîchissement de la page serveurs<br/>'.
			'<div class="small">'.
			'Temps en secondes, Si 0, la page n\'est pas rafraîchie.'.
			'</div>',
	),
	// for newlines in the email messages use <br/>
	'notifications' => array(
		'off_sms' => 'Le Serveur \'%LABEL%\' est HORS SERVICE: IP=%IP%, Port=%PORT%. Erreur=%ERROR%',
		'off_email_subject' => 'IMPORTANT: Le Serveur \'%LABEL%\' est HORS SERVICE',
		'off_email_body' => "Impossible de v&eacute;rifier le serveur suivant:<br/><br/>Serveur: %LABEL%<br/>IP: %IP%<br/>Port: %PORT%<br/>Erreur: %ERROR%<br/>Date: %DATE%",
		'on_sms' => 'Le Serveur \'%LABEL%\' est OK: IP=%IP%, Port=%PORT%',
		'on_email_subject' => 'IMPORTANT: Le Serveur \'%LABEL%\' est OK',
		'on_email_body' => "Le Serveur '%LABEL%' est de nouveau OK:<br/><br/>Serveur: %LABEL%<br/>IP: %IP%<br/>Port: %PORT%<br/>Date: %DATE%",
	),
);

?>