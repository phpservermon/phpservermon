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
 * @author      Simon Berka <berka@berkasimon.com>
 * @author      Pavel Laupe Dvorak <pavel@pavel-dvorak.cz>
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

$sm_lang = array(
    'name' => 'Česky - Czech',
    'locale' => array(
        '0' => 'cs_CZ.UTF-8',
        '1' => 'cs_CZ',
        '2' => 'czech',
        '3' => 'czech',
    ),
    'locale_tag' => 'cs',
    'locale_dir' => 'ltr',
    'system' => array(
        'title' => 'Server Monitor',
        'install' => 'Instalace',
        'action' => 'Akce',
        'save' => 'Uložit',
        'edit' => 'Upravit',
        'delete' => 'Smazat',
        'date' => 'Datum',
        'message' => 'Zpráva',
        'yes' => 'Ano',
        'no' => 'Ne',
        'insert' => 'Vložit',
        'add_new' => 'Přidat',
        'update_available' => 'Nová verze - ({version}) je dostupná na <a
 href="https://github.com/phpservermon/phpservermon/releases/latest" target="_blank"
 rel="noopener">http://www.phpservermonitor.org</a>.',
        'back_to_top' => 'Zpět na začátek',
        'go_back' => 'Zpět',
        'ok' => 'OK',
        'cancel' => 'Zrušit',
        'short_day_format' => '%B %e',
        'long_day_format' => '%B %e, %Y',
        'yesterday_format' => 'Včera v %k:%M',
        'other_day_format' => '%A v %k:%M',
        'never' => 'Nikdy',
        'hours_ago' => 'před %d hodinami',
        'an_hour_ago' => 'cca před hodinou',
        'minutes_ago' => 'před %d minutami',
        'a_minute_ago' => 'cca před minutou',
        'seconds_ago' => 'před %d vteřinami',
        'a_second_ago' => 'před chvílí',
        'seconds' => 'sekunder',
    ),
    'menu' => array(
        'config' => 'Konfigurace',
        'server' => 'Servery',
        'server_log' => 'Log',
        'server_status' => 'Status',
        'server_update' => 'Aktualizace',
        'user' => 'Uživatelé',
        'help' => 'Nápověda',
    ),
    'users' => array(
        'user' => 'Uživatel',
        'name' => 'Jméno',
        'user_name' => 'Uživatelské jméno',
        'password' => 'Heslo',
        'password_repeat' => 'Stejné heslo (pro kontrolu)',
        'password_leave_blank' => 'Ponechte prázdné pro ponechání beze změn.',
        'level' => 'Oprávnění',
        'level_10' => 'Administrátor',
        'level_20' => 'Uživatel',
        'level_description' => '<b>Administrátor</b> má plný přístup: může spravovat servery, uživatele a
 upravit globální konfiguraci.<br><b>Uživatel</b> má práva pouze na čtení a
 spustit aktualizaci serverů, které má přiřazeny.',
        'mobile' => 'Mobil',
        'email' => 'E-mail',
        'pushover' => 'Pushover',
        'pushover_description' => 'Pushover je služba umožňující jednoduše zasílat real-time upozornění.
 Více na <a href="https://pushover.net/" target="_blank">webu Pushover</a>',
        'pushover_key' => 'Pushover Token',
        'pushover_device' => 'Pushover Zařízení',
        'pushover_device_description' => 'Název zařízení, na které má být zráva odeslána. Ponechte prázdné
 pro odeslání na všechna zařízení.',
        'delete_title' => 'Smazat uživatele',
        'delete_message' => 'Opravdu smazat uživatele \'%1\'?',
        'deleted' => 'Uživatel smazán.',
        'updated' => 'Uživatel aktualizován.',
        'inserted' => 'Uživatel přidán.',
        'profile' => 'Profil',
        'profile_updated' => 'Váš uživatelský profil byl upraven.',
        'error_user_name_bad_length' => 'Uživatelské jméno musí obsahovat 2 až 64 znaků.',
        'error_user_name_invalid' => 'Uživatelské jméno může obsahovat pouze písmena (a-z, A-Z), čísla (0-9),
 tečky (.) a podtržítka (_).',
        'error_user_name_exists' => 'Zadané uživatelské jméno již existuje v databázi.',
        'error_user_email_bad_length' => 'E-mailová adresa musí obsahovat 5 až 255 znaků .',
        'error_user_email_invalid' => 'E-mailová adresa je neplatná',
        'error_user_level_invalid' => 'Zadané oprávnění je neplatné.',
        'error_user_no_match' => 'Uživatel nebyl nalezen.',
        'error_user_password_invalid' => 'Zadané heslo je neplatné.',
        'error_user_password_no_match' => 'Zadaná hesla neodpovídají.',
    ),
    'log' => array(
        'title' => 'Záznamy logu',
        'type' => 'Typ',
        'status' => 'Stav',
        'email' => 'E-mail',
        'sms' => 'SMS',
        'pushover' => 'Pushover',
        'no_logs' => 'Žádné záznamy',
        'clear' => 'Jasný protokol',
        'delete_title' => 'Odstranit protokol',
        'delete_message' => 'Opravdu chcete odstranit protokoly <b>všechny</b>?',
    ),
    'servers' => array(
        'server' => 'Server',
        'status' => 'Stav',
        'label' => 'Popis',
        'domain' => 'Doména/IP',
        'timeout' => 'Časový limit',
        'timeout_description' => 'Počet vteřin čekání na odpověď serveru.',
        'authentication_settings' => 'Nastavení autentizace',
        'optional' => 'volitelný',
        'website_username' => 'Uživatelské jméno',
        'website_username_description' => 'Uživatelské jméno pro přístup na stránku. (Pouze Apache autorizace je
 podporovaná.)',
        'website_password' => 'Heslo',
        'website_password_description' => 'Heslo pro přístup na stránku. Heslo je v databázi šifrované.',
        'fieldset_monitoring' => 'Monitoring',
        'fieldset_permissions' => 'Oprávnění',
        'port' => 'Port',
        'custom_port' => 'Uživatelský Port',
        'popular_ports' => 'Populární Porty',
        'please_select' => 'Prosím vyberte',
        'type' => 'Typ',
        'type_website' => 'Web',
        'type_service' => 'Služba',
        'pattern' => 'Vyhledat řetězec/vzorek',
        'pattern_description' => 'Pokud vzorek nebude na webu nalezen, bude server označen jako offline. Regulární
 výrazy jsou povoleny.',
        'last_check' => 'Poslední kontrola',
        'last_online' => 'Naposledy online',
        'last_offline' => 'Naposledy offline',
        'monitoring' => 'Monitoring',
        'no_monitoring' => 'Žádné monitorované služby',
        'email' => 'E-mail',
        'send_email' => 'Odeslat e-mail',
        'sms' => 'SMS',
        'send_sms' => 'Odeslat SMS',
        'pushover' => 'Pushover',
        'users' => 'Uživatelé',
        'delete_title' => 'Smazat server',
        'delete_message' => 'Opravdu si přejete smazat \'%1\'?',
        'deleted' => 'Server smazán.',
        'updated' => 'Server aktualizován.',
        'inserted' => 'Server přidán.',
        'latency' => 'Latence',
        'latency_max' => 'Latence (maximum)',
        'latency_min' => 'Latence (minimum)',
        'latency_avg' => 'Latence (průměr)',
        'uptime' => 'Uptime',
        'year' => 'Rok',
        'month' => 'Měsíc',
        'week' => 'Týden',
        'day' => 'Den',
        'hour' => 'Hodina',
        'warning_threshold' => 'Stropní hranice varování',
        'warning_threshold_description' => 'Počet neúspěšných pokusů před označením serveru jako offline.',
        'chart_last_week' => 'Minulý týden',
        'chart_history' => 'Historie',
        'chart_day_format' => '%Y-%m-%d',
        'chart_long_date_format' => '%Y-%m-%d %H:%M:%S',
        'chart_short_date_format' => '%m/%d %H:%M',
        'chart_short_time_format' => '%H:%M',
        'warning_notifications_disabled_sms' => 'SMS upozornění jsou vypnuta.',
        'warning_notifications_disabled_email' => 'E-mailová upozornění jsou vypnuta.',
        'warning_notifications_disabled_pushover' => 'Pushover upozornění jsou vypnuta.',
        'error_server_no_match' => 'Server nenalezen.',
        'error_server_label_bad_length' => 'Popisek musí obsahovat 1 až 255 znaků.',
        'error_server_ip_bad_length' => 'Doména/IP adresa musí obsahovat 1 až 255 znaků.',
        'error_server_ip_bad_service' => 'IP adresa není platná.',
        'error_server_ip_bad_website' => 'URL webu není platná.',
        'error_server_type_invalid' => 'Zvolený typ serveru není platný',
        'error_server_warning_threshold_invalid' => 'Hranice varování musí být číslo větší než 0.',
    ),
    'config' => array(
        'general' => 'Obecné',
        'language' => 'Jazyk',
        'show_update' => 'Kontrolovat aktualizace?',
        'password_encrypt_key' => 'Šifrovací klíč pro hesla',
        'password_encrypt_key_note' => 'Tímto klíčem se šifrují hesla, která se ukládají u serverů pro
 přístup na webové stránky. Pokud klíč změníte budou uložená hesla
 neplatná!',
        'email_status' => 'Povolit odesílání e-mailu',
        'email_from_email' => 'E-mailová adresa odesilatele',
        'email_from_name' => 'Jméno odesilatele',
        'email_smtp' => 'Zapnout SMTP',
        'email_smtp_host' => 'SMTP adresa',
        'email_smtp_port' => 'SMTP port',
        'email_smtp_security' => 'SMTP zabezpečení',
        'email_smtp_security_none' => 'žádné',
        'email_smtp_username' => 'SMTP uživatelské jméno',
        'email_smtp_password' => 'SMTP heslo',
        'email_smtp_noauth' => 'Ponechte prázdné pro použití SMTP bez hesla',
        'sms_status' => 'Povolit odesílání textových zpráv',
        'sms_gateway' => 'Brána použitá pro odesílání zpráv',
        'sms_gateway_username' => 'Uživatelské jméno brány',
        'sms_gateway_password' => 'Heslo brány',
        'sms_from' => 'Telefonní číslo odesilatele',
        'pushover_status' => 'Povolit zasílání Pushover zpráv',
        'pushover_description' => 'Pushover je služba umožňující jednoduše zasílat real-time upozornění.
 Více na <a href="https://pushover.net/" target="_blank">webu Pushover</a>',
        'pushover_clone_app' => 'Klikněte pro vytvoření Pushover aplikace',
        'pushover_api_token' => 'Pushover App API Token',
        'pushover_api_token_description' => 'Pře použitím Pushoveru se musíte <a href="%1$s" target="_blank"
 rel="noopener">registrovat</a> a získat API Token.',
        'alert_type' => 'Zvolte kdy si přejete být upozorněni.',
        'alert_type_description' => '<b>Změna stavu:</b> Obdržíte upozornění při změně stavu, tedy:online ->
 offline nebo offline -> online.<br><br /><b>Offline:</b> Obdržíte upozornění,
 kdy server přejde poprvé do offline stavu. Například, pokud je cron nastaven
 na 15 minut a sledovaný server bude offline mezi 01:00 a 06:00. Obdržíte
 upozornění pouze v 01:00. <br><br><b>Vždy:</b> Obdržíte upozornění při
 každém spuštění kontroly, tedy i pokud bude server offline několik hodin.',
        'alert_type_status' => 'Změna stavu',
        'alert_type_offline' => 'Offline',
        'alert_type_always' => 'Vždy',
        'log_status' => 'Log',
        'log_status_description' => 'Pokud je Log nastaven na hodnotu TRUE, systém do něj zapíše veškerá
 provedená upozornění.',
        'log_email' => 'Logovat odeslané e-maily',
        'log_sms' => 'Logovat odeslané textové zprávy',
        'log_pushover' => 'Logovat odeslané Pushover zprávy',
        'updated' => 'Nastavení bylo aktualizováno.',
        'tab_email' => 'E-mail',
        'tab_sms' => 'SMS',
        'tab_pushover' => 'Pushover',
        'settings_email' => 'Nastavení e-mailů',
        'settings_sms' => 'Nastavení textových zpráv',
        'settings_pushover' => 'Nastavení Pushover',
        'settings_notification' => 'Nastavení upozornění',
        'settings_log' => 'Nastavení logu',
        'auto_refresh' => 'Automaticky obnovit',
        'auto_refresh_description' => 'Automaticky obnovit stránku Servery.<br><span class="small">Čas v sekundách,
 0 pro vypnutí automatického obnovení.</span>',
        'test' => 'Test',
        'test_email' => 'E-mail bude odeslán na adresu uvedenou v uživatelském profilu.',
        'test_sms' => 'SMS bude odeslána na telefonní číslo uvedené v uživatelském profilu.',
        'test_pushover' => 'Pushover upozornění bude odesláno uživateli/zařízení dle nastavení v
 uživatelském profilu.',
        'send' => 'Odeslat',
        'test_subject' => 'Test',
        'test_message' => 'Testovací zpráva',
        'email_sent' => 'E-mail odeslán',
        'email_error' => 'Chyba při odeslání e-mailu',
        'sms_sent' => 'SMS odeslána',
        'sms_error' => 'Chyba při odeslání SMS. %s',
        'sms_error_nomobile' => 'Nebylo možné odeslat SMS: v uživatelském profilu nebylo nalezeno platné
 telefonní číslo.',
        'pushover_sent' => 'Pushover upozornění odesláno.',
        'pushover_error' => 'Nastala chyba při odesílání Pushover upozornění: %s',
        'pushover_error_noapp' => 'Nebylo možné odeslat testovací upozornění: v globálním nastavení nebyl
 nalezen žádný API token.',
        'pushover_error_nokey' => 'Nebylo možné odeslat testovací upozornění: ve vašem profilu není definován
 Pushover key.',
        'log_retention_period' => 'Rotace logu',
        'log_retention_period_description' => 'Počet dnů po které budou zachovány logy upozornění. Vložte 0 pro
 vypnutí autorotace.',
        'log_retention_days' => 'dnů',
    ),
    'notifications' => array(
        'off_sms' => 'Server \'%LABEL%\' je offline: ip=%IP%, port=%PORT%. Chyba=%ERROR%',
        'off_email_subject' => 'DŮLEŽITÉ: Server \'%LABEL%\' je offline',
        'off_email_body' => 'Nebylo možné spojit se se serverem:<br><br>Server: %LABEL%<br>IP: %IP%<br>Port:
 %PORT%<br>Chyba: %ERROR%<br>Datum: %DATE%',
        'off_pushover_title' => 'Server \'%LABEL%\' je offline',
        'off_pushover_message' => 'Nebylo možné spojit se se serverem:<br><br>Server: %LABEL%<br>IP: %IP%<br>Port:
 %PORT%<br>Chyba: %ERROR%<br>Datum: %DATE%',
        'on_sms' => 'Server \'%LABEL%\' je online: ip=%IP%, port=%PORT%, it was down for %LAST_OFFLINE_DURATION%',
        'on_email_subject' => 'DŮLEŽITÉ: Server \'%LABEL%\' je online',
        'on_email_body' => 'Server \'%LABEL%\' je opět online, it was down for
 %LAST_OFFLINE_DURATION%:<br><br>Server: %LABEL%<br>IP: %IP%<br>Port: %PORT%<br>Datum:
 %DATE%',
        'on_pushover_title' => 'Server \'%LABEL%\' je online',
        'on_pushover_message' => 'Server \'%LABEL%\' je znovu online, it was down for
 %LAST_OFFLINE_DURATION%:<br><br>Server: %LABEL%<br>IP: %IP%<br>Port:
 %PORT%<br>Datum: %DATE%',
    ),
    'login' => array(
        'welcome_usermenu' => 'Vítejte, %user_name%',
        'title_sign_in' => 'Prosím přihlašte se',
        'title_forgot' => 'Zapomenuté heslo?',
        'title_reset' => 'Obnova hesla',
        'submit' => 'Odeslat',
        'remember_me' => 'Zapamatovat údaje',
        'login' => 'Přihlásit',
        'logout' => 'Odhlásit',
        'username' => 'Uživatelské jméno',
        'password' => 'Heslo',
        'password_repeat' => 'Opište heslo',
        'password_forgot' => 'Zapomenuté heslo?',
        'password_reset' => 'Obnovit heslo',
        'password_reset_email_subject' => 'Obnovit heslo pro PHP Server Monitor',
        'password_reset_email_body' => 'Použijte následující odkaz pro obnovení hesla. Odkaz je platný jednu
 hodinu.<br><br>%link%',
        'error_user_incorrect' => 'Zadané uživatelské jméno nebylo nalezeno.',
        'error_login_incorrect' => 'Přihlášení nebylo úspěšné.',
        'error_login_passwords_nomatch' => 'Zadaná hesla neodpovídají.',
        'error_reset_invalid_link' => 'Odkaz je neplatný.',
        'success_password_forgot' => 'Na vaši e-mailovou adresu byl zaslán e-mail s informacemi pro obnovu hesla.',
        'success_password_reset' => 'Vaše heslo bylo úspěšně obnoveno. Prosím přihlašte se.',
    ),
    'error' => array(
        '401_unauthorized' => 'Nedostatečné oprávnění',
        '401_unauthorized_description' => 'Nemáte oprávnění zobrazit tuto stránku.',
    ),
);
