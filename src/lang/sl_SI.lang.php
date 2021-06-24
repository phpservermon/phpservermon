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
 * @author      Matej Kovacic <https://github.com/MatejKovacic>
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

$sm_lang = array(
    'name' => 'Slovenščina - Slovenian',
    'locale' => array(
        '0' => 'sl_SI.UTF-8',
        '1' => 'sl_SI',
        '2' => 'slovenščina',
        '3' => 'slovenščina',
    ),
    'system' => array(
        'title' => 'Server Monitor',
        'install' => 'Install',
        'action' => 'Action',
        'save' => 'Shrani',
        'edit' => 'Uredi',
        'delete' => 'Izbriši',
        'date' => 'Datum',
        'message' => 'Sporočilo',
        'yes' => 'da',
        'no' => 'ne',
        'insert' => 'Vstavi',
        'add_new' => 'Dodaj novega',
        'update_available' => 'Na voljo je nova različica ({version}); prenesti jo je mogoče iz <a
 href="https://github.com/phpservermon/phpservermon/releases/latest" target="_blank"
 rel="noopener">http://www.phpservermonitor.org</a>.',
        'back_to_top' => 'Nazaj na vrh',
        'go_back' => 'Nazaj',
        'ok' => 'OK',
        'cancel' => 'Prekini',
        'short_day_format' => '%B %e',
        'long_day_format' => '%B %e, %Y',
        'yesterday_format' => 'včeraj ob %k:%M',
        'other_day_format' => '%A at %k:%M',
        'never' => 'nikoli',
        'hours_ago' => 'pred %d urami',
        'an_hour_ago' => 'pred približno uro',
        'minutes_ago' => 'pred %d minutami',
        'a_minute_ago' => 'pred približno minuto',
        'seconds_ago' => 'pred %d sekundami',
        'a_second_ago' => 'pred sekundo',
        'seconds' => 'sekund',
    ),
    'menu' => array(
        'config' => 'Nastavitve',
        'server' => 'Strežniki',
        'server_log' => 'Dnevnik',
        'server_status' => 'Status',
        'server_update' => 'Posodobitev statusa',
        'user' => 'Uporabniki',
        'help' => 'Pomoč',
    ),
    'users' => array(
        'user' => 'Uporabnik',
        'name' => 'Ime',
        'user_name' => 'Uporabniško ime',
        'password' => 'Geslo',
        'password_repeat' => 'Geslo (ponovno)',
        'password_leave_blank' => 'Če ne želite spremeniti pustite prazno',
        'level' => 'Nivo dostopa',
        'level_10' => 'Administrator',
        'level_20' => 'Uporabnik',
        'level_description' => '<b>Administratorji</b> imajo poln dostop: lahko upravljajo strežnike, uporabnike in
 urejajo globalne nastavitve.<br><b>Uporabniki</b> lahko samo vidijo status in
 poganjajo posodobitev statusa za strežnike, ki so jim bili dodeljeni.',
        'mobile' => 'Mobilni telefon',
        'email' => 'E-pošta',
        'pushover' => 'Pushover',
        'pushover_description' => 'Pushover je storitev, ki omogoča enostavno prejemanje obvestil v realnem času.
 Več informacij je na voljo <a href="https://pushover.net/" target="_blank">na
 njihovi spletni strani</a>.',
        'pushover_key' => 'Pushover ključ',
        'pushover_device' => 'Pushover naprava',
        'pushover_device_description' => 'Ime naprave na katero naj se pošlje obvestilo. Če želite obvestilo
 poslati na vse naprave, pustite prazno.',
        'delete_title' => 'Izbriši uporabnika',
        'delete_message' => 'Ste prepričani, da želite izbrisati uporabnika \'%1\'?',
        'deleted' => 'Uporabnik izbrisan.',
        'updated' => 'Podatki uporabnika posodobljeni.',
        'inserted' => 'Uporabnik dodan.',
        'profile' => 'Profil',
        'profile_updated' => 'Vaš profil je bil posodobljen.',
        'error_user_name_bad_length' => 'Uporabniško ime mora biti dolgo med 2 in 64 znakov.',
        'error_user_name_invalid' => 'Uporabniško ime lahko vsebuje samo črke (a-z, A-Z), številke (0-9), pike (.)
 in podčrtaje (_).',
        'error_user_name_exists' => 'Uporabniško ime v bazi podatkov že obstaja.',
        'error_user_email_bad_length' => 'E-naslov mora biti med 5 in 255 znaki.',
        'error_user_email_invalid' => 'E-naslov ni veljaven.',
        'error_user_level_invalid' => 'Izbrani nivo dostopa za uporabnika ni veljaven.',
        'error_user_no_match' => 'Uporabnika ne najdem v bazi podatkov.',
        'error_user_password_invalid' => 'Vneseno geslo ni veljavno.',
        'error_user_password_no_match' => 'Gesli se ne ujemata.',
    ),
    'log' => array(
        'title' => 'Dnevniški zapisi',
        'type' => 'Tip',
        'status' => 'Status',
        'email' => 'E-pošta',
        'sms' => 'SMS',
        'pushover' => 'Pushover',
        'no_logs' => 'ni dnevniških zapisov',
        'clear' => 'Počisti dnevnik',
        'delete_title' => 'Brisanje dnevnika',
        'delete_message' => 'Ali ste prepričani, da želite izbrisati <b>vse</b> dnevnike?',
    ),
    'servers' => array(
        'server' => 'Strežnik',
        'status' => 'Status',
        'label' => 'Ime',
        'domain' => 'Domena / IP naslov',
        'timeout' => 'Časovna omejitev',
        'timeout_description' => 'Koliko sekund naj čakam na odgovor strežnika.',
        'port' => 'Vrata',
        'type' => 'Tip',
        'type_website' => 'Spletna stran (website)',
        'type_service' => 'Storitev (service)',
        'pattern' => 'Iskani niz oz. vzorec',
        'pattern_description' => 'Če ta vzorec ne bo najden na spletni strani, bo strežnik označen kot nedelujoč.
 Dovoljeni so regularni izrazi.',
        'last_check' => 'Zadnje preverjanje',
        'last_online' => 'Nazadnje dostopen',
        'monitoring' => 'Spremljanje',
        'no_monitoring' => 'Se ne spremlja',
        'email' => 'E-pošta',
        'send_email' => 'Pošlji e-pošto',
        'sms' => 'SMS',
        'send_sms' => 'Pošlji SMS',
        'pushover' => 'Pushover',
        'users' => 'Uporabniki',
        'delete_title' => 'Izbriši strežnik',
        'delete_message' => 'Ste prepričani, da želite izbrisati strežnik \'%1\'?',
        'deleted' => 'Strežnik izbrisan.',
        'updated' => 'Podatki o strežniku posodobljeni.',
        'inserted' => 'Strežnik dodan.',
        'latency' => 'Zakasnitev',
        'latency_max' => 'Zakasnitev (največja)',
        'latency_min' => 'Zakasnitev (najmanjša)',
        'latency_avg' => 'Zakasnitev (povprečna)',
        'uptime' => 'Neprekinjeno delovanje',
        'year' => 'leto',
        'month' => 'mesec',
        'week' => 'teden',
        'day' => 'dan',
        'hour' => 'ura',
        'warning_threshold' => 'Prag za opozorilo',
        'warning_threshold_description' => 'Število neuspešnih preverjanj preden je strežnik označen kot
 nedelujoč.',
        'chart_last_week' => 'prejšnji teden',
        'chart_history' => 'Zgodovina',
        'chart_day_format' => '%m. %d. %Y',
        'chart_long_date_format' => '%m. %d. %Y %H:%M:%S',
        'chart_short_date_format' => '%m/%d %H:%M',
        'chart_short_time_format' => '%H:%M',
        'warning_notifications_disabled_sms' => 'SMS obvestila so onemogočena.',
        'warning_notifications_disabled_email' => 'Obvestila po e-pošti so onemogočena.',
        'warning_notifications_disabled_pushover' => 'Pushover obvestila so onemogočena.',
        'error_server_no_match' => 'Strežnik ni najden.',
        'error_server_label_bad_length' => 'Ime mora biti med 1 in 255 znaki.',
        'error_server_ip_bad_length' => 'Domena / IP naslov mora biti med 1 in 255 znaki.',
        'error_server_ip_bad_service' => 'IP naslov ni veljaven.',
        'error_server_ip_bad_website' => 'URL naslov spletne strani ni veljaven.',
        'error_server_type_invalid' => 'Izbrani tip strežnika ni veljaven.',
        'error_server_warning_threshold_invalid' => 'Prag za opozorilo mora biti število večje od 0.',
    ),
    'config' => array(
        'general' => 'Splošno',
        'language' => 'Jezik',
        'show_update' => 'Preverim za posodobitve?',
        'email_status' => 'Dovolim pošiljanje e-pošte',
        'email_from_email' => 'E-poštni naslov pošiljatelja',
        'email_from_name' => 'Ime pošiljatelja',
        'email_smtp' => 'Enable SMTP',
        'email_smtp_host' => 'SMTP strežnik',
        'email_smtp_port' => 'SMTP vrata',
        'email_smtp_security' => 'SMTP varnost',
        'email_smtp_security_none' => 'brez',
        'email_smtp_username' => 'SMTP uporabniško ime',
        'email_smtp_password' => 'SMTP geslo',
        'email_smtp_noauth' => 'Če ni potrebna overovitev, pustite prazno',
        'sms_status' => 'Dovolim pošiljanje SMS sporočil?',
        'sms_gateway' => 'Prehod za pošiljanje SMS sporočil',
        'sms_gateway_username' => 'Uporabniško ime SMS prehoda',
        'sms_gateway_password' => 'Geslo SMS prehoda',
        'sms_from' => 'Telefonska številka pošiljatelja',
        'pushover_status' => 'Dovolim pošiljanje Pushover sporočil',
        'pushover_description' => 'Pushover je storitev, ki omogoča enostavno prejemanje obvestil v realnem času.
 Več informacij je na voljo <a href="https://pushover.net/" target="_blank">na
 njihovi spletni strani</a>.',
        'pushover_clone_app' => 'Kliknite za ustvarjanje vaše Pushover aplikacije',
        'pushover_api_token' => 'Pushover API žeton',
        'pushover_api_token_description' => 'Pred uporabo storitve Pushover, morate na njihovi spletni strani <a
 href="%1$s" target="_blank" rel="noopener">registrirati aplikacijo</a>,
 tukaj pa vnesti API žeton.',
        'alert_type' => 'Izberite kdaj naj se vam pošljejo obvestila.',
        'alert_type_description' => '<b>Sprememba statusa:</b> Obvestilo boste dobili ob vsaki spremembi statusa,
 torej iz delujoč -> nedelujoč ter nedelujoč -> delujoč.<br><br
 /><b>Nedelujoč:</b> Obvestilo boste dobili samo, ko se bo strežnik PRVIKRAT
 prenehal odzivati. Na primer:nastavljeno imate preverjanje strežnikov vsakih 15
 minut. Strežnik preneha delovati ob 13h in ostane nedelujoč do 18h. Dobili
 boste obvestilo samo ob 13h.<br><br><b>Vedno:</b> Obvestilo boste dobili vedno,
 ko se izvede skripta za preverjanje in strežnik ne deluje, pa čeprav bo
 strežnik nedelujoč več ur.',
        'alert_type_status' => 'Sprememba statusa',
        'alert_type_offline' => 'Nedelujoč',
        'alert_type_always' => 'Vedno',
        'log_status' => 'Beleženje statusa',
        'log_status_description' => 'Če je beleženje statusa vključeno, se bodo beležili vsi dogodki povezani s
 pošiljanjem obvestil.',
        'log_email' => 'Beleži e-pošto, ki jo pošilja aplikacija',
        'log_sms' => 'Beleži SMS sporočila, ki jih pošilja aplikacija',
        'log_pushover' => 'Beleži Pushover sporočila, ki jih pošilja aplikacija',
        'updated' => 'Nastavitve so bile posodobljene.',
        'tab_email' => 'E-pošta',
        'tab_sms' => 'SMS',
        'tab_pushover' => 'Pushover',
        'settings_email' => 'Nastavitve e-pošte',
        'settings_sms' => 'Nastavitve SMS sporočil',
        'settings_pushover' => 'Nastavitve Pushover sporočil',
        'settings_notification' => 'Nastavitve obvestil',
        'settings_log' => 'Hramba dnevniških zapisov',
        'auto_refresh' => 'Samodejno posodabljanje',
        'auto_refresh_description' => 'Samodejno posodabljanje pregleda statusa strežnikov.<br><span
 class="small">Čas v sekundah. Če je vrednost 0 se stran ne bo samodejno
 posodabljala.</span>',
        'test' => 'Test',
        'test_email' => 'Na naslov, ki ste ga določili v vašem profilu, bo poslano e-sporočilo.',
        'test_sms' => 'Na telefonsko številko, ki ste jo določili v vašem profilu, bo poslan SMS.',
        'test_pushover' => 'Na uporabniški ključ/napravo, ki ste ju določili v vašem profilu, bo poslano Pushover
 sporočilo.',
        'send' => 'Pošlji',
        'test_subject' => 'Test',
        'test_message' => 'Testno sporočilo',
        'email_sent' => 'E-pošta poslana',
        'email_error' => 'Napaka pri pošiljanju e-pošte',
        'sms_sent' => 'SMS sporočilo poslano',
        'sms_error' => 'Napaka pri pošiljanju SMS sporočila. %s',
        'sms_error_nomobile' => 'Ni mogoče poslati testnega SMS sporočila: v vašem profilu ni vpisana veljavna
 telefonska številka.',
        'pushover_sent' => 'Pushover obvestilo poslano',
        'pushover_error' => 'Napaka pri pošiljanju Pushover sporočila: %s',
        'pushover_error_noapp' => 'Ni mogoče poslati testnega sporočila: med globalnimi nastavitvami ne najdem
 Pushover API žetona.',
        'pushover_error_nokey' => 'Ni mogoče poslati testnega sporočila: med vašimi nastavitvami ne najdem Pushover
 ključa.',
        'log_retention_period' => 'Čas hrambe podatov',
        'log_retention_period_description' => 'Število dni, ko naj se hranijo podatki o obvestilih in statusu
 strežnikov. Če želite podatke hraniti trajno, vnesite 0.',
        'log_retention_days' => 'dni',
    ),
    'notifications' => array(
        'off_sms' => 'Streznik \'%LABEL%\' NE deluje: IP=%IP%, vrata=%PORT%. Napaka=%ERROR%',
        'off_email_subject' => 'POMEMBNO: Strežnik \'%LABEL%\' NE deluje',
        'off_email_body' => 'Pri povezovanju na streznik je prislo do napake:<br><br>Streznik: %LABEL%<br>IP:
 %IP%<br>vrata: %PORT%<br>Napaka: %ERROR%<br>Datum: %DATE%',
        'off_pushover_title' => 'Streznik \'%LABEL%\' NE deluje',
        'off_pushover_message' => 'Ni se mogoče povezati na naslednji streznik:<br><br>Streznik: %LABEL%<br>IP:
 %IP%<br>Vrata: %PORT%<br>Error: %ERROR%<br>Datum: %DATE%',
        'on_sms' => 'Streznik \'%LABEL%\' deluje: IP=%IP%, vrata=%PORT%, it was down for %LAST_OFFLINE_DURATION%',
        'on_email_subject' => 'OBVESTILO: Streznik \'%LABEL%\' ponovno deluje',
        'on_email_body' => 'Streznik \'%LABEL%\' ponovno deluje, it was down for
 %LAST_OFFLINE_DURATION%:<br><br>Strežnik: %LABEL%<br>IP: %IP%<br>Vrata: %PORT%<br>Datum:
 %DATE%',
        'on_pushover_title' => 'Streznik \'%LABEL%\' deluje',
        'on_pushover_message' => 'Streznik \'%LABEL%\' ponovno deluje, it was down for
 %LAST_OFFLINE_DURATION%:<br><br>Server: %LABEL%<br>IP: %IP%<br>Vrata:
 %PORT%<br>Datum: %DATE%',
    ),
    'login' => array(
        'welcome_usermenu' => 'Pozdravljeni, %user_name%',
        'title_sign_in' => 'Prosimo, prijavite se',
        'title_forgot' => 'Ali ste pozabili geslo?',
        'title_reset' => 'Ponastavitev gesla',
        'submit' => 'Pošlji',
        'remember_me' => 'Zapomni si me',
        'login' => 'Prijava',
        'logout' => 'Odjava',
        'username' => 'Uporabniško ime',
        'password' => 'Geslo',
        'password_repeat' => 'Geslo (ponovno)',
        'password_forgot' => 'Pozabljeno geslo?',
        'password_reset' => 'Ponastavitev gesla',
        'password_reset_email_subject' => 'Ponastavite svoje geslo za PHP Server Monitor',
        'password_reset_email_body' => 'Za ponastavitev gesla uporabite spodnjo povezavo. Pomembno: povezava poteče v
 1 uri.<br><br>%link%',
        'error_user_incorrect' => 'Vpisanega uporabniškega imena ne najdem.',
        'error_login_incorrect' => 'Podatki so napačni.',
        'error_login_passwords_nomatch' => 'Vneseno geslo ni pravilno.',
        'error_reset_invalid_link' => 'Povezava za ponastavitev gesla, ki ste jo vnesli, ni pravilna.',
        'success_password_forgot' => 'Poslano vam je bilo sporočilo z navodili za ponastavitev vašega gesla.',
        'success_password_reset' => 'Vaše geslo je bilo uspešno ponastavljeno. Prijavite se prosim.',
    ),
    'error' => array(
        '401_unauthorized' => 'Nepooblaščen dostop',
        '401_unauthorized_description' => 'Nimate dovoljenja za ogled te strani.',
    ),
);
