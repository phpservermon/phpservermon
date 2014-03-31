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
 * @author      Plamen Vasilev <p.vasileff@gmail.com>
 * @copyright   Copyright (c) 2008-2014 Pepijn Over <pep@neanderthal-technology.com>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

$sm_lang = array(
	'name' => 'Български - Bulgarian',
	'system' => array(
		'title' => 'Server Monitor',
		'install' => 'Инсталация',
		'action' => 'Действие',
		'save' => 'Запиши',
		'edit' => 'Редактирай',
		'delete' => 'Изтрии',
		'deleted' => 'Записът е изтрит',
		'date' => 'Дата',
		'message' => 'Съобщебие',
		'yes' => 'Да',
		'no' => 'Не',
		'edit' => 'Редактиране на',
		'insert' => 'Добавяне',
		'add_new' => 'Добави нов',
		'update_available' => 'Налична е нова версия ({version}). Може да я свалите от <a href="http://www.phpservermonitor.org" target="_blank">тук</a>.',
		'back_to_top' => 'Нагоре',
		'go_back' => 'Go back',
		// date/time format according the strftime php function format parameter http://php.net/manual/function.strftime.php
		'short_day_format' => '%B %e',
		'long_day_format' => '%B %e, %Y',
		'yesterday_format' => 'Yesterday at %k:%M',
		'other_day_format' => '%A at %k:%M',
		'never' => 'Never',
		'hours_ago' => '%d hours ago',
		'an_hour_ago' => 'about an hour ago',
		'minutes_ago' => '%d minutes ago',
		'a_minute_ago' => 'about a minute ago',
		'seconds_ago' => '%d seconds ago',
		'a_second_ago' => 'a second ago',
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
		'user_name' => 'Username',
		'password' => 'Password',
		'password_repeat' => 'Password repeat',
		'password_leave_blank' => 'Leave blank to keep unchanged',
		'level' => 'Level',
		'level_10' => 'Administrator',
		'level_20' => 'User',
		'level_description' => '<b>Administrators</b> have full access: they can manage servers, users and edit the global configuration.<br/><b>Users</b> can only view and run the updater for the servers that have been assigned to them.',
		'mobile' => 'Мобилен телефон',
		'email' => 'Имейл',
		'updated' => 'Информацията за потребителя е обновена.',
		'inserted' => 'Потребителят е добавен.',
		'profile' => 'Profile',
		'profile_updated' => 'Your profile has been updated.',
		'error_user_name_bad_length' => 'Usernames must be between 2 and 64 characters.',
		'error_user_name_invalid' => 'It may only contain alphabetic characters (a-z, A-Z), digits (0-9) and underscores (_).',
		'error_user_name_exists' => 'The given username already exists in the database.',
		'error_user_email_bad_length' => 'Email addresses must be between 5 and 255 characters.',
		'error_user_email_invalid' => 'The email address is invalid.',
		'error_user_level_invalid' => 'The given user level is invalid.',
		'error_user_no_match' => 'The user could not be found in the database.',
		'error_user_password_invalid' => 'The entered password is invalid.',
		'error_user_password_no_match' => 'The entered passwords do not match.',
	),
	'log' => array(
		'title' => 'Записи в лога',
		'type' => 'Тип',
		'status' => 'Статус',
		'email' => 'Имейл',
		'sms' => 'SMS',
	),
	'servers' => array(
		'server' => 'Сървър',
		'label' => 'Име',
		'domain' => 'Хост',
		'port' => 'Порт',
		'type' => 'Тип',
		'type_website' => 'Website',
		'type_service' => 'Service',
		'pattern' => 'Търсене на образец/схема',
		'pattern_description' => 'If this pattern is not found on the website, the server will be marked offline. Regular expressions are allowed.',
		'last_check' => 'Последна проверка',
		'last_online' => 'Последно на линия',
		'monitoring' => 'Мониторинг',
		'send_email' => 'Имейл',
		'send_sms' => 'SMS',
		'updated' => 'Информацията за сървъра е обновена.',
		'inserted' => 'Сървърът е добвен успешно.',
		'latency' => 'Пинг',
		'latency_max' => 'Latency (maximum)',
		'latency_min' => 'Latency (minimum)',
		'latency_avg' => 'Latency (average)',
		'year' => 'Year',
		'month' => 'Month',
		'week' => 'Week',
		'day' => 'Day',
		'hour' => 'Hour',
		'warning_threshold' => 'Warning threshold',
		'warning_threshold_description' => 'Number of failed checks required before it is marked offline.',
		'chart_last_week' => 'Last week',
		'chart_history' => 'History',
		// Charts date format according jqPlot date format  http://www.jqplot.com/docs/files/plugins/jqplot-dateAxisRenderer-js.html
		'chart_day_format' => '%d.%m.%Y',
		'chart_long_date_format' => '%d.%m.%Y %H:%M:%S',
		'chart_short_date_format' => '%d.%m %H:%M',
		'chart_short_time_format' => '%H:%M',
	),
	'config' => array(
		'general' => 'Основни настройки',
		'language' => 'Език',
		'show_update' => 'Да проверява ли за нова версия всяка седмица?',
		'email_status' => 'Да се изпращат ли имейли?',
		'email_from_email' => 'Имейл, от който да се изпращат съобщенията',
		'email_from_name' => 'Име на изпращача',
		'email_smtp' => 'Активиране на SMTP',
		'email_smtp_host' => 'SMTP сървър',
		'email_smtp_port' => 'SMTP порт',
		'email_smtp_username' => 'SMTP потребителско име',
		'email_smtp_password' => 'SMTP парола',
		'email_smtp_noauth' => 'Оставете празно за "без аутентикация"',
		'sms_status' => 'Да се изпращат ли SMS-и?',
		'sms_gateway' => 'Портал за изпращане на SMS-и',
		'sms_gateway_mosms' => 'Mosms',
		'sms_gateway_mollie' => 'Mollie',
		'sms_gateway_spryng' => 'Spryng',
		'sms_gateway_inetworx' => 'Inetworx',
		'sms_gateway_clickatell' => 'Clickatell',
		'sms_gateway_textmarketer' => 'Textmarketer',
		'sms_gateway_username' => 'Потребител',
		'sms_gateway_password' => 'Парола',
		'sms_from' => 'Номер на изпращача',
		'alert_type' => 'Изберете кога желаете да получавате известия<br/>',
		'alert_type_description' => '<b>Промяна на сатуса:</b><br>'.
			'Ще получавате известие когато има промяна със връзката на даден някой от описаните сървър или сайт. От Онлайн -> Офлайн и от Офлайн -> Онлайн.<br/>'.
			'<br/><b>Офлайн</b><br>'.
			'Ще получите известие когато връзката до сървъра е изгубена за *ПЪРВИ ПЪТ*. Например, '.
			'вашия cron скрипт проверява всеки 15 минути и връзката до сървъра е изгубена в 1 часа през ноща и не работи до 6 часа сутринта '.
			'Вие ще получите едно известие в 1 часа за това<br/>'.
			'<br><b>Винаги:</b><br> '.
			'Ще получавате известие при всяка проверка на Вашия cron скрипт дори когато връзката до даден сървър или сайт е била'.
			'прекъсната в продължение на часове.',
		'alert_type_status' => 'Промяна на статуса',
		'alert_type_offline' => 'Офлайн',
		'alert_type_always' => 'Винаги',
		'log_status' => 'Статус на логовете<br/><div class="small">Ако е отметнато, системата ще записва всяка промяна:</div>',
		'log_email' => 'Да се пази ли лог на изпратените имейли от системата?',
		'log_sms' => 'Да се пази ли лог на изпратените SMS съобщения от системата?',
		'updated' => 'Настройките са обновени успешно.',
		'settings_email' => 'Имейл настройки',
		'settings_sms' => 'SMS настройки',
		'settings_notification' => 'Настройки на известията',
		'settings_log' => 'Настройки на логовете',
		'auto_refresh_servers' =>
			'Автоматично опресняване на страницата<br/>'.
			'<div class="small">'.
			'Времето е в секунди, ако е 0 страницата няма да се обноява.'.
			'</div>',
	),
	// За нов ред в имейл съобщението, моля използвайте тага <br/>
	'notifications' => array(
		'off_sms' => 'Syrvyryt \'%LABEL%\' e OFFLINE: ip=%IP%, port=%PORT%. Greshka=%ERROR%',
		'off_email_subject' => 'Връзката до \'%LABEL%\' е ИЗГУБЕНА',
		'off_email_body' => "Неуспешно свързване:<br/><br/>Сървър: %LABEL%<br/>IP адрес: %IP%<br/>Порт: %PORT%<br/>Грешка: %ERROR%<br/>Днес: %DATE%",
		'on_sms' => 'Syrvyryt \'%LABEL%\' e ONLINE: ip=%IP%, port=%PORT%',
		'on_email_subject' => 'Връзката до \'%LABEL%\' е ВЪЗСТАНОВЕНА',
		'on_email_body' => "Връзката до '%LABEL%' беше ВЪЗСТАНОВЕНА:<br/><br/>Сървър: %LABEL%<br/>IP адрес: %IP%<br/>Порт: %PORT%<br/>Днес: %DATE%",
	),
	'login' => array(
		'welcome_usermenu' => 'Welcome, %user_name%',
		'title_sign_in' => 'Please sign in',
		'title_forgot' => 'Forgot your password?',
		'title_reset' => 'Reset your password',
		'submit' => 'Submit',
		'remember_me' => 'Remember me',
		'login' => 'Login',
		'logout' => 'Logout',
		'username' => 'Username',
		'password' => 'Password',
		'password_repeat' => 'Repeat password',
		'password_forgot' => 'Forgot password?',
		'password_reset' => 'Reset password',
		'password_reset_email_subject' => 'Reset your password for PHP Server Monitor',
		'password_reset_email_body' => 'Please use the following link to reset your password. Please note it expires in 1 hour.<br/><br/>%link%',
		'error_user_incorrect' => 'The provided username could not be found.',
		'error_login_incorrect' => 'The information is incorrect.',
		'error_login_passwords_nomatch' => 'The provided passwords do not match.',
		'error_reset_invalid_link' => 'The reset link you provided is invalid.',
		'success_password_forgot' => 'An email has been sent to you with information how to reset your password.',
		'success_password_reset' => 'Your password has been reset successfully. Please login.',
	),
);
