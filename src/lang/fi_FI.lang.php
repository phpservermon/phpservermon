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
 * @author      Sami Nieminen <nieminen.sami2@gmail.com>
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

$sm_lang = array(
    'name' => 'Suomi - Finnish',
    'locale' => array(
        '0' => 'fi_FI.UTF-8',
        '1' => 'fi_FI',
        '2' => 'finnish',
        '3' => 'finnish-fi',
    ),
    'locale_tag' => 'fi',
    'locale_dir' => 'ltr',
    'system' => array(
        'title' => 'Server Monitor',
        'install' => 'Asenna',
        'action' => 'Toiminta',
        'save' => 'Tallenna',
        'edit' => 'Muokkaa',
        'delete' => 'Poista',
        'date' => 'Päivä',
        'message' => 'Viesti',
        'yes' => 'Kyllä',
        'no' => 'Ei',
        'insert' => 'Asetukset',
        'add_new' => 'Lisää uusi',
        'update_available' => 'Uusi versio ({version}) on ladattavissa osoitteessa <a
 href="https://github.com/phpservermon/phpservermon/releases/latest" target="_blank"
 rel="noopener">http://www.phpservermonitor.org</a>.',
        'back_to_top' => 'Takaisin ylös',
        'go_back' => 'Takaisin',
        'ok' => 'OK',
        'cancel' => 'Peruuta',
        'short_day_format' => '%B %e',
        'long_day_format' => '%B %e, %Y',
        'yesterday_format' => 'Eilen klo %k:%M',
        'other_day_format' => '%A klo %k:%M',
        'never' => 'Ei koskaan',
        'hours_ago' => '%d tuntia sitten',
        'an_hour_ago' => 'noin tunti sitten',
        'minutes_ago' => '%d minuuttia sitten',
        'a_minute_ago' => 'noin minuutti sitten',
        'seconds_ago' => '%d sekuntia sitten',
        'a_second_ago' => 'sekunti sitten',
    ),
    'menu' => array(
        'config' => 'Asetukset',
        'server' => 'Palvelimet',
        'server_log' => 'Tapahtumat',
        'server_status' => 'Tila',
        'server_update' => 'Päivitä',
        'user' => 'Käyttäjät',
        'help' => 'Apua',
    ),
    'users' => array(
        'user' => 'Käyttäjä',
        'name' => 'Nimi',
        'user_name' => 'Käyttäjänimi',
        'password' => 'Salasana',
        'password_repeat' => 'Salasana uudestaan',
        'password_leave_blank' => 'Jätä tyhjäksi jos et halua vaihtaa',
        'level' => 'Taso',
        'level_10' => 'Järjestelmänvalvoja',
        'level_20' => 'Käyttäjä',
        'level_description' => '<b>Järjestelmänvalvojilla</b> on täydet oikeudet: he voivat hallita palvelimia,
 käyttäjiä ja muokata ohjelmiston asetuksia.<br><b>Käyttäjät</b> voivat vain
 nähdä ja päivittää palvelimia jotka on asetettu heille.',
        'mobile' => 'Puhelin',
        'email' => 'Sähköposti',
        'pushover' => 'Pushover',
        'pushover_description' => 'Pushover on palvelu jolla on helppo lähettää reaaliaikaisia tilaviestejä. Katso
 <a href="https://pushover.net/" target="_blank">verkkosivuilta</a> lisäinfoa.',
        'pushover_key' => 'Pushover avain',
        'pushover_device' => 'Pushover laite',
        'pushover_device_description' => 'Laitteen nimi johon viesti lähetetään. Jätä tyhjäksi lähettääksesi
 kaikkiin laitteisiin.',
        'delete_title' => 'Poista käyttäjä',
        'delete_message' => 'Haluatko varmasti poistaa käyttäjän \'%1\'?',
        'deleted' => 'Käyttäjä poistettu.',
        'updated' => 'Käyttäjä päivitetty.',
        'inserted' => 'Käyttäjä lisätty.',
        'profile' => 'Profiili',
        'profile_updated' => 'Profiilisi on päivitetty.',
        'error_user_name_bad_length' => 'Käyttäjänimi saa olla 2-64 merkkiä pitkä.',
        'error_user_name_invalid' => 'Käyttäjänimessä saa olla vain kirjaimia (a-z, A-Z), numeroita (0-9),
 pisteitä (.) ja alaviivoja (_).',
        'error_user_name_exists' => 'Annettu käyttäjänimi on jo tietokannassa.',
        'error_user_email_bad_length' => 'Sähköpostiosoitteen täytyy olla 5-255 merkkiä pitkä.',
        'error_user_email_invalid' => 'Annettu sähköposti ei kelpaa.',
        'error_user_level_invalid' => 'Annettu käyttäjän taso ei kelpaa.',
        'error_user_no_match' => 'Käyttäjää ei löydetty tietokannasta.',
        'error_user_password_invalid' => 'Annettu salasana on väärin.',
        'error_user_password_no_match' => 'Annetut salasanat eivät täsmää.',
    ),
    'log' => array(
        'title' => 'Tapahtumamerkinnät',
        'type' => 'Tyyppi',
        'status' => 'Tila',
        'email' => 'Sähköposti',
        'sms' => 'Tekstiviesti',
        'pushover' => 'Pushover',
        'no_logs' => 'Ei tapahtumia',
        'clear' => 'Tyhjennä loki',
        'delete_title' => 'Poista loki',
        'delete_message' => 'Haluatko varmasti poistaa <b>kaikki</b> lokit?',
    ),
    'servers' => array(
        'server' => 'Palvelin',
        'status' => 'Tila',
        'label' => 'Nimi',
        'domain' => 'Isäntänimi/IP',
        'timeout' => 'Aikakatkaisu',
        'timeout_description' => 'Kuinka monta sekuntia odottaa kunnes palvelin merkitään sammuneeksi.',
        'port' => 'Portti',
        'type' => 'Tyyppi',
        'type_website' => 'Verkkosivu',
        'type_service' => 'Palvelu',
        'pattern' => 'Etsittävä sarja/kuvio',
        'pattern_description' => 'Jos määriteltyä sarjaa ei löydetä verkkosivuilta, palvelin merkitään
 sammuneeksi. REGEX on sallittua.',
        'last_check' => 'Viimeisin tarkistus',
        'last_online' => 'Viimeksi nähty',
        'monitoring' => 'Valvottava',
        'no_monitoring' => 'Ei valvontaa',
        'email' => 'Sähköposti',
        'send_email' => 'Lähetä sähköposti',
        'sms' => 'Tekstiviesti',
        'send_sms' => 'Lähetä tekstiviesti',
        'pushover' => 'Pushover',
        'users' => 'Käyttäjät',
        'delete_title' => 'Poista palvelin',
        'delete_message' => 'Haluatko varmasti poistaa palvelimen \'%1\'?',
        'deleted' => 'Palvelin poistettu.',
        'updated' => 'Palvelin päivitetty.',
        'inserted' => 'Palvelin lisätty.',
        'latency' => 'Viive',
        'latency_max' => 'Viive (maksimi)',
        'latency_min' => 'Viive (minimi)',
        'latency_avg' => 'Viive (keskiarvo)',
        'uptime' => 'Päälläoloaika',
        'year' => 'Vuosi',
        'month' => 'Kuukausi',
        'week' => 'Viikko',
        'day' => 'Päivä',
        'hour' => 'Tunti',
        'warning_threshold' => 'Varoituskynnys',
        'warning_threshold_description' => 'Epäonnistuneiden tarkistuksien määrä kunnes se merkataan sammuneeksi.',
        'chart_last_week' => 'Viime viikolla',
        'chart_history' => 'Historia',
        'chart_day_format' => '%Y-%m-%d',
        'chart_long_date_format' => '%Y-%m-%d %H:%M:%S',
        'chart_short_date_format' => '%m/%d %H:%M',
        'chart_short_time_format' => '%H:%M',
        'warning_notifications_disabled_sms' => 'Tekstiviesti-ilmoitukset on poistettu käytöstä.',
        'warning_notifications_disabled_email' => 'Sähköposti-ilmoitukset on poistettu käytöstä.',
        'warning_notifications_disabled_pushover' => 'Pushover-ilmoitukset on poistettu käytöstä.',
        'error_server_no_match' => 'Palvelinta ei löydetty.',
        'error_server_label_bad_length' => 'Nimen pitää olla 1-255 merkkiä pitkä.',
        'error_server_ip_bad_length' => 'Isäntänimen / IP:n pitää olla 1-255 merkkiä pitkä.',
        'error_server_ip_bad_service' => 'Annettu IP osoite ei kelpaa.',
        'error_server_ip_bad_website' => 'Annettu verkkosivun osoite ei kelpaa.',
        'error_server_type_invalid' => 'Valittu palvelintyyppi ei kelpaa.',
        'error_server_warning_threshold_invalid' => 'Varoituskynnyksen arvo pitää olla suurempi kuin 0.',
    ),
    'config' => array(
        'general' => 'Yleiset',
        'language' => 'Kieli',
        'show_update' => 'Tarkista päivitykset?',
        'email_status' => 'Salli sähköpostin lähettäminen',
        'email_from_email' => 'Lähettäjän osoite',
        'email_from_name' => 'Lähettäjän nimi',
        'email_smtp' => 'Käytä SMTP:tä',
        'email_smtp_host' => 'SMTP isäntä',
        'email_smtp_port' => 'SMTP portti',
        'email_smtp_security' => 'SMTP turvallisuus',
        'email_smtp_security_none' => 'Ei mitään',
        'email_smtp_username' => 'SMTP käyttäjänimi',
        'email_smtp_password' => 'SMTP salasana',
        'email_smtp_noauth' => 'Jätä tyhjäksi jos ei varmennusta',
        'sms_status' => 'Salli tekstiviestien lähetys',
        'sms_gateway' => 'Palvelu jonka kautta tekstiviestit lähetetään',
        'sms_gateway_username' => 'Palvelun käyttäjänimi',
        'sms_gateway_password' => 'Palvelun salasana',
        'sms_from' => 'Lähettäjän puhelinnumero',
        'pushover_status' => 'Salli Pushover-viestien lähetys',
        'pushover_description' => 'Pushover on palvelu jolla on helppo lähettää reaaliaikaisia tilaviestejä. Katso
 <a href="https://pushover.net/" target="_blank">verkkosivuilta</a> lisäinfoa.',
        'pushover_clone_app' => 'Paina tästä luodaksesi Pushover-sovelluksesi',
        'pushover_api_token' => 'Pushover API-avain',
        'pushover_api_token_description' => 'Ennen kuin voit käyttää Pushoveria, sinun täytyy <a href="%1$s"
 target="_blank" rel="noopener">rekisteröidä sovellus</a> heidän
 nettisivuillaan, ja kopioida API-avain tänne.',
        'alert_type' => 'Valitse milloin haluat ilmoituksia.',
        'alert_type_description' => '<b>Tilan muutos:</b> Saat ilmoituksen kun palvelimen tila vaihtuu. Eli tilasta
 päällä -> sammunut tai sammunut -> päällä.<br><br /><b>Sammunut:</b> Saat
 yhden ilmoituksen kun palvelimen tila vaihtuu sammuneeksi, mutta *VAIN
 ENSIMMÄISEN KERRAN*. Esimerkiksi, jos tarkistus tehdään joka 15 minuutti, ja
 palvelin sammuu klo 1 ja pysyy sammuneena klo 6 asti. Saat vain yhden ilmoituksen
 klo 1, ei muuta.<br><br><b>Aina:</b> Saat ilmoituksen joka kerta kun palvelin
 tarkistetaan, vaikka palvelin olisi ollut sammuneena tunteja.',
        'alert_type_status' => 'Tilan muutos',
        'alert_type_offline' => 'Sammunut',
        'alert_type_always' => 'Aina',
        'log_status' => 'Tallenna tapahtumat',
        'log_status_description' => 'Jos arvo on tosi, palvelin tallentaa tapahtumamerkinnän jokaisesta tilan
 muutoksesta.',
        'log_email' => 'Tallenna lähetetyt sähköpostitapahtumat',
        'log_sms' => 'Tallenna lähetetyt tekstiviestitapahtumat',
        'log_pushover' => 'Tallenna lähetetyt Pushover-tapahtumat',
        'updated' => 'Asetukset tallennettu ja päivitetty.',
        'tab_email' => 'Sähköposti',
        'tab_sms' => 'Tekstiviesti',
        'tab_pushover' => 'Pushover',
        'settings_email' => 'Sähköposti asetukset',
        'settings_sms' => 'Tekstiviesti asetukset',
        'settings_pushover' => 'Pushover asetukset',
        'settings_notification' => 'Ilmoitusasetukset',
        'settings_log' => 'Tapahtumamerkintöjen asetukset',
        'auto_refresh' => 'Automaattipäivitys',
        'auto_refresh_description' => 'Päivittää automaattisesti palvelimet-sivun.<br><span class="small">Aika
 sekunteina, jos 0, sivu ei päivity automaattisesti.</span>',
        'test' => 'Testi',
        'test_email' => 'Testisähköposti lähetetään profiilisi sähköpostiosoitteeseen.',
        'test_sms' => 'Testitekstiviesti lähetetään profiilisi numeroon.',
        'test_pushover' => 'Pushover-ilmoitus lähetetään profiilissa asetettuun laitteeseen.',
        'send' => 'Lähetä',
        'test_subject' => 'Testi',
        'test_message' => 'Testiviesti',
        'email_sent' => 'Sähköposti lähetetty',
        'email_error' => 'Virhe sähköpostin lähetyksessä',
        'sms_sent' => 'Tekstiviesti lähetetty',
        'sms_error' => 'Virhe tekstiviestin lähetyksessä. %s',
        'sms_error_nomobile' => 'Testitektiviestin lähetys epäonnistui: toimivaa numeroa ei löydetty profiilistasi.',
        'pushover_sent' => 'Pushover ilmoitus lähetetty',
        'pushover_error' => 'Virhe Pushover-ilmoitusta lähetettäessä: %s',
        'pushover_error_noapp' => 'Virhe lähetettäessä Pushover-ilmoitusta: Pushover API-avainta ei löydetty
 asetuksista.',
        'pushover_error_nokey' => 'Virhe lähetettäessä Pushover-ilmoitusta: Pushover avainta ei löydetty
 profiilistasi.',
        'log_retention_period' => 'Tapahtumien säilytysaika',
        'log_retention_period_description' => 'Kuinka monta päivää pitää palvelinten päälläoloaikoja ja muita
 tapahtumia. Aseta arvoksi 0 jos haluat pitää ne loputtomasti.',
        'log_retention_days' => 'päivää',
    ),
    'login' => array(
        'welcome_usermenu' => 'Tervetuloa, %user_name%',
        'title_sign_in' => 'Ole hyvä ja kirjaudu sisään',
        'title_forgot' => 'Unohtuiko salasanasi?',
        'title_reset' => 'Resetoi salasanasi',
        'submit' => 'Lähetä',
        'remember_me' => 'Muista minut',
        'login' => 'Kirjaudu sisään',
        'logout' => 'Kirjaudu ulos',
        'username' => 'Käyttäjänimi',
        'password' => 'Salasana',
        'password_repeat' => 'Salasana uudestaan',
        'password_forgot' => 'Unohtuiko salasanasi?',
        'password_reset' => 'Resetoi salasanasi',
        'password_reset_email_subject' => 'Resetoi salasanasi PHP Server Monitoriin',
        'password_reset_email_body' => 'Ole hyvä ja käytä seuraavaa linkkiä restoidaksesi salasanasi. Huomaa että
 linkki vanhentuu tunnin sisällä.<br><br>%link%',
        'error_user_incorrect' => 'Annettua käyttäjänimeä ei löydetty.',
        'error_login_incorrect' => 'Antamasi tiedot eivät ole oikein.',
        'error_login_passwords_nomatch' => 'Annetut salasanat eivät täsmää.',
        'error_reset_invalid_link' => 'Resetointilinkkisi on väärä.',
        'success_password_forgot' => 'Sähköpostiisi on lähetetty ohjeet kuinka resetoida salasanasi.',
        'success_password_reset' => 'Salasanasi on resetoitu onnistuneesti, ole hyvä ja kirjaudu sisään.',
    ),
    'error' => array(
        '401_unauthorized' => 'Ei käyttöoikeuksia',
        '401_unauthorized_description' => 'Sinulla ei ole käyttöoikeuksia katsoa tätä sivua.',
    ),
);
