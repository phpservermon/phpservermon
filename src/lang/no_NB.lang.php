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
 * @author      Daniel S. Billing <daniel@infihex.com>
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

$sm_lang = array(
    'name' => 'Norsk - Norwegian',
    'locale' => array(
        '0' => 'no_NB.UTF-8',
        '1' => 'no_NB',
        '2' => 'norwegian',
        '3' => 'norwegian-no',
    ),
    'locale_tag' => 'no',
    'locale_dir' => 'ltr',
    'system' => array(
        'title' => 'Server Overvåking',
        'install' => 'Installer',
        'action' => 'Handling',
        'save' => 'Lagre',
        'edit' => 'Endre',
        'delete' => 'Slett',
        'date' => 'Dato',
        'message' => 'Melding',
        'yes' => 'Ja',
        'no' => 'Nei',
        'insert' => 'Sett inn',
        'add_new' => 'Legg til ny',
        'update_available' => 'En ny versjon ({versjon}) er tilgjengelig på <a
 href="https://github.com/phpservermon/phpservermon/releases/latest" target="_blank"
 rel="noopener">http://www.phpservermonitor.org</a>.',
        'back_to_top' => 'Tilbake til toppen',
        'go_back' => 'Gå tilbake',
        'ok' => 'OK',
        'cancel' => 'Avbryt',
        'activate' => 'Aktiver',
        'short_day_format' => '%e. %B',
        'long_day_format' => '%e. %B, %Y',
        'yesterday_format' => 'Yesterday at %H:%M',
        'other_day_format' => '%A at %H:%M',
        'never' => 'Aldri',
        'hours_ago' => '%d timer siden',
        'an_hour_ago' => 'omtrent et time siden',
        'minutes_ago' => '%d minutter siden',
        'a_minute_ago' => 'omtrent et minutt siden',
        'seconds_ago' => '%d sekunder siden',
        'a_second_ago' => 'et sekund siden',
        'year' => 'år',
        'years' => 'år',
        'month' => 'måned',
        'months' => 'måneder',
        'day' => 'dag',
        'days' => 'dager',
        'hour' => 'time',
        'hours' => 'timer',
        'minute' => 'minutt',
        'minutes' => 'minutter',
        'second' => 'sekund',
        'seconds' => 'sekunder',
    ),
    'menu' => array(
        'config' => 'Konfig',
        'server' => 'Servere',
        'server_log' => 'Logg',
        'server_status' => 'Status',
        'server_update' => 'Oppdater',
        'user' => 'Brukere',
        'help' => 'Hjelp',
    ),
    'users' => array(
        'user' => 'Bruker',
        'name' => 'Navn',
        'user_name' => 'Brukernavn',
        'password' => 'Passord',
        'password_repeat' => 'Gjenta passord',
        'password_leave_blank' => 'La være tom for å forbli uendret',
        'level' => 'Level',
        'level_10' => 'Administrator',
        'level_20' => 'Bruker',
        'level_description' => '<b>Administratorer</b> har full tilgang: de kan administrere servere, brukere og
 redigere den globale konfigurasjonen.<br><b>Brukere</b> kan bare vise og kjøre
 oppdatering for serverne som er tildelt dem.',
        'mobile' => 'Mobil',
        'email' => 'E-post',
        'pushover' => 'Pushover',
        'pushover_description' => 'Pushover er en tjeneste som gjør det enkelt å få meldinger i sanntid. Se <a
 href="https://pushover.net/" target="_blank">deres nettside</a> for mer info.',
        'pushover_key' => 'Pushover Key',
        'pushover_device' => 'Pushover Device',
        'pushover_device_description' => 'Enhetsnavn for å sende meldingen til. La det være tomt for å sende det
 til alle enheter.',
        'telegram' => 'Telegram',
        'telegram_description' => '<a href="https://telegram.org/" target="_blank">Telegram</a> er en chat-app som
 gjør det enkelt å få meldinger i sanntid. Gå til <a
 href="http://docs.phpservermonitor.org/" target="_blank">dokumentasjonen</a> for
 mer informasjon og en installasjonsguide. ',
        'telegram_chat_id' => 'Telegram chat-ID',
        'telegram_chat_id_description' => 'Meldingen vil bli sendt til tilhørende chat.',
        'telegram_get_chat_id' => 'Klikk her for å få chat-ID',
        'activate_telegram' => 'Aktiver Telegram notifications',
        'activate_telegram_description' => 'Tillat Telegram varsler som skal sendes til det angitte chat-IDet. Uten
 denne tillatelsen tillater Telegram oss ikke å sende varsler til deg.',
        'telegram_bot_username_found' => 'The bot was found!<br><a href="%s" target="_blank" rel="noopener"><button
 class="btn btn-primary">Neste steg</button></a> <br>Dette åpner en chat med
 bot. Her må du trykke på start ved å skrive: /start.',
        'telegram_bot_username_error_token' => '401 - Unauthorized. Pass på at API-token er gyldig.',
        'telegram_bot_error' => 'Det har oppstått en feil under aktivering av Telegram varsling: %s',
        'delete_title' => 'Slett bruker',
        'delete_message' => 'Er du sikker på at du vil slette brukeren \'%1\'?',
        'deleted' => 'Bruker slettet.',
        'updated' => 'Bruker oppdatert.',
        'inserted' => 'Bruker lagt til.',
        'profile' => 'Profil',
        'profile_updated' => 'Din profil har blitt oppdatert.',
        'error_user_name_bad_length' => 'Brukernavn må være mellom 2 og 64 tegn.',
        'error_user_name_invalid' => 'Brukernavnet kan bare inneholde alfabetiske tegn (a-z, A-Z), sifre (0-9),
 punktum (.) and understrek (_).',
        'error_user_name_exists' => 'Det oppgitte brukernavnet eksisterer allerede i databasen.',
        'error_user_email_bad_length' => 'E-postadresser må være mellom 5 og 255 tegn.',
        'error_user_email_invalid' => 'E-postadressen er ugyldig.',
        'error_user_level_invalid' => 'Det oppgitte brukernivået er ugyldig.',
        'error_user_no_match' => 'Brukeren kunne ikke bli funnet i databasen.',
        'error_user_password_invalid' => 'Det oppgitte passordet er ugyldig.',
        'error_user_password_no_match' => 'De oppgitte passordene stemmer ikke overens.',
    ),
    'log' => array(
        'title' => 'Logg oppføringer',
        'type' => 'Type',
        'status' => 'Status',
        'email' => 'E-post',
        'sms' => 'Tekstmelding',
        'pushover' => 'Pushover',
        'telegram' => 'Telegram',
        'no_logs' => 'Ingen logger',
        'clear' => 'Tøm logg',
        'delete_title' => 'Slett logg',
        'delete_message' => 'Er du sikker på at du vil slette <b>alle</ b> logger?',
    ),
    'servers' => array(
        'server' => 'Server',
        'status' => 'Status',
        'label' => 'Label',
        'domain' => 'Domene/IP',
        'timeout' => 'Timeout',
        'timeout_description' => 'Antall sekunder å vente på at serveren skal svare.',
        'authentication_settings' => 'Autentiseringsinnstillinger',
        'optional' => 'ValgfrittF',
        'website_username' => 'Brukernavn',
        'website_username_description' => 'Brukernavn for å få tilgang til nettstedet. (Kun Apache-godkjenning
 støttes.)',
        'website_password' => 'Password',
        'website_password_description' => 'Passord for å få tilgang til nettstedet. Passordet er kryptert i
 databasen.',
        'fieldset_monitoring' => 'Overvåkning',
        'fieldset_permissions' => 'Tilganger',
        'port' => 'Port',
        'custom_port' => 'Tilpasset Port',
        'popular_ports' => 'Populære Ports',
        'please_select' => 'Vennligst vent',
        'type' => 'Type',
        'type_website' => 'Nettside',
        'type_service' => 'Tjeneste',
        'type_ping' => 'Ping',
        'pattern' => 'Søke streng/mønster',
        'pattern_description' => 'Hvis dette mønsteret ikke er funnet på nettstedet, blir serveren merket
 online/offline. Vanlige uttrykk er tillatt.',
        'pattern_online' => 'Mønster indikerer at nettstedet er',
        'pattern_online_description' => 'Online: Hvis dette mønsteret blir funnet på nettstedet, er serverens merke
 online. Frakoblet: Hvis dette mønsteret ikke blir funnet på nettstedet,
 flagges serveren offline.',
        'header_name' => 'Overskriftnavn',
        'header_value' => 'Overskriftsverdi',
        'header_name_description' => 'Versalsensitivt.',
        'header_value_description' => 'Vanlige uttrykk er tillatt.',
        'last_check' => 'Siste sjekk',
        'last_online' => 'Sist online',
        'last_offline' => 'Sist offline',
        'monitoring' => 'Overvåking',
        'no_monitoring' => 'Ingen overvåking',
        'email' => 'E-post',
        'send_email' => 'Send e-post',
        'sms' => 'Tekstmelding',
        'send_sms' => 'Send tekstmelding',
        'pushover' => 'Pushover',
        'send_pushover' => 'Send Pushover melding',
        'telegram' => 'Telegram',
        'send_telegram' => 'Send Telegram melding',
        'users' => 'Brukere',
        'delete_title' => 'Slett server',
        'delete_message' => 'Er du sikker på at du vil slette serveren \'%1\'?',
        'deleted' => 'Server slettet.',
        'updated' => 'Server oppdatert.',
        'inserted' => 'Server lagt til.',
        'latency' => 'Ventetid',
        'latency_max' => 'Ventetid (maximum)',
        'latency_min' => 'Ventetid (minimum)',
        'latency_avg' => 'Ventetid (gjennomsnitt)',
        'online' => 'online',
        'offline' => 'offline',
        'uptime' => 'Oppetid',
        'year' => 'År',
        'month' => 'Måned',
        'week' => 'Uke',
        'day' => 'Dag',
        'hour' => 'Time',
        'warning_threshold' => 'Advarselsgrense',
        'warning_threshold_description' => 'Antall mislykkede sjekker kreves før den er merket frakoblet.',
        'chart_last_week' => 'Forrige uke',
        'chart_history' => 'Historie',
        'chart_day_format' => '%d-%m-%Y',
        'chart_long_date_format' => '%d-%m-%Y %H:%M:%S',
        'chart_short_date_format' => '%d/%m %H:%M',
        'chart_short_time_format' => '%H:%M',
        'warning_notifications_disabled_sms' => 'Tekstmelding varsling er deaktivert.',
        'warning_notifications_disabled_email' => 'E-post varsling er deaktivert.',
        'warning_notifications_disabled_pushover' => 'Pushover varsling er deaktivert.',
        'warning_notifications_disabled_telegram' => 'Telegram varsling er deaktivert.',
        'error_server_no_match' => 'Server ikke funnet.',
        'error_server_label_bad_length' => 'Etiketten må være mellom 1 og 255 tegn.',
        'error_server_ip_bad_length' => 'Domenet / IP må være mellom 1 og 255 tegn.',
        'error_server_ip_bad_service' => 'IP-adressen er ikke gyldig.',
        'error_server_ip_bad_website' => 'Nettstedets URL er ikke gyldig.',
        'error_server_type_invalid' => 'Den valgte servertypen er ugyldig.',
        'error_server_warning_threshold_invalid' => 'Advarselsgrensen må være et gyldig heltall større enn 0.',
    ),
    'config' => array(
        'general' => 'General',
        'language' => 'Språk',
        'show_update' => 'Se etter oppdateringer?',
        'password_encrypt_key' => 'Krypteringsnøkkelpassordet',
        'password_encrypt_key_note' => 'Denne nøkkelen brukes til å kryptere passord som er lagret på servere for
 tilgang til nettsteder. Hvis nøkkelen endres, er det lagrede passordet
 ugyldig!',
        'proxy' => 'Aktiver proxy',
        'proxy_url' => 'Proxy URL',
        'proxy_user' => 'Proxy brukernavn',
        'proxy_password' => 'Proxy passord',
        'email_status' => 'Tillat sending av e-post',
        'email_from_email' => 'E-post fra adresse',
        'email_from_name' => 'E-post from navn',
        'email_smtp' => 'Aktiver SMTP',
        'email_smtp_host' => 'SMTP-vert',
        'email_smtp_port' => 'SMTP-port',
        'email_smtp_security' => 'SMTP-sikkerhet',
        'email_smtp_security_none' => 'Ingen',
        'email_smtp_username' => 'SMTP brukernavn',
        'email_smtp_password' => 'SMTP passord',
        'email_smtp_noauth' => 'La være tom for ingen godkjenning',
        'sms_status' => 'Tillat sending av tekstmeldinger',
        'sms_gateway' => 'Gateway for bruk for sending av meldinger',
        'sms_gateway_username' => 'Gateway brukernavn',
        'sms_gateway_password' => 'Gateway passord',
        'sms_from' => 'Avsenderens telefonnummer',
        'pushover_status' => 'Tillat sending av Pushover-meldinger',
        'pushover_description' => 'Pushover er en tjeneste som gjør det enkelt å få meldinger i sanntid. Se <a
 href="https://pushover.net/" target="_blank">deres nettside</a> for mer info.',
        'pushover_clone_app' => 'Klikk her for å lage din Pushover-app',
        'pushover_api_token' => 'Pushover App API Token',
        'pushover_api_token_description' => 'Før du kan bruke Pushover, må du <a href="%1$s" target="_blank"
 rel="noopener"> registrere en app </a> på deres nettside og angi App API
 Token her.',
        'telegram_status' => 'Tillat sending av Telegram-meldinger',
        'telegram_description' => '<a href="https://telegram.org/" target="_blank">Telegram</a> er en chat-app som
 gjør det enkelt å få meldinger i sanntid. Gå til <a
 href="http://docs.phpservermonitor.org/" target="_blank">dokumentasjonen</a> for
 mer informasjon og en installasjonsveiledning.',
        'telegram_api_token' => 'Telegram API Token',
        'telegram_api_token_description' => 'Før du kan bruke Telegram, må du få en API-token. Gå til <a
 href="http://docs.phpservermonitor.org/"
 target="_blank">dokumentasjonen</a> for å få hjelp.',
        'alert_type' => 'Velg når du vil bli varslet.',
        'alert_type_description' => '<b>Statusendring:</b> Du vil motta et varsel når en server har endret status.
 Så fra online -> offline eller offline -> online.<br><br /><b>Offline:</b> Du
 vil motta et varsel når en server går offline for *FØRSTE GANG BARE*. For
 eksempel,din cronjob er hver 15 minutter og serveren din går ned klokken 01:00
 og holder seg ned til 06:00. Du får 1 melding klokken 01:00 og det er
 det.<br><br><b>Alltid:</b> Du vil motta et varsel hver gang scriptet kjører, og
 et nettsted er nede, selv om nettstedet har vært offline i flere timer.',
        'alert_type_status' => 'Statusendring',
        'alert_type_offline' => 'Offline',
        'alert_type_always' => 'Alltid',
        'alert_proxy' => 'Selv om aktivert, blir proxy aldri brukt for tjenester',
        'alert_proxy_url' => 'Format: Vert:Port',
        'log_status' => 'Logg status',
        'log_status_description' => 'Hvis loggstatus er satt til SANT, logger monitoren på hendelsen når
 meldingsinnstillingene er bestått.',
        'log_email' => 'Logg e-post sendt av skriptet',
        'log_sms' => 'Logg tekstmeldinger sendt av skriptet',
        'log_pushover' => 'Logg pushover-meldinger sendt av skriptet',
        'log_telegram' => 'Logg Telegram-meldinger sendt av skriptet',
        'updated' => 'Konfigurasjonen er oppdatert.',
        'tab_email' => 'E-post',
        'tab_sms' => 'Tekstmelding',
        'tab_pushover' => 'Pushover',
        'tab_telegram' => 'Telegram',
        'settings_email' => 'E-post innstillinger',
        'settings_sms' => 'Tekstmelding innstillinger',
        'settings_pushover' => 'Pushover innstillinger',
        'settings_telegram' => 'Telegram innstillinger',
        'settings_notification' => 'Varsling innstillinger',
        'settings_log' => 'Logg innstillinger',
        'settings_proxy' => 'Proxy innstillinger',
        'auto_refresh' => 'Auto-refresh',
        'auto_refresh_description' => 'Auto-refresh server side.<br><span class="small">Tid i sekunder, hvis 0 siden
 ikke blir oppdatert.</span>',
        'test' => 'Test',
        'test_email' => 'En e-post vil bli sendt til adressen spesifisert i brukerprofilen din.',
        'test_sms' => 'En tekstmelding vil bli sendt til telefonnummeret som er angitt i brukerprofilen din.',
        'test_pushover' => 'En Pushover varsling vil bli sendt til brukernøkkelen/enheten som er angitt i
 brukerprofilen din.',
        'test_telegram' => 'Et telegramvarsling vil bli sendt til chat-ID-en spesifisert i brukerprofilen din.',
        'send' => 'Send',
        'test_subject' => 'Test',
        'test_message' => 'Test melding',
        'email_sent' => 'E-post sent',
        'email_error' => 'Feil ved sending av e-post',
        'sms_sent' => 'Tekstmelding sendt',
        'sms_error' => 'Det har oppstått en feil under sending av tekstmelding: %s',
        'sms_error_nomobile' => 'Kan ikke sende test tekstmelding: ingen gyldig telefonnummer funnet i profilen din.',
        'pushover_sent' => 'Pushover varsling sendt',
        'pushover_error' => 'Det har oppstått en feil under sending av Pushover-varslingen: %s',
        'pushover_error_noapp' => 'Kan ikke sende testvarsling: Ingen Pushover App API-token funnet i den globale
 konfigurasjonen.',
        'pushover_error_nokey' => 'Kan ikke sende testvarsling: Ingen Pushover-nøkkel funnet i profilen din.',
        'telegram_sent' => 'Telegram varsling sent',
        'telegram_error' => 'Det har oppstått en feil under sending av telegrammeldingen: %s',
        'telegram_error_notoken' => 'Kan ikke sende testvarsling: Ingen Telegram API-token funnet i den globale
 konfigurasjonen.',
        'telegram_error_noid' => 'Kan ikke sende testvarsling: Ingen chat-ID funnet i profilen din.',
        'log_retention_period' => 'Oppbevaringsperiode for logg',
        'log_retention_period_description' => 'Antall dager for å holde logger over varsler og arkiver av
 serveroppetid. Skriv 0 for å deaktivere loggopprydding.',
        'log_retention_days' => 'dager',
    ),
    'notifications' => array(
        'off_sms' => 'Serveren \'%LABEL%\' er NEDE: ip=%IP%, port=%PORT%. Feil=%ERROR%',
        'off_email_subject' => 'VIKTIG: Serveren \'%LABEL%\' er NEDE',
        'off_email_body' => 'Kunne ikke koble til følgende server:<br><br>Server: %LABEL%<br>IP: %IP%<br>Port:
 %PORT%<br>Feil: %ERROR%<br>Dato: %DATE%',
        'off_pushover_title' => 'Server \'%LABEL%\' er NEDE',
        'off_pushover_message' => 'Kunne ikke koble til følgende server:<br><br>Server: %LABEL%<br>IP: %IP%<br>Port:
 %PORT%<br>Feil: %ERROR%<br>Dato: %DATE%',
        'off_telegram_message' => 'Kunne ikke koble til følgende server:<br><br>Server: %LABEL%<br>IP: %IP%<br>Port:
 %PORT%<br>Feil: %ERROR%<br>Dato: %DATE%',
        'on_sms' => 'Server \'%LABEL%\' er OPPE igjen: ip=%IP%, port=%PORT%, det var nede i %LAST_OFFLINE_DURATION%',
        'on_email_subject' => 'VIKTIG: Server \'%LABEL%\' er OPPE',
        'on_email_body' => 'Server \'%LABEL%\' er oppe igjen, det var nede i %LAST_OFFLINE_DURATION%:<br><br>Server:
 %LABEL%<br>IP: %IP%<br>Port: %PORT%<br>Dato: %DATE%',
        'on_pushover_title' => 'Server \'%LABEL%\' er OPPE',
        'on_pushover_message' => 'Server \'%LABEL%\' er oppe igjen, det var nede i
 %LAST_OFFLINE_DURATION%:<br><br>Server: %LABEL%<br>IP: %IP%<br>Port: %PORT%<br>Dato:
 %DATE%',
        'on_telegram_message' => 'Server \'%LABEL%\' er oppe igjen, det var nede i
 %LAST_OFFLINE_DURATION%:<br><br>Server: %LABEL%<br>IP: %IP%<br>Port: %PORT%<br>Dato:
 %DATE%',
    ),
    'login' => array(
        'welcome_usermenu' => 'Velkommen, %user_name%',
        'title_sign_in' => 'Vennligst logg inn',
        'title_forgot' => 'Glemt passordet?',
        'title_reset' => 'Tilbakestill passordet ditt',
        'submit' => 'Send inn',
        'remember_me' => 'Husk meg',
        'login' => 'Logg inn',
        'logout' => 'Logg ut',
        'username' => 'Brukernavn',
        'password' => 'Passord',
        'password_repeat' => 'Gjenta passord',
        'password_forgot' => 'Glemt passordet?',
        'password_reset' => 'Tilbakestille passord',
        'password_reset_email_subject' => 'Tilbakestill passordet ditt for PHP Server Monitor',
        'password_reset_email_body' => 'Vennligst bruk følgende link for å tilbakestille passordet ditt. Vær
 oppmerksom på at det utløper om 1 time.<br><br>%link%',
        'error_user_incorrect' => 'Det oppgitte brukernavnet ble ikke funnet.',
        'error_login_incorrect' => 'Informasjonen er feil.',
        'error_login_passwords_nomatch' => 'De oppgitte passordene stemmer ikke overens.',
        'error_reset_invalid_link' => 'Tilbakestill lenken du oppgav er ugyldig.',
        'success_password_forgot' => 'En epost er sendt til deg med informasjon om hvordan du tilbakestiller passordet
 ditt.',
        'success_password_reset' => 'Ditt passord er tilbakestilt. Vennligst logg inn.',
    ),
    'error' => array(
        '401_unauthorized' => 'Uautorisert',
        '401_unauthorized_description' => 'Du har ikke rettighetene til å se denne siden.',
    ),
);
