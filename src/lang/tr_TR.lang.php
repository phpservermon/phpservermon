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
 * @author      Haydar Kulekci <haydarkulekci@gmail.com>
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

$sm_lang = array(
    'name' => 'Türkçe - Turkish',
    'locale' => array(
        '0' => 'tr_TR.UTF-8',
        '1' => 'tr_TR',
        '2' => 'turkish',
        '3' => 'turkish-tr',
    ),
    'locale_tag' => 'tr',
    'locale_dir' => 'ltr',
    'system' => array(
        'title' => 'Server Monitor',
        'install' => 'Yükle',
        'action' => 'Aksiyon',
        'save' => 'Kaydet',
        'edit' => 'Düzenle',
        'delete' => 'Sil',
        'date' => 'Tarih',
        'message' => 'Mesaj',
        'yes' => 'Evet',
        'no' => 'Hayır',
        'insert' => 'Ekle',
        'add_new' => 'Yeni ekle',
        'update_available' => '({version}) sürümü şu anda <a
 href="https://github.com/phpservermon/phpservermon/releases/latest" target="_blank"
 rel="noopener">http://www.phpservermonitor.org</a> adresindedir.',
        'back_to_top' => 'Başa Dön',
        'go_back' => 'Geri Git',
        'ok' => 'Tamam',
        'cancel' => 'İptal',
        'short_day_format' => '%B %e',
        'long_day_format' => '%B %e, %Y',
        'yesterday_format' => 'Yesterday at %k:%M',
        'other_day_format' => '%A at %k:%M',
        'never' => 'Hiç',
        'hours_ago' => '%d saat önce',
        'an_hour_ago' => 'yaklaşık bir saat önce',
        'minutes_ago' => '%d dakika önce',
        'a_minute_ago' => 'yaklaşık bir dakika önce',
        'seconds_ago' => '%d saniye önce',
        'a_second_ago' => 'bir saniye önce',
        'seconds' => 'saniye',
    ),
    'menu' => array(
        'config' => 'Ayarlar',
        'server' => 'Sunucular',
        'server_log' => 'Log',
        'server_status' => 'Durum',
        'server_update' => 'Güncelle',
        'user' => 'Kullanıcılar',
        'help' => 'Yardım',
    ),
    'users' => array(
        'user' => 'Kullanıcı',
        'name' => 'İsim',
        'user_name' => 'Kullanıcı adı',
        'password' => 'Şifre',
        'password_repeat' => 'Şifre tekrarı',
        'password_leave_blank' => 'Değiştirmemek için boş bırakın',
        'level' => 'Seviye',
        'level_10' => 'Yönetici',
        'level_20' => 'Kullanıcı',
        'level_description' => '<b>Yöneticiler</b> tüm yetkilere sahiptir: Onlar sunucuları, kullanıcıları
 yönetebilir genel ayarlamaları düzenleyebilirler.<br> <b>Kullanıcılar</b> sadece
 görüntüleyebilir ve onlara atanmış sunucu güncelleyicileri
 çalıştırabilirler.',
        'mobile' => 'Mobil',
        'email' => 'E-posta',
        'pushover' => 'Pushover',
        'pushover_description' => 'Pushover gerçek zamanlı bildirim alabilmek için bir servistir. Daha fazla bilgi
 için <a href="https://pushover.net/" target="_blank">sitesine</a> bakabilirsiniz.',
        'pushover_key' => 'Pushover Anahtarı',
        'pushover_device' => 'Pushover Aracı',
        'pushover_device_description' => 'Mesajın gönderileceği cihazın adı. Tüm cihazlara göndermek için boş
 bırakın.',
        'delete_title' => 'Kullanıcıyı Sil',
        'delete_message' => '\'%1\' kullanıcısını silmek istediğinize emin misiniz?',
        'deleted' => 'Kullanıcı silindi.',
        'updated' => 'Kullanıcı güncellendi.',
        'inserted' => 'Kullanıcı eklendi.',
        'profile' => 'Profil',
        'profile_updated' => 'Profiliniz güncellendi.',
        'error_user_name_bad_length' => 'Kullanıcı adları en az 2 ve en fazla 64 karakter uzunluğunda olmalıdır.',
        'error_user_name_invalid' => 'Kullanıcı adları sadece harf (a-z, A-Z), sayı (0-9), noktalar (.) and alttan
 çizgi (_) karakterlerini içerebilir.',
        'error_user_name_exists' => 'Bu kullanıcı adı daha önce alınmış.',
        'error_user_email_bad_length' => 'E-posta adresi en az 5 ve en fazla 255 karakter uzunluğunda olmalıdır.',
        'error_user_email_invalid' => 'Geçersiz e-posta adresi.',
        'error_user_level_invalid' => 'Verilen kullanıcı seviyesi geçersiz.',
        'error_user_no_match' => 'Kullanıcı veritabanında bulunamadı.',
        'error_user_password_invalid' => 'Geçersiz bir şifre girdiniz.',
        'error_user_password_no_match' => 'Şifreler birbiri ile eşleşmedi.',
    ),
    'log' => array(
        'title' => 'Log Girdileri',
        'type' => 'Tip',
        'status' => 'Durum',
        'email' => 'E-posta',
        'sms' => 'SMS',
        'pushover' => 'Pushover',
        'no_logs' => 'Kayıt yok.',
        'clear' => 'Günlüğü temizle',
        'delete_title' => 'Günlüğü temizle',
        'delete_message' => 'Tüm günlükleri silmek istediğinizden emin misiniz?',
    ),
    'servers' => array(
        'server' => 'Sunucu',
        'status' => 'Durum',
        'label' => 'Etiket',
        'domain' => 'Domain/IP',
        'timeout' => 'Zaman Aşımı',
        'timeout_description' => 'Sunucunun cevap vermesini beklenecek saniye.',
        'port' => 'Port',
        'type' => 'Tip',
        'type_website' => 'Website',
        'type_service' => 'Servis',
        'pattern' => 'String/Pattern ara',
        'pattern_description' => 'Bu pattern web sitenizde bulunamaz ise, sunucu offline olarak işaretlenecek.
 Regular expression\'a izin verilmiştir.',
        'last_check' => 'Son kontrol',
        'last_online' => 'Son çevrimiçi zamanı',
        'last_offline' => 'Last offline',
        'monitoring' => 'Monitoring',
        'no_monitoring' => 'No monitoring',
        'email' => 'E-posta',
        'send_email' => 'E-posta Gönder',
        'sms' => 'SMS',
        'send_sms' => 'SMS Gönder',
        'pushover' => 'Pushover',
        'users' => 'Kullanıcılar',
        'delete_title' => 'Sunucu Sil',
        'delete_message' => '\'%1\' sunucusunu silmek istediğinize emin misiniz?',
        'deleted' => 'Sunucu silindi.',
        'updated' => 'Sunucu güncellendi.',
        'inserted' => 'Sunucu eklendi.',
        'latency' => 'Gecikme',
        'latency_max' => 'Gecikme (Azami)',
        'latency_min' => 'Gecikme (Asgari)',
        'latency_avg' => 'Gecikme (Ortalama)',
        'uptime' => 'Uptime',
        'year' => 'Yıl',
        'month' => 'Ay',
        'week' => 'Hafta',
        'day' => 'Gün',
        'hour' => 'Saat',
        'warning_threshold' => 'Uyarı Eşiği',
        'warning_threshold_description' => 'Number of failed checks required before it is marked offline.',
        'chart_last_week' => 'Geçen Hafta',
        'chart_history' => 'Geçmiş',
        'chart_day_format' => '%Y-%m-%d',
        'chart_long_date_format' => '%Y-%m-%d %H:%M:%S',
        'chart_short_date_format' => '%m/%d %H:%M',
        'chart_short_time_format' => '%H:%M',
        'warning_notifications_disabled_sms' => 'SMS bildirimi devre dışı.',
        'warning_notifications_disabled_email' => 'E-posta bildirimi devre dışı.',
        'warning_notifications_disabled_pushover' => 'Pushover bildirimi devre dışı.',
        'error_server_no_match' => 'Sunucu bulunamadı.',
        'error_server_label_bad_length' => 'Etiken en az 1 ve en çok 255 karakter olmalıdır.',
        'error_server_ip_bad_length' => 'Alan adı / IP en az 1 ve en fazla 255 karakter olmalıdır.',
        'error_server_ip_bad_service' => 'IP adresi geçerli değil.',
        'error_server_ip_bad_website' => 'Site adresi geçerli değil.',
        'error_server_type_invalid' => 'Seçilen sunucu tipi geçerli değil.',
        'error_server_warning_threshold_invalid' => 'Hata eşiği 0\'dan büyük bir tam sayı olmalıdır.',
    ),
    'config' => array(
        'general' => 'Genel',
        'language' => 'Dil',
        'show_update' => 'Güncellemeleri kontrol et?',
        'email_status' => 'E-posta gönderimine izin ver',
        'email_from_email' => 'Gönderilen e-posta adresi',
        'email_from_name' => 'E-posta adresinde görünecek isim',
        'email_smtp' => 'SMTP\'yi aktif et',
        'email_smtp_host' => 'SMTP sunucusu',
        'email_smtp_port' => 'SMTP port',
        'email_smtp_security' => 'SMTP security',
        'email_smtp_security_none' => 'None',
        'email_smtp_username' => 'SMTP kullanıcı adı',
        'email_smtp_password' => 'SMTP şifre',
        'email_smtp_noauth' => 'Doğrulama yapmamak için boş bırakın',
        'sms_status' => 'SMS mesaj göndermeye izin ver',
        'sms_gateway' => 'Mesaj göndermek için servisi seçin',
        'sms_gateway_username' => 'Servis kullanıcı adı',
        'sms_gateway_password' => 'Servis şifresi',
        'sms_from' => 'Gönderen numarası',
        'pushover_status' => 'Pushover mesaj gönderimine izin ver',
        'pushover_description' => 'Pushover gerçek zamanlı bildirim alabilmek için bir servistir. Daha fazla bilgi
 için <a href="https://pushover.net/" target="_blank">sitesine</a> bakabilirsiniz.',
        'pushover_clone_app' => 'Pushover uygulaması oluşturmak için buraya tıklayınız.',
        'pushover_api_token' => 'Pushover Uygulaması API Token Bilgisi',
        'pushover_api_token_description' => 'Pushover kullanmadan önce, <a href="%1$s" target="_blank"
 rel="noopener">Pushover sitesi üzerinden</a> bir uygulama
 oluşturmalısınız ve API Token bilgilerini buraya yazmalısınız.',
        'alert_type' => 'Ne zaman uyarılmak istediğinizi seçin.',
        'alert_type_description' => '<b>Durum değişikliği:</b> Sunucu durumu değişiklik durumunda bildirim
 alacaksınız. Sunucu çevrimiçi durumundan çevrimdışı durumuna veya
 çevrimdışı durumundan çevrim için durumuna geçtiğinde.<br><br
 /><b>Çevrimdışı:</b> Sunucu çevrim dışı duruma geçtiğinde bildirim
 alırsınız. *SADECE İLK GEÇTİĞİNDE*. Örneğin, Cronjob her 15 dakikada
 bir çalışıyorsa ve sunucu 1\'de gidip 6\'ya kadar kapalı kalırsa. Sadece
 size saat 1\'de bildirim gönderilecektir.<br><br><b>Daima:</b> Site
 çevrimdışı olduğu her zaman size bildirim gönderilecektir, site saatler
 boyunca kapalı kalse bile.',
        'alert_type_status' => 'Durum değişikliği',
        'alert_type_offline' => 'Çevrimdışı',
        'alert_type_always' => 'Daima',
        'log_status' => 'Log durumu',
        'log_status_description' => 'Eğer log durumu TRUE olarak işaretlenirse, bildirim ayarlarından geçen her
 olay log olarak tutulacaktır.',
        'log_email' => 'Log e-posta mesajı otomatik gönderilmiştir.',
        'log_sms' => 'Log sms mesajı otomatik gönderilmiştir.',
        'log_pushover' => 'Log pushover mesajı otomatik gönderilmiştir.',
        'updated' => 'Ayarlar güncellendi.',
        'tab_email' => 'E-posta',
        'tab_sms' => 'SMS',
        'tab_pushover' => 'Pushover',
        'settings_email' => 'E-posta ayarları',
        'settings_sms' => 'Sms mesaj ayarları',
        'settings_pushover' => 'Pushover ayarları',
        'settings_notification' => 'Bildirim ayarları',
        'settings_log' => 'Log ayarları',
        'auto_refresh' => 'Otomatik Yenileme',
        'auto_refresh_description' => 'Otomatik yenileme sunucu sayfası<br><span class="small">Eğer sayfa yenilenmez
 ise.</span>',
        'test' => 'Test',
        'test_email' => 'Profilinizde tanımladığınız e-posta adresinize bir e-posta gönderilecek.',
        'test_sms' => 'Profilinizde tanımladığınız numaranıza bir SMS mesajı gönderilecek.',
        'test_pushover' => 'Profilinizde tanımladığını bilgiler üzerinden bir pushover bildirimi gönderilecek.',
        'send' => 'Gönder',
        'test_subject' => 'Test',
        'test_message' => 'Test mesaj',
        'email_sent' => 'E-posta gönderildi',
        'email_error' => 'E-posta gönderiminde hata.',
        'sms_sent' => 'Sms gönderildi',
        'sms_error' => 'SMS gönderiminde hata. %s',
        'sms_error_nomobile' => 'SMS gönderilemiyor: profilinizde geçerli bir telefon numarası yok.',
        'pushover_sent' => 'Pushover bildirimi gönderildi',
        'pushover_error' => 'Pushover bildirimi gönderilirken bir hata meydana geldi: %s',
        'pushover_error_noapp' => 'Test için bildirim gönderilemiyor: Pushover Uygulaması API token bilgisi
 bulunamadı.',
        'pushover_error_nokey' => 'Test için bildirim gönderilemiyor: Pushover key bilgisi profilinizde bulunamadı.',
        'log_retention_period' => 'Log tutma süresi',
        'log_retention_period_description' => 'Bildirim loglarının ve sunucunun çalışma zamanlarının arşivinin
 saklanması için gün sayısı. Logların temizlenmesini kapatmak
 için 0 giriniz.',
        'log_retention_days' => 'gün',
    ),
    'notifications' => array(
        'off_sms' => '\'%LABEL%\' isimli sunucu KAPANDI: ip=%IP%, port=%PORT%. Error=%ERROR%',
        'off_email_subject' => 'ÖNEMLİ: \'%LABEL%\' isimli sunucu KAPANDI.',
        'off_email_body' => 'Aşağıdaki sunuculara erişim sağlanamıyor:<br><br>Sunucu: %LABEL%<br>IP:
 %IP%<br>Port: %PORT%<br>Hata: %ERROR%<br>Tarih: %DATE%',
        'off_pushover_title' => '\'%LABEL%\' isimli sunucu KAPANDI.',
        'off_pushover_message' => 'Aşağıdaki nuculara erişim sağlanamıyor:<br><br>Sunucu: %LABEL%<br>IP:
 %IP%<br>Port: %PORT%<br>Hata: %ERROR%<br>Tarih: %DATE%',
        'on_sms' => '\'%LABEL%\' isimli sunucu YAYINDA: ip=%IP%, port=%PORT%, it was down for %LAST_OFFLINE_DURATION%',
        'on_email_subject' => 'ÖNEMLİ:\'%LABEL%\' isimli sunucu YAYINDA.',
        'on_email_body' => '\'%LABEL%\' isimli sunucu tekrar yayında, it was down for
 %LAST_OFFLINE_DURATION%:<br><br>Sunucu: %LABEL%<br>IP: %IP%<br>Port: %PORT%<br>Tarih:
 %DATE%',
        'on_pushover_title' => '\'%LABEL%\' isimli sunucu YAYINDA',
        'on_pushover_message' => '\'%LABEL%\' isimli sunucu tekrar yayında, it was down for
 %LAST_OFFLINE_DURATION%:<br><br>Sunucu: %LABEL%<br>IP: %IP%<br>Port:
 %PORT%<br>Tarih: %DATE%',
    ),
    'login' => array(
        'welcome_usermenu' => 'Hoşgeldin, %user_name%',
        'title_sign_in' => 'Lütfen giriş yapın',
        'title_forgot' => 'Şifreni mi unuttun?',
        'title_reset' => 'Şifreni yenile',
        'submit' => 'Gönder',
        'remember_me' => 'Beni hatırla',
        'login' => 'Giriş yap',
        'logout' => 'Çıkış yap',
        'username' => 'Kullanıcı adı',
        'password' => 'Şifre',
        'password_repeat' => 'Şifre tekrarı',
        'password_forgot' => 'Şifreni mi unuttun?',
        'password_reset' => 'Şifreni yenile',
        'password_reset_email_subject' => 'PHP Server Monitor için şifreni yenile',
        'password_reset_email_body' => 'Aşağıdaki bağlantıyı kullanarak şifrenizi güncelleyiniz. Bağlantı 1
 saat sonra geçerliliğini kaybedecektir.<br><br>%link%',
        'error_user_incorrect' => 'Kullanıcı adı bulunamadı.',
        'error_login_incorrect' => 'Bilgi yanlış.',
        'error_login_passwords_nomatch' => 'Şifreleriniz uyuşmuyor.',
        'error_reset_invalid_link' => 'Sağladığını sıfırlama bağlantısı geçersiz.',
        'success_password_forgot' => 'Şifrenizi yenilemeniz için gerekli bilgileri içeren bir e-posta gönderildi.',
        'success_password_reset' => 'Şifreniz başarıyla yenilendi. Şimdi giriş yapın.',
    ),
    'error' => array(
        '401_unauthorized' => 'Yetkisiz',
        '401_unauthorized_description' => 'Bu sayfayı görüntülemek için yetkin yok.',
    ),
);
