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
 * @author      Plamen Vasilev a.k.a Paco <p.vasileff@gmail.com>
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

$sm_lang = array(
    'name' => 'Български - Bulgarian',
    'locale' => array(
        '0' => 'bg_BG.UTF-8',
        '1' => 'bg_BG',
        '2' => 'bulgarian',
    ),
    'locale_tag' => 'bg',
    'locale_dir' => 'ltr',
    'system' => array(
        'title' => 'Мониторинг',
        'install' => 'Инсталация',
        'action' => 'Действие',
        'save' => 'Запиши',
        'edit' => 'Редактирай',
        'delete' => 'Изтрий',
        'date' => 'Дата',
        'message' => 'Съобщение',
        'yes' => 'Да',
        'no' => 'Не',
        'insert' => 'Добавяне',
        'add_new' => 'Добави нов',
        'update_available' => 'Налична е нова версия: ({version}). Може да я свалите
 от <a href="https://github.com/phpservermon/phpservermon/releases/latest"
 target="_blank" rel="noopener">тук</a>.',
        'back_to_top' => 'Нагоре',
        'go_back' => 'Назад',
        'ok' => 'Ок',
        'cancel' => 'Отказ',
        'short_day_format' => '%B %e',
        'long_day_format' => '%B %e, %Y',
        'yesterday_format' => 'Вчера в %k:%M',
        'other_day_format' => '%A в %k:%M',
        'never' => 'Никога',
        'hours_ago' => 'преди %d часа',
        'an_hour_ago' => 'преди час',
        'minutes_ago' => 'преди %d минути',
        'a_minute_ago' => 'преди минута',
        'seconds_ago' => 'преди %d секунди',
        'a_second_ago' => 'преди секунда',
        'seconds' => 'секунди',
    ),
    'menu' => array(
        'config' => 'Настройки',
        'server' => 'Сървъри',
        'server_log' => 'Логове',
        'server_status' => 'Статус',
        'server_update' => 'Обнови данните',
        'user' => 'Потребители',
        'help' => 'Помощ',
    ),
    'users' => array(
        'user' => 'Потребител',
        'name' => 'Име',
        'user_name' => 'Потребител',
        'password' => 'Парола',
        'password_repeat' => 'Повторете паролата',
        'password_leave_blank' => 'Оставете празно, за да не бъде променена
 паролата',
        'level' => 'Ниво на достъп',
        'level_10' => 'Администратор',
        'level_20' => 'Потребител',
        'level_description' => '<b>Администраторите</b> имат пълен достъп: могат
 да управляват сървърите, потребителите и да
 редактират глобалните
 настройки.<br><b>Потребителите</b> могат само да
 виждат статуса на сървърите и да обнояват
 информацията за даден сървър, за който им е
 разрешен достъп.',
        'mobile' => 'Мобилен телефон',
        'email' => 'Имейл',
        'pushover' => 'Pushover',
        'pushover_description' => 'Pushover е услуга, която улеснява получаването на
 известия в реално време. Посетете <a
 href="https://pushover.net/" target="_blank">техния сайт</a> за
 повече информация.',
        'pushover_key' => 'Pushover Ключ',
        'pushover_device' => 'Pushover Устройство',
        'pushover_device_description' => 'Име на устройство, което да получава
 съобщение. Оставете празно, за изпращане
 до всички устройства.',
        'delete_title' => 'Изтриване на потребител',
        'delete_message' => 'Сигурни ли сте, че искате да изтриете потребител
 \'%1\'?',
        'deleted' => 'Потребителят е изтрит успешно.',
        'updated' => 'Информацията за потребителя е обновена.',
        'inserted' => 'Потребителят е добавен.',
        'profile' => 'Профил',
        'profile_updated' => 'Профилът е обновен успешно',
        'error_user_name_bad_length' => 'Потребителското име трябва да съдържа
 между 2 и 64 символа',
        'error_user_name_invalid' => 'Може да съдържа само латински букви (a-z, A-Z),
 цифри (0-9), точка (.) и долна черта (_).',
        'error_user_name_exists' => 'Вече съществува акаунт с това потребителско
 име.',
        'error_user_email_bad_length' => 'Имейл адреса трябва да съдържа между 5 и 255
 символа.',
        'error_user_email_invalid' => 'Въведения имейл адрес е грешен.',
        'error_user_level_invalid' => 'Избраното ниво на достъп е грешно.',
        'error_user_no_match' => 'Потребителят не може да бъде намерен.',
        'error_user_password_invalid' => 'Въведената парола е грешка.',
        'error_user_password_no_match' => 'Въведените пароли не съвпадат.',
    ),
    'log' => array(
        'title' => 'Записи в лога',
        'type' => 'Тип',
        'status' => 'Статус',
        'email' => 'Имейл',
        'sms' => 'SMS',
        'pushover' => 'Pushover',
        'no_logs' => 'Няма налични логове',
        'clear' => 'Изчистване на дневника',
        'delete_title' => 'Изтриване на дневника',
        'delete_message' => 'Наистина ли искате да изтриете <b>всички</b>
 дневници?',
    ),
    'servers' => array(
        'server' => 'Сървър',
        'status' => 'Статус',
        'label' => 'Име',
        'domain' => 'Хост',
        'timeout' => 'Изчакване',
        'timeout_description' => 'Брой секунди, който да изчака отговор от
 сървъра',
        'port' => 'Порт',
        'type' => 'Тип',
        'type_website' => 'Сайт',
        'type_service' => 'Услуга',
        'pattern' => 'Търсене на стринг/образец',
        'pattern_description' => 'Ако този текст не е намерен в интернет
 страницата (когато имате добавен сайт), той ще
 бъде маркиран като Офлайн. Регулярните изрази
 са разрешени.',
        'last_check' => 'Последна проверка',
        'last_online' => 'Последно на линия',
        'last_offline' => 'Last offline',
        'monitoring' => 'Мониторинг',
        'no_monitoring' => 'Не се наблюдава',
        'email' => 'Имейл',
        'send_email' => 'Имейл',
        'sms' => 'SMS',
        'send_sms' => 'SMS',
        'pushover' => 'Pushover',
        'users' => 'Потребители',
        'delete_title' => 'Изтриване на сървър',
        'delete_message' => 'Сигурни ли сте, че искате да изтриете сървър \'%1\'?',
        'deleted' => 'Сървъра е изтрит успешно.',
        'updated' => 'Информацията за сървъра е обновена.',
        'inserted' => 'Сървърът е добавен успешно.',
        'latency' => 'Латенция',
        'latency_max' => 'Латенция (максимална)',
        'latency_min' => 'Латенция (минимална)',
        'latency_avg' => 'Латенция (средна)',
        'uptime' => 'Ъптайм',
        'year' => 'Година',
        'month' => 'Месец',
        'week' => 'Седмица',
        'day' => 'Ден',
        'hour' => 'Час',
        'warning_threshold' => 'Предупредителен праг',
        'warning_threshold_description' => 'Брой неуспешни проверки, преди сървъра
 или сайта да бъдат маркирани като
 Офлайн.',
        'chart_last_week' => 'Последната седмица',
        'chart_history' => 'История',
        'chart_day_format' => '%d.%m.%Y',
        'chart_long_date_format' => '%d.%m.%Y %H:%M:%S',
        'chart_short_date_format' => '%d.%m %H:%M',
        'chart_short_time_format' => '%H:%M',
        'warning_notifications_disabled_sms' => 'SMS известията са изключени.',
        'warning_notifications_disabled_email' => 'Имейл известията са изключени.',
        'warning_notifications_disabled_pushover' => 'Pushover известията са изключени.',
        'error_server_no_match' => 'Сървърът не е намерен.',
        'error_server_label_bad_length' => 'Името трябва да е между 1 и 255 символа.',
        'error_server_ip_bad_length' => 'Хоста/IP адреса трябва да е между 1 и 255
 символа.',
        'error_server_ip_bad_service' => 'IP адреса е невалиден.',
        'error_server_ip_bad_website' => 'Сайта е невалиден.',
        'error_server_type_invalid' => 'Избраният тип сървър е невалиден.',
        'error_server_warning_threshold_invalid' => 'Броя неуспешни проверки, преди
 сървъра или сайта да бъдат
 маркирани като Офлайн трябва да е
 цифра по-голяма от 0.',
    ),
    'config' => array(
        'general' => 'Основни настройки',
        'language' => 'Език',
        'show_update' => 'Да проверява ли за нова версия всяка седмица',
        'email_status' => 'Да се изпращат ли имейли',
        'email_from_email' => 'Имейл, от който да се изпращат съобщенията',
        'email_from_name' => 'Име на изпращача',
        'email_smtp' => 'Активиране на SMTP',
        'email_smtp_host' => 'SMTP сървър',
        'email_smtp_port' => 'SMTP порт',
        'email_smtp_username' => 'SMTP потребителско име',
        'email_smtp_password' => 'SMTP парола',
        'email_smtp_noauth' => 'Оставете празно за "без аутентикация"',
        'sms_status' => 'Да се изпращат ли SMS-и',
        'sms_gateway' => 'Портал за изпращане на SMS-и',
        'sms_gateway_username' => 'Потребител',
        'sms_gateway_password' => 'Парола',
        'sms_from' => 'Номер на изпращача',
        'pushover_status' => 'Позволява изпращането на Pushover съобщения',
        'pushover_description' => 'Pushover е услуга, която улеснява получаването на
 известия в реално време. Посетете <a
 href="https://pushover.net/" target="_blank">техния сайт</a> за
 повече информация.',
        'pushover_clone_app' => 'Кликнете тук за да създаване на вашият Pushover App',
        'pushover_api_token' => 'Pushover App API Token',
        'pushover_api_token_description' => 'Преди да използвате Pushover, трябва да <a
 href="%1$s" target="_blank" rel="noopener">регистрирате
 свой App</a> в техния сайт и въведете вашия
 App API Token тук.',
        'alert_type' => 'Изберете кога желаете да получавате известия',
        'alert_type_description' => '<b>Промяна на сатуса:</b><br>Ще получавате
 известие когато има промяна със връзката на
 даден някой от описаните сървър или сайт. От
 Онлайн -> Офлайн и от Офлайн ->
 Онлайн.<br><br><b>Офлайн</b><br>Ще получите
 известие когато връзката до сървъра е
 изгубена за *ПЪРВИ ПЪТ*. Например, вашия cron
 скрипт проверява всеки 15 минути и връзката
 до сървъра е изгубена в 1 часа през нощта и не
 работи до 6 часа сутринта Вие ще получите
 едно известие в 1 часа за
 това<br><br><b>Винаги:</b><br> Ще получавате
 известие при всяка проверка на Вашия крон
 скрипт дори когато връзката до даден сървър
 или сайт е била прекъсната в продължение на
 часове.',
        'alert_type_status' => 'Промяна на статуса',
        'alert_type_offline' => 'Офлайн',
        'alert_type_always' => 'Винаги',
        'log_status' => 'Статус на логовете',
        'log_status_description' => 'Ако е отметнато, системата ще записва всяка
 промяна.',
        'log_email' => 'Да се пази ли лог на изпратените имейли от
 системата',
        'log_sms' => 'Да се пази ли лог на изпратените SMS съобщения от
 системата',
        'updated' => 'Настройките са обновени успешно.',
        'tab_email' => 'Имейл',
        'tab_sms' => 'SMS',
        'tab_pushover' => 'Pushover',
        'settings_email' => 'Имейл настройки',
        'settings_sms' => 'SMS настройки',
        'settings_pushover' => 'Pushover настройки',
        'settings_notification' => 'Настройки на известията',
        'settings_log' => 'Настройки на логовете',
        'auto_refresh' => 'Автоматично опресняване',
        'auto_refresh_description' => 'Автоматично опресняване на
 страницата.<br><span class="small">Времето е в
 секунди, ако е 0 страницата няма да се
 обновява.</span>',
        'seconds' => 'секунди',
        'test' => 'Тест',
        'test_email' => 'Ще бъде изпратенo тестово съобщение до имейл
 адреса, който сте задали в профила си.',
        'test_sms' => 'Ще бъде изпратен тестово SMS съобщение до телефонния
 номер, който сте задали в профила си.',
        'test_pushover' => 'Pushover известоята ще бъдат изпратени до
 потребителски ключ/устройство посочено във
 вашият профил.',
        'send' => 'Изпрати',
        'test_subject' => 'Тестово съобщение',
        'test_message' => 'Тестово съобщение изпртено от PHP Сървър
 мониторинг',
        'email_sent' => 'Тестовия имейл е изпратен успешно.',
        'email_error' => 'Възникна грешка при изпращането на тесовия имейл',
        'sms_sent' => 'Тестовото SMS съобщение е изпратеното успешно.',
        'sms_error' => 'Възникна грешка при изпращането на тестовия SMS. %s',
        'sms_error_nomobile' => 'Неуспешно изпращане на тестов SMS: не е намерен
 валиден телефонен номер във вашия профил.',
        'pushover_sent' => 'Pushover тестово известие',
        'pushover_error' => 'Възникна грешка при изпращане на тестово Pushover
 известие: %s',
        'pushover_error_noapp' => 'Unable to send test notification: не е зададен валиден Pushover
 App API token в настройките.',
        'pushover_error_nokey' => 'Unable to send test notification: не е зададен валиден Pushover
 ключ във вашия профил.',
        'log_retention_period' => 'Период на съхранение на логовете',
        'log_retention_period_description' => 'Какъв брой дни да се пазят логовете от
 известията и архиви за ъптайм на
 сървърите. Въведете 0 ако желаете
 логовете да не се трият.',
        'log_retention_days' => 'дни',
    ),
    'notifications' => array(
        'off_sms' => 'Сървър \'%LABEL%\' е Офлайн: ip=%IP%, port=%PORT%. Greshka=%ERROR%',
        'off_email_subject' => 'Връзката до \'%LABEL%\' е ИЗГУБЕНА',
        'off_email_body' => 'Неуспешно свързване:<br><br>Сървър: %LABEL%<br>IP адрес:
 %IP%<br>Порт: %PORT%<br>Грешка: %ERROR%<br>Днес: %DATE%',
        'off_pushover_title' => 'Връзката до \'%LABEL%\' е ИЗГУБЕНА',
        'off_pushover_message' => 'Неуспешно свързване:<br><br>Сървър: %LABEL%<br>IP
 адрес: %IP%<br>Порт: %PORT%<br>Грешка: %ERROR%<br>Днес: %DATE%',
        'on_sms' => 'Сървър \'%LABEL%\' е Онлайн: ip=%IP%, port=%PORT%, it was down for
 %LAST_OFFLINE_DURATION%',
        'on_email_subject' => 'Връзката до \'%LABEL%\' е ВЪЗСТАНОВЕНА',
        'on_email_body' => 'Връзката до \'%LABEL%\' беше ВЪЗСТАНОВЕНА, it was down for
 %LAST_OFFLINE_DURATION%:<br><br>Сървър: %LABEL%<br>IP адрес: %IP%<br>Порт:
 %PORT%<br>Днес: %DATE%',
        'on_pushover_title' => 'Връзката до \'%LABEL%\' е ВЪЗСТАНОВЕНА',
        'on_pushover_message' => 'Връзката до \'%LABEL%\' беше ВЪЗСТАНОВЕНА, it was down for
 %LAST_OFFLINE_DURATION%:<br><br>Сървър: %LABEL%<br>IP адрес:
 %IP%<br>Порт: %PORT%<br>Днес: %DATE%',
    ),
    'login' => array(
        'welcome_usermenu' => 'Добре дошъл, %user_name%',
        'title_sign_in' => 'Моля, влезте с профила си',
        'title_forgot' => 'Забравили сте паролата си?',
        'title_reset' => 'Възстановяване на паролата',
        'submit' => 'Вход',
        'remember_me' => 'Искам да остана логнат',
        'login' => 'Вход',
        'logout' => 'Изход',
        'username' => 'Потребител',
        'password' => 'Парола',
        'password_repeat' => 'Повторете паролата',
        'password_forgot' => 'Забравили сте паролата си?',
        'password_reset' => 'Възстановяване на паролата',
        'password_reset_email_subject' => 'Възстановяване на парола за PHP Сървър
 Мониторинг',
        'password_reset_email_body' => 'За да възстановите паролата си е нужно да
 кликнете на линка по-долу. Валидността на
 линка е един час.<br><br>%link%',
        'error_user_incorrect' => 'Потребителят не може да бъде намерен.',
        'error_login_incorrect' => 'Информацията е грешна.',
        'error_login_passwords_nomatch' => 'Паролите не съвпадат.',
        'error_reset_invalid_link' => 'Линкът за възстановяване на паролата не е
 валиден.',
        'success_password_forgot' => 'Изпратен е имейл с информация за
 възстановяване на паролата.',
        'success_password_reset' => 'Вашата парола е променена успешно. Моля,
 влезте в системата.',
    ),
    'error' => array(
        '401_unauthorized' => 'Неоторизиран достъп',
        '401_unauthorized_description' => 'Нямате нужното ниво на достъп за да
 прегледате тази страница.',
    ),
);
