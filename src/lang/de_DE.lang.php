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
 * @author      Jean Pierre Kolb <http://www.jpkc.com/>
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

$sm_lang = array(
    'name' => 'Deutsch - German',
    'locale' => array(
        '0' => 'de_DE.UTF-8',
        '1' => 'de_DE',
        '2' => 'german',
    ),
    'locale_tag' => 'de',
    'locale_dir' => 'ltr',
    'system' => array(
        'title' => 'Server Monitor',
        'install' => 'Installation',
        'action' => 'Aktion',
        'save' => 'Speichern',
        'edit' => 'Bearbeiten',
        'delete' => 'Löschen',
        'date' => 'Datum',
        'message' => 'Meldung',
        'yes' => 'Ja',
        'no' => 'Nein',
        'insert' => 'Einfügen',
        'add_new' => 'Neuen Eintrag erstellen',
        'update_available' => 'Eine Aktualisierung ({version}) ist verfügbar unter <a
 href="https://github.com/phpservermon/phpservermon/releases/latest" target="_blank"
 rel="noopener">http://www.phpservermonitor.org</a>.',
        'back_to_top' => 'nach oben',
        'go_back' => 'Zurück',
        'ok' => 'OK',
        'cancel' => 'Abbrechen',
        'short_day_format' => '%B %e',
        'long_day_format' => '%B %e, %Y',
        'yesterday_format' => 'Gestern um %k:%M Uhr',
        'other_day_format' => '%A um %k:%M Uhr',
        'never' => 'Nie',
        'hours_ago' => 'vor %d Stunden',
        'an_hour_ago' => 'vor über einer Stunde',
        'minutes_ago' => 'vor %d Minuten',
        'a_minute_ago' => 'vor über einer Minute',
        'seconds_ago' => 'vor %d Sekunden',
        'a_second_ago' => 'vor über einer Sekunde',
        'seconds' => 'Sekunden',
    ),
    'menu' => array(
        'config' => 'Einstellungen',
        'server' => 'Server',
        'server_log' => 'Protokoll',
        'server_status' => 'Status',
        'server_update' => 'Update',
        'user' => 'Benutzer',
        'help' => 'Hilfe',
    ),
    'users' => array(
        'user' => 'Benutzer',
        'name' => 'Name',
        'user_name' => 'Benutzername',
        'password' => 'Passwort',
        'password_repeat' => 'Passwort wiederholen',
        'password_leave_blank' => 'Passwort ändern...',
        'level' => 'Berechtigungsstufe',
        'level_10' => 'Administrator',
        'level_20' => 'Benutzer',
        'level_description' => '<b>Administratoren</b> haben vollen Zugriff — sie können Webseiten, Benutzer und
 globale Einstellungen verwalten.<br><b>Benutzer</b> können nur (für ihnen
 zugeordnete Webseiten) Analysedaten einsehen und deren Aktualisierung veranlassen.',
        'mobile' => 'Mobil',
        'email' => 'E-Mail',
        'pushover' => 'Pushover',
        'pushover_description' => 'Pushover ist ein Dienst, der es stark vereinfacht, Statusbenachrichtigungen in
 Echtzeit zu erhalten. Besuchen Sie <a href="https://pushover.net/"
 target="_blank">pushover.net</a> für weitere Informationen.',
        'pushover_key' => 'Pushover Key/Schlüssel',
        'pushover_device' => 'Pushover Gerät',
        'pushover_device_description' => 'Name des Gerätes, an das die Nachricht gesendet werden soll. Leer lassen,
 um die Nachricht an alle registrierten Geräte zu senden.',
        'delete_title' => 'Benutzer löschen',
        'delete_message' => 'Sind Sie sicher, dass Sie den Benutzer \'%1\' löschen wollen?',
        'deleted' => 'Benutzer gelöscht.',
        'updated' => 'Benutzer bearbeitet.',
        'inserted' => 'Benutzer hinzugefügt.',
        'profile' => 'Profileinstellungen',
        'profile_updated' => 'Ihr Profil wurde aktualisiert.',
        'error_user_name_bad_length' => 'Benutzernamen müssen zwischen 2 und 64 Zeichen lang sein.',
        'error_user_name_invalid' => 'Der Benutzername darf nur alphanumerische Zeichen (a-z, A-Z), Zahlen (0-9),
 Punkte (.) und Unterstriche (_) enthalten.',
        'error_user_name_exists' => 'Der gewählte Benutzername existiert bereits in der Datenbank.',
        'error_user_email_bad_length' => 'E-Mail-Adressen müssen zwischen 5 und 255 Zeichen lang sein.',
        'error_user_email_invalid' => 'Die E-Mail-Adresse ist ungültig.',
        'error_user_level_invalid' => 'Die gewählte Berechtigungsstufe ist ungültig.',
        'error_user_no_match' => 'Der Benutzer konnte in der Datenbank nicht gefunden werden.',
        'error_user_password_invalid' => 'Das eingegebene Passwort ist nicht korrekt.',
        'error_user_password_no_match' => 'Die eingegebenen Passwörter stimmen nicht überein.',
    ),
    'log' => array(
        'title' => 'Protokoll',
        'type' => 'Typ',
        'status' => 'Status',
        'email' => 'E-Mail',
        'sms' => 'SMS',
        'pushover' => 'Pushover',
        'no_logs' => 'Keine Protokolle vorhanden.',
        'clear' => 'Protokoll löschen',
        'delete_title' => 'Protokoll löschen',
        'delete_message' => 'Bist du sicher, dass du <b>alle</b> Protokolle löschen möchtest?',
    ),
    'servers' => array(
        'server' => 'Server',
        'status' => 'Status',
        'label' => 'Beschriftung',
        'domain' => 'Domain/IP',
        'timeout' => 'Timeout',
        'timeout_description' => 'Anzahl der Sekunden, die auf eine Antwort des Servers gewartet werden soll.',
        'port' => 'Port',
        'type' => 'Typ',
        'type_website' => 'Webseite',
        'type_service' => 'Service',
        'type_ping' => 'Ping',
        'pattern' => 'Suchstring/-muster',
        'pattern_description' => 'Wenn das gesuchte Muster nicht in der Webseite ist, wird die Seite als offline
 markiert. Reguläre Ausdrücke sind erlaubt.',
        'last_check' => 'Letzter Check',
        'last_online' => 'Zuletzt online',
        'last_offline' => 'Zuletzt offline',
        'monitoring' => 'Monitoring',
        'no_monitoring' => 'Monitoring inaktiv',
        'email' => 'E-Mail',
        'send_email' => 'E-Mail versenden',
        'sms' => 'SMS',
        'send_sms' => 'SMS versenden',
        'pushover' => 'Pushover',
        'users' => 'Benutzer',
        'delete_title' => 'Server löschen',
        'delete_message' => 'Sind Sie sicher, dass Sie den Server \'%1\' löschen wollen?',
        'deleted' => 'Server gelöscht.',
        'updated' => 'Server aktualisiert.',
        'inserted' => 'Server hinzugefügt.',
        'latency' => 'Antwortzeit',
        'latency_max' => 'Antwortzeit (Maximum)',
        'latency_min' => 'Antwortzeit (Minimum)',
        'latency_avg' => 'Antwortzeit (im Durchschnitt)',
        'uptime' => 'Uptime',
        'year' => 'Jahr',
        'month' => 'Monat',
        'week' => 'Woche',
        'day' => 'Tag',
        'hour' => 'Stunde',
        'warning_threshold' => 'Warnschwelle',
        'warning_threshold_description' => 'Anzahl der fehlgeschlagenen Überprüfungen, bevor der Status als offline
 markiert wird.',
        'chart_last_week' => 'Letzte Woche',
        'chart_history' => 'Historie',
        'chart_day_format' => '%d.%m.%Y',
        'chart_long_date_format' => '%d.%m.%Y %H:%M:%S Uhr',
        'chart_short_date_format' => '%d.%m %H:%M Uhr',
        'chart_short_time_format' => '%H:%M Uhr',
        'warning_notifications_disabled_sms' => 'SMS-Benachrichtigungen sind deaktiviert.',
        'warning_notifications_disabled_email' => 'E-Mail-Benachrichtigungen sind deaktiviert.',
        'warning_notifications_disabled_pushover' => 'Pushover-Benachrichtigungen sind deaktiviert.',
        'error_server_no_match' => 'Server nicht gefunden.',
        'error_server_label_bad_length' => 'Das Label muss zwischen 1 und 255 Zeichen lang sein.',
        'error_server_ip_bad_length' => 'Die Domain/IP muss zwischen 1 und 255 Zeichen lang sein.',
        'error_server_ip_bad_service' => 'Die eingegebene IP-Adresse ist ungültig.',
        'error_server_ip_bad_website' => 'Die eingegebene Webseiten-URL ist ungültig.',
        'error_server_type_invalid' => 'Der gewählte Server-Typ ist ungültig.',
        'error_server_warning_threshold_invalid' => 'Die Warnschwelle muss eine gültige ganze Zahl größer als 0
 sein.',
    ),
    'config' => array(
        'general' => 'Allgemein',
        'language' => 'Sprache',
        'show_update' => 'Wöchentlich auf Aktualisierungen prüfen?',
        'email_status' => 'E-Mail-Versand erlauben?',
        'email_from_email' => 'Absenderadresse',
        'email_from_name' => 'Name des Absenders',
        'email_smtp' => 'SMTP-Versand aktivieren',
        'email_smtp_host' => 'SMTP Server/Host',
        'email_smtp_port' => 'SMTP Port',
        'email_smtp_security' => 'SMTP Authentifizierung',
        'email_smtp_security_none' => 'Keine',
        'email_smtp_username' => 'SMTP Benutzername',
        'email_smtp_password' => 'SMTP Passwort',
        'email_smtp_noauth' => 'Feld leer lassen, bei fehlender Authentifizierung',
        'sms_status' => 'SMS-Nachrichtenversand erlauben?',
        'sms_gateway' => 'SMS Gateway',
        'sms_gateway_username' => 'Gateway Benutzername',
        'sms_gateway_password' => 'Gateway Passwort',
        'sms_from' => 'SMS-Sendernummer',
        'pushover_status' => 'Ermögliche das Senden von Pushover-Nachrichten',
        'pushover_description' => 'Pushover ist ein Dienst, der es stark vereinfacht, Statusbenachrichtigungen in
 Echtzeit zu erhalten. Besuchen Sie <a href="https://pushover.net/"
 target="_blank">pushover.net</a> für weitere Informationen.',
        'pushover_clone_app' => 'Klicken Sie hier, um Ihre Pushover-Anwendung zu erstellen',
        'pushover_api_token' => 'Pushover-Anwendungs-API-Token',
        'pushover_api_token_description' => 'Bevor Sie Pushover verwenden können, müssen Sie Ihre <a href="%1$s"
 target="_blank" rel="noopener">Anwendung hier registrieren</a> und Ihren
 Anwendungs-API-Token hier eingeben.',
        'alert_type' => 'Wann möchten Sie benachrichtigt werden?',
        'alert_type_description' => '<b>Status geändert:</b> ... wenn sich der Status ändert<br>z. B. online ->
 offline oder offline -> online.<br><br><b>Offline: </b>Sie bekommen eine
 Benachrichtigung, wenn ein Server offline ist.<br>Es wird nur eine Mitteilung
 versendet.<br><br><b>Immer: </b>Sie erhalten jedes Mal eine Benachrichtigung,
 sobald der CronJob oder das Skript ausgeführt werden, auch wenn der Dienst
 mehrere Stunden offline sein sollte.',
        'alert_type_status' => 'Status geändert',
        'alert_type_offline' => 'Offline',
        'alert_type_always' => 'Immer',
        'log_status' => 'Protokollierung aktivieren?',
        'log_status_description' => 'Ist die Protokollierung aktiviert (d.h. ist ein Haken gesetzt), wird jeder Status
 und jede Meldung vom System protokolliert.',
        'log_email' => 'E-Mail-Versand protokollieren?',
        'log_sms' => 'SMS-Versand protokollieren?',
        'log_pushover' => 'Pushover-Versand protokollieren?',
        'updated' => 'Die Einstellungen wurden gespeichert.',
        'tab_email' => 'E-Mail',
        'tab_sms' => 'SMS',
        'tab_pushover' => 'Pushover',
        'settings_email' => 'E-Mail-Einstellungen',
        'settings_sms' => 'SMS-Einstellungen',
        'settings_pushover' => 'Pushover-Einstellungen',
        'settings_notification' => 'Benachrichtigungseinstellungen',
        'settings_log' => 'Protokollierungseinstellungen',
        'auto_refresh' => 'Automatische Aktualisierung',
        'auto_refresh_description' => 'Automatische Aktualisierung der Server-Übersichtsseite<br><span
 class="small">Zeit in Sekunden - die Ziffer \'0\' deaktiviert die automatische
 Aktualisierung.</span>',
        'test' => 'Test',
        'test_email' => 'Eine E-Mail wird an die E-Mail-Adresse gesendet, die in Ihrem Profil hinterlegt ist.',
        'test_sms' => 'Eine SMS wird an die Telefonnummer gesendet, die in Ihrem Profil hinterlegt ist.',
        'test_pushover' => 'Eine Pushover-Benachrichtigung wird an den Schlüssel/das Gerät gesendet, welche(s) in
 Ihrem Profil hinterlegt ist.',
        'send' => 'Senden',
        'test_subject' => 'Test',
        'test_message' => 'Testnachricht',
        'email_sent' => 'E-Mail gesendet.',
        'email_error' => 'Beim Versand der E-Mail trat ein Fehler auf.',
        'sms_sent' => 'SMS-Nachricht gesendet.',
        'sms_error' => 'Beim Versand der SMS-Nachricht trat ein Fehler auf. %s',
        'sms_error_nomobile' => 'Versand der SMS-Nachricht nicht möglich: Es wurde keine gültige Telefonnummer in
 Ihrem Profil hinterlegt.',
        'pushover_sent' => 'Pushover-Benachrichtigung versendet',
        'pushover_error' => 'Beim Versand der Pushover-Benachrichtigung trat ein Fehler auf: %s',
        'pushover_error_noapp' => 'Es konnte keine Testbenachrichtigung versendet werden: Kein
 Pushover-Anwendungs-API-Token in den allgemeinen Einstellungen hinterlegt.',
        'pushover_error_nokey' => 'Es konnte keine Testbenachrichtigung versendet werden: Es wurde kein Pushover
 Key/Schlüssel in Ihrem Profil hinterlegt.',
        'log_retention_period' => 'Protokollierungszeitraum',
        'log_retention_period_description' => 'Anzahl in Tagen bis zur automatischen Bereinigung/Löschung sämtlicher
 Protokollierungsdaten im System. Geben Sie die Ziffer \'0\' ein, um die
 automatische Bereinigung/Löschung zu deaktivieren.',
        'log_retention_days' => 'Tage',
    ),
    'notifications' => array(
        'off_sms' => 'Dienst/Webseite \'%LABEL%\' ist offline: ip=%IP%, port=%PORT%. Fehler=%ERROR%',
        'off_email_subject' => 'Warnung: Dienst/Webseite \'%LABEL%\' ist offline.',
        'off_email_body' => 'Kann keine funktionierende Verbindung zum Dienst bzw. der Webseite
 aufbauen:<br><br>Dienst/Webseite: %LABEL%<br>IP: %IP%<br>Port: %PORT%<br>Fehler:
 %ERROR%<br>Datum: %DATE% Uhr',
        'off_pushover_title' => 'Dienst/Webseite \'%LABEL%\' ist offline.',
        'off_pushover_message' => 'Kann keine funktionierende Verbindung zum Dienst bzw. der Webseite
 aufbauen:<br><br>Dienst/Webseite: %LABEL%<br>IP: %IP%<br>Port: %PORT%<br>Fehler:
 %ERROR%<br>Datum: %DATE% Uhr',
        'on_sms' => 'Dienst/Webseite \'%LABEL%\' ist wieder online: ip=%IP%, port=%PORT%, offline für
 %LAST_OFFLINE_DURATION%',
        'on_email_subject' => 'Hinweis: Dienst/Webseite \'%LABEL%\' ist wieder online.',
        'on_email_body' => 'Dienst/Webseite \'%LABEL%\' ist wieder erreichbar, offline für
 %LAST_OFFLINE_DURATION%:<br><br>Server: %LABEL%<br>IP: %IP%<br>Port: %PORT%<br>Datum:
 %DATE% Uhr',
        'on_pushover_title' => 'Dienst/Webseite \'%LABEL%\' ist wieder online.',
        'on_pushover_message' => 'Dienst/Webseite \'%LABEL%\' ist wieder erreichbar, offline für
 %LAST_OFFLINE_DURATION%:<br><br>Server: %LABEL%<br>IP: %IP%<br>Port:
 %PORT%<br>Datum: %DATE% Uhr',
    ),
    'login' => array(
        'welcome_usermenu' => '%user_name%',
        'title_sign_in' => 'Bitte loggen Sie sich ein.',
        'title_forgot' => 'Passwort vergessen?',
        'title_reset' => 'Ihr Passwort zurücksetzen',
        'submit' => 'Senden',
        'remember_me' => 'Angemeldet bleiben',
        'login' => 'Login',
        'logout' => 'Abmelden',
        'username' => 'Benutzername',
        'password' => 'Passwort',
        'password_repeat' => 'Passwort wiederholen',
        'password_forgot' => 'Passwort vergessen?',
        'password_reset' => 'Passwort zurücksetzen',
        'password_reset_email_subject' => 'Setzen Sie Ihr Zugangspasswort für den Server Monitor',
        'password_reset_email_body' => 'Benutzen Sie bitte den folgenden Link, um Ihr Zugangspasswort zurückzusetzen.
 Bitte beachten Sie: Der Link verfällt in einer Stunde.<br><br>%link%',
        'error_user_incorrect' => 'Der angegebene Benutzername konnte nicht gefunden werden.',
        'error_login_incorrect' => 'Die angegebenen Informationen sind leider nicht korrekt.',
        'error_login_passwords_nomatch' => 'Die angegebenen Passwörter stimmen nicht überein.',
        'error_reset_invalid_link' => 'Der angegebene Link, um Ihr Zugangspasswort zurückzusetzen, ist ungültig.',
        'success_password_forgot' => 'Eine Nachricht wurde an Ihre E-Mail-Adresse versendet. Sie beschreibt, wie Sie
 Ihr Passwort zurücksetzen können.',
        'success_password_reset' => 'Ihr Passwort wurde erfolgreich zurückgesetzt. Bitte versuchen Sie, sich erneut
 anzumelden.',
    ),
    'error' => array(
        '401_unauthorized' => 'Nicht autorisiert',
        '401_unauthorized_description' => 'Sie haben nicht die erforderlichen Zugriffsrechte, um diese Seite
 aufzurufen.',
    ),
);
