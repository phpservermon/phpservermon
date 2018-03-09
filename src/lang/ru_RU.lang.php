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
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

$sm_lang = array(
	'name' => 'Russian - Русский',
	'locale' => array('ru_RU.UTF-8', 'ru_RU', 'russian', 'russian'),
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
		'update_available' => 'Новая версия ({version}) доступна по адресу <a href="http://www.phpservermonitor.org" target="_blank">http://www.phpservermonitor.org</a>.',
		'back_to_top' => 'Наверх',
		'go_back' => 'Вернуться',
		'ok' => 'OK',
		'cancel' => 'Отмена',
		// date/time format according the strftime php function format parameter http://php.net/manual/function.strftime.php
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
		'level_description' => '<b>Администраторы</b> имеют полный доступ: они могут управлять серверами, пользователями и изменять общую конфигурацию.<br/><b>Пользователи</b> могут только просматривать и запускать проверку для серверов, которые были к ним прикреплены.',
		'mobile' => 'Телефон',
		'email' => 'E-mail',
		'pushover' => 'Pushover',
		'pushover_description' => 'Pushover - это сервис, который позволяет легко получать уведомления в режиме реального времени. Больше информации на <a href="https://pushover.net/">их веб-сайте</a>.',
		'pushover_key' => 'Pushover ключ',
		'pushover_device' => 'Pushover устройство',
		'pushover_device_description' => 'Имя устройства, на которое будут отправляться уведомления. Оставьте пустым, что бы отправлять уведомления на все устройства.',
		'delete_title' => 'Удалить пользователя',
		'delete_message' => 'Вы уверены что хотите удалить пользователя \'%1\'?',
		'deleted' => 'Пользователь удален.',
		'updated' => 'Пользователь обновлен.',
		'inserted' => 'Пользователь добавлен.',
		'profile' => 'Профиль',
		'profile_updated' => 'Ваш профиль был обновлен.',
		'error_user_name_bad_length' => 'Логин должен содержать от 2 до 64 знаков.',
		'error_user_name_invalid' => 'Имя пользователя может содержать только латинские символы (a-z, A-Z), цифры (0-9), точки (.) и подчеркивание (_).',
		'error_user_name_exists' => 'Данный логин уже существует.',
		'error_user_email_bad_length' => 'E-mail может содержать от 5 до 255 знаков.',
		'error_user_email_invalid' => 'E-mail указан неверно.',
		'error_user_level_invalid' => 'Данный уровень пользователя недействителен.',
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
		'no_logs' => 'Записей нет',
		'clear' => 'Clear log',
		'delete_title' => 'Delete log',
		'delete_message' => 'Are you sure you want to delete <b>all</b> logs?',
	),
	'servers' => array(
		'server' => 'Сервер',
		'status' => 'Состояние',
		'label' => 'Название',
		'domain' => 'Домен/IP',
		'timeout' => 'Тайм-аут',
		'timeout_description' => 'Количество секунд ожидания ответа сервера.',
		'port' => 'Порт',
		'type' => 'Тип',
		'type_website' => 'Веб-сайт',
		'type_service' => 'Сервис',
		'pattern' => 'Искать текст/шаблон',
		'pattern_description' => 'Если текст по шаблону не найден на сайте, сервер будет помечен как Оффлайн. Регулярные выражения допустимы.',
		'last_check' => 'Последняя проверка',
		'last_online' => 'Был онлайн',
		'monitoring' => 'Мониторинг',
		'no_monitoring' => 'Нет мониторинга',
		'email' => 'E-mail',
		'send_email' => 'Отправить E-mail',
		'sms' => 'CMC',
		'send_sms' => 'Отправить CMC',
		'pushover' => 'Pushover',
		'users' => 'Пользователи',
		'delete_title' => 'Удалить сервер',
		'delete_message' => 'Вы уверены что хотите удалить сервер \'%1\'?',
		'deleted' => 'Сервер удален.',
		'updated' => 'Сервер обновлен.',
		'inserted' => 'Север добавлен.',
		'latency' => 'Задержка',
		'latency_max' => 'Задержка (максимальная)',
		'latency_min' => 'Задержка (минимальная)',
		'latency_avg' => 'Задержка (средняя)',
		'uptime' => 'Аптайм',
		'year' => 'Год',
		'month' => 'Месяц',
		'week' => 'Неделя',
		'day' => 'День',
		'hour' => 'Час',
		'warning_threshold' => 'Порог предупреждения',
		'warning_threshold_description' => 'Количество неудачных проверок, требуемых перед тем как сервер будет помечен как Оффлайн.',
		'chart_last_week' => 'Прошлая неделя',
		'chart_history' => 'История',
		// Charts date format according jqPlot date format  http://www.jqplot.com/docs/files/plugins/jqplot-dateAxisRenderer-js.html
		'chart_day_format' => '%d-%m-%Y',
		'chart_long_date_format' => '%d-%m-%Y %H:%M:%S',
		'chart_short_date_format' => '%d/%m %H:%M',
		'chart_short_time_format' => '%H:%M',
		'warning_notifications_disabled_sms' => 'SMS уведомления отключены.',
		'warning_notifications_disabled_email' => 'E-mail уведомления отключены.',
		'warning_notifications_disabled_pushover' => 'Pushover уведомления отключены.',
		'error_server_no_match' => 'Сервер не найден.',
		'error_server_label_bad_length' => 'Название должно содержать от 1 до 255 знаков.',
		'error_server_ip_bad_length' => 'Домен/IP должен содержать от 1 до 255 знаков',
		'error_server_ip_bad_service' => 'IP-адрес недействителен.',
		'error_server_ip_bad_website' => 'Ссылка веб-страницы недействительна.',
		'error_server_type_invalid' => 'Выбраный тип сервера недействителен.',
		'error_server_warning_threshold_invalid' => 'Порог предупреждения должен иметь значение больше 0',
	),
	'config' => array(
		'general' => 'Основные',
		'language' => 'Язык',
		'show_update' => 'Обновления',
		'email_status' => 'Разрешить отправку E-mail',
		'email_from_email' => 'Отправлять от адреса',
		'email_from_name' => 'Отправлять от имени',
		'email_smtp' => 'Включить SMTP',
		'email_smtp_host' => 'SMTP сервер',
		'email_smtp_port' => 'SMTP порт',
		'email_smtp_security' => 'SMTP security',
		'email_smtp_security_none' => 'None',
		'email_smtp_username' => 'SMTP пользователь',
		'email_smtp_password' => 'SMTP пароль',
		'email_smtp_noauth' => 'Оставить пустым, если без аутентификации',
		'sms_status' => 'Разрешить отправку SMS',
		'sms_gateway' => 'Шлюз для отправки SMS',
		'sms_gateway_mosms' => 'Mosms',
		'sms_gateway_mollie' => 'Mollie',
		'sms_gateway_spryng' => 'Spryng',
		'sms_gateway_inetworx' => 'Inetworx',
		'sms_gateway_clickatell' => 'Clickatell',
        'sms_gateway_textmarketer' => 'Textmarketer',
		'sms_gateway_smsglobal' => 'SMSGlobal',
		'sms_gateway_octopush' => 'Octopush',
		'sms_gateway_smsit' => 'Smsit',
		'sms_gateway_freevoipdeal' => 'FreeVoipDeal',
		'sms_gateway_nexmo' => 'Nexmo',
		'sms_gateway_cmbulksms' => 'CM Telecom',
		'sms_gateway_username' => 'Пользователь',
		'sms_gateway_password' => 'Пароль',
		'sms_from' => 'Номер отправителя',
		'pushover_status' => 'Разрешить отправку Pushover сообщений',
		'pushover_description' => 'Pushover - это сервис, который позволяет легко получать уведомления в режиме реального времени. Больше информации на <a href="https://pushover.net/">их веб-сайте</a>.',
		'pushover_clone_app' => 'Click here to create your Pushover app',
		'pushover_api_token' => 'Pushover App API Token',
		'pushover_api_token_description' => 'Прежде чем вы сможете начать пользоваться Pushover, вам необходимо зарегестрировать <a href="%1$s" target="_blank">"App"</a> на их веб-сайте и ввести "App API Token" сюда.',
		'alert_type' => 'Выбeрите, какие вы хотите получать уведомления',
        'alert_type_description' => '<b>Изменение статуса :</b> '.
		    'Вы получите уведомление об изменение статуса. Для онлайн -> оффлайн или офлайн -> онлайн.<br/>'.
		    '<br /><b>Оффлайн:</b> '.
		    'Вы получите уведомление только когда сервер перейдет в статус оффлайн. Например, '.
		    'Задание Cron выставлено на каждые 15 минут. Сервер перейдет в статус оффлайн в 1:00 и не измениться до 6:00. '.
		    'Вы получите 1 уведомление только в 1:00<br/>'.
		    '<br><b>Всегда:</b> '.
		    'Вы будете получать уведомление при каждом запуске скрипта проверки, как только сервер перейдет в статус оффлайн, даже если сервер находится в этом статусе несколько часов',
		'alert_type_status' => 'Изменение статуса',
		'alert_type_offline' => 'Оффлайн',
		'alert_type_always' => 'Всегда',
		'log_status' => 'Лог статусов',
		'log_status_description' => 'Если лог установлен в TRUE, монитор будет логировать все события режим которых выбран в типе уведомлений.',
		'log_email' => 'Логировать уведомления отправленые по E-mail',
		'log_sms' => 'Логировать уведомления отправленые по SMS',
		'log_pushover' => 'Логировать Pushover уведомления',
		'updated' => 'Параметры были успешно применены.',
		'tab_email' => 'E-mail',
		'tab_sms' => 'SMS',
		'tab_pushover' => 'Pushover',
		'settings_email' => 'Настройка E-mail',
		'settings_sms' => 'Настройка SMS',
		'settings_pushover' => 'Настройка Pushover',
		'settings_notification' => 'Настройка уведомлений',
		'settings_log' => 'Настройка логирования',
		'auto_refresh' => 'Авто-обновление',
		'auto_refresh_servers' =>
			'Авто-обновление страницы статуса серверов.<br/>'.
			'<span class="small">'.
			'Вермя в секундах, если 0 страница не будет обновляться.'.
			'</span>',
		'seconds' => 'секунд',
		'test' => 'Проверка',
		'test_email' => 'Сообщение будет отправлено на адрес указаный в профиле пользователя.',
		'test_sms' => 'Сообщение будет отправлено на номер телефона указаный в профиле пользователя.',
		'test_pushover' => 'Pushover уведомление будет отправленно на устройство указанное в профиле пользователя.',
		'send' => 'Отправить',
		'test_subject' => 'Проверка',
		'test_message' => 'Тестовое сообщение',
		'email_sent' => 'Сообщение отправлено',
		'email_error' => 'Ошибка при отправке сообщения',
		'sms_sent' => 'SMS отправлено',
		'sms_error' => 'Ошибка при отправке SMS',
		'sms_error_nomobile' => 'Не удалось отправить пробный SMS: действительный телефонный номер не был найден в вашем профиле.',
		'pushover_sent' => 'Pushover уведомление отправлено',
		'pushover_error' => 'Произошла ошибка во время отправки Pushover уведомления: %s',
		'pushover_error_noapp' => 'Не удалось отправить пробное уведомление: Pushover "App API token" не был найден в основных настройках.',
		'pushover_error_nokey' => 'Не удалось отправить пробное уведомление: Pushover ключ не был найден в вашем профиле.',
		'log_retention_period' => 'Период хранения логов',
		'log_retention_period_description' => 'Количество дней хранения логов уведомлений и архива аптайма серверов. Введите 0 для выключения очистки логов.',
		'log_retention_days' => 'дней',
	),
	// for newlines in the email messages use <br/>
	'notifications' => array(
		'off_sms' => 'Сервер \'%LABEL%\' сейчас НЕДОСТУПЕН: ip=%IP%, port=%PORT%. Ошибка=%ERROR%',
		'off_email_subject' => 'ВАЖНО: сервер \'%LABEL%\' сейчас НЕДОСТУПЕН',
		'off_email_body' => "Невозможно подключиться к следующему серверу:<br/><br/>Сервер: %LABEL%<br/>IP: %IP%<br/>Порт: %PORT%<br/>Ошибка: %ERROR%<br/>Дата: %DATE%",
		'off_pushover_title' => 'Cервер \'%LABEL%\' сейчас НЕДОСТУПЕН',
		'off_pushover_message' => "Невозможно подключиться к следующему серверу:<br/><br/>Сервер: %LABEL%<br/>IP: %IP%<br/>Порт: %PORT%<br/>Ошибка: %ERROR%<br/>Дата: %DATE%",
		'on_sms' => 'Сервер \'%LABEL%\' сейчас ДОСТУПЕН: ip=%IP%, port=%PORT%',
		'on_email_subject' => 'ВАЖНО: Сервер \'%LABEL%\' сейчас ДОСТУПЕН',
		'on_email_body' => "Сервер '%LABEL%' снова доступен:<br/><br/>Сервер: %LABEL%<br/>IP: %IP%<br/>Порт: %PORT%<br/>Дата: %DATE%",
		'on_pushover_title' => 'Сервер \'%LABEL%\' сейчас ДОСТУПЕН',
		'on_pushover_message' => "Сервер '%LABEL%' снова доступен:<br/><br/>Сервер: %LABEL%<br/>IP: %IP%<br/>Порт: %PORT%<br/>Дата: %DATE%",
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
		'password_reset_email_subject' => 'Сбросить пароль для PHP Server Monitor',
		'password_reset_email_body' => 'Пожалуйста, используйте следующую ссылку для сброса пароля. Ссылка действительна 1 час.<br/><br/>%link%',
		'error_user_incorrect' => 'Пользователь с указаными данными не найден.',
		'error_login_incorrect' => 'Информация указана неверно.',
		'error_login_passwords_nomatch' => 'Пароль указан неверно.',
		'error_reset_invalid_link' => 'Ссылка для сброса пароля недействительна.',
		'success_password_forgot' => 'Вам был отправлен email, с описанием сброса пароля.',
		'success_password_reset' => 'Ваш пароль был сброшен. Пожалуйста авторизуйтесь.',
	),
	'error' => array(
		'401_unauthorized' => 'Доступ закрыт',
		'401_unauthorized_description' => 'У вас нет прав доступа к этой странице.',
	),
);
