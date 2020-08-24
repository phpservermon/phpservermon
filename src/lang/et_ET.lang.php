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
 * @author      Richard A.
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

$sm_lang = array(
    'name' => 'Eesti keel - Estonian',
    'locale' => array(
        '0' => 'et_ET.UTF-8',
        '1' => 'et_ET',
        '2' => 'estonian',
    ),
    'locale_tag' => 'et',
    'locale_dir' => 'ltr',
    'system' => array(
        'title' => 'Serveri Monitor',
        'install' => 'Installeeri',
        'action' => 'Toiming',
        'save' => 'Salvesta',
        'edit' => 'Muuda',
        'delete' => 'Kustuta',
        'date' => 'Kuupäev',
        'message' => 'Sõnum',
        'yes' => 'Jah',
        'no' => 'Ei',
        'insert' => 'Sisesta',
        'add_new' => 'Lisa uus',
        'update_available' => 'Uus versioon ({version}) on saadaval <a
 href="https://github.com/phpservermon/phpservermon/releases/latest" target="_blank"
 rel="noopener">http://www.phpservermonitor.org</a>.',
        'back_to_top' => 'Tagasi üles',
        'go_back' => 'Mine tagasi',
        'ok' => 'OK',
        'cancel' => 'Tühista',
        'short_day_format' => '%B %e',
        'long_day_format' => '%B %e, %Y',
        'yesterday_format' => 'Eile kell %k:%M',
        'other_day_format' => '%A kell %k:%M',
        'never' => 'Never',
        'hours_ago' => '%d tundi tagasi',
        'an_hour_ago' => 'umbes tund aega tagasi',
        'minutes_ago' => '%d minutit tagasi',
        'a_minute_ago' => 'umbes minut aega tagasi',
        'seconds_ago' => '%d sekundit tagasi',
        'a_second_ago' => 'üks sekund tagasi',
        'seconds' => 'sekundit',
    ),
    'menu' => array(
        'config' => 'Konfiguratsioon',
        'server' => 'Serverid',
        'server_log' => 'Logi',
        'server_status' => 'Staatus',
        'server_update' => 'Uuenda',
        'user' => 'Kasutajad',
        'help' => 'Abi',
    ),
    'users' => array(
        'user' => 'Kasutaja',
        'name' => 'Nimi',
        'user_name' => 'Kasutajanimi',
        'password' => 'Parool',
        'password_repeat' => 'Korda parooli',
        'password_leave_blank' => 'Jäta tühjaks, et jätta samaks',
        'level' => 'Tase',
        'level_10' => 'Administraator',
        'level_20' => 'Kasutaja',
        'level_description' => '<b>Administraatoritel</b> on täielik ligipääs: nad saavad hallata servereid,
 kasutajaid ja muuta globaalset konfiguratsiooni.<br><b>Kasutajad</b> saavad ainult
 näha ja uuendada neid servereid, mis on neile määratud.',
        'mobile' => 'Mobiil',
        'email' => 'Email',
        'pushover' => 'Pushover',
        'pushover_description' => 'Pushover on teenus, mis teeb reaalaja teavitused imelihtsaks. Vaata <a
 href="https://pushover.net/" target="_blank">nende kodulehte</a> rohkema info
 jaoks.',
        'pushover_key' => 'Pushoveri Võti',
        'pushover_device' => 'Pushoveri Seade',
        'pushover_device_description' => 'Seadme nimi, kuhu teavitus saata. Jäta tühjaks, et saata igale seadmele.',
        'delete_title' => 'Kustuta Kasutaja',
        'delete_message' => 'Oled kindel, et soovid selle kasutaja kustutada \'%1\'?',
        'deleted' => 'Kasutaja kustutatud.',
        'updated' => 'Kasutaja uuendatud.',
        'inserted' => 'Kasutaja lisatud.',
        'profile' => 'Profiil',
        'profile_updated' => 'Sinu profiil on uuendatud.',
        'error_user_name_bad_length' => 'Kasutajanimi peab olema 2 kuni 64 tähemärki pikk.',
        'error_user_name_invalid' => 'Kasutajanimi võib koosneda ainult tähenumbrilistest kombinatsioonidest (a-z,
 A-Z), numbritest (0-9), punktid (.) ja alakriipsust (_).',
        'error_user_name_exists' => 'Antud kasutaja juba eksisteerib andmebaasis.',
        'error_user_email_bad_length' => 'Email võib olla 5 kuni 255 tähemärki pikk.',
        'error_user_email_invalid' => 'Emaili aadress on kehtetu.',
        'error_user_level_invalid' => 'Antud kasutaja tase on kehtetu.',
        'error_user_no_match' => 'Kasutajat ei leitud andmebaasist.',
        'error_user_password_invalid' => 'Sisestatud parool on kehtetu.',
        'error_user_password_no_match' => 'Sisestatud paroolid ei kattu.',
    ),
    'log' => array(
        'title' => 'Logi kirjed',
        'type' => 'Tüüp',
        'status' => 'Staatus',
        'email' => 'Email',
        'sms' => 'SMS',
        'pushover' => 'Pushover',
        'no_logs' => 'Logisid ei eksisteeri',
        'clear' => 'Puhasta logig',
        'delete_title' => 'Kustuta logi',
        'delete_message' => 'Kas olete kindel, et soovite kustutada <b>kõik</b> logid?',
    ),
    'servers' => array(
        'server' => 'Server',
        'status' => 'Staatus',
        'label' => 'Silt',
        'domain' => 'Domeen/IP',
        'timeout' => 'Ajalõpp',
        'timeout_description' => 'Arv sekundeid oodata serveri vastamiseks.',
        'port' => 'Port',
        'type' => 'Tüüp',
        'type_website' => 'Veebileht',
        'type_service' => 'Teenus',
        'pattern' => 'Otsi nööri/mudelit',
        'pattern_description' => 'Kui seda mudelit serverist ei leita, siis server märgitakse võrgustväljas.
 Tavapärased väljendid on lubatud.',
        'last_check' => 'Viimane kontroll',
        'last_online' => 'Viimati oli võrgus',
        'monitoring' => 'Jälgib',
        'no_monitoring' => 'Ei jälgi',
        'email' => 'Email',
        'send_email' => 'Saada Email',
        'sms' => 'SMS',
        'send_sms' => 'Saada SMS',
        'pushover' => 'Pushover',
        'users' => 'Kasutajad',
        'delete_title' => 'Kustuta server',
        'delete_message' => 'Oled kindel, et soovid serveri kustutada \'%1\'?',
        'deleted' => 'Server kustutatud.',
        'updated' => 'Server uuendatud.',
        'inserted' => 'Server lisatud.',
        'latency' => 'Viivitus',
        'latency_max' => 'Viivitus (maksimaalne)',
        'latency_min' => 'Viivitus (minimaalne)',
        'latency_avg' => 'Viivitus (keskmine)',
        'uptime' => 'Võrgus oldud aeg',
        'year' => 'Aasta',
        'month' => 'Kuu',
        'week' => 'Nädal',
        'day' => 'Päev',
        'hour' => 'Tund',
        'warning_threshold' => 'Hoiatuskünnis',
        'warning_threshold_description' => 'Arv ebaõnnestunud kontrolle enne võrgustväljas märkimist.',
        'chart_last_week' => 'Eelmine nädal',
        'chart_history' => 'Ajalugu',
        'chart_day_format' => '%Y-%m-%d',
        'chart_long_date_format' => '%Y-%m-%d %H:%M:%S',
        'chart_short_date_format' => '%d/%m %H:%M',
        'chart_short_time_format' => '%H:%M',
        'warning_notifications_disabled_sms' => 'SMS teavitused on väljas.',
        'warning_notifications_disabled_email' => 'Emaili teavitused on väljas.',
        'warning_notifications_disabled_pushover' => 'Pushover teavitused on väljas.',
        'error_server_no_match' => 'Serverit ei leitud.',
        'error_server_label_bad_length' => 'Silt peab olema 1 kuni 255 tähemärki pikk.',
        'error_server_ip_bad_length' => 'Domeen / IP peab olema 1 kuni 255 tähemärki pikk.',
        'error_server_ip_bad_service' => 'Antud IP aadress ei ole kehtiv.',
        'error_server_ip_bad_website' => 'Antud veebileht ei ole kehtiv.',
        'error_server_type_invalid' => 'Valitud server oli kehtetu.',
        'error_server_warning_threshold_invalid' => 'Hoiatuskünnis peab olema suurem täisarv kui 0.',
    ),
    'config' => array(
        'general' => 'Üldine',
        'language' => 'Keel',
        'show_update' => 'Otsi värskendusi?',
        'email_status' => 'Luba emailide saatmine',
        'email_from_email' => 'Email aadressilt',
        'email_from_name' => 'Email nimelt',
        'email_smtp' => 'Luba SMTP',
        'email_smtp_host' => 'SMTP host',
        'email_smtp_port' => 'SMTP port',
        'email_smtp_security' => 'SMTP turvalisus',
        'email_smtp_security_none' => 'Mitte ükski',
        'email_smtp_username' => 'SMTP kasutajanimi',
        'email_smtp_password' => 'SMTP parool',
        'email_smtp_noauth' => 'Jäta tühjaks, et jätkata ilma autentimiseta',
        'sms_status' => 'Luba sõnumite saatmine',
        'sms_gateway' => 'Väravad sõnumite saatmiseks',
        'sms_gateway_username' => 'Värava kasutajanimi',
        'sms_gateway_password' => 'Värava parool',
        'sms_from' => 'Saatja telefoni number',
        'pushover_status' => 'Luba Pushoveri sõnumite saatmine',
        'pushover_description' => 'Pushover on teenus, mis teeb reaalaja teavitused imelihtsaks. Vaata <a
 href="https://pushover.net/" target="_blank">nende kodulehte</a> rohkema info
 jaoks.',
        'pushover_clone_app' => 'Kliki siia, et teha oma Pushover äpp',
        'pushover_api_token' => 'Pushover Äppi API Žetoon',
        'pushover_api_token_description' => 'Enne, kui saad Pushoverida pead sa <a href="%1$s" target="_blank"
 rel="noopener">regristreerima äpi</a> nende kodulehel ja sisestama API
 žetooni siia.',
        'alert_type' => 'Vali, millal sa sooviksid olla teavitatud.',
        'alert_type_description' => '<b>Staatuse muutus:</b> Saate teavituse kui serveri staatuses toimub muudatusi.
 Seega kättesaadav -> võrgust väljas või võrgust väljas ->
 kättesaadav.<br><br /><b>Võrgust väljas:</b> Saate teavituse kui server läheb
 võrgust välja *ESIMEST KORDA*. Näiteks, sinu cronjob on iga 15 minuti tagant
 ja sulgub kell 1 öösel kuni kella 6ni hommikul. Saate 1 teavituse kell 1
 öösel ja see on kõik.<br><br><b>Alati:</b> Saate teavituse iga kord kui
 staatust uuendatakse, isegi kui leht on olnud maas juba tunde.',
        'alert_type_status' => 'Staatuse muutus',
        'alert_type_offline' => 'Võrgust väljas',
        'alert_type_always' => 'Alati',
        'log_status' => 'Logi staatus',
        'log_status_description' => 'Kui logimine on seatud TÕESEKS, siis monitor logib aktiivsuse mil teavituse
 seaded on läbitud.',
        'log_email' => 'Logi saadetud emailid',
        'log_sms' => 'Logi saadetud sõnumid',
        'log_pushover' => 'Logi Pushoveri saadetud teavitused',
        'updated' => 'Konfiguratsioon on uuendatud.',
        'tab_email' => 'Email',
        'tab_sms' => 'SMS',
        'tab_pushover' => 'Pushover',
        'settings_email' => 'Emaili seaded',
        'settings_sms' => 'Sõnumite seaded',
        'settings_pushover' => 'Pushoveri seaded',
        'settings_notification' => 'Teavituste seaded',
        'settings_log' => 'Logi seaded',
        'auto_refresh' => 'Automaatne värskendamine',
        'auto_refresh_description' => 'Värskenda lehte automaatselt.<br><span class="small">Aeg sekundites, kui 0
 siis lehte ei värskendata.</span>',
        'test' => 'Test',
        'test_email' => 'Email saadetakse profiilil märgitud aadressile.',
        'test_sms' => 'SMS saadetakse profiilil märgitud numbrile.',
        'test_pushover' => 'Pushover teavitus saadetakse profiilil märgitud seadmele/tele.',
        'send' => 'Saada',
        'test_subject' => 'Test',
        'test_message' => 'Test sõnum',
        'email_sent' => 'Email saadetud',
        'email_error' => 'Emaili saatmisel esines error',
        'sms_sent' => 'Sms saadetud',
        'sms_error' => 'Smsi saatmisel esines error. %s',
        'sms_error_nomobile' => 'Test SMSi ei saadetud: kehtivat telefoni numbrit ei leitud.',
        'pushover_sent' => 'Pushover teavitus saadetud',
        'pushover_error' => 'Pushover teavituse saatmisel esines error: %s',
        'pushover_error_noapp' => 'Test teavitust ei saadetud: Pushover API žetooni ei leitud globaalsest
 konfiguratsioonist.',
        'pushover_error_nokey' => 'Test teavitust ei saadetud: Pushover võtit ei leitud.',
        'log_retention_period' => 'Logi säilitamis periood',
        'log_retention_period_description' => 'Arv päevi, mil hoida logid alles. Sisesta 0, et keelata logide
 puhastus.',
        'log_retention_days' => 'päeva',
    ),
    'notifications' => array(
        'off_sms' => 'Server \'%LABEL%\' on MAAS: ip=%IP%, port=%PORT%. Error=%ERROR%',
        'off_email_subject' => 'TÄHTIS: Server \'%LABEL%\' is MAAS',
        'off_email_body' => 'Ühendus järgnevasse serverisse ebaõnnestus:<br><br>Server: %LABEL%<br>IP:
 %IP%<br>Port: %PORT%<br>Error: %ERROR%<br>Kuupäev: %DATE%',
        'off_pushover_title' => 'Server \'%LABEL%\' on MAAS',
        'off_pushover_message' => 'Ühendus järgnevasse serverisse ebaõnnestus:<br><br>Server: %LABEL%<br>IP:
 %IP%<br>Port: %PORT%<br>Error: %ERROR%<br>Kuupäev: %DATE%',
        'on_sms' => 'Server \'%LABEL%\' on KÄTTESAADAV: ip=%IP%, port=%PORT%, it was down for %LAST_OFFLINE_DURATION%',
        'on_email_subject' => 'TÄHTIS: Server \'%LABEL%\' on kättesaadav',
        'on_email_body' => 'Server \'%LABEL%\' on jälle kättesaadav, it was down for
 %LAST_OFFLINE_DURATION%:<br><br>Server: %LABEL%<br>IP: %IP%<br>Port: %PORT%<br>Kuupäev:
 %DATE%',
        'on_pushover_title' => 'Server \'%LABEL%\' on kättesaadav',
        'on_pushover_message' => 'Server \'%LABEL%\' on jälle kättesaadav, it was down for
 %LAST_OFFLINE_DURATION%:<br><br>Server: %LABEL%<br>IP: %IP%<br>Port:
 %PORT%<br>Kuupäev: %DATE%',
    ),
    'login' => array(
        'welcome_usermenu' => 'Teretulemast, %user_name%',
        'title_sign_in' => 'Palun logi sisse',
        'title_forgot' => 'Unustasid oma salasõna?',
        'title_reset' => 'Lähtesta oma parool',
        'submit' => 'Esita',
        'remember_me' => 'Mäleta mind',
        'login' => 'Logi sisse',
        'logout' => 'Logi välja',
        'username' => 'Kasutajanimi',
        'password' => 'Parool',
        'password_repeat' => 'Korda salasõna',
        'password_forgot' => 'Unustasid salasõna?',
        'password_reset' => 'Lähtesta parool',
        'password_reset_email_subject' => 'Lähtestage oma PHP Serveri Monitori parool',
        'password_reset_email_body' => 'Palun kasutage järgnevat linki oma parooli lähtestamiseks. Palume
 tähendada, et see aegub 1 tunni jooksul.<br><br>%link%',
        'error_user_incorrect' => 'Antud kasutaja ei ole kehtiv.',
        'error_login_incorrect' => 'Informatsioon ei ole õige.',
        'error_login_passwords_nomatch' => 'Sisestatud paroolid ei kattu.',
        'error_reset_invalid_link' => 'Teie antud lähtestus link ei kehti.',
        'success_password_forgot' => 'Teile saadeti email, kuidas lähtestada oma parooli.',
        'success_password_reset' => 'Teie parool on edukalt muudetud. Palun logige sisse.',
    ),
    'error' => array(
        '401_unauthorized' => 'Puuduvad õigused',
        '401_unauthorized_description' => 'Teil ei ole piisavalt õigusi seda lehte vaadata.',
    ),
);
