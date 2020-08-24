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
 * @author      Oleksa Vyshnivsky <dying.escape@gmail.com>
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

$sm_lang = array(
    'name' => 'Українська — Ukrainian',
    'locale' => array(
        '0' => 'uk_UA.UTF-8',
        '1' => 'uk_UA',
        '2' => 'ukrainian',
    ),
    'locale_tag' => 'uk',
    'locale_dir' => 'ltr',
    'system' => array(
        'title' => 'Server Monitor',
        'install' => 'Встановити',
        'action' => 'Дія',
        'save' => 'Зберегти',
        'edit' => 'Редагувати',
        'delete' => 'Видалити',
        'view' => 'Перегляд',
        'date' => 'Дата',
        'message' => 'Повідомлення',
        'yes' => 'Так',
        'no' => 'Ні',
        'insert' => 'Вставити',
        'add_new' => 'Додати',
        'update_available' => 'Доступна нова версія ({version}). Перейдіть <a
 href="https://github.com/phpservermon/phpservermon/releases/latest" target="_blank"
 rel="noopener">сюди</a> для завантаження оновлення.',
        'back_to_top' => 'Нагору',
        'go_back' => 'Назад',
        'ok' => 'OK',
        'bad' => 'погано',
        'cancel' => 'Скасувати',
        'none' => 'Жоден',
        'activate' => 'Активувати',
        'short_day_format' => '%e %b',
        'long_day_format' => '%e %b %Y',
        'yesterday_format' => 'Учора о %k:%M',
        'other_day_format' => '%A о %k:%M',
        'never' => 'Ніколи',
        'hours_ago' => '%d годин тому',
        'an_hour_ago' => 'близько години тому',
        'minutes_ago' => '%d хвилин тому',
        'a_minute_ago' => 'близько хвилини тому',
        'seconds_ago' => '%d секунд тому',
        'a_second_ago' => 'секунду тому',
        'year' => 'рік',
        'years' => 'років',
        'month' => 'місяць',
        'months' => 'місяців',
        'day' => 'дні',
        'days' => 'днів',
        'hour' => 'година',
        'hours' => 'годин',
        'minute' => 'хвилина',
        'minutes' => 'хвилин',
        'second' => 'секунда',
        'seconds' => 'секунд',
        'current' => 'поточний',
        'settings' => 'Налаштування',
        'search' => 'Пошук',
    ),
    'menu' => array(
        'config' => 'Конфіг',
        'server' => 'Сервери',
        'server_log' => 'Лог',
        'server_status' => 'Статус',
        'server_update' => 'Оновити',
        'user' => 'Користувачі',
        'help' => 'Довідка',
    ),
    'users' => array(
        'user' => 'Користувач',
        'name' => 'Ім’я',
        'user_name' => 'Ім’я користувача',
        'password' => 'Пароль',
        'password_repeat' => 'Повторити пароль',
        'password_leave_blank' => 'Залиште пустим, щоб не змінювати',
        'level' => 'Рівень',
        'level_10' => 'Адміністратор',
        'level_20' => 'Користувач',
        'level_description' => '<b>Адміністратори</b> мають повний доступ: вони
 можуть керувати серверами, користувачами, а
 також редагувати глобальні
 налаштування.<br><b>Користувачі</b> можуть тільки
 переглядати й запускати перевірку серверів, до
 яких їм надали доступ.',
        'mobile' => 'Мобільний',
        'email' => 'Електронна пошта',
        'pushover' => 'Pushover',
        'pushover_description' => 'Pushover — сервіс, що дозволяє легко отримувати
 сповіщення у реальному часі. За деталями
 перейдіть на <a href="https://pushover.net/" target="_blank">їхній
 вебсайт</a>.',
        'pushover_key' => 'Ключ Pushover',
        'pushover_device' => 'Пристрій Pushover',
        'pushover_device_description' => 'Ім’я пристрою, на який надсилати
 повідомлення. Залиште пустим, щоб
 надсилати на всі пристрої.',
        'telegram' => 'Telegram',
        'telegram_description' => '<a href="https://telegram.org/" target="_blank">Telegram</a> —
 чат-застосунок, що дозволяє легко отримувати
 сповіщення у реальному часі. За деталями й
 інструкцією зі встановлення зверніться до <a
 href="http://docs.phpservermonitor.org/"
 target="_blank">документації</a>.',
        'telegram_chat_id' => 'Ідентифікатор чату Telegram',
        'telegram_chat_id_description' => 'Повідомлення буде надіслане у
 відповідний чат.',
        'telegram_get_chat_id' => 'Натисніть тут для отримання свого
 ідентифікатора чату',
        'activate_telegram' => 'Активувати сповіщення у Telegram',
        'activate_telegram_description' => 'Дозволити надсилання Telegram-сповіщень на
 визначений ідентифікатор чату. Без
 цього дозволу Telegram не дозволить нам
 надсилати вам сповіщення.',
        'telegram_bot_username_found' => 'Бот знайдений!<br><a href="%s" target="_blank"
 rel="noopener"><button class="btn btn-primary">Наступний
 крок</button></a> <br>На ньому відкриється чат з
 ботом. Там буде потрібно натиснути start або
 набрати /start.',
        'telegram_bot_username_error_token' => '401 - Несанкціоновано. Будь ласка,
 перевірте, чи API-токен правильний.',
        'telegram_bot_error' => 'Сталася помилка при активації Telegram-сповіщень:
 %s',
        'delete_title' => 'Видалити користувача',
        'delete_message' => 'Ви дійсно хочете видалити користувача \'%1\'?',
        'deleted' => 'Користувача видалено.',
        'updated' => 'Користувача оновлено.',
        'inserted' => 'Користувача додано.',
        'profile' => 'Профіль',
        'profile_updated' => 'Ваш профіль оновлено.',
        'error_user_name_bad_length' => 'Імена користувачів мають бути довжиною
 від 2 до 64 символів.',
        'error_user_name_invalid' => 'Ім’я користувача може містити лише літери
 (a-z, A-Z), цифри (0-9), крапки (.) і підкреслення (_).',
        'error_user_name_exists' => 'Таке ім’я користувача уже існує у базі
 даних.',
        'error_user_email_bad_length' => 'Електронні адреси мають бути довжиною
 від 5 до 255 символів.',
        'error_user_email_invalid' => 'Неправильна електронна адреса.',
        'error_user_level_invalid' => 'Неправильний рівень користувача.',
        'error_user_no_match' => 'Користувача у базі даних не знайдено.',
        'error_user_password_invalid' => 'Введено неправильний пароль.',
        'error_user_password_no_match' => 'Введені паролі не збігаються.',
        'error_user_admin_cant_be_deleted' => 'Останнього адміністратора видалити не
 можна.',
    ),
    'log' => array(
        'title' => 'Записи у журналі',
        'type' => 'Тип',
        'status' => 'Статус',
        'email' => 'Email',
        'sms' => 'SMS',
        'pushover' => 'Pushover',
        'telegram' => 'Telegram',
        'no_logs' => 'Немає журналів',
        'clear' => 'Очистити журнали',
        'delete_title' => 'Видалити журнал',
        'delete_message' => 'Ви дійсно хочете видалити <b>усі</b> журнали?',
    ),
    'servers' => array(
        'server' => 'Сервер',
        'status' => 'Статус',
        'label' => 'Назва',
        'domain' => 'Домен/IP',
        'timeout' => 'Timeout',
        'timeout_description' => 'Кількість секунд очікування на відповідь
 сервера.',
        'authentication_settings' => 'Налаштування автентифікації',
        'optional' => 'Необов’язково',
        'website_username' => 'Ім’я користувача',
        'website_username_description' => 'Ім’я користувача для доступу до сайту.
 (Підтримується лише Apache-автентифікація.)',
        'website_password' => 'Пароль',
        'website_password_description' => 'Пароль для доступу до сайту. У базі даних
 пароль зберігається зашифрованим.',
        'fieldset_monitoring' => 'Моніторинг',
        'fieldset_permissions' => 'Дозволи',
        'permissions' => 'Сервер можуть переглядати такі користувачі',
        'port' => 'Порт',
        'custom_port' => 'Власний порт',
        'popular_ports' => 'Популярні порти',
        'request_method' => 'Метод запиту',
        'custom_request_method' => 'Власний метод запиту',
        'popular_request_methods' => 'Популярні методи запиту',
        'post_field' => 'Post-поле',
        'post_field_description' => 'Дані будуть надіслані з використанням
 вибраного вище методу.',
        'please_select' => 'Будь ласка, виберіть',
        'type' => 'Тип',
        'type_website' => 'Вебсайт',
        'type_service' => 'Сервіс',
        'type_ping' => 'Пінг',
        'pattern' => 'Шукати рядок/зразок',
        'pattern_description' => 'Якщо цей зразок не знайдено на сайті, сервер
 буде позначений як онлайн/офлайн. Регулярні
 вирази дозволені.',
        'pattern_online' => 'Зразок свідчить, що сайт — ',
        'pattern_online_description' => 'Онлайн: Якщо цей зразок не знайдено на
 сайті, сервер буде позначений як онлайн.
 Офлайн: Якщо цей зразок не знайдено на
 сайті, сервер буде позначений як офлайн.',
        'redirect_check' => 'Переспрямування на інший домен —',
        'redirect_check_description' => 'Переспрямування на інший домен зазвичай є
 поганим знаком.',
        'allow_http_status' => 'Дозволити код статусу HTTP',
        'allow_http_status_description' => 'Позначити вебсайт як онлайн. Коди
 статусів HTTP нижче ніж 400 позначаються як
 онлайн за замовчуванням. Розділяти коди
 символом |.',
        'header_name' => 'Ім’я у заголовку',
        'header_value' => 'Значення у заголовку',
        'header_name_description' => 'З урахуванням регістру.',
        'header_value_description' => 'Регулярні вирази дозволені.',
        'last_check' => 'Остання перевірка',
        'last_online' => 'Востаннє онлайн',
        'last_offline' => 'Востаннє офлайн',
        'last_output' => 'Остання позитивна відповідь',
        'last_error' => 'Остання помилка',
        'last_error_output' => 'Остання негативна відповідь',
        'output' => 'Вивід',
        'monitoring' => 'Моніторинг',
        'no_monitoring' => 'Немає моніторингу',
        'email' => 'Email',
        'send_email' => 'Надсилати електронні листи',
        'sms' => 'SMS',
        'send_sms' => 'Надсилати SMS',
        'pushover' => 'Pushover',
        'send_pushover' => 'Надсилати Pushover-сповіщення',
        'telegram' => 'Telegram',
        'send_telegram' => 'Надсилати Telegram-сповіщення',
        'users' => 'Користувачі',
        'delete_title' => 'Видалити сервер',
        'delete_message' => 'Ви дійсно хочете видалити сервер \'%1\'?',
        'deleted' => 'Сервер видалено.',
        'updated' => 'Сервер оновлено.',
        'inserted' => 'Сервер додано.',
        'latency' => 'Затримка',
        'latency_max' => 'Затримка (максимум)',
        'latency_min' => 'Затримка (мінімум)',
        'latency_avg' => 'Затримка (середня)',
        'online' => 'онлайн',
        'offline' => 'офлайн',
        'uptime' => 'Час роботи',
        'year' => 'Років',
        'month' => 'Місяць',
        'week' => 'Тиждень',
        'day' => 'День',
        'hour' => 'Година',
        'warning_threshold' => 'Поріг попередження',
        'warning_threshold_description' => 'Кількість невдалих перевірок перед
 виставленням статусу офлайн.',
        'chart_last_week' => 'Останній тиждень',
        'chart_history' => 'Історія',
        'chart_day_format' => '%d/%m/%Y',
        'chart_long_date_format' => '%d/%m/%Y %H:%M:%S',
        'chart_short_date_format' => '%d/%m %H:%M',
        'chart_short_time_format' => '%H:%M',
        'warning_notifications_disabled_sms' => 'SMS-сповіщення вимкнено.',
        'warning_notifications_disabled_email' => 'Email-сповіщення вимкнено.',
        'warning_notifications_disabled_pushover' => 'Pushover-сповіщення вимкнено.',
        'warning_notifications_disabled_telegram' => 'Telegram-сповіщення вимкнено.',
        'error_server_no_match' => 'Сервер не знайдено.',
        'error_server_label_bad_length' => 'Заголовок повинен бути довжиною від 1 до
 255 символів.',
        'error_server_ip_bad_length' => 'Домен/IP повинен бути довжиною від 1 до 255
 символів.',
        'error_server_ip_bad_service' => 'IP-адреса недійсна.',
        'error_server_ip_bad_website' => 'URL вебсайту недійсний.',
        'error_server_type_invalid' => 'Вибраний тип сервера недійсний.',
        'error_server_warning_threshold_invalid' => 'Поріг попередження має бути цілим
 числом більше 0.',
    ),
    'config' => array(
        'general' => 'Загальне',
        'language' => 'Мова',
        'show_update' => 'Перевіряти наявність оновлень?',
        'password_encrypt_key' => 'Пароль ключа шифрування',
        'password_encrypt_key_note' => 'Цей ключ використовується для шифрування
 паролів доступу до вебсайтів, що
 зберігаються на сервері. Якщо ключ буде
 змінений, збережені паролі будуть
 недійсними!',
        'proxy' => 'Увімкнути проксі-сервер',
        'proxy_url' => 'URL-адреса проксі-сервера',
        'proxy_user' => 'Ім’я користувача проксі-сервера',
        'proxy_password' => 'Пароль користувача проксі-сервера',
        'email_status' => 'Дозволити надсилання електронної пошти',
        'email_from_email' => 'Листи з адреси',
        'email_from_name' => 'Листи від імені',
        'email_smtp' => 'Увімкнути SMTP',
        'email_smtp_host' => 'SMTP-хост',
        'email_smtp_port' => 'SMTP-порт',
        'email_smtp_security' => 'SMTP-безпека',
        'email_smtp_security_none' => 'Немає',
        'email_smtp_username' => 'Ім’я користувача SMTP',
        'email_smtp_password' => 'Пароль користувача SMTP',
        'email_smtp_noauth' => 'Залиште пустим, щоб не автентифікуватися',
        'sms_status' => 'Дозволити надсилання текстових повідомлень',
        'sms_gateway' => 'Шлюз для надсилання повідомлень',
        'sms_gateway_username' => 'Ім’я користувача шлюзу',
        'sms_gateway_password' => 'Пароль користувача шлюзу',
        'sms_from' => 'Номер телефону відправника',
        'pushover_status' => 'Дозволити надсилання Pushover-повідомлень',
        'pushover_description' => 'Pushover — сервіс, що дозволяє легко отримувати
 сповіщення у реальному часі. За детальнішою
 інформацію перейдіть на <a href="https://pushover.net/"
 target="_blank">їхній вебсайт</a>.',
        'pushover_clone_app' => 'Натисніть тут, щоб створити ваш Pushover-додаток',
        'pushover_api_token' => 'Токен API Pushover-додатку',
        'pushover_api_token_description' => 'Перед використанням Pushover ви маєте <a
 href="%1$s" target="_blank" rel="noopener">зареєструвати
 Додаток</a> на їхньому вебсайті та ввести
 токен API Додатку тут.',
        'telegram_status' => 'Дозволити надсилання Telegram-повідомлень',
        'telegram_description' => '<a href="https://telegram.org/" target="_blank">Telegram</a> —
 чат-застосунок, що дозволяє легко отримувати
 сповіщення у реальному часі. Детальніша
 інформація та інструкція зі встановлення
 доступні у <a href="http://docs.phpservermonitor.org/"
 target="_blank">документації</a>.',
        'telegram_api_token' => 'Токен Telegram API',
        'telegram_api_token_description' => 'Перед використанням Telegram ви маєте
 отримати токен API. За довідкою
 зверніться до <a href="http://docs.phpservermonitor.org/"
 target="_blank">документації</a>.',
        'alert_type' => 'Виберіть, коли б вам хотілося отримувати
 сповіщення.',
        'alert_type_description' => '<b>Зміна статусу:</b> Ви отримуватимете
 сповіщення, коли змінюється статус сервера.
 Тобто при переходах онлайн -> офлайн і офлайн
 -> онлайн.<br><br><b>Офлайн:</b> Ви отримаєте
 сповіщення, коли сервер переходить у офлайн
 *ТІЛЬКИ ПЕРШИЙ РАЗ*. Наприклад, ваше
 крон-завдання виконується кожні 15 хвилин і
 ваш сервер лягає о 1-й годині ночі й лежить до
 6-ї години ранку. Ви отримаєте тільки одне
 сповіщення — о 1-й годині
 ночі.<br><br><b>Завжди:</b> Ви отримуватимете
 сповіщення при кожному запуску сценарію,
 коли сайт лежить, навіть якщо він лежить
 годинами.',
        'alert_type_status' => 'Зміна статусу',
        'alert_type_offline' => 'Офлайн',
        'alert_type_always' => 'Завжди',
        'combine_notifications' => 'Об’єднувати сповіщення',
        'combine_notifications_description' => 'Зменшує кількість сповіщень,
 об’єднуючи їх в 1 єдине сповіщення. (Це
 не стосується SMS-сповіщень.)',
        'alert_proxy' => 'Навіть якщо увімкнений, проксі-сервер ніколи не
 використовується для сервісів',
        'alert_proxy_url' => 'Формат: хост:порт',
        'log_status' => 'Статус журналу',
        'log_status_description' => 'Якщо статус журналу — TRUE, то монітор
 записуватиме у журнал подію щоразу, коли
 виконуватимуться умови надсилання
 сповіщення.',
        'log_email' => 'Записувати у журнал електронні листи, надіслані
 сценарієм',
        'log_sms' => 'Записувати у журнал текстові повідомлення,
 надіслані сценарієм',
        'log_pushover' => 'Записувати у журнал Pushover-повідомлення, надіслані
 сценарієм',
        'log_telegram' => 'Записувати у журнал Telegram-повідомлення, надіслані
 сценарієм',
        'updated' => 'Налаштування оновлено.',
        'tab_email' => 'Електронна пошта',
        'tab_sms' => 'SMS',
        'tab_pushover' => 'Pushover',
        'tab_telegram' => 'Telegram',
        'settings_email' => 'Налаштування електронної пошти',
        'settings_sms' => 'Налаштування текстових повідомлень',
        'settings_pushover' => 'Налаштування Pushover',
        'settings_telegram' => 'Налаштування Telegram',
        'settings_notification' => 'Налаштування сповіщень',
        'settings_log' => 'Налаштування логів',
        'settings_proxy' => 'Налаштування проксі',
        'auto_refresh' => 'Автооновлення',
        'auto_refresh_description' => 'Сторінка автооновлення серверів.<br><span
 class="small">Час у секундах; якщо 0, сторінка не
 оновлюватиметься.</span>',
        'test' => 'Тест',
        'test_email' => 'Електронний лист буде надісланий на адресу,
 вказану у вашому профілі користувача.',
        'test_sms' => 'SMS буде надіслане на номер телефону, вказаний у
 вашому профілі користувача.',
        'test_pushover' => 'Pushover-сповіщення буде надіслане на ключ/пристрій
 користувача, заданий у вашому профілі
 користувача.',
        'test_telegram' => 'Telegram-сповіщення буде надіслане у чат,
 ідентифікатор якого заданий у вашому профілі
 користувача.',
        'send' => 'Надіслати',
        'test_subject' => 'Тест',
        'test_message' => 'Тестове повідомлення',
        'email_sent' => 'Електронний лист надіслано',
        'email_error' => 'Помилка надсилання електронного листа',
        'sms_sent' => 'SMS надіслане',
        'sms_error' => 'При надсиланні SMS сталася помилка: %s',
        'sms_error_nomobile' => 'Не можу надіслати тестове SMS: у вашому профілі
 не знайдено дійсного номера телефону.',
        'pushover_sent' => 'Pushover-сповіщення надіслане',
        'pushover_error' => 'При надсиланні Pushover-сповіщення сталася помилка:
 %s',
        'pushover_error_noapp' => 'Не можу надіслати тестове сповіщення: у
 глобальних налаштуваннях не знайдено токен
 API Pushover-додатку.',
        'pushover_error_nokey' => 'Не можу надіслати тестове сповіщення: у
 вашому профілі не знайдено ключа Pushover.',
        'telegram_sent' => 'Telegram-сповіщення надіслане',
        'telegram_error' => 'При надсиланні Telegram-сповіщення сталася помилка:
 %s',
        'telegram_error_notoken' => 'Не можу надіслати тестове сповіщення: у
 глобальних налаштуваннях не знайдено токен
 Telegram API.',
        'telegram_error_noid' => 'Не можу надіслати тестове сповіщення: у
 вашому профілі не знайдено ідентифікатор
 чату.',
        'log_retention_period' => 'Період зберігання логів',
        'log_retention_period_description' => 'Кількість днів зберігання журналів
 сповіщень і архівів часу роботи
 серверів. Введіть 0, щоб вимкнути
 очищення журналів.',
        'log_retention_days' => 'днів',
    ),
    'notifications' => array(
        'off_sms' => 'Сервер \'%LABEL%\' ЛЕЖИТЬ: ip=%IP%, порт=%PORT%. Помилка=%ERROR%',
        'off_email_subject' => 'ВАЖЛИВО: Сервер \'%LABEL%\' ЛЕЖИТЬ',
        'off_email_body' => 'Не вдалося під’єднатися до такого
 сервера:<br><br>Сервер: %LABEL%<br>IP: %IP%<br>Порт:
 %PORT%<br>Помилка: %ERROR%<br>Дата: %DATE%',
        'off_pushover_title' => 'Сервер \'%LABEL%\' ЛЕЖИТЬ',
        'off_pushover_message' => 'Не вдалося під’єднатися до такого
 сервера:<br><br>Сервер: %LABEL%<br>IP: %IP%<br>Порт:
 %PORT%<br>Помилка: %ERROR%<br>Дата: %DATE%',
        'off_telegram_message' => 'Не вдалося під’єднатися до такого
 сервера:<br><br>Сервер: %LABEL%<br>IP: %IP%<br>Порт:
 %PORT%<br>Помилка: %ERROR%<br>Дата: %DATE%',
        'on_sms' => 'Сервер \'%LABEL%\' ПРАЦЮЄ: ip=%IP%, порт=%PORT%, він лежав
 протягом %LAST_OFFLINE_DURATION%',
        'on_email_subject' => 'ВАЖЛИВО: Сервер \'%LABEL%\' ПРАЦЮЄ',
        'on_email_body' => 'Сервер \'%LABEL%\' знову працює, він лежав протягом
 %LAST_OFFLINE_DURATION%:<br><br>Сервер: %LABEL%<br>IP: %IP%<br>Порт:
 %PORT%<br>Дата: %DATE%',
        'on_pushover_title' => 'Сервер \'%LABEL%\' ПРАЦЮЄ',
        'on_pushover_message' => 'Сервер \'%LABEL%\' знову працює, він лежав протягом
 %LAST_OFFLINE_DURATION%:<br><br>Сервер: %LABEL%<br>IP: %IP%<br>Порт:
 %PORT%<br>Дата: %DATE%',
        'on_telegram_message' => 'Сервер \'%LABEL%\' знову працює, він лежав
 протягом: %LAST_OFFLINE_DURATION%<br><br>Сервер: %LABEL%<br>IP:
 %IP%<br>Порт: %PORT%<br>Дата: %DATE%',
        'combi_off_email_message' => '<ul><li>Сервер: %LABEL%</li><li>IP: %IP%</li><li>Порт:
 %PORT%</li><li>Помилка: %ERROR%</li><li>Дата: %DATE%</li></ul>',
        'combi_off_pushover_message' => '<ul><li>Сервер: %LABEL%</li><li>IP: %IP%</li><li>Порт:
 %PORT%</li><li>Помилка: %ERROR%</li><li>Дата: %DATE%</li></ul>',
        'combi_off_telegram_message' => '- Сервер: %LABEL%<br>- IP: %IP%<br>- Порт: %PORT%<br>-
 Помилка: %ERROR%<br>- Дата: %DATE%<br><br>',
        'combi_on_email_message' => '<ul><li>Сервер: %LABEL%</li><li>IP: %IP%</li><li>Порт:
 %PORT%</li><li>Час простою: %LAST_OFFLINE_DURATION%</li><li>Дата:
 %DATE%</li></ul>',
        'combi_on_pushover_message' => '<ul><li>Сервер: %LABEL%</li><li>IP: %IP%</li><li>Порт:
 %PORT%</li><li>Час простою:
 %LAST_OFFLINE_DURATION%</li><li>Дата: %DATE%</li></ul>',
        'combi_on_telegram_message' => '- Сервер: %LABEL%<br>- IP: %IP%<br>- Порт: %PORT%<br>- Час
 простою: %LAST_OFFLINE_DURATION%<br>- Дата: %DATE%<br><br>',
        'combi_email_subject' => 'ВАЖЛИВО: \'%UP%\' серверів знову ПРАЦЮЮТЬ, \'%DOWN%\'
 серверів ЛЕЖАТЬ',
        'combi_pushover_subject' => '\'%UP%\' серверів знову ПРАЦЮЮТЬ, \'%DOWN%\'
 серверів ЛЕЖАТЬ',
        'combi_email_message' => '<b>Такі сервери лягли:</b><br>%DOWN_SERVERS%<br><b>Такі
 сервери знову працюють:</b><br>%UP_SERVERS%',
        'combi_pushover_message' => '<b>Такі сервери лягли:</b><br>%DOWN_SERVERS%<br><b>Такі
 сервери знову працюють:</b><br>%UP_SERVERS%',
        'combi_telegram_message' => '<b>Такі сервери лягли:</b><br>%DOWN_SERVERS%<br><b>Такі
 сервери знову працюють:</b><br>%UP_SERVERS%',
    ),
    'login' => array(
        'welcome_usermenu' => 'Ласкаво просимо, %user_name%',
        'title_sign_in' => 'Будь ласка, увійдіть',
        'title_forgot' => 'Забули свій пароль?',
        'title_reset' => 'Скинути пароль',
        'submit' => 'Надіслати',
        'remember_me' => 'Запам’ятати мене',
        'login' => 'Вхід',
        'logout' => 'Вихід',
        'username' => 'Ім’я користувача',
        'password' => 'Пароль',
        'password_repeat' => 'Повторити пароль',
        'password_forgot' => 'Забули пароль?',
        'password_reset' => 'Скинути пароль',
        'password_reset_email_subject' => 'Скинути свій пароль до PHP Server Monitor',
        'password_reset_email_body' => 'Будь ласка, скористайтеся наступним
 посиланням для скидання свого пароля. Будь
 ласка, пам’ятайте, що воно діє протягом 1
 години.<br><br>%link%',
        'error_user_incorrect' => 'Не вдалося знайти вказане ім’я користувача.',
        'error_login_incorrect' => 'Інформація неправильна.',
        'error_login_passwords_nomatch' => 'Надані паролі не збігаються.',
        'error_reset_invalid_link' => 'Надане посилання для скидання пароля
 недійсне.',
        'success_password_forgot' => 'Вам надіслано електронний лист із
 інформацією про відновлення пароля.',
        'success_password_reset' => 'Ваш пароль успішно скинутий. Будь ласка,
 увійдіть.',
    ),
    'error' => array(
        '401_unauthorized' => 'Несанкціоновано',
        '401_unauthorized_description' => 'Ви не маєте дозволу переглядати цю
 сторінку.',
    ),
);
