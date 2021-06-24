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
 * @author      Javad Evazzadeh Kakroudi
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

$sm_lang = array(
    'name' => 'فارسی - Persian',
    'locale' => array(
        '0' => 'fa_IR.UTF-8',
        '1' => 'fa_IR',
        '2' => 'far',
        '3' => 'per',
    ),
    'locale_tag' => 'fa',
    'locale_dir' => 'rtl',
    'system' => array(
        'title' => 'مانیتورینگ سرور',
        'install' => 'نصب',
        'action' => 'عملیات',
        'save' => 'ذخیره',
        'edit' => 'ویرایش',
        'delete' => 'حذف',
        'date' => 'تاریخ',
        'message' => 'پیغام',
        'yes' => 'بله',
        'no' => 'خیر',
        'insert' => 'افزودن',
        'add_new' => 'افزودن',
        'update_available' => 'نسخه جدیدتر ({version}) در <a
 href="https://github.com/phpservermon/phpservermon/releases/latest" target="_blank"
 rel="noopener">http://www.phpservermonitor.org</a> موجود است.',
        'back_to_top' => 'برو به بالا',
        'go_back' => 'برگرد',
        'ok' => 'تایید',
        'cancel' => 'انصراف',
        'short_day_format' => '%B %e',
        'long_day_format' => '%B %e, %Y',
        'yesterday_format' => 'دیروز در %k:%M',
        'other_day_format' => '%A در %k:%M',
        'never' => 'هرگز',
        'hours_ago' => '%d ساعت پیش',
        'an_hour_ago' => 'حدود یک ساعت پیش',
        'minutes_ago' => '%d دقیقه پیش',
        'a_minute_ago' => 'حدود یک دقیقه پیش',
        'seconds_ago' => '%d ثانیه پیش',
        'a_second_ago' => 'یک ثانیه پیش',
        'seconds' => 'ثانیه',
    ),
    'menu' => array(
        'config' => 'تنظیم',
        'server' => 'سرور',
        'server_log' => 'لاگ',
        'server_status' => 'وضعیت',
        'server_update' => 'بروزرسانی',
        'user' => 'کاربران',
        'help' => 'پشتیبانی',
    ),
    'users' => array(
        'user' => 'کاربر',
        'name' => 'نام',
        'user_name' => 'نام کاربری',
        'password' => 'کلمه عبور',
        'password_repeat' => 'تکرار کلمه عبور',
        'password_leave_blank' => 'برای عدم تغییر خالی بگذارید',
        'level' => 'سطح',
        'level_10' => 'مدیر',
        'level_20' => 'کاربر',
        'level_description' => '<b>مدیر</b> دسترسی کامل: این گروه ها توانایی
 مدیریت سرورها، کاربران و ویرایش تنظیمات عمومی
 را داردند.<br><b>کاربران</b> تنها توانایی دیدن و
 بروزرسانی سرورهای اختصاص داده شده به خودشان را
 داردند.',
        'mobile' => 'موبایل',
        'email' => 'ایمیل',
        'pushover' => 'Pushover',
        'pushover_description' => 'Pushover سرویسی است که دریافت اطلاعیه های بلادرنگ
 را ساده می کند. برای اطلاعات بیشتر <a
 href="https://pushover.net/" target="_blank">سایت آن ها</a> را
 ببینید.',
        'pushover_key' => 'کلید Pushover',
        'pushover_device' => 'دستگاه Pushover',
        'pushover_device_description' => 'نام دستگاه برای ارسال پیام. برای ارسال به
 همه دستگاه ها آن را خالی بگذارید',
        'delete_title' => 'حذف کاربر',
        'delete_message' => 'آیا برای حذف کاربر \'%1\' مطئن هستیند؟',
        'deleted' => 'کاربر حذف شد.',
        'updated' => 'کاربر بروزرسانی شد.',
        'inserted' => 'کاربر اضافه شد.',
        'profile' => 'پروفایل',
        'profile_updated' => 'پروفایل شما بروزرسانی شد.',
        'error_user_name_bad_length' => 'نام های کاربری باید بین 2 و 64 کاراکتر باشد.',
        'error_user_name_invalid' => 'نام کاربری باید فقط شامل حروف (a-z, A-Z)، نقطه (.)
 اعداد (0-9) و علامت (_) باشد.',
        'error_user_name_exists' => 'نام کاربری وارد شده در حال حاضر در پایگاه
 داده موجود است.',
        'error_user_email_bad_length' => 'آدرس های ایمیل باید بین 5 و 255 کاراکتر باشد.',
        'error_user_email_invalid' => 'آدرس ایمیل نامعتبر است.',
        'error_user_level_invalid' => 'سطح کاربرد داده شده نامعتبر است.',
        'error_user_no_match' => 'کاربر داده شده در پایگاه داده موجود نیست.',
        'error_user_password_invalid' => 'کلمه عبور وارد شده نامعتبر است.',
        'error_user_password_no_match' => 'کلمه های عبور وارد شده یکسان نیستند.',
    ),
    'log' => array(
        'title' => 'ورودی های لاگ',
        'type' => 'نوع',
        'status' => 'وضعیت',
        'email' => 'ایمیل',
        'sms' => 'پیامک',
        'pushover' => 'Pushover',
        'no_logs' => 'لاگی وجود ندارد.',
        'clear' => 'پاک کردن ورود',
        'delete_title' => 'حذف ورود',
        'delete_message' => 'آیا مطمئن هستید که میخواهید سیاهههای «همه» را
 حذف کنید؟',
    ),
    'servers' => array(
        'server' => 'سرور',
        'status' => 'وضعیت',
        'label' => 'برچسب',
        'domain' => 'دامنه/آی پی',
        'timeout' => 'تایم اوت',
        'timeout_description' => 'زمان مورد نیاز برای سرور جهت پاسخ دهی به ثانیه',
        'port' => 'پورت',
        'type' => 'نوع',
        'type_website' => 'وب سایت',
        'type_service' => 'سرویس',
        'pattern' => 'جستجوری رشته/الگو',
        'pattern_description' => 'اگر این الگو در سایت یافته نشد، سرور آفلاین
 نمایش داده خواهد شد. عبارات منظم مجاز هستند.',
        'last_check' => 'آخرین بررسی',
        'last_online' => 'آخرین زمان آنلاین بودن',
        'monitoring' => 'مانیتورینگ',
        'no_monitoring' => 'بدون مانیتورینگ',
        'email' => 'ایمیل',
        'send_email' => 'ارسال ایمیل',
        'sms' => 'پیامک',
        'send_sms' => 'ارسال پیامک',
        'pushover' => 'Pushover',
        'users' => 'کاربران',
        'delete_title' => 'حذف سرور',
        'delete_message' => 'مطمئنید که میخواهید سرور را پاک کنید \'%1\'؟',
        'deleted' => 'سرور پاک شد.',
        'updated' => 'سرور به روز رسانی شد.',
        'inserted' => 'سرور اضافه شد.',
        'latency' => 'زمان بررسی',
        'latency_max' => 'زمان بررسی (حداکثر)',
        'latency_min' => 'زمان بررسی (حداقل)',
        'latency_avg' => 'زمان بررسی (میانگین)',
        'uptime' => 'آپ تایم',
        'year' => 'سال',
        'month' => 'ماه',
        'week' => 'هفته',
        'day' => 'روز',
        'hour' => 'ساعت',
        'warning_threshold' => 'آستانه هشدار',
        'warning_threshold_description' => 'تعداد چک های شکست خورده قبل از اینکه به
 عنوان آفلاین نشانه گذاری شود.',
        'chart_last_week' => 'هفته گذشته',
        'chart_history' => 'تاریخچه',
        'chart_day_format' => '%Y-%m-%d',
        'chart_long_date_format' => '%Y-%m-%d %H:%M:%S',
        'chart_short_date_format' => '%m/%d %H:%M',
        'chart_short_time_format' => '%H:%M',
        'warning_notifications_disabled_sms' => 'اطلاعیه های پیامک غیرفعال هستند.',
        'warning_notifications_disabled_email' => 'اطلاعیه های ایمیل غیرفعال هستند.',
        'warning_notifications_disabled_pushover' => 'اطلاعیه های پوش آور غیرفعال هستند.',
        'error_server_no_match' => 'سرور پیدا نشد.',
        'error_server_label_bad_length' => 'برچسب باید بین 1 و 255 کاراکتر باشد.',
        'error_server_ip_bad_length' => 'دامنمه / آی پی باید بین 1 و 255 کاراکتر باشد.',
        'error_server_ip_bad_service' => 'آدرس آی پی معتبر نیست.',
        'error_server_ip_bad_website' => 'آدرس وب سایت معتبر نیست.',
        'error_server_type_invalid' => 'نوع سرور انتخاب شده نامعتبر است.',
        'error_server_warning_threshold_invalid' => 'آستانه هشدار باید یک عدد صحیح
 بزرگتر از 0 باشد.',
    ),
    'config' => array(
        'general' => 'عمومی',
        'language' => 'زبان',
        'show_update' => 'به روز رسانی بررسی شود؟',
        'email_status' => 'اجازه ارسال ایمیل',
        'email_from_email' => 'ایمیل ارسال کننده',
        'email_from_name' => 'نام ارسال کننده',
        'email_smtp' => 'فعالسازی SMTP',
        'email_smtp_host' => 'هاست SMTP',
        'email_smtp_port' => 'پورت SMTP',
        'email_smtp_security' => 'امنیت SMTP',
        'email_smtp_security_none' => 'هیچ کدام',
        'email_smtp_username' => 'نام کاربری SMTP',
        'email_smtp_password' => 'کلمه عبور SMTP',
        'email_smtp_noauth' => 'برای عدم احراز هویت اینجا را خالی بگذارید.',
        'sms_status' => 'اجازه ارسال پیام های متنی',
        'sms_gateway' => 'گیت وی برای ارسال پیام ها',
        'sms_gateway_username' => 'نام کاربری Gateway',
        'sms_gateway_password' => 'کلمه عبور Gateway',
        'sms_from' => 'شماره تلفن ارسال کننده',
        'pushover_status' => 'اجازه ارسال پیام های Pushover',
        'pushover_description' => 'Pushover سرویسی است که دریافت اطلاعیه های بلادرنگ
 را ساده می کند. برای اطلاعات بیشتر <a
 href="https://pushover.net/" target="_blank">سایت آن ها</a> را
 ببینید.',
        'pushover_clone_app' => 'برای ایجاد برنامه پوش آور خود اینجا را کلیک
 کنید.',
        'pushover_api_token' => 'رمز API برنامه پوش آور',
        'pushover_api_token_description' => 'قبل از استفاده از پوش آور، شما باید در
 سایت آن ها <a href="%1$s" target="_blank" rel="noopener">یک
 برنامه ثبت نام کنید</a> و رمز API برنامه پوش
 آور را اینجا وارد کنید.',
        'alert_type' => 'زمان دلخواه خورد برای دریافت اطلاعیه ها را انتخاب
 کنید.',
        'alert_type_description' => '<b>تغییر وضعیت:</b> زمانی که وضعیت سرور تغییر
 کرد شما یک اطلاعیته دریافت خواهید کرد. از
 آنلاین -> آفلاین یا آفلاین -> آنلاین.<br><br
 /><b>آفلاین:</b> زمانی که یک سرور *فقط برای اولین
 بار* آفلاین شد شما یک اطلاعیه دریافت خواهید
 کرد. به عنوان مثال،cronjob شما هر 15 دقیقه است و
 سرور شما در ساعت 1 صبح دان می شود و تا ساعت 6
 صبح دان می ماند.شما 1 اطلاعیه در ساعت 1 صبح
 دریافت خواهید کرد. همین و بس!<br><b>همیشه:</b> هر
 بار که اسکریپت اجرا شود و یک سایت دان شود شما
 یک اطلاعیه دریافت خواهید کرد، حتی اگر سایت
 چند ساعت آفلاین باشد.',
        'alert_type_status' => 'تغییر وضعیت',
        'alert_type_offline' => 'آفلاین',
        'alert_type_always' => 'همیشه',
        'log_status' => 'وضعیت لاگ',
        'log_status_description' => 'اگر لاگ در وضعیت درست باشد مانیتور هر وقت که
 تنظیمات اطلاعیه ها وارد شود رویدادها را لاگ
 می کند.',
        'log_email' => 'لاگ کردن ایمیل هایی که ارسال شده توسط اسکریپت',
        'log_sms' => 'لاگ کردن پیامک های ارسال شده توسط اسکریپت',
        'log_pushover' => 'لاگ پیام های پوش آور ارسال شده توسط سرور',
        'updated' => 'پیکربندی به روز رسانی شد.',
        'tab_email' => 'ایمیل',
        'tab_sms' => 'پیامک',
        'tab_pushover' => 'پوش آور',
        'settings_email' => 'تنظیمات ایمیل',
        'settings_sms' => 'تنظیمات پیامک',
        'settings_pushover' => 'تنظیمات پوش آور',
        'settings_notification' => 'تنظیمات اطلاعیه ها',
        'settings_log' => 'تنظیمات لاگ',
        'auto_refresh' => 'رفرش خودکار',
        'auto_refresh_description' => 'رفرش خودکار صفحه سرورها.<br><span class="small">زمان
 به ثنیه, اگر 0 باشد صفحه رفرش نخواهد شد.</span>',
        'test' => 'تست',
        'test_email' => 'یک ایمیل به آدرس تعیین شده در پروفایل شما ارسال
 خواهد شد.',
        'test_sms' => 'یک پیامک به شماره تلفن تعیین شده در پروفایل شما
 ارسال خواهد شد.',
        'test_pushover' => 'یک پیام پوش آور به کلید کاربر/دستگاه تعیین شده در
 پروفایل شما ارسال خواهد شد.',
        'send' => 'ارسال',
        'test_subject' => 'تست',
        'test_message' => 'پیام تستی',
        'email_sent' => 'ایمیل ارسال شد',
        'email_error' => 'خطا در ارسال ایمیل',
        'sms_sent' => 'پیامک ارسال شد',
        'sms_error' => '%s خطا در ارسال پیامک',
        'sms_error_nomobile' => 'قادر به ارسال پیامک تستی نیستیم: شماره تلفن
 معتبر در پروفایل شما یافته نشد.',
        'pushover_sent' => 'اطلاعیه پوش آور ارسال شد.',
        'pushover_error' => 'یک خطا در هنگام ارسال اطلاعیه پوش آور رخ داده است:
 %s',
        'pushover_error_noapp' => 'قادر به ارسال اطلاعیه تستی نیستیم: رمز API
 برنامه پوش آور در پیکربندی عمومی یافته نشد.',
        'pushover_error_nokey' => 'قادر به ارسال اطلاعیه تستی نیستیم: کلید پوش
 آور در پروفایل شما یافته نشد.',
        'log_retention_period' => 'مدت زمان ذخیره سازی لاگ ها',
        'log_retention_period_description' => 'تعداد روزها برای نگهداری لاگ اطلاعیه
 ها و آرشیو های آپ تایم های سرور. برای
 غیرفعال کردن پاکسازی لاگ 0 وارد کنید.',
        'log_retention_days' => 'روزها',
    ),
    'notifications' => array(
        'off_sms' => 'Server \'%LABEL%\' دان است: آی پی=%IP%, پورت=%PORT%. خطا=%ERROR%',
        'off_email_subject' => 'مهم: سرور \'%LABEL%\' دان است',
        'off_email_body' => 'اتصال به سرور زیر با شکست مواجه شد:<br><br>سرور:
 %LABEL%<br>آی پی: %IP%<br>پورت: %PORT%<br>خطا: %ERROR%<br>تاریخ: %DATE%',
        'off_pushover_title' => 'سرور \'%LABEL%\' دان است',
        'off_pushover_message' => 'اتصال به سرور زیر با شکست مواجه شد:<br><br>سرور:
 %LABEL%<br>آی پی: %IP%<br>پورت: %PORT%<br>خطا: %ERROR%<br>تاریخ:
 %DATE%',
        'on_sms' => 'سرور \'%LABEL%\' در حال اجراست: آی پی=%IP%, پورت=%PORT%, it was down for
 %LAST_OFFLINE_DURATION%',
        'on_email_subject' => 'مهم: سرور \'%LABEL%\' در حال اجراست',
        'on_email_body' => 'سرور \'%LABEL%\' دوباره در حال اجراست, it was down for
 %LAST_OFFLINE_DURATION%:<br><br>سرور: %LABEL%<br>آی پی: %IP%<br>پورت:
 %PORT%<br>تاریخ: %DATE%',
        'on_pushover_title' => 'سرور \'%LABEL%\' در حال اجراست',
        'on_pushover_message' => 'سرور \'%LABEL%\' دوباره در حال اجراست, it was down for
 %LAST_OFFLINE_DURATION%:<br><br>سرور: %LABEL%<br>آی پی: %IP%<br>پورت:
 %PORT%<br>تاریخ: %DATE%',
    ),
    'login' => array(
        'welcome_usermenu' => 'خوش آمدید, %user_name%',
        'title_sign_in' => 'لطفا وارد شوید',
        'title_forgot' => 'کلمه عبور خود را فراموش کرده اید؟',
        'title_reset' => 'کلمه عبور خود را بازنشانی کنید',
        'submit' => 'ثبت کردن',
        'remember_me' => 'من را به خاطر بسپار',
        'login' => 'ورود',
        'logout' => 'خروج',
        'username' => 'نام کاربری',
        'password' => 'کلمه عبور',
        'password_repeat' => 'تکرار کلمه عبور',
        'password_forgot' => 'کلمه عبور خود را فراموش کرده اید؟',
        'password_reset' => 'بازنشانی کلمه عبور',
        'password_reset_email_subject' => 'کلمه عبور خود را برای مانیتور سرور PHP
 بازنشانی کنید',
        'password_reset_email_body' => 'لطفا برای بازنشانی کلمه عبور خود از این
 لینک استفاده کنید. لطفا توجه کنید تنها 1
 ساعت وقت دارید.<br><br>%link%',
        'error_user_incorrect' => 'نام کاربری ارائه شده یافته نشد.',
        'error_login_incorrect' => 'اطلاعات نادرست است.',
        'error_login_passwords_nomatch' => 'کلمه های عبور یکسان نیستند.',
        'error_reset_invalid_link' => 'لینک بازنشانی شما نامعتبر است.',
        'success_password_forgot' => 'یک ایمیل حاوی اطلاعات مورد نیاز برای
 بازنشانی کلمه عبور برای شما ارسال شد.',
        'success_password_reset' => 'کلمه عبور شما با موفقیت بازنشانی شد. لطفا
 وارد شوید.',
    ),
    'error' => array(
        '401_unauthorized' => 'غیر مجاز',
        '401_unauthorized_description' => 'شما اجازه مشاهده این صفحه را ندارید.',
    ),
);
