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
 * @author      Plamen Vasilev
 * @copyright   Copyright (c) 2008-2014 Pepijn Over <pep@neanderthal-technology.com>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

$sm_lang = array(
	'system' => array(
		'title' => 'Мониторинг система',
		'servers' => 'Сървъри',
		'users' => 'Потребители',
		'log' => 'Логове',
		'status' => 'Статус',
		'update' => 'Обнови данните',
		'config' => 'Настройки',
		'help' => 'Помощ',
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
		'update_available' => 'Налична е нова версия. Може да я свалите от <a href="http://phpservermon.sourceforge.net" target="_blank">тук</a>.',
		'back_to_top' => 'Нагоре',
	),
	'users' => array(
		'user' => 'Потребител',
		'name' => 'Име',
		'mobile' => 'Мобилен телефон',
		'email' => 'Имейл',
		'updated' => 'Информацията за потребителя е обновена.',
		'inserted' => 'Потребителят е добавен.',
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
		'pattern' => 'Търсене на образец/схема',
		'last_check' => 'Последна проверка',
		'last_online' => 'Последно на линия',
		'monitoring' => 'Мониторинг',
		'send_email' => 'Имейл',
		'send_sms' => 'SMS',
		'updated' => 'Информацията за сървъра е обновена.',
		'inserted' => 'Сървърът е добвен успешно.',
		'rtime' => 'Пинг',
	),
	'config' => array(
		'general' => 'General',
		'language' => 'Language',
		'language_en' => 'English',
		'language_bg' => 'Български',
		'language_nl' => 'Dutch',
		'language_fr' => 'French',
		'language_de' => 'German',
		'language_kr' => 'Korean',
		'language_br' => 'Portuguese - Brazilian',
		'show_update' => 'Да проверява ли за нова версия всяка седмица?',
		'email_status' => 'Да се изпращат ли имейли?',
		'email_from_email' => 'Имейл, от който да се изпращат съобщенията',
		'email_from_name' => 'Име на изпращача',
		'email_smtp' => 'Enable SMTP',
		'email_smtp_host' => 'SMTP host',
		'email_smtp_port' => 'SMTP port',
		'email_smtp_username' => 'SMTP username',
		'email_smtp_password' => 'SMTP password',
		'email_smtp_noauth' => 'Leave blank for no authentication',
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
		'alert_type' => 'Изберете кога желаете системата да Ви известява.<br/>',
		'alert_type_description' => '<b>Промяна на сатуса:</b>'.
			'Ще получавате нотификация когато има промяна със връзката на даден някой от описаните. От online -> offline и от offline -> online.<br/>'.
			'<br/><b>Offline</b>'.
			'You will receive a notification when a server goes offline for the *FIRST TIME ONLY*. For example, '.
			'your cronjob is every 15 mins and your server goes down at 1 am and stays down till 6 am. '.
			'You will get 1 notification at 1 am and thats it.<br/>'.
			'<br><b>Always:</b> '.
			'You will receive a notification every time the script runs and a site is down, even if the site has been '.
			'offline for hours.',
		'alert_type_status' => 'Промяна на статуса',
		'alert_type_offline' => 'Офлайн',
		'alert_type_always' => 'Винаги',
		'log_status' => 'Статус на логовете<br/><div class="small">Ако е отметнато, системата ще записва всяка промяна:</div>',
		'log_email' => 'Да се пази ли лог на изпратените имейли от системата?',
		'log_sms' => 'Да се пази ли лог на изпратените SMS съобщения от системата?',
		'updated' => 'Настройките са обновени успешно.',
		'settings_email' => 'Имейл настройки',
		'settings_sms' => 'SMS настройки',
		'settings_notification' => 'Настройки на уведомяването',
		'settings_log' => 'Настройки на логовете',
		'auto_refresh_servers' =>
			'Автоматично опресняване на страницата<br/>'.
			'<div class="small">'.
			'Времето е в секунди, ако е 0 страницата няма да се обноява.'.
			'</div>',
	),
	// for newlines in the email messages use <br/>
	'notifications' => array(
		'off_sms' => 'Server \'%LABEL%\' is DOWN: ip=%IP%, port=%PORT%. Error=%ERROR%',
		'off_email_subject' => 'Връзката до \'%LABEL%\' е ИЗГУБЕНА',
		'off_email_body' => "Неуспешно свързване:<br/><br/>Сървър: %LABEL%<br/>IP адрес: %IP%<br/>Порт: %PORT%<br/>Грешка: %ERROR%<br/>Днес: %DATE%",
		'on_sms' => 'Server \'%LABEL%\' is RUNNING: ip=%IP%, port=%PORT%',
		'on_email_subject' => 'Връзката до \'%LABEL%\' е ВЪЗСТАНОВЕНА',
		'on_email_body' => "Връзката до '%LABEL%' беше ВЪЗСТАНОВЕНА:<br/><br/>Сървър: %LABEL%<br/>IP адрес: %IP%<br/>Порт: %PORT%<br/>Днес: %DATE%",
	),
);

?>
