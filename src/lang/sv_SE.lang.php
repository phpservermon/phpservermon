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
 * @author      andlil
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

$sm_lang = array(
    'name' => 'Svenska - Swedish',
    'locale' => array(
        '0' => 'sv_SE.UTF-8',
        '1' => 'sv_SE',
        '2' => 'svenska',
        '3' => 'svenska-SE',
    ),
    'locale_tag' => 'sv',
    'locale_dir' => 'ltr',
    'system' => array(
        'title' => 'Server Monitor',
        'install' => 'Installera',
        'action' => 'Åtgärd',
        'save' => 'Spara',
        'edit' => 'Redigera',
        'delete' => 'Radera',
        'date' => 'Datum',
        'message' => 'Meddelande',
        'yes' => 'Ja',
        'no' => 'Nej',
        'insert' => 'Infoga',
        'add_new' => 'Lägg till',
        'update_available' => 'En ny version ({version}) finns tillgänglig från <a
 href="https://github.com/phpservermon/phpservermon/releases/latest" target="_blank"
 rel="noopener">http://www.phpservermonitor.org</a>.',
        'back_to_top' => 'Gå upp',
        'go_back' => 'Gå tillbaka',
        'ok' => 'OK',
        'cancel' => 'Avbryt',
        'short_day_format' => '%B %e',
        'long_day_format' => '%B %e, %Y',
        'yesterday_format' => 'Igår kl %k:%M',
        'other_day_format' => '%A kl %k:%M',
        'never' => 'Aldrig',
        'hours_ago' => '%d timmar sedan',
        'an_hour_ago' => 'ungefär en timme sedan',
        'minutes_ago' => '%d minuter sedan',
        'a_minute_ago' => 'ungefär en minut sen',
        'seconds_ago' => '%d sekunder sedan',
        'a_second_ago' => 'en sekund sedan',
        'seconds' => 'sekunder',
    ),
    'menu' => array(
        'config' => 'Inställningar',
        'server' => 'Servrar',
        'server_log' => 'Logg',
        'server_status' => 'Status',
        'server_update' => 'Uppdatera',
        'user' => 'Användare',
        'help' => 'Hjälp',
    ),
    'users' => array(
        'user' => 'Användare',
        'name' => 'Namn',
        'user_name' => 'Användarnamn',
        'password' => 'Lösenord',
        'password_repeat' => 'Upprepa lösenord',
        'password_leave_blank' => 'Lämna blankt för att inte ändra ',
        'level' => 'Nivå',
        'level_10' => 'Administratör',
        'level_20' => 'Användare',
        'level_description' => '<b>Administratörer</b> har fulla rättigheter: de kan hantera servrar, användare och
 redigera gemensamma inställningar.<br><b>Användare</b> kan bara se och köra
 uppdateraren för de servrar som de blivit tilldelade.',
        'mobile' => 'Mobilnummer',
        'email' => 'Email',
        'pushover' => 'Pushover',
        'pushover_description' => 'Pushover är en tjänst som skickar meddelande i realtid. Se <a
 href="https://pushover.net/" target="_blank">deras webbsida</a> för mer
 information.',
        'pushover_key' => 'Pushover Key',
        'pushover_device' => 'Pushover Device',
        'pushover_device_description' => 'Enhetsnman att skicka meddelande till. Lämna tomt för att skicka till alla
 enheter.',
        'delete_title' => 'Radera användare',
        'delete_message' => 'Är du säker att du vill radera användare \'%1\'?',
        'deleted' => 'Användare raderad.',
        'updated' => 'Användare uppdaterad.',
        'inserted' => 'Användare tillagd.',
        'profile' => 'Profil',
        'profile_updated' => 'Din profil har uppdaterats.',
        'error_user_name_bad_length' => 'Användarnamn måste vara mellan 2 och 64 tecken.',
        'error_user_name_invalid' => 'Användarnamnet får bara innehålla bokstäver (a-z, A-Z), siffror (0-9),
 prickar (.) and understreck (_).',
        'error_user_name_exists' => 'Användarnamnet används redan.',
        'error_user_email_bad_length' => 'Email-adressen måste vara mellan 5 och 255 tecken.',
        'error_user_email_invalid' => 'Email-adressen är ogiltig.',
        'error_user_level_invalid' => 'Behörighetsnivån är ogiltig.',
        'error_user_no_match' => 'Användaren kunde inte hittas i databasen.',
        'error_user_password_invalid' => 'Lösenordet är ogiltigt.',
        'error_user_password_no_match' => 'Lösenorden stämmer inte överens.',
    ),
    'log' => array(
        'title' => 'Logg-poster',
        'type' => 'Typ',
        'status' => 'Status',
        'email' => 'Email',
        'sms' => 'SMS',
        'pushover' => 'Pushover',
        'no_logs' => 'Inga loggar',
        'clear' => 'Tydlig logg',
        'delete_title' => 'Tydlig logg',
        'delete_message' => 'Är du säker på att du vill radera <b>alla</b> loggar?',
    ),
    'servers' => array(
        'server' => 'Server',
        'status' => 'Status',
        'label' => 'Namn',
        'domain' => 'Domän/IP',
        'timeout' => 'Timeout',
        'timeout_description' => 'Antal sekunder att vänta på svar.',
        'port' => 'Port',
        'type' => 'Typ',
        'type_website' => 'Website',
        'type_service' => 'Service',
        'pattern' => 'Hitta sträng/mönster',
        'pattern_description' => 'Om detta mönster inte hittas i svaret kommer servern att markeras offline. "Regular
 expressions" är tillåtna.',
        'last_check' => 'Senaste kontroll',
        'last_online' => 'Senast online',
        'last_offline' => 'Senast offline',
        'monitoring' => 'Övervakas',
        'no_monitoring' => 'Övervakas inte',
        'email' => 'Email',
        'send_email' => 'Skicka Email',
        'sms' => 'SMS',
        'send_sms' => 'Skicka SMS',
        'pushover' => 'Pushover',
        'users' => 'Användare',
        'delete_title' => 'Radera server',
        'delete_message' => 'Är du säker att du vill radera server \'%1\'?',
        'deleted' => 'Server raderad.',
        'updated' => 'Server uppdaterad.',
        'inserted' => 'Server tillagd.',
        'latency' => 'Fördröjning',
        'latency_max' => 'Fördröjning (maximum)',
        'latency_min' => 'Fördröjning (minimum)',
        'latency_avg' => 'Fördröjning (medel)',
        'uptime' => 'Uptime',
        'year' => 'År',
        'month' => 'Månad',
        'week' => 'Vecka',
        'day' => 'Dag',
        'hour' => 'Timme',
        'warning_threshold' => 'Varningströskel',
        'warning_threshold_description' => 'Antalet misslyckade kontroller innan server markeras som offline.',
        'chart_last_week' => 'Senaste veckan',
        'chart_history' => 'Historik',
        'chart_day_format' => '%Y-%m-%d',
        'chart_long_date_format' => '%Y-%m-%d %H:%M:%S',
        'chart_short_date_format' => '%m/%d %H:%M',
        'chart_short_time_format' => '%H:%M',
        'warning_notifications_disabled_sms' => 'SMS-meddelande är avstängda.',
        'warning_notifications_disabled_email' => 'Email-meddelande är avstängda.',
        'warning_notifications_disabled_pushover' => 'Pushover-meddelande är avstängda.',
        'error_server_no_match' => 'Server kan inte hittas.',
        'error_server_label_bad_length' => 'Namn måste vara mellan 1 och 255 tecken.',
        'error_server_ip_bad_length' => 'Domän / IP måste vara mellan 1 och 255 tecken.',
        'error_server_ip_bad_service' => 'IP-adressen är ogiltig.',
        'error_server_ip_bad_website' => 'URL:en är ogiltig.',
        'error_server_type_invalid' => 'Vald servertyp är ogiltig.',
        'error_server_warning_threshold_invalid' => 'Varningströskel skall vara ett heltal större än 0.',
    ),
    'config' => array(
        'general' => 'Allmänt',
        'language' => 'Språk',
        'show_update' => 'Sök efter uppdateringar?',
        'email_status' => 'Tillåt email',
        'email_from_email' => 'Email avsändaradress',
        'email_from_name' => 'Email från namn',
        'email_smtp' => 'Aktivera SMTP',
        'email_smtp_host' => 'SMTP värd',
        'email_smtp_port' => 'SMTP port',
        'email_smtp_security' => 'SMTP säkerhet',
        'email_smtp_security_none' => 'Ingen',
        'email_smtp_username' => 'SMTP användarnamn',
        'email_smtp_password' => 'SMTP lösenord',
        'email_smtp_noauth' => 'Lämna blank för att inte autentisera',
        'sms_status' => 'Tillåt SMS',
        'sms_gateway' => 'Gateway för SMS',
        'sms_gateway_username' => 'Gateway användarnamn',
        'sms_gateway_password' => 'Gateway lösenord',
        'sms_from' => 'Avsändarens telefonnummer',
        'pushover_status' => 'Tillåt Pushover-meddelande',
        'pushover_description' => 'Pushover är en tjänst som skickar meddelande i realtid. Se <a
 href="https://pushover.net/" target="_blank">deras webbsida</a> för mer info.',
        'pushover_clone_app' => 'Klicka här för att skapa din Pushover app',
        'pushover_api_token' => 'Pushover App API Token',
        'pushover_api_token_description' => 'Innan du kan använda Pushover behöver du <a href="%1$s" target="_blank"
 rel="noopener">registrera en App</a> på deras webbsida och skriva in App
 API Token här.',
        'alert_type' => 'Välj när du vill bli meddelad.',
        'alert_type_description' => '<b>Statusförändring:</b> Du får ett meddelande när status ändras. Så från
 online -> offline eller offline -> online.<br><br /><b>Offline:</b> Du får ett
 meddelande när en server går offline *FÖR FÖRSTA GÅNGEN* Exempelvis, ditt
 cronjob körs var 15 minut och din server går ned kl 1 och är nere till kl 6.
 Du kommer få 1 meddelande kl 1 och inga mer.<br><br><b>Alltid:</b> Du kommer få
 ett meddelande varje gång kontrollen görs, även om servern har varit offline
 under en längre tid.',
        'alert_type_status' => 'Statusförändring',
        'alert_type_offline' => 'Offline',
        'alert_type_always' => 'Alltid',
        'log_status' => 'Statusloggning',
        'log_status_description' => 'Om statusloggning är TRUE, kommer alla händelser som triggar ett meddelande att
 loggas.',
        'log_email' => 'Logga email',
        'log_sms' => 'Logga SMS',
        'log_pushover' => 'Logga Pushover-meddelande',
        'updated' => 'Inställningarna har uppdaterats.',
        'tab_email' => 'Email',
        'tab_sms' => 'SMS',
        'tab_pushover' => 'Pushover',
        'settings_email' => 'Email-inställningar',
        'settings_sms' => 'SMS-inställningar',
        'settings_pushover' => 'Pushover-inställningar',
        'settings_notification' => 'Meddelande-inställningar',
        'settings_log' => 'Logg-inställningar',
        'auto_refresh' => 'Auto-uppdatera',
        'auto_refresh_description' => 'Auto-uppdatera status-sidan.<br><span class="small">Tid i sekunder, om "0" så
 uppdateras sidan inte automatiskt.</span>',
        'test' => 'Test',
        'test_email' => 'Ett emial kommer skickas till adressen i din profil.',
        'test_sms' => 'Ett SMS kommer skickas till mobilnumret i din profil.',
        'test_pushover' => 'Ett Pushover-meddelande kommer skickas till "user key/device" i din profil.',
        'send' => 'Skicka',
        'test_subject' => 'Test',
        'test_message' => 'Testmeddelande',
        'email_sent' => 'Email skickat',
        'email_error' => 'Sändning av email misslyckades',
        'sms_sent' => 'Sms skickat',
        'sms_error' => 'Sändning av SMS misslyckades. %s',
        'sms_error_nomobile' => 'Kan inte skicka test-SMS: det finns inget giltigt mobilnummer i din profil.',
        'pushover_sent' => 'Pushover-meddelande skickat',
        'pushover_error' => 'Ett fel uppstod vid sändning av Pushover-meddelande: %s',
        'pushover_error_noapp' => 'Kan inte skicka test-meddelande: Ingen Pushover App API token hittades i gemensamma
 inställningar.',
        'pushover_error_nokey' => 'Kan inte skicka test-meddelande: Ingen Pushover key finns i din profil.',
        'log_retention_period' => 'Loggar sparas',
        'log_retention_period_description' => 'Antal dagar loggar över meddelande och uptime sparas. 0 innebär att
 loggrensning är avstängd.',
        'log_retention_days' => 'dagar',
    ),
    'notifications' => array(
        'off_sms' => 'Server \'%LABEL%\' är NERE: ip=%IP%, port=%PORT%. Fel=%ERROR%',
        'off_email_subject' => 'VIKTIGT: Server \'%LABEL%\' är NERE',
        'off_email_body' => 'Kunde inte ansluta till följande server:<br><br>Server: %LABEL%<br>IP: %IP%<br>Port:
 %PORT%<br>Fel: %ERROR%<br>Tid: %DATE%',
        'off_pushover_title' => 'Server \'%LABEL%\' är NERE',
        'off_pushover_message' => 'Kunde inte ansluta till följande server:<br><br>Server: %LABEL%<br>IP:
 %IP%<br>Port: %PORT%<br>Fel: %ERROR%<br>Tid: %DATE%',
        'on_sms' => 'Server \'%LABEL%\' är UPPE: ip=%IP%, port=%PORT%, it was down for %LAST_OFFLINE_DURATION%',
        'on_email_subject' => 'VIKTIGT: Server \'%LABEL%\' är UPPE',
        'on_email_body' => 'Server \'%LABEL%\' är uppe igen, it was down for %LAST_OFFLINE_DURATION%:<br><br>Server:
 %LABEL%<br>IP: %IP%<br>Port: %PORT%<br>Tid: %DATE%',
        'on_pushover_title' => 'Server \'%LABEL%\' är UPPE',
        'on_pushover_message' => 'Server \'%LABEL%\' är uppe igen, it was down for
 %LAST_OFFLINE_DURATION%:<br><br>Server: %LABEL%<br>IP: %IP%<br>Port: %PORT%<br>Tid:
 %DATE%',
    ),
    'login' => array(
        'welcome_usermenu' => 'Välkommen, %user_name%',
        'title_sign_in' => 'Logga in',
        'title_forgot' => 'Glömt ditt lösenord?',
        'title_reset' => 'Återställ ditt lösenord',
        'submit' => 'Skicka',
        'remember_me' => 'Kom ihåg mig',
        'login' => 'Logga in',
        'logout' => 'Logga ut',
        'username' => 'Användarnamn',
        'password' => 'Lösenord',
        'password_repeat' => 'Upprepa lösenord',
        'password_forgot' => 'Glömt lösenord?',
        'password_reset' => 'Återställ lösenord',
        'password_reset_email_subject' => 'Password reset for PHP Server Monitor',
        'password_reset_email_body' => 'Anv&auml;nd f&ouml;ljande l&auml;nk f&ouml;r att &aring;terst&auml;lla ditt
 l&ouml;senord. T&auml;nk p&aring; att l&auml;nken bara &auml;r giltig 1
 timme.<br><br>%link%',
        'error_user_incorrect' => 'Användaren kunde inte hittas.',
        'error_login_incorrect' => 'Informationen är felaktig.',
        'error_login_passwords_nomatch' => 'Lösenorden stämmer inte överens.',
        'error_reset_invalid_link' => 'Reset-länken är ogiltig.',
        'success_password_forgot' => 'Ett email med information om hur du nollställer ditt lösenord har skickats.',
        'success_password_reset' => 'Ditt lösenord har nollställts. Var god logga in.',
    ),
    'error' => array(
        '401_unauthorized' => 'Unauthorized',
        '401_unauthorized_description' => 'You do not have the privileges to view this page.',
    ),
);
