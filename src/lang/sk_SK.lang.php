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
 * @author      Peter Misura <bzurko@gmail.com>
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

$sm_lang = array(
    'name' => 'Slovensky - Slovak',
    'locale' => array(
        '0' => 'sk_SK.UTF-8',
        '1' => 'sk_SK',
        '2' => 'slovak',
        '3' => 'slovak',
    ),
    'locale_tag' => 'sk',
    'locale_dir' => 'ltr',
    'system' => array(
        'title' => 'Server Monitor',
        'install' => 'Inštalácia',
        'action' => 'Akcia',
        'save' => 'Uložiť',
        'edit' => 'Upraviť',
        'delete' => 'Zmazať',
        'date' => 'Dátum',
        'message' => 'Správa',
        'yes' => 'Áno',
        'no' => 'Nie',
        'insert' => 'Vložiť',
        'add_new' => 'Pridať',
        'update_available' => 'Nová verzia - ({version}) je dostupná na <a
 href="https://github.com/phpservermon/phpservermon/releases/latest" target="_blank"
 rel="noopener">http://www.phpservermonitor.org</a>.',
        'back_to_top' => 'Späť na začiatok',
        'go_back' => 'Späť',
        'ok' => 'OK',
        'cancel' => 'Zrušiť',
        'short_day_format' => '%B %e',
        'long_day_format' => '%B %e, %Y',
        'yesterday_format' => 'Včera v %k:%M',
        'other_day_format' => '%A v %k:%M',
        'never' => 'Nikdy',
        'hours_ago' => 'pred %d hodinami',
        'an_hour_ago' => 'cca pred hodinou',
        'minutes_ago' => 'pred %d minútami',
        'a_minute_ago' => 'cca pred minútou',
        'seconds_ago' => 'pred %d sekundami',
        'a_second_ago' => 'pred chvíľou',
        'seconds' => 'sekúnd',
    ),
    'menu' => array(
        'config' => 'Konfigurácia',
        'server' => 'Servery',
        'server_log' => 'Log',
        'server_status' => 'Stav',
        'server_update' => 'Aktualizácia',
        'user' => 'Užívateľ',
        'help' => 'Nápoveda',
    ),
    'users' => array(
        'user' => 'Užívateľ',
        'name' => 'Meno',
        'user_name' => 'Užívateľské meno',
        'password' => 'Heslo',
        'password_repeat' => 'Rovnaké heslo (pre kontrolu)',
        'password_leave_blank' => 'Nevyplňujte ak nechcete zmeniť.',
        'level' => 'Oprávnenie',
        'level_10' => 'Administrátor',
        'level_20' => 'Užívateľ',
        'level_description' => '<b>Administrátor</b> má plný prístup: môže spravovať servery, užívateľov a
 upraviť globálnu konfiguráciu.<br><b>Uživatel</b> má práva len na čítanie a
 spustiť aktualizáciu serverov, ktoré má priradené.',
        'mobile' => 'Mobil',
        'email' => 'E-mail',
        'pushover' => 'Pushover',
        'pushover_description' => 'Pushover je služba umožňujúca jednoducho zasielať real-time upozornenia. Viac
 na <a href="https://pushover.net/">webe Pushover</a>',
        'pushover_key' => 'Pushover Token',
        'pushover_device' => 'Pushover Zariadenie',
        'pushover_device_description' => 'Název zariadenia, na ktoré má byť správa odoslaná. Ponechajte prázdne
 pre odoslanie na všetky zariadenia.',
        'delete_title' => 'Zmazať užívateľa',
        'delete_message' => 'Naozaj zmazať užívateľa \'%1\'?',
        'deleted' => 'Užívateľ zmazaný.',
        'updated' => 'Užívateľ aktualizovaný.',
        'inserted' => 'Užívateľ pridaný.',
        'profile' => 'Profil',
        'profile_updated' => 'Váš užívateľský profil bol upravený.',
        'error_user_name_bad_length' => 'Užívateľské meno musí obsahovať 2 až 64 znakov.',
        'error_user_name_invalid' => 'Užívateľské meno môže obsahovať iba písmena (a-z, A-Z), čísla (0-9),
 bodky (.) a podtržítka (_).',
        'error_user_name_exists' => 'Zadané uživatelské jméno již existuje v databázi.',
        'error_user_email_bad_length' => 'E-mailová adresa musí obsahovat 5 až 255 znaků .',
        'error_user_email_invalid' => 'E-mailová adresa je neplatná',
        'error_user_level_invalid' => 'Zadané oprávnenie je neplatné.',
        'error_user_no_match' => 'Užívateľ nebol najdený.',
        'error_user_password_invalid' => 'Zadané heslo je neplatné.',
        'error_user_password_no_match' => 'Zadaná heslá sa nezhodujú.',
    ),
    'log' => array(
        'title' => 'Záznamy logu',
        'type' => 'Typ',
        'status' => 'Stav',
        'email' => 'E-mail',
        'sms' => 'SMS',
        'pushover' => 'Pushover',
        'no_logs' => 'Žiadne záznamy',
        'clear' => 'Jasný protokol',
        'delete_title' => 'Jasný protokol',
        'delete_message' => 'Naozaj chcete odstrániť <b>všetky</b> záznamy?',
    ),
    'servers' => array(
        'server' => 'Server',
        'status' => 'Stav',
        'label' => 'Popis',
        'domain' => 'Doména/IP',
        'timeout' => 'Časový limit',
        'timeout_description' => 'Počet sekúnd čakania na odpoveď serveru.',
        'authentication_settings' => 'Nastavenie autentizacie',
        'optional' => 'voliteľný',
        'website_username' => 'Užívateľské meno',
        'website_username_description' => 'Užívateľské meno pre prístup na stránku. (Len Apache autorizácia je
 podporovaná.)',
        'website_password' => 'Heslo',
        'website_password_description' => 'Heslo pre prístup na stránku. Heslo je v databázi šifrované.',
        'fieldset_monitoring' => 'Monitoring',
        'fieldset_permissions' => 'Oprávnenie',
        'port' => 'Port',
        'custom_port' => 'Užívateľský Port',
        'popular_ports' => 'Populárne Porty',
        'please_select' => 'Prosím vyberte',
        'type' => 'Typ',
        'type_website' => 'Web',
        'type_service' => 'Služba',
        'pattern' => 'Vyhledat reťazec/vzor',
        'pattern_description' => 'Pokiaľ reťazec nebude na webe nájdený, bude server označený ako offline.
 Regulárne výrazy sú povolené.',
        'last_check' => 'Posledná kontrola',
        'last_online' => 'Naposledy online',
        'monitoring' => 'Monitoring',
        'no_monitoring' => 'Žiadne monitorované služby',
        'email' => 'E-mail',
        'send_email' => 'Odoslať e-mail',
        'sms' => 'SMS',
        'send_sms' => 'Odoslať SMS',
        'pushover' => 'Pushover',
        'users' => 'Užívatelia',
        'delete_title' => 'Zmazať server',
        'delete_message' => 'Naozaj si prajete zmazať \'%1\'?',
        'deleted' => 'Server zmazaný.',
        'updated' => 'Server aktualizovaný.',
        'inserted' => 'Server pridaný.',
        'latency' => 'Latencia',
        'latency_max' => 'Latencia (maximum)',
        'latency_min' => 'Latencia (minimum)',
        'latency_avg' => 'Latencia (priemer)',
        'uptime' => 'Uptime',
        'year' => 'Rok',
        'month' => 'Mesiac',
        'week' => 'Týždeň',
        'day' => 'Deň',
        'hour' => 'Hodina',
        'warning_threshold' => 'Stropná hranica varovania',
        'warning_threshold_description' => 'Počet neúspešných pokusov pred označením serveru ako offline.',
        'chart_last_week' => 'Minulý týždeň',
        'chart_history' => 'História',
        'chart_day_format' => '%Y-%m-%d',
        'chart_long_date_format' => '%Y-%m-%d %H:%M:%S',
        'chart_short_date_format' => '%m/%d %H:%M',
        'chart_short_time_format' => '%H:%M',
        'warning_notifications_disabled_sms' => 'SMS upozornenia sú vypnuté.',
        'warning_notifications_disabled_email' => 'E-mailové upozornenia sú vypnuté.',
        'warning_notifications_disabled_pushover' => 'Pushover upozornenia sú vypnuté.',
        'error_server_no_match' => 'Server nenájdený.',
        'error_server_label_bad_length' => 'Popisok musí obsahovať 1 až 255 znakov.',
        'error_server_ip_bad_length' => 'Doména/IP adresa musí obsahovať 1 až 255 znakov.',
        'error_server_ip_bad_service' => 'IP adresa nie je platná.',
        'error_server_ip_bad_website' => 'URL webu nie je platná.',
        'error_server_type_invalid' => 'Zvolený typ serveru nie je platný',
        'error_server_warning_threshold_invalid' => 'Hranica varovania musí byť číslo väčšie ako 0.',
    ),
    'config' => array(
        'general' => 'Všeobecné',
        'language' => 'Jazyk',
        'show_update' => 'Kontrolovať aktualizácie?',
        'password_encrypt_key' => 'Šifrovací kľúč pre heslá',
        'password_encrypt_key_note' => 'Týmto klúčom sa šifrujú heslá, ktoré sa ukladajú na serveroch pre
 prístup na webové stránky. Ak kľúč zmeníte, budú uložené heslá
 neplatné!',
        'email_status' => 'Povoliť odosielanie e-mailu',
        'email_from_email' => 'E-mailová adresa odosielateľa',
        'email_from_name' => 'Jméno odosielateľa',
        'email_smtp' => 'Zapnúť SMTP',
        'email_smtp_host' => 'SMTP adresa',
        'email_smtp_port' => 'SMTP port',
        'email_smtp_security' => 'SMTP zabezpečenie',
        'email_smtp_security_none' => 'žiadne',
        'email_smtp_username' => 'SMTP užívateľské meno',
        'email_smtp_password' => 'SMTP heslo',
        'email_smtp_noauth' => 'Nechajte prázdne pre použitie SMTP bez hesla',
        'sms_status' => 'Povoliť odosielanie textových správ',
        'sms_gateway' => 'Brána použitá pro odosielanie správ',
        'sms_gateway_username' => 'Užívateľské meno brány',
        'sms_gateway_password' => 'Heslo brány',
        'sms_from' => 'Telefónne číslo odosielateľa',
        'pushover_status' => 'Povoliť zasielanie Pushover správ',
        'pushover_description' => 'Pushover je služba umožňujúca jednoducho zasielať real-time upozornenia. Viac
 na <a href="https://pushover.net/">webe Pushover</a>',
        'pushover_clone_app' => 'Kliknite pre vytvorenie Pushover aplikácie',
        'pushover_api_token' => 'Pushover App API Token',
        'pushover_api_token_description' => 'Pred použitím Pushoveru sa musíte <a href="%1$s" target="_blank"
 rel="noopener">registrovať</a> a získať API Token.',
        'alert_type' => 'Zvoľte kedy si prajete byť upozornení.',
        'alert_type_description' => '<b>Zmena stavu:</b> Obdržíte upozornenie pri zmene stavu, teda: online ->
 offline alebo offline -> online.<br><br /><b>Offline:</b> Obdržíte upozornenie,
 keď server prejde *PO PRVÝ KRÁT* do offline stavu. Napríklad, pokiaľ je cron
 nastavený na 15 minút a sledovaný server bude offline mezi 01:00 a 06:00, tak
 obdržíte upozornenie iba o 01:00.<br><br><b>Vždy:</b> Obdržíte upozornenie
 pri každom spustení kontroly, teda aj pokiaľ bude server offline niekoľko
 hodín.',
        'alert_type_status' => 'Zmena stavu',
        'alert_type_offline' => 'Offline',
        'alert_type_always' => 'Vždy',
        'log_status' => 'Log',
        'log_status_description' => 'Pokiaľ je Log nastavený na hodnotu TRUE, systém do neho zapíše všetky
 upozornenia.',
        'log_email' => 'Logovať odoslané e-maily',
        'log_sms' => 'Logovať odoslané textové správy',
        'log_pushover' => 'Logovať odoslané Pushover správy',
        'updated' => 'Nastavenie bolo aktualizované.',
        'tab_email' => 'E-mail',
        'tab_sms' => 'SMS',
        'tab_pushover' => 'Pushover',
        'settings_email' => 'Nastavenie e-mailov',
        'settings_sms' => 'Nastavenie textových správ',
        'settings_pushover' => 'Nastavenie Pushover',
        'settings_notification' => 'Nastavenie upozornení',
        'settings_log' => 'Nastavenie logu',
        'auto_refresh' => 'Automaticky obnoviť',
        'auto_refresh_description' => 'Automaticky obnoviť stránku Servery.<br><span class="small">Čas v
 sekundách, 0 pre vypnutie automatického obnovenia.</span>',
        'test' => 'Test',
        'test_email' => 'E-mail bude odoslaný na adresu uvedenú v užívateľskom profile.',
        'test_sms' => 'SMS bude odoslaná na telefónne číslo uvedené v užívateľskom profile.',
        'test_pushover' => 'Pushover upozornenie bude odoslané užívateľovi/zariadeniu podľa nastavení v
 užívateľskom profile.',
        'send' => 'Odoslať',
        'test_subject' => 'Test',
        'test_message' => 'Testovacia správa',
        'email_sent' => 'E-mail odoslaný',
        'email_error' => 'Chyba pri odosielaní e-mailu',
        'sms_sent' => 'SMS odoslaná',
        'sms_error' => 'Chyba pri odosielaní SMS. %s',
        'sms_error_nomobile' => 'Nebolo možné odoslať SMS: v užívateľskom profile nebylo nájdené platné
 telefónne číslo.',
        'pushover_sent' => 'Pushover upozornenie odoslané.',
        'pushover_error' => 'Nastala chyba pri odosielaní Pushover upozornenia: %s',
        'pushover_error_noapp' => 'Nebolo možné odoslať testovacie upozornenie: v globálnom nastavení nebol
 nájdený žiaden API token.',
        'pushover_error_nokey' => 'Nebylo možné odoslať testovacie upozornenie: ve vašom profile nie je
 definovaný Pushover key.',
        'log_retention_period' => 'Rotácia logu',
        'log_retention_period_description' => 'Počet dní po které budú uchované logy upozornení. Vložte 0 pre
 vypnutie autorotáce.',
        'log_retention_days' => 'dní',
    ),
    'notifications' => array(
        'off_sms' => 'Server \'%LABEL%\' je offline: ip=%IP%, port=%PORT%. Chyba=%ERROR%',
        'off_email_subject' => 'DÔLEŽITÉ: Server \'%LABEL%\' je offline',
        'off_email_body' => 'Nebolo možné spojiť sa so serverom:<br><br>Server: %LABEL%<br>IP: %IP%<br>Port:
 %PORT%<br>Chyba: %ERROR%<br>Dátum: %DATE%',
        'off_pushover_title' => 'Server \'%LABEL%\' je offline',
        'off_pushover_message' => 'Nebolo možné spojiť sa so serverom:<br><br>Server: %LABEL%<br>IP: %IP%<br>Port:
 %PORT%<br>Chyba: %ERROR%<br>Dátum: %DATE%',
        'on_sms' => 'Server \'%LABEL%\' je online: ip=%IP%, port=%PORT%, it was down for %LAST_OFFLINE_DURATION%',
        'on_email_subject' => 'DÔLEŽITÉ: Server \'%LABEL%\' je online',
        'on_email_body' => 'Server \'%LABEL%\' je opäť online, it was down for
 %LAST_OFFLINE_DURATION%:<br><br>Server: %LABEL%<br>IP: %IP%<br>Port: %PORT%<br>Dátum:
 %DATE%',
        'on_pushover_title' => 'Server \'%LABEL%\' je online',
        'on_pushover_message' => 'Server \'%LABEL%\' je znovu online, it was down for
 %LAST_OFFLINE_DURATION%:<br><br>Server: %LABEL%<br>IP: %IP%<br>Port:
 %PORT%<br>Dátum: %DATE%',
    ),
    'login' => array(
        'welcome_usermenu' => 'Vitajte, %user_name%',
        'title_sign_in' => 'Prosím prihláste sa',
        'title_forgot' => 'Zabudnuté heslo?',
        'title_reset' => 'Obnova hesla',
        'submit' => 'Odoslať',
        'remember_me' => 'Zapamätať údaje',
        'login' => 'Prihlásiť',
        'logout' => 'Odhlásiť',
        'username' => 'Užívateľské meno',
        'password' => 'Heslo',
        'password_repeat' => 'Opakujte heslo',
        'password_forgot' => 'Zabudnuté heslo?',
        'password_reset' => 'Obnoviť heslo',
        'password_reset_email_subject' => 'Obnoviť heslo pre PHP Server Monitor',
        'password_reset_email_body' => 'Použite následujúci odkaz pre obnovenie hesla. Odkaz je platný jednu
 hodinu.<br><br>%link%',
        'error_user_incorrect' => 'Zadané užívateľské meno nebolo nájdené.',
        'error_login_incorrect' => 'Prihlásenie nebolo úspešné.',
        'error_login_passwords_nomatch' => 'Zadané heslá sa nezhodujú.',
        'error_reset_invalid_link' => 'Odkaz je neplatný.',
        'success_password_forgot' => 'Na vašu e-mailovú adresu bol zaslaný e-mail s informáciami pre obnovu hesla.',
        'success_password_reset' => 'Vaše heslo bolo úspešne obnovené. Prosím prihláste sa.',
    ),
    'error' => array(
        '401_unauthorized' => 'Nedostatočné oprávnenia',
        '401_unauthorized_description' => 'Nemáte oprávnenie zobraziť túto stránku.',
    ),
);
