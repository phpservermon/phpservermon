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
 * @author      Jérôme Cabanis <jerome@lauraly.com>
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

$sm_lang = array(
    'name' => 'Français - French',
    'locale' => array(
        '0' => 'fr_FR.UTF-8',
        '1' => 'fr_FR',
        '2' => 'french',
    ),
    'locale_tag' => 'fr',
    'locale_dir' => 'ltr',
    'system' => array(
        'title' => 'Server Monitor',
        'install' => 'Installer',
        'action' => 'Action',
        'save' => 'Enregistrer',
        'edit' => 'Editer',
        'delete' => 'Supprimer',
        'view' => 'Détails',
        'date' => 'Date',
        'message' => 'Message',
        'yes' => 'Oui',
        'no' => 'Non',
        'insert' => 'Nouveau',
        'add_new' => 'Nouveau',
        'update_available' => 'Une nouvelle version ({version}) est disponible à l\'adresse <a
 href="https://github.com/phpservermon/phpservermon/releases/latest" target="_blank"
 rel="noopener">http://www.phpservermonitor.org</a>.',
        'back_to_top' => 'Haut de page',
        'go_back' => 'Retour',
        'ok' => 'OK',
        'bad' => 'mauvais',
        'cancel' => 'Annuler',
        'none' => 'Aucun',
        'activate' => 'Activer',
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
        'year' => 'année',
        'years' => 'années',
        'month' => 'mois',
        'months' => 'mois',
        'day' => 'jour',
        'days' => 'jours',
        'hour' => 'heure',
        'hours' => 'heures',
        'minute' => 'minute',
        'minutes' => 'minutes',
        'second' => 'seconde',
        'seconds' => 'secondes',
        'current' => 'actuel',
        'settings' => 'Paramètres',
        'search' => 'Recherche',
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
        'level' => 'Rôle',
        'level_10' => 'Administrateur',
        'level_20' => 'Utilisateur',
        'level_description' => 'Les <b>Administrateurs</b> ont un accès total. Ils peuvent gérer les serveurs, les
 utilisateurs et éditer la configuration globale.<br>Les <b>Utilisateurs</b> ne
 peuvent que voir et mettre à jour les serveurs qui leur ont été assignés.',
        'mobile' => 'Téléphone',
        'email' => 'Email',
        'pushover' => 'Pushover',
        'pushover_description' => 'Pushover est un service qui simplifie les notifications en temps réel. Voir <a
 href="https://pushover.net/" target="_blank">leur site web</a> pour plus
 d\'informations.',
        'pushover_key' => 'Clé Pushover',
        'pushover_device' => 'Appareil Pushover',
        'pushover_device_description' => 'Nom de l\'appareil auquel le message doit être envoyé. Laissez vide pour
 l\'envoyer à tous les appareils.',
        'telegram' => 'Telegram',
        'telegram_description' => '<a href="https://telegram.org/" target="_blank">Telegram</a> est une application de
 messagerie instantanée qui facilite la réception de notification en temps réel.
 Lisez la <a href="http://docs.phpservermonitor.org/"
 target="_blank">documentation</a> pour obtenir plus d\'informations sur la
 configuration de ce service.',
        'telegram_chat_id' => 'ID de conversation (Chat ID) Telegram',
        'telegram_chat_id_description' => 'Les notifications seront envoyées à la conversation correspondante.',
        'telegram_get_chat_id' => 'Cliquez ici pour obtenir votre ID de conversation (Chat ID)',
        'activate_telegram' => 'Activer les alertes Telegram',
        'activate_telegram_description' => 'Permet aux notifications Telegram d\'être envoyée à la conversation
 spécifiée. Sans cette permission, Telegram ne nous autorise pas à vous
 envoyer des notifications.',
        'telegram_bot_username_found' => 'Le BOT a été trouvé&nbsp;!<br><a href="%s" target="_blank"
 rel="noopener"><button class="btn btn-primary">Étape suivante</button></a>
 <br>Cela va ouvrir une conversation avec le BOT. Vous devez appuyer sur
 \'/start\' ou le saisir.',
        'telegram_bot_username_error_token' => '<b>401 - Unauthorized</b>. Assuez-vous que le Token API soit valide.',
        'telegram_bot_error' => 'Une erreur s\'est produite en tentant d\'activer les notifications Telegram&nbsp;: %s',
        'delete_title' => 'Supprimer un utilisateur',
        'delete_message' => 'Êtes-vous sûr de vouloir supprimer l\'utilisateur \'%1\'&nbsp;?',
        'deleted' => 'Utilisateur supprimé.',
        'updated' => 'Utilisateur mis à jour.',
        'inserted' => 'Utilisateur ajouté.',
        'profile' => 'Profil',
        'profile_updated' => 'Votre profil a été mis à jour.',
        'error_user_name_bad_length' => 'Le nom d\'utilisateur doit avoir entre 2 et 64 caractères.',
        'error_user_name_invalid' => 'Le nom d\'utilisateur ne peut contenir que des caractères alphabétiques (a-z,
 A-Z), des chiffres (0-9), points (.) ou underscore (_).',
        'error_user_name_exists' => 'Ce nom d\'utilisateur existe déjà.',
        'error_user_email_bad_length' => 'L\'adresse email doit avoir entre 5 et 255 caractères.',
        'error_user_email_invalid' => 'L\'adresse email n\'est pas valide.',
        'error_user_level_invalid' => 'Le rôle d\'utilisateur n\'est pas valide.',
        'error_user_no_match' => 'L\'utilisateur n\'a pas été trouvé dans la base de données.',
        'error_user_password_invalid' => 'Le mot de passe n\'est pas valide.',
        'error_user_password_no_match' => 'Le mot de passe est incorrect.',
    ),
    'log' => array(
        'title' => 'Événements',
        'type' => 'Type',
        'status' => 'État',
        'email' => 'Email',
        'sms' => 'SMS',
        'pushover' => 'Pushover',
        'telegram' => 'Telegram',
        'no_logs' => 'Aucun événement',
        'clear' => 'Effacer les journaux',
        'delete_title' => 'Supprimer les journaux',
        'delete_message' => 'Êtes-vous sûr de vouloir supprimer <b>tous</b> les journaux&nbsp;?',
    ),
    'servers' => array(
        'server' => 'Serveur',
        'status' => 'État',
        'label' => 'Nom',
        'domain' => 'Domaine/IP',
        'timeout' => 'Délai d\'attente',
        'timeout_description' => 'Nombre de secondes à attendre une réponse du serveur.',
        'authentication_settings' => 'Paramètres d\'authentification',
        'optional' => 'Optionnel',
        'website_username' => 'Nom d\'utilisateur',
        'website_username_description' => 'Nom d\'utilisateur pour accèder au site. (Seul l\'authentification Apache
 est supporté.)',
        'website_password' => 'Mot de passe',
        'website_password_description' => 'Mot de passe pour accèder au site. Le mot de passe est cryptè dans la
 base de donnée.',
        'fieldset_monitoring' => 'Monitoring',
        'fieldset_permissions' => 'Permissions',
        'permissions' => 'Les utilisateurs suivants pourront voir le serveur.',
        'port' => 'Port',
        'custom_port' => 'Port personnalisé',
        'popular_ports' => 'Ports courant',
        'request_method' => 'Type de requête',
        'custom_request_method' => 'Type de requête personalisée',
        'popular_request_methods' => 'Type de requête prédéfinie',
        'post_field' => 'Champ POST',
        'post_field_description' => 'Les données qui seront envoyés en utilisant le type de requête choisi.',
        'please_select' => 'Veuillez choisir',
        'type' => 'Type',
        'type_website' => 'Site Web',
        'type_service' => 'Service',
        'type_ping' => 'Ping',
        'pattern' => 'Rechercher un texte/motif',
        'pattern_description' => 'Si ce texte n\'est par retrouvé sur le site web, le serveur est marqué
 hors-service. Les expressions régulières sont autorisées.',
        'pattern_online' => 'Le texte indique que le site est',
        'pattern_online_description' => 'En ligne&nbsp;: Si ce texte est trouvé sur le site internet, le serveur sera
 considéré en ligne. Hors-ligne&nbsp;: Si ce texte n\'est pas trouvé sur le
 site, le serveur sera considéré hors-ligne.',
        'redirect_check' => 'La redirection vers un autre domaine est',
        'redirect_check_description' => 'Une redirection vers un autre domaine est généralement mauvais signe.',
        'allow_http_status' => 'Autoriser les codes de status HTTP',
        'allow_http_status_description' => 'Marquer le serveur en ligne. Les codes de status HTTP inférieur à 400
 sont considérés comme en ligne par défaut. Séparés les valeurs avec
 |.',
        'header_name' => 'Nom d\'en-têtes',
        'header_value' => 'Valeur d\'en-tête',
        'header_name_description' => 'Sensible à la casse.',
        'header_value_description' => 'Les expréssions régulières sont autorisées.',
        'last_check' => 'Dernière vérification',
        'last_online' => 'Dernière fois OK',
        'last_offline' => 'Dernière fois hors-ligne',
        'last_output' => 'Dernière sortie positive',
        'last_error' => 'Dernière erreur',
        'last_error_output' => 'Dernière erreur de sortie',
        'output' => 'Sortie',
        'monitoring' => 'Surveillé',
        'no_monitoring' => 'Non surveillé',
        'email' => 'Email',
        'send_email' => 'Envoyer un email',
        'sms' => 'SMS',
        'send_sms' => 'Envoyer un SMS',
        'pushover' => 'Pushover',
        'send_pushover' => 'Envoyer des notifications Pushover',
        'telegram' => 'Telegram',
        'send_telegram' => 'Envoyer des notifications Telegram',
        'users' => 'Utilisateurs',
        'delete_title' => 'Supprimer un serveur',
        'delete_message' => 'Êtes-vous sûr de vouloir supprimer le serveur \'%1\'&nbsp;?',
        'deleted' => 'Serveur supprimé.',
        'updated' => 'Serveur mis à jour.',
        'inserted' => 'Serveur ajouté.',
        'latency' => 'Temps de réponse',
        'latency_max' => 'Temps de réponse maximum',
        'latency_min' => 'Temps de réponse minimum',
        'latency_avg' => 'Temps de réponse moyen',
        'online' => 'en ligne',
        'offline' => 'hors ligne',
        'uptime' => 'Disponibilité',
        'year' => 'Année',
        'month' => 'Mois',
        'week' => 'Semaine',
        'day' => 'Jour',
        'hour' => 'Heure',
        'warning_threshold' => 'Seuil d\'alerte',
        'warning_threshold_description' => 'Nombre d\'échecs de connexion avant que le serveur soit marqué
 hors-service.',
        'chart_last_week' => 'La dernière semaine',
        'chart_history' => 'Historique',
        'chart_day_format' => '%d/%m/%Y',
        'chart_long_date_format' => '%d/%m/%Y %H:%M:%S',
        'chart_short_date_format' => '%d/%m %H:%M',
        'chart_short_time_format' => '%H:%M',
        'warning_notifications_disabled_sms' => 'Les notifications SMS sont désactivées.',
        'warning_notifications_disabled_email' => 'Les notifications par email sont désactivées.',
        'warning_notifications_disabled_pushover' => 'Les notifications Pushover sont désactivées.',
        'warning_notifications_disabled_telegram' => 'Les notifications Telegram sont désactivées.',
        'error_server_no_match' => 'Serveur non trouvé.',
        'error_server_label_bad_length' => 'Le nom doit avoir entre 1 et 255 caractères.',
        'error_server_ip_bad_length' => 'Domaine/IP doit avoir entre 1 et 255 caractères.',
        'error_server_ip_bad_service' => 'L\'adresse IP n\'est pas valide.',
        'error_server_ip_bad_website' => 'L\'URL du site web n\'est pas valide.',
        'error_server_type_invalid' => 'Le type de service sélectionné n\'est pas valide.',
        'error_server_warning_threshold_invalid' => 'Le seuil d\'alerte doit être un nombre entier supérieur à 0.',
    ),
    'config' => array(
        'general' => 'Général',
        'language' => 'Langue',
        'show_update' => 'Vérifier les nouvelles mises à jour chaque semaine',
        'password_encrypt_key' => 'Clée de cryptage des mots de passe',
        'password_encrypt_key_note' => 'Cette clée est utilisée pour crypter les mots de passe qui sont enregistrés
 dans la base de donnée pour les serveurs qui requiert une authentification.
 Si la clé est modifié, les mots de passe enregistré ne seront plus
 valide&nbsp;!',
        'proxy' => 'Activer le proxy',
        'proxy_url' => 'URL du proxy',
        'proxy_user' => 'Nom d\'utilisateur du proxy',
        'proxy_password' => 'Mot de passe du proxy',
        'email_status' => 'Autoriser l\'envoi de mail',
        'email_from_email' => 'Adresse de l\'expéditeur',
        'email_from_name' => 'Nom de l\'expéditeur',
        'email_smtp' => 'Utiliser un serveur SMTP',
        'email_smtp_host' => 'Adresse serveur SMTP',
        'email_smtp_port' => 'Port SMTP',
        'email_smtp_security' => 'Protocole de sécurité SMTP',
        'email_smtp_security_none' => 'Aucun',
        'email_smtp_username' => 'Nom utilisateur SMTP',
        'email_smtp_password' => 'Mot de passe SMTP',
        'email_smtp_noauth' => 'Laisser vide si pas d\'authentication',
        'sms_status' => 'Autoriser l\'envoi de SMS',
        'sms_gateway' => 'Passerelle à utiliser pour l\'envoi de SMS',
        'sms_gateway_username' => 'Nom utilisateur de la passerelle',
        'sms_gateway_password' => 'Mot de passe de la passerelle',
        'sms_from' => 'SMS de l\'expéditeur',
        'pushover_status' => 'Autoriser l\'envoi des messages Pushover',
        'pushover_description' => 'Pushover est un service qui simplifie les notifications en temps réel. Voir <a
 href="https://pushover.net/" target="_blank">leur site web</a> pour plus
 d\'informations.',
        'pushover_clone_app' => 'Cliquez ici pour créer votre application Pushover',
        'pushover_api_token' => 'Jeton application Pushover',
        'pushover_api_token_description' => 'Avant de pouvoir utiliser Pushover, vous devez <a href="%1$s"
 target="_blank" rel="noopener">créer une application</a> sur leur site
 web et entrer ici le jeton (Token) de l\'application.',
        'telegram_status' => 'Autorise l\'envoi de message Telegram',
        'telegram_description' => '<a href="https://telegram.org/" target="_blank">Telegram</a> est une application de
 messagerie instantanée qui facilite la réception de notification en temps réel.
 Lisez la <a href="http://docs.phpservermonitor.org/"
 target="_blank">documentation</a> pour obtenir plus d\'informations sur la
 configuration de ce service.',
        'telegram_api_token' => 'Token API Telegram',
        'telegram_api_token_description' => 'Afin de pouvoir utiliser Telegram, il vous faut obtenir un token api.
 Consultez la <a href="http://docs.phpservermonitor.org/"
 target="_blank">documentation</a> pour obtenir de l\'aide.',
        'alert_type' => 'Choisissez quand vous souhaitez être notifié',
        'alert_type_description' => '<b>Changement d\'état&nbsp;: </b>Vous recevez une notification chaque fois que
 le serveur change d\'état. C\'est-à-dire passe de l\'état OK à HORS SERVICE
 ou de HORS SERVICE à OK.<br><br><b>Hors service&nbsp;: </b>Vous ne recevez une
 notification que quand le serveur passe de l\'état OK à HORS SERVICE. Par
 exemple, Votre tâche planifiée s\'exécute toutes les 15 minutes et votre
 serveur passe à l\'état HORS SERVICE à 1 heure du matin et le reste jusqu\'à
 6 heures du matin.Vous ne recevez qu\'une seule notification à 1 heure du
 matin.<br><br><b>Toujours&nbsp;: </b>Vous recevez une notification à chaque
 exécution de la tâche planifiée si le serveur est à l\'état HORS SERVICE ',
        'alert_type_status' => 'Changement d\'état',
        'alert_type_offline' => 'Hors service',
        'alert_type_always' => 'Toujours',
        'combine_notifications' => 'Combiner les notifications',
        'combine_notifications_description' => 'Réduit le nombre de notifications en les combinant toutes en une
 seule. (Cela ne s\'applique pas aux SMS.)',
        'alert_proxy' => 'Le serveur proxy n\'est jamais utilisé pour les services, même quand celui-ci est activé.',
        'alert_proxy_url' => 'Format&nbsp;: hôte:port',
        'log_status' => 'Etat des événements',
        'log_status_description' => 'Si l\'option est activée, un événement est enregistré chaque fois qu\'une
 notification a lieu.',
        'log_email' => 'Enregistrer tous les emails envoyés',
        'log_sms' => 'Enregistrer tous les SMS envoyés',
        'log_pushover' => 'Enregistrer tous les messages Pushover envoyés',
        'log_telegram' => 'Enregistrer tous les messages Telegram envoyés',
        'updated' => 'La configuration a été mise à jour.',
        'tab_email' => 'Email',
        'tab_sms' => 'SMS',
        'tab_pushover' => 'Pushover',
        'tab_telegram' => 'Telegram',
        'settings_email' => 'Configuration email',
        'settings_sms' => 'Configuration SMS',
        'settings_pushover' => 'Configuration Pushover',
        'settings_telegram' => 'Configuration Telegram',
        'settings_notification' => 'Configuration des notifications',
        'settings_log' => 'Configuration des événements',
        'settings_proxy' => 'Configuration du proxy',
        'auto_refresh' => 'Auto-rachaîchissement',
        'auto_refresh_description' => 'Auto-rachaîchissement de la page serveurs.<br><span class="small">Temps en
 secondes. Si 0, la page n\'est pas rafraîchie.</span>',
        'test' => 'Tester',
        'test_email' => 'Un email va vous être envoyé à l\'adresse définie dans votre profil utilisateur.',
        'test_sms' => 'Un SMS va vous être envoyé au numéro défini dans votre profil utilisateur.',
        'test_pushover' => 'Une notification Pushover va être envoyée en utilisant la clé spécifiée dans votre
 profil utilisateur.',
        'test_telegram' => 'Une notification Telegram sera envoyé à la conversion indiqué sur votre profil (ID de
 conversation).',
        'send' => 'Envoyer',
        'test_subject' => 'Test',
        'test_message' => 'Message de test',
        'email_sent' => 'Email envoyé',
        'email_error' => 'Erreur lors de l\'envoi de l\'email',
        'sms_sent' => 'SMS envoyé',
        'sms_error' => 'Erreur lors de l\'envoi du SMS. %s',
        'sms_error_nomobile' => 'Impossible d\'envoyer un SMS de test: aucun numéro de téléphone défini dans votre
 profil.',
        'pushover_sent' => 'Notification Pushover envoyée',
        'pushover_error' => 'Une erreur s\'est produite lors de l\'envoi de la notification Pushover&nbsp;: %s',
        'pushover_error_noapp' => 'Impossible d\'envoyer une notification de test: Aucun jeton application Pushover
 n\'a été défini dans la configuration Pushover.',
        'pushover_error_nokey' => 'Impossible d\'envoyer une notification de test: Aucune clé Pushover n\'a été
 définie dans votre profil.',
        'telegram_sent' => 'Notification Telegram envoyée',
        'telegram_error' => 'Une erreur s\'est produite lors de l\'envoi de la notification&nbsp;: %s',
        'telegram_error_notoken' => 'Impossible d\'envoyé la notification de test&nbsp;: aucun token APII token
 trouvé dans la configuration.',
        'telegram_error_noid' => 'Impossible d\'envoyé la notification de test&nbsp;: aucun ID de conversation
 trouvé dans votre profil utilisateur.',
        'log_retention_period' => 'Durée de conservation',
        'log_retention_period_description' => 'Nombre de jours de conservation des événements envoyés et des temps
 de réponse des serveurs. Entrez 0 pour les conserver indéfiniment.',
        'log_retention_days' => 'jours',
    ),
    'notifications' => array(
        'off_sms' => 'Le Serveur \'%LABEL%\' est HORS SERVICE: IP=%IP%, Port=%PORT%. Erreur=%ERROR%',
        'off_email_subject' => 'IMPORTANT: Le Serveur \'%LABEL%\' est HORS SERVICE',
        'off_email_body' => 'Impossible de se connecter au serveur suivant:<br><br>Serveur&nbsp;: %LABEL%<br>IP&nbsp;:
 %IP%<br>Port&nbsp;: %PORT%<br>Erreur&nbsp;: %ERROR%<br>Date: %DATE%',
        'off_pushover_title' => 'Le Serveur \'%LABEL%\' est HORS SERVICE',
        'off_pushover_message' => 'Impossible de se connecter au serveur suivant&nbsp;:<br><br>Serveur&nbsp;:
 %LABEL%<br>IP&nbsp;: %IP%<br>Port&nbsp;: %PORT%<br>Erreur&nbsp;:
 %ERROR%<br>Date&nbsp;: %DATE%',
        'off_telegram_message' => 'Impossible de se connecter au serveur suivant&nbsp;:<br><br>Serveur&nbsp;:
 %LABEL%<br>IP&nbsp;: %IP%<br>Port&nbsp;: %PORT%<br>Erreur&nbsp;:
 %ERROR%<br>Date&nbsp;: %DATE%',
        'on_sms' => 'Le Serveur \'%LABEL%\' est OK: IP=%IP%, Port=%PORT%, il était hors-ligne pendant
 %LAST_OFFLINE_DURATION%',
        'on_email_subject' => 'IMPORTANT: Le Serveur \'%LABEL%\' est OK',
        'on_email_body' => 'Le Serveur \'%LABEL%\' est de nouveau OK, il était hors-ligne pendant
 %LAST_OFFLINE_DURATION%:<br><br>Serveur: %LABEL%<br>IP: %IP%<br>Port: %PORT%<br>Date:
 %DATE%',
        'on_pushover_title' => 'Le Serveur \'%LABEL%\' est OK',
        'on_pushover_message' => 'Le Serveur \'%LABEL%\' est de nouveau OK, il était hors-ligne pendant
 %LAST_OFFLINE_DURATION%:<br><br>Serveur: %LABEL%<br>IP: %IP%<br>Port:
 %PORT%<br>Date: %DATE%',
        'on_telegram_message' => 'Server \'%LABEL%\' is running again, it was down for:
 %LAST_OFFLINE_DURATION%<br><br>Server: %LABEL%<br>IP: %IP%<br>Port: %PORT%<br>Date:
 %DATE%',
        'combi_off_email_message' => '<ul><li>Serveur&nbsp;: %LABEL%</li><li>IP&nbsp;: %IP%</li><li>Port&nbsp;:
 %PORT%</li><li>Erreur&nbsp;: %ERROR%</li><li>Date&nbsp;: %DATE%</li></ul>',
        'combi_off_pushover_message' => '<ul><li>Serveur&nbsp;: %LABEL%</li><li>IP&nbsp;: %IP%</li><li>Port&nbsp;:
 %PORT%</li><li>Erreur&nbsp;: %ERROR%</li><li>Date&nbsp;: %DATE%</li></ul>',
        'combi_off_telegram_message' => '- Serveur&nbsp;: %LABEL%<br>- IP&nbsp;: %IP%<br>- Port&nbsp;: %PORT%<br>-
 Erreur&nbsp;: %ERROR%<br>- Date&nbsp;: %DATE%<br><br>',
        'combi_on_email_message' => '<ul><li>Serveur&nbsp;: %LABEL%</li><li>IP&nbsp;: %IP%</li><li>Port&nbsp;:
 %PORT%</li><li>Durée&nbsp;: %LAST_OFFLINE_DURATION%</li><li>Date&nbsp;:
 %DATE%</li></ul>',
        'combi_on_pushover_message' => '<ul><li>Serveur&nbsp;: %LABEL%</li><li>IP&nbsp;: %IP%</li><li>Port&nbsp;:
 %PORT%</li><li>Durée&nbsp;: %LAST_OFFLINE_DURATION%</li><li>Date&nbsp;:
 %DATE%</li></ul>',
        'combi_on_telegram_message' => '- Serveur&nbsp;: %LABEL%<br>- IP: %IP%<br>- Port&nbsp;: %PORT%<br>-
 Durée&nbsp;: %LAST_OFFLINE_DURATION%<br>- Date&nbsp;: %DATE%<br><br>',
        'combi_email_subject' => 'IMPORTANT&nbsp;: \'%UP%\' serveurs de nouveaux en ligne, \'%DOWN%\' serveurs
 hors-ligne',
        'combi_pushover_subject' => '\'%UP%\' serveurs de nouveaux en ligne, \'%DOWN%\' serveurs hors-ligne',
        'combi_email_message' => '<b>Les serveurs suivants sont hors-ligne&nbsp;:</b><br>%DOWN_SERVERS%<br><b>Les
 serveurs suivants sont en ligne&nbsp;:</b><br>%UP_SERVERS%',
        'combi_pushover_message' => '<b>Les serveurs suivants sont hors-ligne&nbsp;:</b><br>%DOWN_SERVERS%<br><b>Les
 serveurs suivants sont en ligne&nbsp;:</b><br>%UP_SERVERS%',
        'combi_telegram_message' => '<b>Les serveurs suivants sont hors-ligne&nbsp;:</b><br>%DOWN_SERVERS%<br><b>Les
 serveurs suivants sont en ligne&nbsp;:</b><br>%UP_SERVERS%',
    ),
    'login' => array(
        'welcome_usermenu' => 'Bonjour %user_name%',
        'title_sign_in' => 'Connectez vous SVP',
        'title_forgot' => 'Mot de passe oublié&nbsp;?',
        'title_reset' => 'Réinitialisation du mot de passe',
        'submit' => 'Envoyer',
        'remember_me' => 'Se souvenir de moi',
        'login' => 'Connexion',
        'logout' => 'Déconnexion',
        'username' => 'Nom',
        'password' => 'Mot de passe',
        'password_repeat' => 'Répéter le mot de passe',
        'password_forgot' => 'Mot de passe oublié&nbsp;?',
        'password_reset' => 'Réinitialiser le mot de passe',
        'password_reset_email_subject' => 'Réinitialisation du mot de passe pour PHP Server Monitor',
        'password_reset_email_body' => 'Cliquez sur le lien ci-dessous pour réinitialiser votre mot de passe.
 Veuillez noter qu\'il expire dans une heure.<br><br>%link%',
        'error_user_incorrect' => 'Nom d\'utilisateur invalide.',
        'error_login_incorrect' => 'Informations incorrectes.',
        'error_login_passwords_nomatch' => 'Mot de passe invalide.',
        'error_reset_invalid_link' => 'Le lien d\'initialisation du mot de passe n\'est pas valide.',
        'success_password_forgot' => 'Un email vous a été envoyé pour réinitialiser votre mot de passe.',
        'success_password_reset' => 'Votre mot de passe a été réinitialisé.',
    ),
    'error' => array(
        '401_unauthorized' => 'Non autorisée',
        '401_unauthorized_description' => 'Vous n\'avez pas les privilèges nécessaires pour voir cette page.',
    ),
);
