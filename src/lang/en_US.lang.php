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
 * @author      Pepijn Over <pep@mailbox.org>
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

$sm_lang = array(
    'name' => 'English',
    'locale' => array(
        '0' => 'en_US.UTF-8',
        '1' => 'en_US',
        '2' => 'american',
        '3' => 'english-us',
    ),
    'locale_tag' => 'en',
    'locale_dir' => 'ltr',
    'system' => array(
        'title' => 'Server Monitor',
        'install' => 'Install',
        'action' => 'Action',
        'save' => 'Save',
        'edit' => 'Edit',
        'delete' => 'Delete',
        'view' => 'View',
        'date' => 'Date',
        'message' => 'Message',
        'yes' => 'Yes',
        'no' => 'No',
        'insert' => 'Insert',
        'add_new' => 'Add new',
        'update_available' => 'A new version ({version}) is available. Click <a
 href="https://github.com/phpservermon/phpservermon/releases/latest" target="_blank"
 rel="noopener">here</a> to download the update.',
        'back_to_top' => 'Back to top',
        'go_back' => 'Go back',
        'ok' => 'OK',
        'bad' => 'bad',
        'cancel' => 'Cancel',
        'none' => 'None',
        'activate' => 'Activate',
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
        'year' => 'year',
        'years' => 'years',
        'month' => 'month',
        'months' => 'months',
        'day' => 'day',
        'days' => 'days',
        'hour' => 'hour',
        'hours' => 'hours',
        'minute' => 'minute',
        'minutes' => 'minutes',
        'second' => 'second',
        'seconds' => 'seconds',
        'current' => 'current',
        'settings' => 'Settings',
        'search' => 'Search',
    ),
    'menu' => array(
        'config' => 'Config',
        'server' => 'Servers',
        'server_log' => 'Log',
        'server_status' => 'Status',
        'server_update' => 'Update',
        'user' => 'Users',
        'help' => 'Help',
    ),
    'users' => array(
        'user' => 'User',
        'name' => 'Name',
        'user_name' => 'Username',
        'password' => 'Password',
        'password_repeat' => 'Password repeat',
        'password_leave_blank' => 'Leave blank to keep unchanged',
        'level' => 'Level',
        'level_10' => 'Administrator',
        'level_20' => 'User',
        'level_description' => '<b>Administrators</b> have full access: they can manage servers, users and edit the
 global configuration.<br><b>Users</b> can only view and run the updater for the
 servers that have been assigned to them.',
        'mobile' => 'Mobile',
        'email' => 'Email',
        'pushover' => 'Pushover',
        'pushover_description' => 'Pushover is a service that makes it easy to get real-time notifications. See <a
 href="https://pushover.net/">their website</a> for more info.',
        'pushover_key' => 'Pushover Key',
        'pushover_device' => 'Pushover Device',
        'pushover_device_description' => 'Device name to send the message to. Leave empty to send it to all devices.',
        'telegram' => 'Telegram',
        'telegram_description' => '<a href="https://telegram.org/">Telegram</a> is a chat app that makes it easy to
 get real-time notifications. Visit the <a
 href="http://docs.phpservermonitor.org/">documentation</a> for more info and an
 install guide.',
        'telegram_chat_id' => 'Telegram chat id',
        'telegram_chat_id_description' => 'The message will be send to the corresponding chat.',
        'telegram_get_chat_id' => 'Click here to get your chat id',
        'activate_telegram' => 'Activate Telegram notifications',
        'activate_telegram_description' => 'Allow Telegram notifications to be sent to the specified chat id. Without
 this permission, Telegram doesn\'t allow us to send notifications to you.',
        'telegram_bot_username_found' => 'The bot was found!<br><a href="%s" target="_blank" rel="noopener"><button
 class="btn btn-primary">Next step</button></a> <br>This will open a chat
 with the bot. Here you need to press start of type /start.',
        'telegram_bot_username_error_token' => '401 - Unauthorized. Please make sure that the API token is valid.',
        'telegram_bot_error' => 'An error has occurred while activating Telegram notification: %s',
        'delete_title' => 'Delete User',
        'delete_message' => 'Are you sure you want to delete user \'%1\'?',
        'deleted' => 'User deleted.',
        'updated' => 'User updated.',
        'inserted' => 'User added.',
        'profile' => 'Profile',
        'profile_updated' => 'Your profile has been updated.',
        'error_user_name_bad_length' => 'Usernames must be between 2 and 64 characters.',
        'error_user_name_invalid' => 'The username may only contain alphabetic characters (a-z, A-Z), digits (0-9),
 dots (.) and underscores (_).',
        'error_user_name_exists' => 'The given username already exists in the database.',
        'error_user_email_bad_length' => 'Email addresses must be between 5 and 255 characters.',
        'error_user_email_invalid' => 'The email address is invalid.',
        'error_user_level_invalid' => 'The given user level is invalid.',
        'error_user_no_match' => 'The user could not be found in the database.',
        'error_user_password_invalid' => 'The entered password is invalid.',
        'error_user_password_no_match' => 'The entered passwords do not match.',
        'error_user_admin_cant_be_deleted' => 'You can\'t remove the last administrator.',
    ),
    'log' => array(
        'title' => 'Log entries',
        'type' => 'Type',
        'status' => 'Status',
        'email' => 'Email',
        'sms' => 'SMS',
        'pushover' => 'Pushover',
        'telegram' => 'Telegram',
        'no_logs' => 'No logs',
        'clear' => 'Clear log',
        'delete_title' => 'Delete log',
        'delete_message' => 'Are you sure you want to delete <b>all</b> logs?',
    ),
    'servers' => array(
        'server' => 'Server',
        'status' => 'Status',
        'label' => 'Label',
        'domain' => 'Domain/IP',
        'timeout' => 'Timeout',
        'timeout_description' => 'Number of seconds to wait for the server to respond.',
        'authentication_settings' => 'Authentication Settings',
        'optional' => 'Optional',
        'website_username' => 'Username',
        'website_username_description' => 'Username to access the site. (Only Apache authentication is supported.)',
        'website_password' => 'Password',
        'website_password_description' => 'Password to access the site. The password is encrypted in the database.',
        'fieldset_monitoring' => 'Monitoring',
        'fieldset_permissions' => 'Permissions',
        'permissions' => 'Server will be visible for the following users',
        'port' => 'Port',
        'custom_port' => 'Custom Port',
        'popular_ports' => 'Popular Ports',
        'request_method' => 'Request method',
        'custom_request_method' => 'Custom request method',
        'popular_request_methods' => 'Popular request methods',
        'post_field' => 'Post field',
        'post_field_description' => 'The data that will be send using the request method above.',
        'please_select' => 'Please select',
        'type' => 'Type',
        'type_website' => 'Website',
        'type_service' => 'Service',
        'type_ping' => 'Ping',
        'pattern' => 'Search string/pattern',
        'pattern_description' => 'If this pattern is not found on the website, the server will be marked
 online/offline. Regular expressions are allowed.',
        'pattern_online' => 'Pattern indicates website is',
        'pattern_online_description' => 'Online: If this pattern was found on the website, the server will be marked
 online. Offline: If this pattern was not found on the website, the server
 will be marked offline.',
        'redirect_check' => 'Redirecting to another domain is',
        'redirect_check_description' => 'Redirect to another domain is usually a bad sign.',
        'allow_http_status' => 'Allow HTTP status code',
        'allow_http_status_description' => 'Mark website as online. HTTP Status codes lower then 400 are marked as
 online by default. Seperate with |.',
        'header_name' => 'Header name',
        'header_value' => 'Header value',
        'header_name_description' => 'Case-sensitive.',
        'header_value_description' => 'Regular expressions are allowed.',
        'last_check' => 'Last check',
        'last_online' => 'Last online',
        'last_offline' => 'Last offline',
        'last_output' => 'Last positive output',
        'last_error' => 'Last error',
        'last_error_output' => 'Last error output',
        'output' => 'Output',
        'monitoring' => 'Monitoring',
        'no_monitoring' => 'No monitoring',
        'email' => 'Email',
        'send_email' => 'Send Email',
        'sms' => 'SMS',
        'send_sms' => 'Send SMS',
        'pushover' => 'Pushover',
        'send_pushover' => 'Send Pushover notification',
        'telegram' => 'Telegram',
        'send_telegram' => 'Send Telegram notification',
        'users' => 'Users',
        'delete_title' => 'Delete server',
        'delete_message' => 'Are you sure you want to delete server \'%1\'?',
        'deleted' => 'Server deleted.',
        'updated' => 'Server updated.',
        'inserted' => 'Server added.',
        'latency' => 'Latency',
        'latency_max' => 'Latency (maximum)',
        'latency_min' => 'Latency (minimum)',
        'latency_avg' => 'Latency (average)',
        'online' => 'online',
        'offline' => 'offline',
        'uptime' => 'Uptime',
        'year' => 'Year',
        'month' => 'Month',
        'week' => 'Week',
        'day' => 'Day',
        'hour' => 'Hour',
        'warning_threshold' => 'Warning threshold',
        'warning_threshold_description' => 'Number of failed checks required before it is marked offline.',
        'ssl_cert_expiry_days' => 'SSL Certificate Validity',
        'ssl_cert_expiry_days_description' => 'The minimum remaining days the SSL certificate is still valid. Use 0 to
 disable check.',
        'ssl_cert_expired' => 'SSL certificate expired since',
        'ssl_cert_expiring' => 'SSL certificate expiring:',
        'chart_last_week' => 'Last week',
        'chart_history' => 'History',
        'chart_day_format' => '%Y-%m-%d',
        'chart_long_date_format' => '%Y-%m-%d %H:%M:%S',
        'chart_short_date_format' => '%m/%d %H:%M',
        'chart_short_time_format' => '%H:%M',
        'warning_notifications_disabled_sms' => 'SMS notifications are disabled.',
        'warning_notifications_disabled_email' => 'Email notifications are disabled.',
        'warning_notifications_disabled_pushover' => 'Pushover notifications are disabled.',
        'warning_notifications_disabled_telegram' => 'Telegram notifications are disabled.',
        'error_server_no_match' => 'Server not found.',
        'error_server_label_bad_length' => 'The label must be between 1 and 255 characters.',
        'error_server_ip_bad_length' => 'The domain / IP must be between 1 and 255 characters.',
        'error_server_ip_bad_service' => 'The IP address is not valid.',
        'error_server_ip_bad_website' => 'The website URL is not valid.',
        'error_server_type_invalid' => 'The selected server type is invalid.',
        'error_server_warning_threshold_invalid' => 'The warning threshold must be a valid integer greater than 0.',
        'error_server_ssl_cert_expiry_days' => 'The remaining days for SSL certificate validity must be a valid integer
 greater than or equal to 0.',
    ),
    'config' => array(
        'general' => 'General',
        'language' => 'Language',
        'show_update' => 'Check for updates?',
        'password_encrypt_key' => 'The encryption key password',
        'password_encrypt_key_note' => 'This key is used to encrypt passwords that are stored on servers for access to
 websites. If the key will change the stored password is invalid!',
        'proxy' => 'Enable proxy',
        'proxy_url' => 'Proxy URL',
        'proxy_user' => 'Proxy username',
        'proxy_password' => 'Proxy password',
        'email_status' => 'Allow sending email',
        'email_from_email' => 'Email from address',
        'email_from_name' => 'Email from name',
        'email_smtp' => 'Enable SMTP',
        'email_smtp_host' => 'SMTP host',
        'email_smtp_port' => 'SMTP port',
        'email_smtp_security' => 'SMTP security',
        'email_smtp_security_none' => 'None',
        'email_smtp_username' => 'SMTP username',
        'email_smtp_password' => 'SMTP password',
        'email_smtp_noauth' => 'Leave blank for no authentication',
        'sms_status' => 'Allow sending text messages',
        'sms_gateway' => 'Gateway to use for sending messages',
        'sms_gateway_username' => 'Gateway username',
        'sms_gateway_password' => 'Gateway password',
        'sms_from' => 'Sender\'s phone number',
        'pushover_status' => 'Allow sending Pushover messages',
        'pushover_description' => 'Pushover is a service that makes it easy to get real-time notifications. See <a
 href="https://pushover.net/">their website</a> for more info.',
        'pushover_clone_app' => 'Click here to create your Pushover app',
        'pushover_api_token' => 'Pushover App API Token',
        'pushover_api_token_description' => 'Before you can use Pushover, you need to <a href="%1$s" target="_blank"
 rel="noopener">register an App</a> at their website and enter the App API
 Token here.',
        'telegram_status' => 'Allow sending Telegram messages',
        'telegram_description' => '<a href="https://telegram.org/">Telegram</a> is a chat app that makes it easy to
 get real-time notifications. Visit the <a
 href="http://docs.phpservermonitor.org/">documentation</a> for more info and an
 install guide.',
        'telegram_api_token' => 'Telegram API Token',
        'telegram_api_token_description' => 'Before you can use Telegram, you need to get a API token. Visit the <a
 href="http://docs.phpservermonitor.org/">documentation</a> for help.',
        'alert_type' => 'Select when you\'d like to be notified.',
        'alert_type_description' => '<b>Status change:</b> You will receive a notification when a server has a change
 in status. So from online -> offline or offline -> online.<br><br><b>Offline:</b>
 You will receive a notification when a server goes offline for the *FIRST TIME
 ONLY*. For example, your cronjob is every 15 minutes and your server goes down at
 1 am and stays down till 6 am. You will get 1 notification at 1 am and that\'s
 it.<br><br><b>Always:</b> You will receive a notification every time the script
 runs and a site is down, even if the site has been offline for hours.',
        'alert_type_status' => 'Status change',
        'alert_type_offline' => 'Offline',
        'alert_type_always' => 'Always',
        'combine_notifications' => 'Combine notifications',
        'combine_notifications_description' => 'Reduces the amount of notification by combining the notifications into
 1 single notification. (This does not affect SMS notifications.)',
        'alert_proxy' => 'Even if enabled, proxy is never used for services',
        'alert_proxy_url' => 'Format: host:port',
        'log_status' => 'Log status',
        'log_status_description' => 'If log status is set to TRUE, the monitor will log the event whenever the
 notification settings are passed.',
        'log_email' => 'Log emails sent by the script',
        'log_sms' => 'Log text messages sent by the script',
        'log_pushover' => 'Log pushover messages sent by the script',
        'log_telegram' => 'Log Telegram messages sent by the script',
        'updated' => 'The configuration has been updated.',
        'tab_email' => 'Email',
        'tab_sms' => 'SMS',
        'tab_pushover' => 'Pushover',
        'tab_telegram' => 'Telegram',
        'settings_email' => 'Email settings',
        'settings_sms' => 'Text message settings',
        'settings_pushover' => 'Pushover settings',
        'settings_telegram' => 'Telegram settings',
        'settings_notification' => 'Notification settings',
        'settings_log' => 'Log settings',
        'settings_proxy' => 'Proxy settings',
        'auto_refresh' => 'Auto-refresh',
        'auto_refresh_description' => 'Auto-refresh servers page.<br><span class="small">Time in seconds, if 0 the
 page won\'t refresh.</span>',
        'seconds' => 'seconds',
        'test' => 'Test',
        'test_email' => 'An email will be sent to the address specified in your user profile.',
        'test_sms' => 'An SMS will be sent to the phone number specified in your user profile.',
        'test_pushover' => 'A Pushover notification will be sent to the user key/device specified in your user
 profile.',
        'test_telegram' => 'A Telegram notification will be sent to the chat id specified in your user profile.',
        'send' => 'Send',
        'test_subject' => 'Test',
        'test_message' => 'Test message',
        'email_sent' => 'Email sent',
        'email_error' => 'Error in email sending',
        'sms_sent' => 'SMS sent',
        'sms_error' => 'An error has occurred while sending the SMS: %s',
        'sms_error_nomobile' => 'Unable to send test SMS: no valid phone number found in your profile.',
        'pushover_sent' => 'Pushover notification sent',
        'pushover_error' => 'An error has occurred while sending the Pushover notification: %s',
        'pushover_error_noapp' => 'Unable to send test notification: no Pushover App API token found in the global
 configuration.',
        'pushover_error_nokey' => 'Unable to send test notification: no Pushover key found in your profile.',
        'telegram_sent' => 'Telegram notification sent',
        'telegram_error' => 'An error has occurred while sending the Telegram notification: %s',
        'telegram_error_notoken' => 'Unable to send test notification: no Telegram API token found in the global
 configuration.',
        'telegram_error_noid' => 'Unable to send test notification: no chat id found in your profile.',
        'log_retention_period' => 'Log retention period',
        'log_retention_period_description' => 'Number of days to keep logs of notifications and archives of server
 uptime. Enter 0 to disable log cleanup.',
        'log_retention_days' => 'days',
    ),
    'notifications' => array(
        'off_sms' => 'Server \'%LABEL%\' is DOWN: ip=%IP%, port=%PORT%. Error=%ERROR%',
        'off_email_subject' => 'IMPORTANT: Server \'%LABEL%\' is DOWN',
        'off_email_body' => 'Failed to connect to the following server:<br><br>Server: %LABEL%<br>IP: %IP%<br>Port:
 %PORT%<br>Error: %ERROR%<br>Date: %DATE%',
        'off_pushover_title' => 'Server \'%LABEL%\' is DOWN',
        'off_pushover_message' => 'Failed to connect to the following server:<br><br>Server: %LABEL%<br>IP:
 %IP%<br>Port: %PORT%<br>Error: %ERROR%<br>Date: %DATE%',
        'off_telegram_message' => 'Failed to connect to the following server:<br><br>Server: %LABEL%<br>IP:
 %IP%<br>Port: %PORT%<br>Error: %ERROR%<br>Date: %DATE%',
        'on_sms' => 'Server \'%LABEL%\' is RUNNING: ip=%IP%, port=%PORT%, it was down for %LAST_OFFLINE_DURATION%',
        'on_email_subject' => 'IMPORTANT: Server \'%LABEL%\' is RUNNING',
        'on_email_body' => 'Server \'%LABEL%\' is running again, it was down for
 %LAST_OFFLINE_DURATION%:<br><br>Server: %LABEL%<br>IP: %IP%<br>Port: %PORT%<br>Date:
 %DATE%',
        'on_pushover_title' => 'Server \'%LABEL%\' is RUNNING',
        'on_pushover_message' => 'Server \'%LABEL%\' is running again, it was down for
 %LAST_OFFLINE_DURATION%:<br><br>Server: %LABEL%<br>IP: %IP%<br>Port: %PORT%<br>Date:
 %DATE%',
        'on_telegram_message' => 'Server \'%LABEL%\' is running again, it was down for:
 %LAST_OFFLINE_DURATION%<br><br>Server: %LABEL%<br>IP: %IP%<br>Port: %PORT%<br>Date:
 %DATE%',
        'combi_off_email_message' => '<ul><li>Server: %LABEL%</li><li>IP: %IP%</li><li>Port: %PORT%</li><li>Error:
 %ERROR%</li><li>Date: %DATE%</li></ul>',
        'combi_off_pushover_message' => '<ul><li>Server: %LABEL%</li><li>IP: %IP%</li><li>Port: %PORT%</li><li>Error:
 %ERROR%</li><li>Date: %DATE%</li></ul>',
        'combi_off_telegram_message' => '- Server: %LABEL%<br>- IP: %IP%<br>- Port: %PORT%<br>- Error: %ERROR%<br>-
 Date: %DATE%<br><br>',
        'combi_on_email_message' => '<ul><li>Server: %LABEL%</li><li>IP: %IP%</li><li>Port: %PORT%</li><li>Downtime:
 %LAST_OFFLINE_DURATION%</li><li>Date: %DATE%</li></ul>',
        'combi_on_pushover_message' => '<ul><li>Server: %LABEL%</li><li>IP: %IP%</li><li>Port:
 %PORT%</li><li>Downtime: %LAST_OFFLINE_DURATION%</li><li>Date:
 %DATE%</li></ul>',
        'combi_on_telegram_message' => '- Server: %LABEL%<br>- IP: %IP%<br>- Port: %PORT%<br>- Downtime:
 %LAST_OFFLINE_DURATION%<br>- Date: %DATE%<br><br>',
        'combi_email_subject' => 'IMPORTANT: \'%UP%\' servers UP again, \'%DOWN%\' servers DOWN',
        'combi_pushover_subject' => '\'%UP%\' servers UP again, \'%DOWN%\' servers DOWN',
        'combi_email_message' => '<b>The following servers went down:</b><br>%DOWN_SERVERS%<br><b>The following
 servers are up again:</b><br>%UP_SERVERS%',
        'combi_pushover_message' => '<b>The following servers went down:</b><br>%DOWN_SERVERS%<br><b>The following
 servers are up again:</b><br>%UP_SERVERS%',
        'combi_telegram_message' => '<b>The following servers went down:</b><br>%DOWN_SERVERS%<br><b>The following
 servers are up again:</b><br>%UP_SERVERS%',
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
        'password_reset_email_body' => 'Please use the following link to reset your password. Please note it expires
 in 1 hour.<br><br>%link%',
        'error_user_incorrect' => 'The provided username could not be found.',
        'error_login_incorrect' => 'The information is incorrect.',
        'error_login_passwords_nomatch' => 'The provided passwords do not match.',
        'error_reset_invalid_link' => 'The reset link you provided is invalid.',
        'success_password_forgot' => 'An email has been sent to you with information how to reset your password.',
        'success_password_reset' => 'Your password has been reset successfully. Please login.',
    ),
    'error' => array(
        '401_unauthorized' => 'Unauthorized',
        '401_unauthorized_description' => 'You do not have the privileges to view this page.',
    ),
);
