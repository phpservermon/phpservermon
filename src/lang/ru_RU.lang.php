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
 * @author      Roman Beylin <roman.beylin@yandex.ru>
 * @author      Alexell <alexell@alexell.ru>
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

$sm_lang = array(
    'name' => 'Русский - Russian',
    'locale' => array(
        '0' => 'ru_RU.UTF-8',
        '1' => 'ru_RU',
        '2' => 'russian',
        '3' => 'russian',
    ),
    'locale_tag' => 'ru',
    'locale_dir' => 'ltr',
    'system' => array(
        'title' => 'Сервер Мониторинг',
        'install' => 'Установка',
        'action' => 'Действие',
        'save' => 'Сохранить',
        'edit' => 'Редактировать',
        'delete' => 'Удалить',
        'date' => 'Дата',
        'message' => 'Сообщение',
        'yes' => 'Да',
        'no' => 'Нет',
        'insert' => 'Добавить',
        'add_new' => 'Добавить новый',
        'update_available' => 'Новая версия ({version}) доступна по адресу <a
 href="https://github.com/phpservermon/phpservermon/releases/latest" target="_blank"
 rel="noopener">http://www.phpservermonitor.org</a>.',
        'back_to_top' => 'Наверх',
        'go_back' => 'Вернуться',
        'ok' => 'OK',
        'cancel' => 'Отмена',
        'activate' => 'Активировать',
        'short_day_format' => '%e %B',
        'long_day_format' => '%e %B %Y',
        'yesterday_format' => 'Вчера в %k:%M',
        'other_day_format' => '%A в %k:%M',
        'never' => 'Никогда',
        'hours_ago' => '%d часов назад',
        'an_hour_ago' => 'час назад',
        'minutes_ago' => '%d минут назад',
        'a_minute_ago' => 'минуту назад',
        'seconds_ago' => '%d секунд назад',
        'a_second_ago' => 'секунду назад',
        'year' => 'год',
        'years' => 'лет',
        'month' => 'месяц',
        'months' => 'месяцев',
        'day' => 'день',
        'days' => 'дней',
        'hour' => 'час',
        'hours' => 'часов',
        'minute' => 'минута',
        'minutes' => 'минут',
        'second' => 'секунда',
        'seconds' => 'секунд',
    ),
    'menu' => array(
        'config' => 'Параметры',
        'server' => 'Серверы',
        'server_log' => 'Лог',
        'server_status' => 'Статус',
        'server_update' => 'Обновить',
        'user' => 'Пользователи',
        'help' => 'Помощь',
    ),
    'users' => array(
        'user' => 'Пользователь',
        'name' => 'Имя пользователя',
        'user_name' => 'Логин',
        'password' => 'Пароль',
        'password_repeat' => 'Повтор пароля',
        'password_leave_blank' => 'Оставить пустым, если не меняется',
        'level' => 'Уровень',
        'level_10' => 'Администратор',
        'level_20' => 'Пользователь',
        'level_description' => '<b>Администраторы</b> имеют полный доступ: они
 могут управлять серверами, пользователями и
 изменять общую
 конфигурацию.<br><b>Пользователи</b> могут только
 просматривать и запускать проверку для
 серверов, которые были к ним прикреплены.',
        'mobile' => 'Телефон',
        'email' => 'E-mail',
        'pushover' => 'Pushover',
        'pushover_description' => 'Pushover - это сервис, который позволяет легко
 получать уведомления в режиме реального
 времени. Больше информации на <a
 href="https://pushover.net/" target="_blank">их веб-сайте</a>.',
        'pushover_key' => 'Pushover ключ',
        'pushover_device' => 'Pushover устройство',
        'pushover_device_description' => 'Имя устройства, на которое будут
 отправляться уведомления. Оставьте
 пустым, что бы отправлять уведомления на
 все устройства.',
        'telegram' => 'Telegram',
        'telegram_description' => '<a href="https://telegram.org/" target="_blank">Telegram</a> удобный
 мессенджер для получения уведомлений в
 реальном времени. Посетите <a
 href="http://docs.phpservermonitor.org/" target="_blank">раздел
 документации</a> для получения доп. информации
 и инструкций по установке.',
        'telegram_chat_id' => 'Telegram chat id',
        'telegram_chat_id_description' => 'Сообщения будут отправляться на
 указанный идентификатор чата.',
        'telegram_get_chat_id' => 'Нажмите здесь чтобы получить ваш chat id',
        'activate_telegram' => 'Активировать уведомления в Telegram',
        'activate_telegram_description' => 'Разрешить отправку уведомлений на
 указанный идентификатор чата. Без этого
 разрешения Telegram не позволит нам
 отправлять вам уведомления.',
        'telegram_bot_username_found' => 'Бот обнаружен!<br><a href="%s" target="_blank"
 rel="noopener"><button class="btn btn-primary">Следующий
 шаг</button></a> <br>Откроется чат с ботом. Здесь
 вам нужно нажать кнопку Start или отправить
 команду /start.',
        'telegram_bot_username_error_token' => '401 - Unauthorized. Пожалуйста укажите
 действительный API токен..',
        'telegram_bot_error' => 'Произошла ошибка при активации уведомления
 Telegram: %s',
        'delete_title' => 'Удалить пользователя',
        'delete_message' => 'Вы уверены что хотите удалить пользователя \'%1\'?',
        'deleted' => 'Пользователь удален.',
        'updated' => 'Пользователь обновлен.',
        'inserted' => 'Пользователь добавлен.',
        'profile' => 'Профиль',
        'profile_updated' => 'Ваш профиль был обновлен.',
        'error_user_name_bad_length' => 'Логин должен содержать от 2 до 64 знаков.',
        'error_user_name_invalid' => 'Имя пользователя может содержать только
 латинские символы (a-z, A-Z), цифры (0-9), точки (.)
 и подчеркивание (_).',
        'error_user_name_exists' => 'Данный логин уже существует.',
        'error_user_email_bad_length' => 'E-mail может содержать от 5 до 255 знаков.',
        'error_user_email_invalid' => 'E-mail указан неверно.',
        'error_user_level_invalid' => 'Данный уровень пользователя
 недействителен.',
        'error_user_no_match' => 'Данного пользователя нет в базе данных.',
        'error_user_password_invalid' => 'Пароль указан неверно.',
        'error_user_password_no_match' => 'Введенные пароли не совпадают.',
    ),
    'log' => array(
        'title' => 'Запись',
        'type' => 'Тип',
        'status' => 'Статус',
        'email' => 'E-mail',
        'sms' => 'SMS',
        'pushover' => 'Pushover',
        'telegram' => 'Telegram',
        'no_logs' => 'Записей нет',
        'clear' => 'Очистить логи',
        'delete_title' => 'Удаление логов',
        'delete_message' => 'Вы уверены что хотите удалить <b>все</b> логи?',
    ),
    'servers' => array(
        'server' => 'Сервер',
        'status' => 'Состояние',
        'label' => 'Название',
        'domain' => 'Домен/IP',
        'timeout' => 'Тайм-аут',
        'timeout_description' => 'Количество секунд ожидания ответа сервера.',
        'authentication_settings' => 'Настройки аутентификации',
        'optional' => 'необязательно',
        'website_username' => 'Имя пользователя',
        'website_username_description' => 'Имя пользователя для доступа к сайту.
 (Поддерживается только Apache authentication.)',
        'website_password' => 'Пароль',
        'website_password_description' => 'пароль для доступа к сайту. Пароль будет
 храниться в зашифрованном виде.',
        'fieldset_monitoring' => 'Мониторинг',
        'fieldset_permissions' => 'Права доступа',
        'port' => 'Порт',
        'custom_port' => 'Указать порт',
        'popular_ports' => 'Популярные порты',
        'please_select' => 'Выберите',
        'type' => 'Тип',
        'type_website' => 'Веб-сайт',
        'type_service' => 'Сервис',
        'type_ping' => 'Пинг',
        'pattern' => 'Искать текст/шаблон',
        'pattern_description' => 'Если текст по шаблону не найден на сайте,
 сервер будет помечен как Оффлайн. Регулярные
 выражения допустимы.',
        'pattern_online' => 'Шаблон указывает что вебсайт:',
        'pattern_online_description' => 'Online: Если этот шаблон найден на веб-сайте,
 сервер будет отмечен Онлайн. Offline: Если
 этот шаблон не найден на веб-сайте, сервер
 будет отмечен как Оффлайн.',
        'header_name' => 'Название заголовка',
        'header_value' => 'Значение заголовка',
        'header_name_description' => 'с учетом регистра.',
        'header_value_description' => 'Разрешены регулярные выражения.',
        'last_check' => 'Последняя проверка',
        'last_online' => 'Был онлайн',
        'last_offline' => 'Был оффлайн',
        'monitoring' => 'Мониторинг',
        'no_monitoring' => 'Нет мониторинга',
        'email' => 'E-mail',
        'send_email' => 'Отправить E-mail',
        'sms' => 'CMC',
        'send_sms' => 'Отправить CMC',
        'pushover' => 'Pushover',
        'send_pushover' => 'Отправлять уведомления в Pushover',
        'telegram' => 'Telegram',
        'send_telegram' => 'Отправлять уведомления в Telegram',
        'users' => 'Пользователи',
        'delete_title' => 'Удалить сервер',
        'delete_message' => 'Вы уверены что хотите удалить сервер \'%1\'?',
        'deleted' => 'Сервер удален.',
        'updated' => 'Сервер обновлен.',
        'inserted' => 'Сервер добавлен.',
        'latency' => 'Задержка',
        'latency_max' => 'Задержка (максимальная)',
        'latency_min' => 'Задержка (минимальная)',
        'latency_avg' => 'Задержка (средняя)',
        'online' => 'онлайн',
        'offline' => 'оффлайн',
        'uptime' => 'Аптайм',
        'year' => 'Год',
        'month' => 'Месяц',
        'week' => 'Неделя',
        'day' => 'День',
        'hour' => 'Час',
        'warning_threshold' => 'Порог предупреждения',
        'warning_threshold_description' => 'Количество неудачных проверок,
 требуемых чтобы сервер был помечен как
 Оффлайн.',
        'chart_last_week' => 'Прошлая неделя',
        'chart_history' => 'История',
        'chart_day_format' => '%d.%m.%Y',
        'chart_long_date_format' => '%d.%m.%Y %H:%M:%S',
        'chart_short_date_format' => '%d.%m %H:%M',
        'chart_short_time_format' => '%H:%M',
        'warning_notifications_disabled_sms' => 'SMS уведомления отключены.',
        'warning_notifications_disabled_email' => 'E-mail уведомления отключены.',
        'warning_notifications_disabled_pushover' => 'Pushover уведомления отключены.',
        'warning_notifications_disabled_telegram' => 'Уведомления в Telegram отключены.',
        'error_server_no_match' => 'Сервер не найден.',
        'error_server_label_bad_length' => 'Название должно содержать от 1 до 255
 знаков.',
        'error_server_ip_bad_length' => 'Домен/IP должен содержать от 1 до 255 знаков',
        'error_server_ip_bad_service' => 'IP-адрес недействителен.',
        'error_server_ip_bad_website' => 'Ссылка веб-страницы недействительна.',
        'error_server_type_invalid' => 'Выбраный тип сервера недействителен.',
        'error_server_warning_threshold_invalid' => 'Порог предупреждения должен иметь
 значение больше 0',
    ),
    'config' => array(
        'general' => 'Основные',
        'language' => 'Язык',
        'show_update' => 'Проверять обновления?',
        'password_encrypt_key' => 'Ключ шифрования пароля',
        'password_encrypt_key_note' => 'Этот ключ используется для шифрования
 паролей, которые указаны на серверах (для
 доступа к веб-сайтам). Если ключ изменится,
 сохраненный пароль будет недействителен!',
        'proxy' => 'Использовать прокси',
        'proxy_url' => 'Адрес прокси',
        'proxy_user' => 'Имя пользователя прокси',
        'proxy_password' => 'Пароль прокси',
        'email_status' => 'Разрешить отправку email',
        'email_from_email' => 'Отправлять от адреса',
        'email_from_name' => 'Отправлять от имени',
        'email_smtp' => 'Использовать SMTP',
        'email_smtp_host' => 'SMTP адрес',
        'email_smtp_port' => 'SMTP порт',
        'email_smtp_security' => 'SMTP защита',
        'email_smtp_security_none' => 'нет',
        'email_smtp_username' => 'SMTP пользователь',
        'email_smtp_password' => 'SMTP пароль',
        'email_smtp_noauth' => 'Оставить пустым, если без аутентификации',
        'sms_status' => 'Разрешить отправку SMS',
        'sms_gateway' => 'Шлюз для отправки SMS',
        'sms_gateway_username' => 'Пользователь',
        'sms_gateway_password' => 'Пароль',
        'sms_from' => 'Номер отправителя',
        'pushover_status' => 'Разрешить отправку Pushover сообщений',
        'pushover_description' => 'Pushover - это сервис, который позволяет легко
 получать уведомления в режиме реального
 времени. Больше информации на <a
 href="https://pushover.net/" target="_blank">их веб-сайте</a>.',
        'pushover_clone_app' => 'Нажмите здесь чтобы создать ваш Pushover app',
        'pushover_api_token' => 'Pushover App API Token',
        'pushover_api_token_description' => 'Прежде чем вы сможете начать
 пользоваться Pushover, вам необходимо
 зарегистрировать <a href="%1$s" target="_blank"
 rel="noopener">"App"</a> на их веб-сайте и ввести "App
 API Token" сюда.',
        'telegram_status' => 'Разрешить отправку уведомлений в Telegram',
        'telegram_description' => '<a href="https://telegram.org/" target="_blank">Telegram</a> удобный
 мессенджер для получения уведомлений в
 реальном времени. Посетите <a
 href="http://docs.phpservermonitor.org/" target="_blank">раздел
 документации</a> для получения доп. информации
 и инструкций по установке.',
        'telegram_api_token' => 'Telegram API Token',
        'telegram_api_token_description' => 'Прежде чем вы сможете начать
 пользоваться Telegram, вам необходимо
 получить API Token. Посетите <a
 href="http://docs.phpservermonitor.org/" target="_blank">раздел
 документации</a> для получения помощи.',
        'alert_type' => 'Тип уведомлений',
        'alert_type_description' => '<b>Изменение статуса:</b> Вы получите
 уведомление об изменение статуса. Для
 онлайн -> оффлайн или офлайн -> онлайн.<br><br
 /><b>Оффлайн:</b> Вы получите уведомление
 только когда сервер перейдет в статус
 оффлайн. Например, задание Cron выставлено на
 каждые 15 минут. Сервер перейдет в статус
 оффлайн в 1:00 и не измениться до 6:00. Вы
 получите 1 уведомление только в
 1:00<br><br><b>Всегда:</b> Вы будете получать
 уведомление при каждом запуске скрипта
 проверки, как только сервер перейдет в
 статус оффлайн, даже если сервер находится в
 этом статусе несколько часов.',
        'alert_type_status' => 'Изменение статуса',
        'alert_type_offline' => 'Оффлайн',
        'alert_type_always' => 'Всегда',
        'alert_proxy' => 'Даже если включено, прокси никогда не
 используется для сервисов',
        'alert_proxy_url' => 'Формат: адрес:порт',
        'log_status' => 'Лог статусов',
        'log_status_description' => 'Если лог статусов включен, монитор будет
 логировать все события выбранные в типе
 уведомлений.',
        'log_email' => 'Логировать уведомления отправленые по E-mail',
        'log_sms' => 'Логировать уведомления отправленые по SMS',
        'log_pushover' => 'Логировать Pushover уведомления',
        'log_telegram' => 'Логировать Telegram уведомления',
        'updated' => 'Настройки успешно сохранены.',
        'tab_email' => 'Email',
        'tab_sms' => 'SMS',
        'tab_pushover' => 'Pushover',
        'tab_telegram' => 'Telegram',
        'settings_email' => 'Настройка E-mail',
        'settings_sms' => 'Настройка SMS',
        'settings_pushover' => 'Настройка Pushover',
        'settings_telegram' => 'Настройка Telegram',
        'settings_notification' => 'Настройка уведомлений',
        'settings_log' => 'Настройка логирования',
        'settings_proxy' => 'Настройка прокси',
        'auto_refresh' => 'Авто-обновление',
        'auto_refresh_description' => 'Авто-обновление страницы статуса
 серверов.<br><span class="small">Время в секундах.
 Если указано 0, то страница не будет
 обновляться.</span>',
        'test' => 'Проверка',
        'test_email' => 'Сообщение будет отправлено на адрес указаный в
 профиле пользователя.',
        'test_sms' => 'SMS будет отправлено на номер телефона указаный в
 профиле пользователя.',
        'test_pushover' => 'Pushover уведомление будет отправленно на
 устройство указанное в профиле пользователя.',
        'test_telegram' => 'Уведомление Telegram будет отправлено на
 идентификатор чата, указанный в профиле
 пользователя.',
        'send' => 'Отправить',
        'test_subject' => 'Проверка',
        'test_message' => 'Тестовое сообщение',
        'email_sent' => 'Email отправлен',
        'email_error' => 'Ошибка отправки email',
        'sms_sent' => 'SMS отправлено',
        'sms_error' => 'При отправке SMS произошла ошибка: %s',
        'sms_error_nomobile' => 'Не удалось отправить тестовое SMS:
 действительный номер телефона не найден в
 вашем профиле.',
        'pushover_sent' => 'Pushover уведомление отправлено',
        'pushover_error' => 'Произошла ошибка во время отправки Pushover
 уведомления: %s',
        'pushover_error_noapp' => 'Не удалось отправить тестовое уведомление:
 Pushover "App API token" не найден в основных
 настройках.',
        'pushover_error_nokey' => 'Не удалось отправить тестовое уведомление:
 Pushover ключ не найден в вашем профиле.',
        'telegram_sent' => 'Уведомление в Telegram отправлено',
        'telegram_error' => 'Произошла ошибка при отправке уведомления в
 Telegram: %s',
        'telegram_error_notoken' => 'Не удалось отправить тестовое уведомление:
 Telegram API token не найден в основных настройках.',
        'telegram_error_noid' => 'Не удалось отправить тестовое уведомление:
 идентификатор чата не найден в вашем профиле.',
        'log_retention_period' => 'Период хранения логов',
        'log_retention_period_description' => 'Количество дней хранения логов
 уведомлений и архива аптайма серверов.
 Введите 0 для выключения очистки логов.',
        'log_retention_days' => 'дней',
    ),
    'notifications' => array(
        'off_sms' => 'Сервер \'%LABEL%\' сейчас НЕДОСТУПЕН: IP=%IP%, Порт=%PORT%.
 Ошибка=%ERROR%',
        'off_email_subject' => 'ВАЖНО: сервер \'%LABEL%\' сейчас НЕДОСТУПЕН',
        'off_email_body' => 'Невозможно подключиться к следующему
 серверу:<br><br>Сервер: %LABEL%<br>IP: %IP%<br>Порт:
 %PORT%<br>Ошибка: %ERROR%<br>Дата: %DATE%',
        'off_pushover_title' => 'Cервер \'%LABEL%\' сейчас НЕДОСТУПЕН',
        'off_pushover_message' => 'Невозможно подключиться к следующему
 серверу:<br><br>Сервер: %LABEL%<br>IP: %IP%<br>Порт:
 %PORT%<br>Ошибка: %ERROR%<br>Дата: %DATE%',
        'off_telegram_message' => 'Невозможно подключиться к следующему
 серверу:<br><br>Сервер: %LABEL%<br>IP: %IP%<br>Порт:
 %PORT%<br>Ошибка: %ERROR%<br>Дата: %DATE%',
        'on_sms' => 'Сервер \'%LABEL%\' снова ДОСТУПЕН: IP=%IP%, Порт=%PORT%. Был
 недоступен: %LAST_OFFLINE_DURATION%',
        'on_email_subject' => 'ВАЖНО: Сервер \'%LABEL%\' сейчас ДОСТУПЕН',
        'on_email_body' => 'Сервер \'%LABEL%\' снова доступен.<br>Был недоступен:
 %LAST_OFFLINE_DURATION%<br><br>Сервер: %LABEL%<br>IP: %IP%<br>Порт:
 %PORT%<br>Дата: %DATE%',
        'on_pushover_title' => 'Сервер \'%LABEL%\' сейчас ДОСТУПЕН',
        'on_pushover_message' => 'Сервер \'%LABEL%\' снова доступен.<br>Был
 недоступен: %LAST_OFFLINE_DURATION%<br><br>Сервер: %LABEL%<br>IP:
 %IP%<br>Порт: %PORT%<br>Дата: %DATE%',
        'on_telegram_message' => 'Сервер \'%LABEL%\' снова доступен.<br>Был
 недоступен: %LAST_OFFLINE_DURATION%<br><br>Сервер: %LABEL%<br>IP:
 %IP%<br>Порт: %PORT%<br>Дата: %DATE%',
    ),
    'login' => array(
        'welcome_usermenu' => 'Здравствуйте, %user_name%',
        'title_sign_in' => 'Пожалуйста, авторизуйтесь',
        'title_forgot' => 'Забыли пароль?',
        'title_reset' => 'Сбросить пароль',
        'submit' => 'Подтвердить',
        'remember_me' => 'Запомнить меня',
        'login' => 'Войти',
        'logout' => 'Выйти',
        'username' => 'Логин',
        'password' => 'Пароль',
        'password_repeat' => 'Повторить пароль',
        'password_forgot' => 'Забыли пароль?',
        'password_reset' => 'Сбросить пароль',
        'password_reset_email_subject' => 'Сброс пароля для PHP Server Monitor',
        'password_reset_email_body' => 'Пожалуйста, используйте следующую ссылку
 для сброса пароля. Ссылка действительна 1
 час.<br><br>%link%',
        'error_user_incorrect' => 'Пользователь с указаными данными не найден.',
        'error_login_incorrect' => 'Информация указана неверно.',
        'error_login_passwords_nomatch' => 'Пароль указан неверно.',
        'error_reset_invalid_link' => 'Ссылка для сброса пароля недействительна.',
        'success_password_forgot' => 'Вам был отправлен email, с инструкциями по
 сбросу пароля.',
        'success_password_reset' => 'Ваш пароль был сброшен. Пожалуйста
 авторизуйтесь.',
    ),
    'error' => array(
        '401_unauthorized' => 'Доступ закрыт',
        '401_unauthorized_description' => 'У вас нет прав доступа к этой странице.',
    ),
);
