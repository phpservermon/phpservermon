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
 * @author      Arkadiusz Klenczar <a.klenczar@gmail.com>
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: v3.5.2
 * @link        http://www.phpservermonitor.org/
 **/

$sm_lang = array(
    'name' => 'Polski - Polish',
    'locale' => array(
        '0' => 'pl_PL.UTF-8',
        '1' => 'pl_PL',
        '2' => 'polski',
        '3' => 'polski',
    ),
    'locale_tag' => 'pl',
    'locale_dir' => 'ltr',
    'system' => array(
        'title' => 'Server Monitor',
        'install' => 'Instalacja',
        'action' => 'Akcja',
        'save' => 'Zapisz',
        'edit' => 'Edycja',
        'delete' => 'Usuń',
        'view' => 'Zobacz',
        'date' => 'Data',
        'message' => 'Wiadomość',
        'yes' => 'Tak',
        'no' => 'Nie',
        'insert' => 'Wstaw',
        'add_new' => 'Dodaj',
        'update_available' => 'Nowa wersja ({version}) jest dostępna do pobrania z <a
 href="https://github.com/phpservermon/phpservermon/releases/latest" target="_blank"
 rel="noopener">http://www.phpservermonitor.org</a>.',
        'back_to_top' => 'Do góry',
        'go_back' => 'Wstecz',
        'ok' => 'pożądane',
        'bad' => 'niepożądane',
        'cancel' => 'Anuluj',
        'none' => 'Brak',
        'activate' => 'Aktywny',
        'short_day_format' => '%B %e',
        'long_day_format' => '%B %e, %Y',
        'yesterday_format' => 'Wczoraj o %k:%M',
        'other_day_format' => '%A o %k:%M',
        'never' => 'Nigdy',
        'hours_ago' => '%d godzin temu',
        'an_hour_ago' => 'godzinę temu',
        'minutes_ago' => '%d minut temu',
        'a_minute_ago' => 'minutę temu',
        'seconds_ago' => '%d sekund temu',
        'a_second_ago' => 'sekundę temu',
        'year' => 'rok',
        'years' => 'lata',
        'month' => 'miesiąc',
        'months' => 'miesiące',
        'day' => 'dzień',
        'days' => 'dni',
        'hour' => 'godzina',
        'hours' => 'godziny',
        'minute' => 'minuta',
        'minutes' => 'minut',
        'second' => 'sekunda',
        'seconds' => 'sekundy',
        'millisecond' => 'milisekunka',
        'milliseconds' => 'milisekundy',
        'current' => 'aktualnie',
        'settings' => 'Ustawienia',
        'search' => 'Szukaj',
    ),
    'menu' => array(
        'config' => 'Konfiguracja',
        'server' => 'Serwery',
        'server_log' => 'Logi',
        'server_status' => 'Status',
        'server_update' => 'Aktualizuj',
        'user' => 'Użytkownicy',
        'help' => 'Pomoc',
    ),
    'users' => array(
        'user' => 'Użytkownik',
        'name' => 'Nazwa',
        'user_name' => 'Login',
        'password' => 'Hasło',
        'password_repeat' => 'Powtórz hasło',
        'password_leave_blank' => 'Pozostaw puste aby zaniechać zmian',
        'level' => 'Poziom',
        'level_10' => 'Administrator',
        'level_20' => 'Użytkownik',
        'level_description' => '<b>Administratorzy</b> posiadają pełny dostęp: mogą zarządzać serwerami,
 użytkownikami oraz edytować konfigurację globalną.<br><b>Użytkownicy</b> mogą
 podejrzeć serwer oraz uruchomić aktualizację statusu dla serwerów do nich
 przypisanych.',
        'mobile' => 'Telefon',
        'email' => 'Email',
        'pushover' => 'Pushover',
        'pushover_description' => 'Pushover jest usługą szybkich notyfikacji. Sprawdź <a
 href="https://pushover.net/" target="_blank">ich stronę</a> po więcej informacji.',
        'pushover_key' => 'Pushover Key',
        'pushover_device' => 'Urządzenie dla Pushover',
        'pushover_device_description' => 'Nazwa urządzenia do którego wysłać powiadomienie. Pozostaw puste aby
 wysłać do wszystkich urządzeń.',
        'discord' => 'Discord',
        'discord_label' => 'Discord',
        'discord_description' => 'Podaj swoje <a href="https://discordjs.guide/popular-topics/webhooks.html"
 target="_blank">webhook</a> tutaj.',
        'telegram' => 'Telegram',
        'telegram_description' => '<a href="https://telegram.org/" target="_blank">Telegram</a> jest komunikatorem
 internetowym, który umożliwa notyfikacje w czasie rzeczywistym. Odwiedź stronę
 z <a href="http://docs.phpservermonitor.org/" target="_blank">documentacja</a> aby
 uzyskać więcej informacji.',
        'telegram_chat_id' => 'Telegram chat id',
        'telegram_chat_id_description' => 'Wiadomość zostanie wysłana do odpowiedniej rozmowy.',
        'telegram_get_chat_id' => 'Kliknij tutaj żeby otrzywać swój chat id',
        'activate_telegram' => 'Aktywuj notyfikacje Telegram',
        'activate_telegram_description' => 'Zezwól na wysyłanie notyfikacji Telegram do podanego chat id. Bez tej
 zgodny Telegram nie zezwoli na wysyłanie notyfikacji do Ciebie.',
        'telegram_bot_username_found' => 'Bot został odnaleziony!<br><a href="%s" target="_blank"
 rel="noopener"><button class="btn btn-primary">Następny krok</button></a>
 <br>Następnie otworzy się okno rozmowy z botem. Musisz nacisnąć start
 lub wpisać /start.',
        'telegram_bot_username_error_token' => '401 - Błąd autoryzacji. Proszę sprawdzić czy API token jest
 prawidłowy.',
        'telegram_bot_error' => 'Wystąpił błąd podczas aktywowania notyfikacji Telegram: %s',
        'jabber' => 'Jabber',
        'jabber_label' => 'Jabber',
        'jabber_description' => 'Twoje konto Jabber',
        'webhook' => 'Webhook',
        'webhook_description' => 'Wyślij json webhook do wybranego endpoint. <br/>Zapytanie json może być dowolnie
 dostosowane np.  {"text":"servermon: #message"}',
        'webhook_url' => 'Webhook URL',
        'webhook_url_description' => 'Publiczne webhook endpoint URL powinny się zaczynać od https://.',
        'webhook_json' => 'Webhook JSON',
        'webhook_json_description' => 'Zdefiniuj niestandardowy json, użyj #message jak zmienną z treścią
 wiadomości.',
        'delete_title' => 'Usuń użytkownika',
        'delete_message' => 'Czy jesteś pewny że chcesz usunąć użytkownika \'%1\'?',
        'deleted' => 'Użytkownik usunięty.',
        'updated' => 'Użytkownik zaktualizowany.',
        'inserted' => 'Użytkownik dodany.',
        'profile' => 'Profil',
        'profile_updated' => 'Twój profil został zaktualizowany.',
        'error_user_name_bad_length' => 'Login musi mieć od 2 do 64 znaków.',
        'error_user_name_invalid' => 'Login może zawierać tylko litery (a-z, A-Z), cyfry (0-9), kropki (.) oraz znak
 podkreślenia (_).',
        'error_user_name_exists' => 'Wybrana nazwa użytkownika jest już używana.',
        'error_user_email_bad_length' => 'Email powinien mieć od 5 do 255 znaków.',
        'error_user_email_invalid' => 'Wprowadzony adres email jest nieprawidłowy.',
        'error_user_level_invalid' => 'Wybrany poziom uprawnień użytkownika jest nieprawidłowy.',
        'error_user_no_match' => 'Użytkownik nie został odnaleziony.',
        'error_user_password_invalid' => 'Wprowadzone hasło jest nieprawidłowe.',
        'error_user_password_no_match' => 'Wprowadzone hasła są różne.',
        'error_user_admin_cant_be_deleted' => 'Nie można usunąć jedynego konta administratora.',
    ),
    'log' => array(
        'title' => 'Logi',
        'type' => 'Typ',
        'status' => 'Status',
        'email' => 'Email',
        'sms' => 'SMS',
        'discord' => 'Discord',
        'pushover' => 'Pushover',
        'webhook' => 'Webhook',
        'telegram' => 'Telegram',
        'jabber' => 'Jabber',
        'no_logs' => 'Brak logów',
        'clear' => 'Wyczyść log',
        'delete_title' => 'Wyczyść log',
        'delete_message' => 'Czy na pewno chcesz usunąć <b>wszystkie</b> dzienniki?',
    ),
    'servers' => array(
        'server' => 'Server',
        'status' => 'Status',
        'label' => 'Etykieta',
        'domain' => 'Domena/IP',
        'timeout' => 'Timeout',
        'timeout_description' => 'Liczba sekund do odczekania na odpowiedź serwera.',
        'authentication_settings' => 'Ustawienia uwierzytelniania',
        'optional' => 'Opcjonalne',
        'website_username' => 'Nazwa użytkownika',
        'website_username_description' => 'Nazwa użytkownika z dostępem do strony (tylko uwierzytelnianie Apache
 jest wspierana).',
        'website_password' => 'Hasło',
        'website_password_description' => 'Hasło dostęput do strony. Hasło zostanie zaszyfrowane i zapisane w
 badzie danych.',
        'fieldset_monitoring' => 'Monitoring',
        'fieldset_permissions' => 'Uprawnienia',
        'permissions' => 'Serwer będzie widoczny dla następujących użytkowników',
        'port' => 'Port',
        'custom_port' => 'Niestandardowy port',
        'popular_ports' => 'Popularne porty',
        'request_method' => 'Metoda HTTP',
        'custom_request_method' => 'Niestandardowe metoda HTTP',
        'popular_request_methods' => 'Popularne metody HTTP',
        'post_field' => 'Pole Post',
        'post_field_description' => 'Dane zostaną wysłane za pomocą wyżej wybranej metody.',
        'please_select' => 'Proszę wybrać',
        'type' => 'Typ',
        'type_website' => 'Strona',
        'type_service' => 'Usługa',
        'type_ping' => 'Ping',
        'pattern' => 'Wyszukiwane wyrażenie/wzorzec',
        'pattern_description' => 'Jeśli wzorzec nie zostanie odnaleziony, status zostanie zmieniony. Dozwolone są
 wyrażenia regularne.',
        'pattern_online' => 'Wykrycie wzorca oznacza, że strona jest',
        'pattern_online_description' => 'Online: jeżeli wzorzec zostanie wykryty na stronie to server zostanie
 oznaczony jako online. Offline: jeżeli wzorzec nie zostanie wykryty na
 stronie to serwer zostanie oznaczony jako offline.',
        'redirect_check' => 'Przekierowanie na inną domenę jest',
        'redirect_check_description' => 'Przekierowanie na inną domenę zazwyczaj jest niepożądanym zachowaniem.',
        'allow_http_status' => 'Dozwolone kody odpowiedzi HTTP',
        'allow_http_status_description' => 'Podaj listę dozwolonych kodów odpowiedzi HTTP, kolejne wartości
 oddzielone za pomocą |. Domyślnie odpowiedzi o wartości poniżej 400
 zostaną uznane jako prawidłowe.',
        'header_name' => 'Nazwa nagłówka',
        'header_value' => 'Wartość nagłówka',
        'header_name_description' => 'Wielkość liter ma znaczenie.',
        'header_value_description' => 'Dozwolone są wyrażenia regularne.',
        'last_check' => 'Ostatnie sprawdzenie',
        'last_online' => 'Ostatnio online',
        'last_offline' => 'Ostatnio offline',
        'last_output' => 'Ostatni prawidłowy wynik',
        'last_error' => 'Ostatni bląd',
        'last_error_output' => 'Ostatni wynik blądu',
        'output' => 'Wynik',
        'monitoring' => 'Monitorowany',
        'no_monitoring' => 'Brak monitoringu',
        'email' => 'Email',
        'send_email' => 'Wyślij Email',
        'sms' => 'SMS',
        'send_sms' => 'Wyślij SMS',
        'discord' => 'Discord',
        'send_discord' => 'Wyślij powiadomienie Discord',
        'webhook' => 'Webook',
        'send_webhook' => 'Wyślij powiadomienie Webhook',
        'pushover' => 'Pushover',
        'send_pushover' => 'Wyślij powiadomienie Pushover',
        'telegram' => 'Telegram',
        'send_telegram' => 'Wyślij powiadomienie Telegram',
        'jabber' => 'Jabber',
        'send_jabber' => 'Wyślij powiadomienie Jabber',
        'users' => 'Użytkownicy',
        'delete_title' => 'Usuń serwer',
        'delete_message' => 'Czy jesteś pewny że chcesz usunąć serwer \'%1\'?',
        'deleted' => 'Serwer usunięty.',
        'updated' => 'Serwer zaktualizowany.',
        'inserted' => 'Server dodany.',
        'latency' => 'Opóźnienie',
        'latency_max' => 'Opóźnienie (maksymalne)',
        'latency_min' => 'Opóźnienie (minimalne)',
        'latency_avg' => 'Opóźnienie (średnie)',
        'online' => 'online',
        'offline' => 'offline',
        'uptime' => 'Czas dostępności',
        'year' => 'Rok',
        'month' => 'Miesiąc',
        'week' => 'Tydzień',
        'day' => 'Dzień',
        'hour' => 'Godzina',
        'warning_threshold' => 'Próg ostrzeżeń',
        'warning_threshold_description' => 'Ilość wymaganych niepowodzeń przed oznaczeniem serwera jako offline.',
        'ssl_cert_expiry_days' => 'Ważność certyfikatu SSL',
        'ssl_cert_expiry_days_description' => 'Minimalna ilość dni, których certyfikat SSL musi być ważny.
 Ustawienie wartości 0 spowoduje, że ważność certyfikatu nie
 będzie sprawdzana.',
        'ssl_cert_expired' => 'Certyfikat SSL wygasł',
        'ssl_cert_expiring' => 'Certyfikat SSL wygaśnie:',
        'chart_last_week' => 'Ostatni tydzień',
        'chart_history' => 'Historia',
        'chart_day_format' => '%Y-%m-%d',
        'chart_long_date_format' => '%Y-%m-%d %H:%M:%S',
        'chart_short_date_format' => '%m/%d %H:%M',
        'chart_short_time_format' => '%H:%M',
        'warning_notifications_disabled_sms' => 'Powiadomienia SMS są wyłączone.',
        'warning_notifications_disabled_email' => 'Powiadomienia Email są wyłączone.',
        'warning_notifications_disabled_discord' => 'Powiadomienia Discord są wyłączone.',
        'warning_notifications_disabled_webhook' => 'Powiadomienia Webhook są wyłączone.',
        'warning_notifications_disabled_pushover' => 'Powiadomienia Pushover są wyłączone.',
        'warning_notifications_disabled_telegram' => 'Powiadomienia Telegram są wyłączone.',
        'warning_notifications_disabled_jabber' => 'Powiadomienia Jabber są wyłączone.',
        'error_server_no_match' => 'Nie odnaleziono serwera.',
        'error_server_label_bad_length' => 'Etykieta musi mieć pomiędzy 1 a 255 znaków.',
        'error_server_ip_bad_length' => 'Domena/IP musi mieć pomiędzy 1 a 255 znaków.',
        'error_server_ip_bad_service' => 'Adres IP jest nieprawidłowy.',
        'error_server_ip_bad_website' => 'Adres URL jest nieprawidłowy.',
        'error_server_type_invalid' => 'Wybrany typ serwera jest nieprawidłowy.',
        'error_server_warning_threshold_invalid' => 'Próg ostrzeżeń musi być liczbą całkowitą większą od 0.',
        'error_server_ssl_cert_expiry_days' => 'Minimalna ilość dla ważności certyfikatu SSL musi być liczbą
 całkowitą większą lub równą 0.',
    ),
    'config' => array(
        'general' => 'Ogólne',
        'site_title' => 'Tytuł strony',
        'language' => 'Język',
        'show_update' => 'Sprawdzić aktualizacje?',
        'password_encrypt_key' => 'Klucz szyfrowania haseł',
        'password_encrypt_key_note' => 'Klucz będzie użyty do szyfrowania haseł, które są zapisane w ustawieniach
 serwerów żeby mieć dostęp do stron. Jeżeli klucz zostanie zmienione to
 zapisane hasła będą nieprawidłowe!',
        'proxy' => 'Włącz proxy',
        'proxy_url' => 'Proxy ULR',
        'proxy_user' => 'Użytkownik proxy',
        'proxy_password' => 'Hasło proxy',
        'email_status' => 'Pozwól na wysyłkę email',
        'email_from_email' => 'Email z adresu',
        'email_from_name' => 'Email od(nazwa)',
        'email_smtp' => 'Włącz SMTP',
        'email_smtp_host' => 'SMTP host',
        'email_smtp_port' => 'SMTP port',
        'email_smtp_security' => 'SMTP security',
        'email_smtp_security_none' => 'None',
        'email_smtp_username' => 'SMTP login',
        'email_smtp_password' => 'SMTP hasło',
        'email_smtp_noauth' => 'Pozostaw puste dla braku uwierzytelniania',
        'sms_status' => 'Pozwól na wysyłkę SMS',
        'sms_gateway' => 'Bramka SMS',
        'sms_gateway_username' => 'Login do bramki',
        'sms_gateway_password' => 'Hasło do bramki',
        'sms_from' => 'Numer nadawcy',
        'discord_status' => 'Zezwól na wysyłanie powiadomień Discord',
        'discord_description' => 'Discord jest serwisem, który umożliwia wysyłania powiadomień w czasie
 rzeczywistym. Odwiedź <a href="https://discord.com/" target="_blank">stronę
 serwisu</a> żeby otrzymać więcej informacji.',
        'webhook_status' => 'Zezwól na wysyłanie powiadomień webhooks.',
        'webhook_description' => 'Zezwól na wysyłanie powiadomień webhooks do serwisów takich jak Slack. Endpoint
 dla payload wiadomości jest zdefiniowany w ustawieniach profilu użytkownika.',
        'webhook_url' => 'Webhook URL',
        'webhook_url_description' => 'URL dla webhook endpoint',
        'webhook_json' => 'Webhook Json',
        'webhook_json_description' => 'Niestandardowsy Json, użyj #message jak zmienną z treścią wiadomości.',
        'pushover_status' => 'Zezwól na wysyłanie powiadomień Pushover',
        'pushover_description' => 'Pushover jest usługą ułatwiającą otrzymywanie powiadomień w czasie
 rzeczywistym. Sprawdź <a href="https://pushover.net/" target="_blank">ich
 stronę</a> aby uzyskać więcej informacji.',
        'pushover_clone_app' => 'Kliknij tutaj aby stworzyć aplikację korzystającą z Pushover',
        'pushover_api_token' => 'Pushover App API Token',
        'pushover_api_token_description' => 'Zanim zaczniesz używać Pushover, musisz <a href="%1$s" target="_blank"
 rel="noopener"> zarejestrować aplikację</a> na ich stronie internetowej
 i wpisać tutaj App API Token.',
        'telegram_status' => 'Zezwól na wysyłanie powiadomień Telegram',
        'telegram_description' => '<a href="https://telegram.org/" target="_blank">Telegram</a> jest komunikatorem
 internetowym, który umożliwa notyfikacje w czasie rzeczywistym. Odwiedź stronę
 z <a href="http://docs.phpservermonitor.org/" target="_blank">documentacja</a> aby
 uzyskać więcej informacji.',
        'telegram_api_token' => 'Telegram API Token',
        'telegram_api_token_description' => 'Zanim zaczniesz używać Telegram, potrzebujesz uzyskać API Token.
 Odwiedź strone z <a href="http://docs.phpservermonitor.org/"
 target="_blank">dokumentacją</a> żeby uzyskać pomocy.',
        'jabber_status' => 'Zezwól na wysyłanie powiadomień Jabber (XMPP)',
        'jabber_description' => 'Odwiedź stronę <a href="http://docs.phpservermonitor.org/">dokumentacją</a> aby
 uzyskać więcej informaji oraz przewodnik po instalacji.',
        'jabber_host' => 'Host',
        'jabber_host_description' => 'Adres host dostawcy Twojego konta Jabber. Dla konta Google użyj
 talk.google.com.',
        'jabber_port' => 'Port',
        'jabber_port_description' => 'Port Twojego dostawcy Jabber. Domyślnie 5222. Dla konta Google użyj 5223.',
        'jabber_username' => 'Nazwa użytkownika',
        'jabber_username_description' => 'Dla konta Google użyj razem z domeną np. example@google.com.',
        'jabber_domain' => 'Domena',
        'jabber_domain_description' => 'Domena Twojego dostawy Jabber. Zostaw puste dla konta Google.',
        'jabber_password' => 'Hasło',
        'jabber_password_description' => 'Wypełnij tylko żeby ustawić lub zmienić.',
        'jabber_check' => 'Sprawdź swoje konto Jabber czy powiadomienie zostało odebrane.',
        'alert_type' => 'Wybierz kiedy chcesz być powiadomiony.',
        'alert_type_description' => '<b>Zmiana statusu:</b> Otrzymasz powiadomienie gdy serwer zmieni status. Z online
 -> offline lub offline -> online.<br><br /><b>Offline:</b> Otrzymasz
 powiadomienie gdy serwer zmieni status na offline po raz pierwszy. Na przykład,
 Twój cronjob uruchamia się co 15 minut, a Twój serwer przestaje odpowiadać o
 13 i nie działa do 18. Otrzymasz *TYLKO* jedno powiadomienie o
 13.<br><br><b>Zawsze:</b> Otrzymasz powiadomienie za każdym razem gdy skrypt
 zostanie uruchomiony a strona będzie niedostępna.',
        'alert_type_status' => 'Zmiana statusu',
        'alert_type_offline' => 'Offline',
        'alert_type_always' => 'Zawsze',
        'combine_notifications' => 'Scalanie powiadomień',
        'combine_notifications_description' => 'Ogranicza ilość wysyłanych powiadomień poprzez scalanie wszystkich
 powiadomień w jedną wiadomość (nie dotyczy powiadomień SMS).',
        'alert_proxy' => 'Jeżeli włączone to proxy nigdy nie bedzie użyte dla serwisów',
        'alert_proxy_url' => 'Fomat: host:port',
        'log_status' => 'Status logowania',
        'log_status_description' => 'Jeśli status logowania ustawiony jest na TRUE, monitor będzie logował
 wydarzenia.',
        'log_email' => 'Emaile wysłane przez skrypt',
        'log_sms' => 'SMS wysłane przez skrypt',
        'log_discord' => 'Notyfikacje Discord wysłane przez skrypt',
        'log_pushover' => 'Notyfikacje Pushover wysłane przez skrypt',
        'log_webhook' => 'Notyfikacje Webhook wysłane przez skrypt',
        'log_telegram' => 'Notyfikacje Telegram wysłane przez skrypt',
        'log_jabber' => 'Notyfikacje Jabber wysłane przez skrypt',
        'updated' => 'Konfiguracja została zaktualizowana.',
        'tab_email' => 'Email',
        'tab_sms' => 'SMS',
        'tab_discord' => 'Discord',
        'tab_pushover' => 'Pushover',
        'tab_webhook' => 'Webhook',
        'tab_telegram' => 'Telegram',
        'tab_jabber' => 'Jabber',
        'settings_email' => 'Ustawienia Email',
        'settings_sms' => 'Ustawienia SMS',
        'settings_discord' => 'Ustawienie Discord',
        'settings_pushover' => 'Ustawienia Pushover',
        'settings_webhook' => 'Ustawienia Webhook',
        'settings_telegram' => 'Ustawienia Telegram',
        'settings_jabber' => 'Ustawienia Jabber',
        'settings_notification' => 'Ustawienia powiadomień',
        'settings_log' => 'Ustawienia Logowania',
        'settings_proxy' => 'Ustawienia serwera Proxy',
        'auto_refresh' => 'Auto-odświeżanie',
        'auto_refresh_description' => 'Auto-odświeżanie strony serwera.<br><span class="small">Czas w sekundach, dla
 czasu 0 strona nie będzie odświeżana.</span>',
        'test' => 'Test',
        'test_email' => 'Email zostanie wysłany na adres podany w Twoim profilu.',
        'test_sms' => 'SMS zostanie wysłany na numer podany w Twoim profilu.',
        'test_discord' => 'Powiadomienie Discord zostanie wysłane do webhook, który został podany w Twoim profilu
 użytkownika.',
        'test_pushover' => 'Powiadomienie Pushover zostanie wysłane na klucz użytkownika/urządzenie podane w Twoim
 profilu użytkownika.',
        'test_webhook' => 'Powiadomienia Webhook zostanie wysłane do endpoint o podanym URL.',
        'test_telegram' => 'Powiadomienie Telegram zostanie wysłane na chat id podane w Twoim profilu użytkownika.',
        'test_jabber' => 'Powiadomienie Telegram zostanie wysłane na konto Jabber podane w Twoim profilu
 użytkownika.',
        'send' => 'Wyślij',
        'test_subject' => 'Test',
        'test_message' => 'Testowa wiadomość',
        'email_sent' => 'Email wysłany',
        'email_error' => 'Błąd podczas wysyłania emaila',
        'sms_sent' => 'Sms wysłany',
        'sms_error' => 'Błąd podczas wysyłania sms. %s',
        'sms_error_nomobile' => 'Nie udało się wysłać testowego SMS: brak poprawnego telefonu w Twoim profilu.',
        'discord_sent' => 'Powiadomienie Discord wysłane',
        'discord_error' => 'Błąd podczas wysyłania powiadomienia Pushover: %s',
        'discord_error_nowebhook' => 'Błąd podczas wysyłania powiadomienia Discord: brak prawidłowego Discord
 webhook w profilu użytkownika.',
        'webhook_sent' => 'Powiadomienie Webhook wysłane',
        'webhook_error' => 'Błąd podczas wysyłania powiadomienia Webhook: %s',
        'webhook_error_nourl' => 'Błąd podczas wysyłania testowego powiadomienia: brak Webhook URL w profilu
 użytkownika.',
        'webhook_error_nojson' => 'Błąd podczas wysyłania testowego powiadomienia: brak json w profilu
 użytkownika.',
        'pushover_sent' => 'Powiadomienie Pushover wysłane.',
        'pushover_error' => 'Błąd podczas wysyłania powiadomienia Pushover: %s',
        'pushover_error_noapp' => 'Błąd podczas wysyłania testowego powiadomienia: brak Pushover App API token w
 konfiguracji globalnej.',
        'pushover_error_nokey' => 'Błąd podczas wysyłania testowego powiadomienia: brak Pushover key na Twoim
 profilu.',
        'telegram_sent' => 'Powiadomienie Telegram zostało wysłane',
        'telegram_error' => 'Wystąpił błąd podczas wysyłania powiadomienia Telegram: %s',
        'telegram_error_notoken' => 'Nie można wysłać testowego powiadomienia: brak Telegram API token w głównych
 ustawieniach systemu.',
        'telegram_error_noid' => 'Nie można wysłać testowego powiadomienia: brak chat id w ustawieniach profilu
 Twojego użytkownika.',
        'jabber_sent' => 'Powiadomienie Jabber zostało wysłane',
        'jabber_error' => 'Wystąpił błąd podczas wysyłania powiadomienia Jabber: %s',
        'jabber_error_noconfig' => 'Nie można wysłać testowego powiadomienia: brak konfiguracji konta Jabber w
 głównych ustawieniach systemu.',
        'jabber_error_noaccount' => 'Nie można wysłać testowego powiadomienia: brak konfiguracji konta Jabber w
 ustawieniach profilu Twojego użytkownika.',
        'log_retention_period' => 'Czas rotacji logów',
        'log_retention_period_description' => 'Liczba dni przez którą należy przetrzymywać logi powiadomień i
 archiwizować uptime serwera. Wpisz 0 aby wyłączyć czyszczenie
 logów.',
        'log_retention_days' => 'dni',
        'user_agent' => 'User Agent',
        'user_agent_key_note' => 'Niestandardowy user agent używany przez monitor do komunikacji z zewnętrznymi
 serwisami.',
    ),
    'notifications' => array(
        'off_sms' => 'Serwer \'%LABEL%\' przestał odpowiadać: ip=%IP%, port=%PORT%. Błąd=%ERROR%',
        'off_email_subject' => 'Uwaga: Serwer \'%LABEL%\' nie odpowiada',
        'off_email_body' => 'Błąd połączenia do serwera:<br><br>Serwer: %LABEL%<br>IP: %IP%<br>Port:
 %PORT%<br>Błąd: %ERROR%<br>Data: %DATE%',
        'off_discord_message' => 'Błąd połączenia do serwera:<br><br>Serwer: %LABEL%<br>IP: %IP%<br>Port:
 %PORT%<br>Błąd: %ERROR%<br>Data: %DATE%',
        'off_webhook_title' => 'Serwer \'%LABEL%\' nie odpowiada',
        'off_webhook_message' => 'Błąd połączenia do serwera:<br><br>Serwer: %LABEL%<br>IP: %IP%<br>Port:
 %PORT%<br>Błąd: %ERROR%<br>Data: %DATE%',
        'off_pushover_title' => 'Serwer \'%LABEL%\' nie odpowiada',
        'off_pushover_message' => 'Błąd połączenia do serwera:<br><br>Serwer: %LABEL%<br>IP: %IP%<br>Port:
 %PORT%<br>Błąd: %ERROR%<br>Data: %DATE%',
        'off_telegram_message' => 'Błąd połączenia do serwera:<br><br>Serwer: %LABEL%<br>IP: %IP%<br>Port:
 %PORT%<br>Błąd: %ERROR%<br>Data: %DATE%',
        'off_jabber_message' => 'Błąd połączenia do serwera:<br><br>Serwer: %LABEL%<br>IP: %IP%<br>Port:
 %PORT%<br>Błąd: %ERROR%<br>Data: %DATE%',
        'on_sms' => 'Serwer \'%LABEL%\' działa poprawnie: ip=%IP%, port=%PORT%, it was down for
 %LAST_OFFLINE_DURATION%',
        'on_email_subject' => 'Uwaga: Serwer \'%LABEL%\' działa poprawnie',
        'on_email_body' => 'Serwer \'%LABEL%\' znów odpowiada, był offline przez
 %LAST_OFFLINE_DURATION%:<br><br>Serwer: %LABEL%<br>IP: %IP%<br>Port: %PORT%<br>Data:
 %DATE%',
        'on_discord_message' => 'Serwer \'%LABEL%\' znów odpowiada, był offline przez
 %LAST_OFFLINE_DURATION%:<br><br>Serwer: %LABEL%<br>IP: %IP%<br>Port: %PORT%<br>Data:
 %DATE%',
        'on_webhook_title' => 'Serwer \'%LABEL%\' działa poprawnie',
        'on_webhook_message' => 'Serwer \'%LABEL%\' znów odpowiada, był offline przez
 %LAST_OFFLINE_DURATION%:<br><br>Serwer: %LABEL%<br>IP: %IP%<br>Port: %PORT%<br>Data:
 %DATE%',
        'on_pushover_title' => 'Serwer \'%LABEL%\' działa poprawnie',
        'on_pushover_message' => 'Serwer \'%LABEL%\' znów działa poprawnie, był offline przez
 %LAST_OFFLINE_DURATION%:<br><br>Serwer: %LABEL%<br>IP: %IP%<br>Port: %PORT%<br>Data:
 %DATE%',
        'on_telegram_message' => 'Serwer \'%LABEL%\' znów działa poprawnie, był offline przez
 %LAST_OFFLINE_DURATION%:<br><br>Serwer: %LABEL%<br>IP: %IP%<br>Port: %PORT%<br>Data:
 %DATE%',
        'on_jabber_message' => 'Serwer \'%LABEL%\' znów działa poprawnie, był offline przez
 %LAST_OFFLINE_DURATION%:<br><br>Serwer: %LABEL%<br>IP: %IP%<br>Port: %PORT%<br>Data:
 %DATE%',
        'combi_off_email_message' => '<ul><li>Server: %LABEL%</li><li>IP: %IP%</li><li>Port: %PORT%</li><li>Error:
 %ERROR%</li><li>Date: %DATE%</li></ul>',
        'combi_off_discord_message' => '- Server: %LABEL%<br>- IP: %IP%<br>- Port: %PORT%<br>- Error: %ERROR%<br>-
 Date: %DATE%<br><br>',
        'combi_off_webhook_message' => '<ul><li>Server: %LABEL%</li><li>IP: %IP%</li><li>Port: %PORT%</li><li>Error:
 %ERROR%</li><li>Date: %DATE%</li></ul>',
        'combi_off_pushover_message' => '<ul><li>Server: %LABEL%</li><li>IP: %IP%</li><li>Port: %PORT%</li><li>Error:
 %ERROR%</li><li>Date: %DATE%</li></ul>',
        'combi_off_telegram_message' => '- Server: %LABEL%<br>- IP: %IP%<br>- Port: %PORT%<br>- Error: %ERROR%<br>-
 Date: %DATE%<br><br>',
        'combi_off_jabber_message' => '- Server: %LABEL%<br>- IP: %IP%<br>- Port: %PORT%<br>- Error: %ERROR%<br>-
 Date: %DATE%<br><br>',
        'combi_on_email_message' => '<ul><li>Server: %LABEL%</li><li>IP: %IP%</li><li>Port: %PORT%</li><li>Downtime:
 %LAST_OFFLINE_DURATION%</li><li>Date: %DATE%</li></ul>',
        'combi_on_webhook_message' => '<ul><li>Server: %LABEL%</li><li>IP: %IP%</li><li>Port: %PORT%</li><li>Downtime:
 %LAST_OFFLINE_DURATION%</li><li>Date: %DATE%</li></ul>',
        'combi_on_discord_message' => '- Server: %LABEL%<br>- IP: %IP%<br>- Port: %PORT%<br>- Downtime:
 %LAST_OFFLINE_DURATION%<br>- Date: %DATE%<br><br>',
        'combi_on_pushover_message' => '<ul><li>Server: %LABEL%</li><li>IP: %IP%</li><li>Port:
 %PORT%</li><li>Downtime: %LAST_OFFLINE_DURATION%</li><li>Date:
 %DATE%</li></ul>',
        'combi_on_telegram_message' => '- Server: %LABEL%<br>- IP: %IP%<br>- Port: %PORT%<br>- Downtime:
 %LAST_OFFLINE_DURATION%<br>- Date: %DATE%<br><br>',
        'combi_on_jabber_message' => '- Server: %LABEL%<br>- IP: %IP%<br>- Port: %PORT%<br>- Downtime:
 %LAST_OFFLINE_DURATION%<br>- Date: %DATE%<br><br>',
        'combi_email_subject' => 'WAŻNE: \'%UP%\' serverów znowu ONLINE, \'%DOWN%\' serverów jest OFFLINE',
        'combi_webhook_subject' => '\'%UP%\' serverów jest znowu ONLINE UP, \'%DOWN%\' serverów jest OFFLINE',
        'combi_pushover_subject' => '\'%UP%\' serverów jest znowu ONLINE UP, \'%DOWN%\' serverów jest OFFLINE',
        'combi_email_message' => '<b>Następujące serwery są offline:</b><br>%DOWN_SERVERS%<br><b>Następujące
 serwery są znowu online:</b><br>%UP_SERVERS%',
        'combi_discord_message' => '<b>Następujące serwery są offline:</b><br>%DOWN_SERVERS%<br><b>Następujące
 serwery są znowu online:</b><br>%UP_SERVERS%',
        'combi_webhook_message' => '<b>Następujące serwery są offline:</b><br>%DOWN_SERVERS%<br><b>Następujące
 serwery są znowu online:</b><br>%UP_SERVERS%',
        'combi_pushover_message' => '<b>Następujące serwery są offline:</b><br>%DOWN_SERVERS%<br><b>Następujące
 serwery są znowu online:</b><br>%UP_SERVERS%',
        'combi_telegram_message' => '<b>Następujące serwery są offline:</b><br>%DOWN_SERVERS%<br><b>Następujące
 serwery są znowu online:</b><br>%UP_SERVERS%',
        'combi_jabber_message' => '<b>Następujące serwery są offline:</b><br>%DOWN_SERVERS%<br><b>Następujące
 serwery są znowu online:</b><br>%UP_SERVERS%',
    ),
    'login' => array(
        'welcome_usermenu' => 'Witaj, %user_name%',
        'title_sign_in' => 'Zaloguj się',
        'title_forgot' => 'Zapomniałeś hasła?',
        'title_reset' => 'Zresetuj hasło',
        'submit' => 'Zapisz',
        'remember_me' => 'Zapamiętaj mnie',
        'login' => 'Zaloguj',
        'logout' => 'Wyloguj',
        'username' => 'Login',
        'password' => 'Hasło',
        'password_repeat' => 'Powtórz hasło',
        'password_forgot' => 'Zapomniałeś hasła?',
        'password_reset' => 'Zresetuj hasło',
        'password_reset_email_subject' => 'Zresetuj hasło do monitoringu',
        'password_reset_email_body' => 'Aby zresetować hasło użyj tego linku. Ważność linku to jedna
 godzina.<br><br>%link%',
        'error_user_incorrect' => 'Brak użytkownika o takim loginie.',
        'error_login_incorrect' => 'Login lub hasło jest błędne.',
        'error_login_passwords_nomatch' => 'Podane hasła nie pasują do siebie.',
        'error_reset_invalid_link' => 'Podany link do zmiany hasła jest nieprawidłowy.',
        'success_password_forgot' => 'Email został wysłany do Ciebie z informacjami dotyczącymi zresetowania
 hasła.',
        'success_password_reset' => 'Twoje hasło zostało pomyślnie zmienione. Zaloguj się.',
    ),
    'error' => array(
        '401_unauthorized' => 'Brak autoryzacji',
        '401_unauthorized_description' => 'Nie masz odpowiednich praw dostępu by przeglądać tę stronę.',
    ),
);
