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
 * @author      Loi Le <lploi91@gmail.com>
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

$sm_lang = array(
    'name' => 'Tiếng Việt - Vietnamese',
    'locale' => array(
        '0' => 'vi_VN.UTF-8',
        '1' => 'vi_VN',
        '2' => 'Việt Nam',
    ),
    'system' => array(
        'title' => 'Server Monitor',
        'install' => 'Cài đặt',
        'action' => 'Hành động',
        'save' => 'Lưu',
        'edit' => 'Sửa',
        'delete' => 'Xóa',
        'date' => 'Ngày',
        'message' => 'Message',
        'yes' => 'Yes',
        'no' => 'No',
        'insert' => 'Thêm mới',
        'add_new' => 'Thêm mới',
        'update_available' => 'Phiên bản mới ({version}) có săn trên <a
 href="https://github.com/phpservermon/phpservermon/releases/latest" target="_blank"
 rel="noopener">http://www.phpservermonitor.org</a>.',
        'back_to_top' => 'Lên đầu trang',
        'go_back' => 'Quay lại',
        'ok' => 'OK',
        'cancel' => 'Cancel',
        'short_day_format' => '%B %e',
        'long_day_format' => '%B %e, %Y',
        'yesterday_format' => 'Yesterday at %k:%M',
        'other_day_format' => '%A at %k:%M',
        'never' => 'Never',
        'hours_ago' => '%d giờ trước',
        'an_hour_ago' => 'khoảng một giờ trước',
        'minutes_ago' => '%d phút trước',
        'a_minute_ago' => 'khoảng một phút trước',
        'seconds_ago' => '%d giây trước',
        'a_second_ago' => 'một giây trước',
        'seconds' => 'giây',
    ),
    'menu' => array(
        'config' => 'Cấu hình',
        'server' => 'Servers',
        'server_log' => 'Log',
        'server_status' => 'Trạng thái',
        'server_update' => 'Cập nhật',
        'user' => 'Người dùng',
        'help' => 'Giúp đỡ',
    ),
    'users' => array(
        'user' => 'Người dùng',
        'name' => 'Tên',
        'user_name' => 'Tên đăng nhập',
        'password' => 'Mật khẩu',
        'password_repeat' => 'Nhập lại mật khẩu',
        'password_leave_blank' => 'Leave blank to keep unchanged',
        'level' => 'Cấp độ',
        'level_10' => 'Administrator',
        'level_20' => 'User',
        'level_description' => '<b>Administrators</b> có toàn quyền: họ có thể quản lý server, người
 dùng và chỉnh sửa cấu hình.<br><b>Users</b> chỉ xem và chạy cập nhật
 cho servers được giao cho họ.',
        'mobile' => 'Di động',
        'email' => 'Email',
        'pushover' => 'Pushover',
        'pushover_description' => 'Pushover là một dịch vụ dễ dàng nhận các thông báo theo thời gian
 thực. Xem <a href="https://pushover.net/" target="_blank">website của họ</a>
 để biết thêm thông tin.',
        'pushover_key' => 'Pushover Key',
        'pushover_device' => 'Pushover Device',
        'pushover_device_description' => 'Tên thiết bị để gửi tin nhắn đến. Để trống để gửi
 cho tất cả các thiết bị.',
        'delete_title' => 'Xóa Người dùng',
        'delete_message' => 'Bạn có chắc chắn xóa người dùng \'%1\'?',
        'deleted' => 'Đã xóa người dùng.',
        'updated' => 'Đã cập nhật người dùng.',
        'inserted' => 'Đã thêm người dùng.',
        'profile' => 'Hồ sơ',
        'profile_updated' => 'Hồ sơ của bạn đã được cập nhật.',
        'error_user_name_bad_length' => 'Tên người dùng phải có từ 2 và 64 ký tự.',
        'error_user_name_invalid' => 'Tên người dùng chỉ có thể chứa các chữ cái(a-z, A-Z), số
 (0-9), dấu chấm (.) và dấu gạch dưới (_).',
        'error_user_name_exists' => 'Tên người dùng đã tồn tại trong cơ sở dữ liệu.',
        'error_user_email_bad_length' => 'Địa chỉ email phải từ 5 đến 255 ký tự.',
        'error_user_email_invalid' => 'Địa chỉ email không hợp lệ.',
        'error_user_level_invalid' => 'Cấp độ người dùng không hợp lệ.',
        'error_user_no_match' => 'Người dùng không tìm thấy trong cơ sở dữ liệu.',
        'error_user_password_invalid' => 'Đặt mật khẩu không hợp lệ.',
        'error_user_password_no_match' => 'Các mật khẩu không khớp.',
    ),
    'log' => array(
        'title' => 'Log entries',
        'type' => 'Loại',
        'status' => 'Trạng thái',
        'email' => 'Email',
        'sms' => 'SMS',
        'pushover' => 'Pushover',
        'no_logs' => 'No logs',
        'clear' => 'Xoá nhật ký',
        'delete_title' => 'Xoá nhật ký',
        'delete_message' => 'Bạn có chắc chắn muốn xóa <b>tất</b> cả các bản ghi?',
    ),
    'servers' => array(
        'server' => 'Server',
        'status' => 'Trạng thái',
        'label' => 'Nhãn',
        'domain' => 'Domain/IP',
        'timeout' => 'Timeout',
        'timeout_description' => 'Số giây để đợi máy chủ phản hồi.',
        'port' => 'Cổng',
        'type' => 'Loại',
        'type_website' => 'Website',
        'type_service' => 'Dịch vụ',
        'pattern' => 'Tìm kiếm chuỗi/mẫu',
        'pattern_description' => 'Nếu mẫu không tìm thấy trên website, server sẽ được đánh dấu là
 offline. Biểu thức chính quy (Regular expressions) được cho phép.',
        'last_check' => 'Kiểm tra lần cuối',
        'last_online' => 'Trực tuyến lần cuối',
        'monitoring' => 'Giám sát',
        'no_monitoring' => 'Không giám sát',
        'email' => 'Email',
        'send_email' => 'Gửi Email',
        'sms' => 'SMS',
        'send_sms' => 'Gửi SMS',
        'pushover' => 'Pushover',
        'users' => 'Người dùng',
        'delete_title' => 'Xóa server',
        'delete_message' => 'Bạn có chắt chắn xóa server \'%1\'?',
        'deleted' => 'Đã xóa server.',
        'updated' => 'Đã cập nhật server.',
        'inserted' => 'Đã thêm server.',
        'latency' => 'Độ trễ',
        'latency_max' => 'Độ trễ (cao nhất)',
        'latency_min' => 'Độ trễ (thấp nhất)',
        'latency_avg' => 'Độ trễ (trung bình)',
        'uptime' => 'Thời gian hoạt động',
        'year' => 'Năm',
        'month' => 'Tháng',
        'week' => 'Tuần',
        'day' => 'Ngày',
        'hour' => 'Giờ',
        'warning_threshold' => 'Ngưỡng cảnh báo',
        'warning_threshold_description' => 'Số lần kiểm tra thất bại trước khi đánh đấu là offline.',
        'chart_last_week' => 'Tuần trước',
        'chart_history' => 'Lịch sử',
        'chart_day_format' => '%Y-%m-%d',
        'chart_long_date_format' => '%Y-%m-%d %H:%M:%S',
        'chart_short_date_format' => '%m/%d %H:%M',
        'chart_short_time_format' => '%H:%M',
        'warning_notifications_disabled_sms' => 'SMS thông báo bị vô hiệu hóa.',
        'warning_notifications_disabled_email' => 'Email thông báo bị vô hiệu hóa.',
        'warning_notifications_disabled_pushover' => 'Pushover thông báo bị vô hiệu hóa.',
        'error_server_no_match' => 'Không tìm thấy server.',
        'error_server_label_bad_length' => 'Nhãn phải có từ 1 đến 255 ký tự.',
        'error_server_ip_bad_length' => 'The domain / IP Nhãn phải có từ 1 đến 255 ký tự.',
        'error_server_ip_bad_service' => 'Địa chỉ IP không hợp lệ.',
        'error_server_ip_bad_website' => 'URL website không hợp lệ.',
        'error_server_type_invalid' => 'Chọn loại server không hợp lệ.',
        'error_server_warning_threshold_invalid' => 'Ngưỡng cảnh báo phải là một số nguyên có giá
 trị lớn hơn 0.',
    ),
    'config' => array(
        'general' => 'Tổng quát',
        'language' => 'Ngôn ngữ',
        'show_update' => 'Kiểm tra cập nhật?',
        'email_status' => 'Cho phép gửi email',
        'email_from_email' => 'Gửi email từ địa chỉ',
        'email_from_name' => 'Tên địa chỉ mail',
        'email_smtp' => 'Enable SMTP',
        'email_smtp_host' => 'SMTP host',
        'email_smtp_port' => 'SMTP port',
        'email_smtp_security' => 'SMTP security',
        'email_smtp_security_none' => 'None',
        'email_smtp_username' => 'SMTP username',
        'email_smtp_password' => 'SMTP password',
        'email_smtp_noauth' => 'Để trống nếu không có chứng thực',
        'sms_status' => 'Cho phép gửi tin nhắn văn bản',
        'sms_gateway' => 'Gateway sử dụng để gửi tin nhắn',
        'sms_gateway_username' => 'Gateway username',
        'sms_gateway_password' => 'Gateway password',
        'sms_from' => 'Số điện thoại của người gửi',
        'pushover_status' => 'Cho phép gửi tin nhắn bằng Pushover',
        'pushover_description' => 'Pushover là một dịch vụ dễ dàng nhận các thông báo theo thời gian
 thực. Xem <a href="https://pushover.net/" target="_blank">website của họ</a>
 để biết thêm thông tin.',
        'pushover_clone_app' => 'Nhấn vào đây để tạo ứng dụng Pushover của bạn',
        'pushover_api_token' => 'Pushover App API Token',
        'pushover_api_token_description' => 'Trước khi bạn có thể sử dụng Pushover, bạn cần phải <a
 href="%1$s" target="_blank" rel="noopener">đăng ký một ứng
 dụng</a> tại trang web của họ và nhập Token App API ở đây.',
        'alert_type' => 'Chọn khi bạn muốn được thông báo.',
        'alert_type_description' => '<b>Thay đổi trạng thái:</b> Bạn sẽ nhận được thông báo khi
 một máy chủ có một sự thay đổi trạng thái. Từ online -> offline
 hoặc offline -> online.<br><br /><b>Offline:</b> Bạn sẽ nhận được
 thông báo khi một máy chủ offline *MỘT LẦN DUY NHẤT*. Ví dụ,
 cronjob của bạn hoạt động mỗi 15 phút và server của bạn down
 tại 01h00 cho đến 6h00. Bạn sẽ nhận được 1 thông báo lúc 01h00
 và đó là nó.<br><br><b>Always:</b> Bạn sẽ nhận được thông báo
 mỗi khi chạy đoạn script và một trang web tắt, ngay cả khi trang
 web đã được offline trong nhiều giờ.',
        'alert_type_status' => 'Thay đổi trạng thái',
        'alert_type_offline' => 'Offline',
        'alert_type_always' => 'Always',
        'log_status' => 'Log status',
        'log_status_description' => 'Nếu log status được đặt là TRUE, màn hình sẽ đăng sự kiện
 này bất cứ khi nào các thiết lập thông báo được truyền.',
        'log_email' => 'Log emails gửi bởi script',
        'log_sms' => 'Log Tin nhăn văn bản gửi bởi script',
        'log_pushover' => 'Log tin nhắn pushover gửi bởi script',
        'updated' => 'Cấu hình đã được cập nhật.',
        'tab_email' => 'Email',
        'tab_sms' => 'SMS',
        'tab_pushover' => 'Pushover',
        'settings_email' => 'Thiết lặp email',
        'settings_sms' => 'Thiết lập tin nhăn văn bản',
        'settings_pushover' => 'Thiết lặp Pushover',
        'settings_notification' => 'Thiết lặp thông báo',
        'settings_log' => 'Thiết lặp Log',
        'auto_refresh' => 'Tự động làm mới',
        'auto_refresh_description' => 'Tự động làm mới servers page.<br><span class="small">Trong vài giây,
 nếu 0 trang sẽ không làm mới.</span>',
        'test' => 'Thử',
        'test_email' => 'Một email sẽ được gửi đến địa chỉ được xác định trong hồ sơ
 người dùng của bạn.',
        'test_sms' => 'Một SMS sẽ được gửi đến địa chỉ được xác định trong hồ sơ người
 dùng của bạn.',
        'test_pushover' => 'Một thông báo Pushover sẽ được gửi đến địa chỉ được xác định
 trong hồ sơ người dùng của bạn.',
        'send' => 'Gửi',
        'test_subject' => 'Thử nghiệm',
        'test_message' => 'tin nhắn thử nghiệm',
        'email_sent' => 'Gửi email',
        'email_error' => 'Lỗi trong khi gửi mail',
        'sms_sent' => 'Gửi SMS',
        'sms_error' => 'Lỗi trong khi gửi sms. %s',
        'sms_error_nomobile' => 'Không thể gửi thử SMS: không có số điện thoại hợp lệ được
 tìm thấy trong hồ sơ của bạn.',
        'pushover_sent' => 'Gửi thông báo Pushover',
        'pushover_error' => 'Một lỗi đã xảy ra trong khi gửi thông báo Pushover: %s',
        'pushover_error_noapp' => 'Không thể gửi thử thông báo: không tìm thấy Pushover App API token
 trong cấu hình.',
        'pushover_error_nokey' => 'Không thể gửi thử thông báo: không tìm thấy Pushover key trong hồ
 sơ của bạn.',
        'log_retention_period' => 'Thời gian lưu giữ log',
        'log_retention_period_description' => 'Số ngày để giữ các bản ghi của các thông báo và tài
 liệu lưu trữ của thời gian hoạt động máy chủ. Nhập 0
 để vô hiệu hóa dọn dẹp log.',
        'log_retention_days' => 'ngày',
    ),
    'notifications' => array(
        'off_sms' => 'Server \'%LABEL%\' is DOWN: ip=%IP%, cổng=%PORT%. Lỗi=%ERROR%',
        'off_email_subject' => 'IMPORTANT: Server \'%LABEL%\' is DOWN',
        'off_email_body' => 'Không thể kết nối đến máy chủ sau:<br><br>Server: %LABEL%<br>IP:
 %IP%<br>Cổng: %PORT%<br>Lỗi: %ERROR%<br>Thời gian: %DATE%',
        'off_pushover_title' => 'Server \'%LABEL%\' is DOWN',
        'off_pushover_message' => 'Không thể kết nối đến máy chủ:<br><br>Server: %LABEL%<br>IP:
 %IP%<br>Cổng: %PORT%<br>Lỗi: %ERROR%<br>Thời gian: %DATE%',
        'on_sms' => 'Server \'%LABEL%\' is RUNNING: ip=%IP%, port=%PORT%, it was down for %LAST_OFFLINE_DURATION%',
        'on_email_subject' => 'IMPORTANT: Server \'%LABEL%\' hoạt động',
        'on_email_body' => 'Server \'%LABEL%\' hoạt động lại, it was down for
 %LAST_OFFLINE_DURATION%:<br><br>Server: %LABEL%<br>IP: %IP%<br>Cổng: %PORT%<br>Thời
 gian: %DATE%',
        'on_pushover_title' => 'Server \'%LABEL%\' hoạt động',
        'on_pushover_message' => 'Server \'%LABEL%\' hoạt động lại, it was down for
 %LAST_OFFLINE_DURATION%:<br><br>Server: %LABEL%<br>IP: %IP%<br>Cổng:
 %PORT%<br>Thời gian: %DATE%',
    ),
    'login' => array(
        'welcome_usermenu' => 'Chào mừng, %user_name%',
        'title_sign_in' => 'Vui lòng đăng nhập',
        'title_forgot' => 'Quên mật khẩu?',
        'title_reset' => 'Khôi phục mật khẩu',
        'submit' => 'Gửi',
        'remember_me' => 'Ghi nhớ tôi',
        'login' => 'Đăng nhập',
        'logout' => 'Đăng xuất',
        'username' => 'Tên đăng nhập',
        'password' => 'Mật khẩu',
        'password_repeat' => 'Nhập lại mật khẩu',
        'password_forgot' => 'Quên mật khẩu?',
        'password_reset' => 'Khôi phục mật khẩu',
        'password_reset_email_subject' => 'Khôi phục lại mật khẩu của bạn cho PHP Server Monitor',
        'password_reset_email_body' => 'Vui lòng sử dụng liên kết sau đây để thiết lập lại mật
 khẩu của bạn. Xin lưu ý nó hết hạn trong 1 giờ.<br><br>%link%',
        'error_user_incorrect' => 'Tên người dùng cung cấp không thể tìm thấy.',
        'error_login_incorrect' => 'Thông tin không đúng.',
        'error_login_passwords_nomatch' => 'Mật khẩu được cung cấp không phù hợp.',
        'error_reset_invalid_link' => 'Liên kết đặt lại mà bạn cung cấp không hợp lệ.',
        'success_password_forgot' => 'Một email đã được gửi đến bạn với thông tin làm thế nào
 để khôi phục lại mật khẩu của bạn.',
        'success_password_reset' => 'Mật khẩu bạn được khôi phục thành công. Vui lòng đăng nhập.',
    ),
    'error' => array(
        '401_unauthorized' => 'Không được phép',
        '401_unauthorized_description' => 'Bạn không có quyền xem trang này.',
    ),
);
