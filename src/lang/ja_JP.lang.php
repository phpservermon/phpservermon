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
 * @version     Release: v3.2.0
 * @link        http://www.phpservermonitor.org/
 **/

$sm_lang = array(
    'name' => '日本語 - Japanese',
    'locale' => array(
        '0' => 'ja_JP.UTF-8',
        '1' => 'ja_JP',
        '2' => 'Japan',
        '3' => 'Japanese',
    ),
    'locale_tag' => 'ja',
    'locale_dir' => 'ltr',
    'system' => array(
        'title' => 'サーバーモニター',
        'install' => 'インストール',
        'action' => 'アクション',
        'save' => 'セーブ',
        'edit' => '編集',
        'delete' => '削除',
        'date' => '日時',
        'message' => 'メッセージ',
        'yes' => 'はい',
        'no' => 'いいえ',
        'insert' => '挿入',
        'add_new' => '新規に追加',
        'update_available' => '新しいバージョン({version})
 がリリースされています。ここから入手可能です： <a
 href="https://github.com/phpservermon/phpservermon/releases/latest" target="_blank"
 rel="noopener">http://www.phpservermonitor.org</a>.',
        'back_to_top' => 'トップに戻る',
        'go_back' => '戻る',
        'ok' => 'OK',
        'bad' => 'よくない',
        'cancel' => 'キャンセル',
        'none' => 'なし',
        'activate' => '有効化',
        'short_day_format' => '%B %e',
        'long_day_format' => '%B %e, %Y',
        'yesterday_format' => '昨日の %k:%M',
        'other_day_format' => '%A の %k:%M',
        'never' => 'なし',
        'hours_ago' => '%d 時間前',
        'an_hour_ago' => '1時間くらい前',
        'minutes_ago' => '%d 分前',
        'a_minute_ago' => '1分くらい前',
        'seconds_ago' => '%d 秒前',
        'a_second_ago' => '＜1秒',
        'year' => '年',
        'years' => '年',
        'month' => '月',
        'months' => '月',
        'day' => '日',
        'days' => '日',
        'hour' => '時間',
        'hours' => '時間',
        'minute' => '分',
        'minutes' => '分',
        'second' => '秒',
        'seconds' => '秒',
    ),
    'menu' => array(
        'config' => '設定',
        'server' => 'サーバー',
        'server_log' => 'ログ',
        'server_status' => 'ステータス',
        'server_update' => 'アップデート',
        'user' => 'ユーザー',
        'help' => 'ヘルプ',
    ),
    'users' => array(
        'user' => 'ユーザー',
        'name' => '名前',
        'user_name' => 'ユーザーネーム',
        'password' => 'パスワード',
        'password_repeat' => 'パスワードを繰り返す',
        'password_leave_blank' => '空白のままにしておく',
        'level' => 'レベル',
        'level_10' => '管理者(Administrator)',
        'level_20' => 'ユーザー(User)',
        'level_description' => '<b>管理者(Administrator)</b>
 はフルアクセス権があります：サーバーの管理、
 ユーザーとグローバル設定を変更できます。<br><b>ユーザー(Users)</b>は、割り当てられたサーバーのアップデータのみを表示して実行できます。',
        'mobile' => 'モバイル',
        'email' => 'メールアドレス',
        'pushover' => 'Pushover',
        'pushover_description' => 'Pushoverサービスは、リアルタイムで通知を受け取るのが簡単にできます。詳細についてはこちらをご覧ください：
 <a href="https://pushover.net/" target="_blank"
 rel="noopener">https://pushover.net/</a>',
        'pushover_key' => 'Pushoverキー',
        'pushover_device' => 'Pushoverデバイス',
        'pushover_device_description' => '指定したデバイスに送信します。空欄ですべてのデバイスに送信できます。',
        'telegram' => 'Telegram',
        'telegram_description' => '<a href="https://telegram.org/" target="_blank" rel="noopener">Telegram</a>
 はチャットアプリで、簡単にリアルタイム通知を受け取ることができます。
 <a href="http://docs.phpservermonitor.org/" target="_blank"
 rel="noopener">ドキュメント</a>
 で詳しい情報、インストールの方法を知りましょう。',
        'telegram_chat_id' => 'Telegram チャットID',
        'telegram_chat_id_description' => 'メッセージは対応するチャットへ送信されます。',
        'telegram_get_chat_id' => 'ここをクリックしてあなたのチャットIDを取得します。',
        'activate_telegram' => 'Telegramの通知を有効化',
        'activate_telegram_description' => '指定されたチャットIDにTelegram通知を送信できるようにします。
 この許可がなければ、Telegramはあなたに通知を送信することができません。',
        'telegram_bot_username_found' => 'ボットが見つかりました！<br><a href="%s" target="_blank"><button
 class="btn btn-primary">次のステップ</button></a>
 <br>これにより、ボットとあなたのチャットが開かれます。ここであなたは、
 /start を入力する必要があります。',
        'telegram_bot_username_error_token' => '401 - 未認証。
 APIトークンが有効であることを確認してください。',
        'telegram_bot_error' => 'Telegram通知を有効化中にエラーが発生: %s',
        'delete_title' => 'ユーザーを削除',
        'delete_message' => '本当にユーザーを削除しますか？： \'%1\'?',
        'deleted' => 'ユーザーを削除しました。',
        'updated' => 'ユーザー情報を更新しました。',
        'inserted' => 'ユーザーを追加しました。',
        'profile' => 'プロフィール',
        'profile_updated' => 'あなたのプロフィールは更新されました。',
        'error_user_name_bad_length' => 'ユーザーネームは2～64文字以内で入力してください。',
        'error_user_name_invalid' => 'ユーザー名は、アルファベット、数字とアンダーバーのみを含むことができます
 ドット（.）。',
        'error_user_name_exists' => '登録しようとしたユーザー名は既にデータベースに登録されています。',
        'error_user_email_bad_length' => 'メールアドレスは5～255文字以内で入力してください。',
        'error_user_email_invalid' => 'メールアドレスが無効です。',
        'error_user_level_invalid' => '指定したレベルが無効です。',
        'error_user_no_match' => 'このユーザー名は存在しません。',
        'error_user_password_invalid' => 'パスワードが無効です。',
        'error_user_password_no_match' => '確認のパスワードが一致しません。',
    ),
    'log' => array(
        'title' => 'ログエントリー',
        'type' => 'タイプ',
        'status' => 'ステータス',
        'email' => 'メール',
        'sms' => 'SMS',
        'pushover' => 'Pushover',
        'telegram' => 'Telegram',
        'no_logs' => 'ログがありません',
        'clear' => 'ログをクリアする',
        'delete_title' => 'ログを削除する',
        'delete_message' => 'すべてのログを削除してもよろしいですか？',
    ),
    'servers' => array(
        'server' => 'サーバー',
        'status' => 'ステータス',
        'label' => 'ラベル',
        'domain' => 'ドメイン/IP',
        'timeout' => 'タイムアウト',
        'timeout_description' => '指定した秒数、サーバーのレスポンスを待ちます。',
        'authentication_settings' => '認証設定',
        'optional' => 'オプション',
        'website_username' => 'ユーザー名',
        'website_username_description' => 'ユーザー名でウェブサイトにアクセスします。
 (サポートはApache認証のみです。)',
        'website_password' => 'パスワード',
        'website_password_description' => 'パスワードはサイトのアクセスに使用します。パスワードは暗号化されてデータベースへ保存されます。',
        'fieldset_monitoring' => 'モニター',
        'fieldset_permissions' => '権限',
        'port' => 'ポート',
        'custom_port' => 'カスタムポート',
        'popular_ports' => '主要なポート',
        'request_method' => 'リクエストメソッド',
        'custom_request_method' => 'カスタムリクエストメソッド',
        'popular_request_methods' => '主要なリクエストメソッド',
        'post_field' => 'Postフィールド',
        'post_field_description' => 'このデータは上記のリクエストメソッドを使用する際に使用されます。
 例: param1=val1&amp;param2=val2&...',
        'please_select' => '選択してください',
        'type' => 'タイプ',
        'type_website' => 'ウェブサイト',
        'type_service' => 'サービス',
        'type_ping' => 'Ping',
        'pattern' => '文字列/パターンを検索',
        'pattern_description' => '指定した文字列/パターンが存在しない場合は、「オフライン」としてマークされます。また、標準的な計算式は許可されています。',
        'pattern_online' => 'パターンがウェブサイトであることを示すパターン: ',
        'pattern_online_description' => 'オンライン：このパターンがWebサイトにある場合、オンラインとしてマークされます。
 オフライン：このパターンがWebサイトにない場合、オフラインとしてマークされます。',
        'redirect_check' => '別のドメインへのリダイレクト: ',
        'redirect_check_description' => '別のドメインにリダイレクトするのは通常は悪い兆候です。',
        'allow_http_status' => 'HTTPステータスコードを許可する',
        'allow_http_status_description' => 'ウェブサイトをオンラインにマークします。
 400未満のステータスコードはデフォルトでオンラインとマークされます。
 | で区切ります。 例: 401|403.',
        'header_name_description' => 'ヘッダー名(大文字小文字を区別します)',
        'header_value_description' => 'ヘッダーの値。正規表現が利用可能です。',
        'last_check' => '最後の確認',
        'last_online' => '最後のオンライン',
        'last_offline' => '最後のオフライン',
        'last_output' => '最後のポジティブの出力',
        'last_error' => '最後のエラー',
        'last_error_output' => '最後のエラー出力',
        'monitoring' => 'モニタリング',
        'no_monitoring' => 'モニタリングなし',
        'email' => 'メール',
        'send_email' => 'メールを送信',
        'sms' => 'SMS',
        'send_sms' => 'SMSを送信',
        'pushover' => 'Pushover',
        'send_pushover' => 'Pushover通知を送信',
        'telegram' => 'Telegram',
        'send_telegram' => 'Telegram通知を送信',
        'users' => 'ユーザー',
        'delete_title' => 'サーバーを削除',
        'delete_message' => '本当にこのサーバーを削除しますか？： \'%1\'?',
        'deleted' => 'サーバーを削除しました。',
        'updated' => 'サーバーを更新しました。',
        'inserted' => 'サーバーを追加しました。',
        'latency' => 'レイテンシ',
        'latency_max' => 'レイテンシ(最大)',
        'latency_min' => 'レイテンシ(最小)',
        'latency_avg' => 'レイテンシ(アベレージ)',
        'uptime' => '稼働時間',
        'year' => '年',
        'month' => '月',
        'week' => '週間',
        'day' => '日',
        'hour' => '時間',
        'warning_threshold' => '警告閾値',
        'warning_threshold_description' => 'オフラインとしてマークされる前に失敗したチェックの数',
        'chart_last_week' => '最後の週間',
        'chart_history' => '履歴',
        'chart_day_format' => '%Y-%m-%d',
        'chart_long_date_format' => '%Y-%m-%d %H:%M:%S',
        'chart_short_date_format' => '%m/%d %H:%M',
        'chart_short_time_format' => '%H:%M',
        'warning_notifications_disabled_sms' => 'SMS 通知は無効です。',
        'warning_notifications_disabled_email' => 'メール通知は無効です。',
        'warning_notifications_disabled_pushover' => 'Pushover通知は無効です。',
        'warning_notifications_disabled_telegram' => 'Telegram通知は無効です。',
        'error_server_no_match' => 'サーバーが見つかりません',
        'error_server_label_bad_length' => 'ラベルは1～255文字以内で入力してください。',
        'error_server_ip_bad_length' => 'ドメイン/IPは1～255文字以内で入力してください。',
        'error_server_ip_bad_service' => '無効なIPです。',
        'error_server_ip_bad_website' => 'ウェブサイトのURLが無効です。',
        'error_server_type_invalid' => '選択されたサーバータイプが無効です。',
        'error_server_warning_threshold_invalid' => '警告のしきい値は、0より大きい有効な整数でなければなりません。',
    ),
    'config' => array(
        'general' => '基本',
        'language' => '言語',
        'show_update' => 'アップデートをチェックしますか？',
        'password_encrypt_key' => '暗号鍵パスワード',
        'password_encrypt_key_note' => 'このキーは、Webサイトにアクセスするためにサーバーに保存されているパスワードを暗号化するために使用されます。
 キーが変更された場合、保存されたパスワードは無効です！',
        'proxy' => 'プロキシを有効化する',
        'proxy_url' => 'プロキシのURL',
        'proxy_user' => 'プロキシのユーザー名',
        'proxy_password' => 'プロキシのパスワード',
        'email_status' => 'メールの送信を許可',
        'email_from_email' => 'アドレスからのメール',
        'email_from_name' => '名前からのメール',
        'email_smtp' => 'SMTPを有効にしますか？',
        'email_smtp_host' => 'SMTPホスト',
        'email_smtp_port' => 'SMTPポート',
        'email_smtp_security' => 'SMTPセキュリティ',
        'email_smtp_security_none' => 'なし',
        'email_smtp_username' => 'SMTPのユーザー名',
        'email_smtp_password' => 'SMTPのパスワード',
        'email_smtp_noauth' => '空白で認証なしになります',
        'sms_status' => 'テキストメッセージの送信を許可する',
        'sms_gateway' => 'このゲートウェイは、メッセージの送信に使用されます。',
        'sms_gateway_username' => 'ゲートウェイのユーザー名',
        'sms_gateway_password' => 'ゲートウェイのパスワード',
        'sms_from' => '送信者の電話番号:',
        'pushover_status' => 'Pushoverのメッセージを送信することを許可する',
        'pushover_description' => 'Pushoverは、リアルタイムの通知を簡単に取得できるサービスです。
 詳細については、   
 href="https://pushover.net/">ウェブサイト</a>をご覧ください。',
        'pushover_clone_app' => 'クリックでPushoverアプリケーションを作成できます。',
        'pushover_api_token' => 'PushoverアプリケーションのAPIトークン',
        'pushover_api_token_description' => 'Pushoverを使用するには、事前にウェブサイトで<a
 href="%1$s" target="_blank"
 rel="noopener">アプリを登録</a>してApp
 APIトークンを入力する必要があります。',
        'telegram_status' => 'Telegramメッセージの送信を許可する',
        'telegram_description' => '<a href="https://telegram.org/" target="_blank" rel="noopener">Telegram</a>
 はチャットアプリで、簡単にリアルタイム通知を受け取ることができます。
 <a href="http://docs.phpservermonitor.org/" target="_blank"
 rel="noopener">documentation</a>
 で詳しい情報、インストールの方法を知りましょう。',
        'telegram_api_token' => 'Telegram APIトークン',
        'telegram_api_token_description' => 'Telegramを使用する前に、APIトークンを取得する必要があります。
 <a href="http://docs.phpservermonitor.org/" target="_blank"
 rel="noopener">documentation</a>
 でヘルプを参照してください。',
        'alert_type' => '通知するタイミングを選択',
        'alert_type_description' => '<b>状態の変化:</b>
 サーバーのステータスが変更されたときに通知を受け取ります。
 だからオンライン -> オフラインまたはオフライン ->
 オンライン。<br><br /><b>オフライン:</b>
 サーバーが*初めての間*オフラインになったときに通知を受け取ります。
 例えば、あなたのcronの仕事は15分ごとです。あなたのサーバーは午前1時にダウンし、午前6時まで停止します。
 午前1時に1つの通知が届きます。<br><br><b>常に:</b>
 サイトが数時間にわたってオフラインになっていても、スクリプトが実行され、サイトが停止するたびに通知を受け取ります。',
        'alert_type_status' => '状況の変化',
        'alert_type_offline' => 'オフライン',
        'alert_type_always' => '常に',
        'combine_notifications' => '通知の結合',
        'combine_notifications_description' => '通知を1つの通知にまとめて通知の量を削減します。(これはSMS通知には影響しません。)',
        'alert_proxy' => '有効にしても、プロキシはサービスに使用されません',
        'alert_proxy_url' => 'フォーマット: ホスト:ポート',
        'log_status' => 'ログステータス',
        'log_status_description' => 'ログステータスがTRUEに設定されている場合、モニターは通知設定が渡されるたびにイベントを記録します。',
        'log_email' => 'スクリプトによって送信された電子メールを記録する',
        'log_sms' => 'スクリプトによって送信されたテキストメッセージを記録する',
        'log_pushover' => 'スクリプトによって送信されたPushoverメッセージを記録する',
        'log_telegram' => 'スクリプトによって送信されたTelegramメッセージを記録する',
        'updated' => '設定は更新されました。',
        'tab_email' => 'メール',
        'tab_sms' => 'SMS',
        'tab_pushover' => 'Pushover',
        'tab_telegram' => 'Telegram',
        'settings_email' => 'メール設定',
        'settings_sms' => 'テキストメッセージ設定',
        'settings_pushover' => 'Pushover設定',
        'settings_telegram' => 'Telegram設定',
        'settings_notification' => '通知設定',
        'settings_log' => 'ログ設定',
        'settings_proxy' => 'プロキシ設定',
        'auto_refresh' => '自動更新',
        'auto_refresh_description' => 'サーバーページを自動更新します。<br><span
 class="small">時間を秒で指定し、0に設定すると更新しません。</span>',
        'test' => 'テスト',
        'test_email' => 'あなたのユーザープロフィールで指定されたアドレスに電子メールが送信されます。',
        'test_sms' => 'あなたのユーザープロフィールで指定された電話番号にSMSが送信されます。',
        'test_pushover' => 'あなたのユーザープロフィールで指定されたユーザー
 キー/デバイスにPushover通知が送信されます。',
        'test_telegram' => 'あなたのユーザープロフィールで指定されたチャットIDにTelegram通知が送信されます。',
        'send' => '送信',
        'test_subject' => 'テスト',
        'test_message' => 'これはテストメッセージです',
        'email_sent' => 'メールが送信されました',
        'email_error' => 'メールを送信中にエラーが発生しました',
        'sms_sent' => 'SMSが送信されました',
        'sms_error' => 'SMSを送信中にエラーが発生しました %s',
        'sms_error_nomobile' => 'テストSMSの送信に失敗:
 あなたのプロフィールに有効な電話番号がありません',
        'pushover_sent' => 'Pushover通知が送信されました',
        'pushover_error' => 'Pushover通知を送信中にエラーが発生しました: %s',
        'pushover_error_noapp' => 'テスト通知の送信に失敗しました：グローバル設定にAPIトークンがありません',
        'pushover_error_nokey' => 'テスト通知の送信に失敗しました：あなたのプロフィールに有効なPushoverキーがありません',
        'telegram_sent' => 'Telegram通知が送信されました',
        'telegram_error' => 'Telegram通知を送信中にエラーが発生しました: %s',
        'telegram_error_notoken' => 'テスト通知の送信に失敗しました：グローバル設定にTelegram
 APIトークンがありません',
        'telegram_error_noid' => 'テスト通知の送信に失敗しました：あなたのプロフィールに有効なチャットIDがありません',
        'log_retention_period' => 'ログ保持期間',
        'log_retention_period_description' => '通知のログおよびサーバー稼働時間のアーカイブを保持する日数。
 ログのクリーンアップを無効にするには、0を入力します。',
        'log_retention_days' => '日',
    ),
    'notifications' => array(
        'off_sms' => 'サーバー \'%LABEL%\' はダウンしています: ip=%IP%, ポート=%PORT%.
 エラー=%ERROR%',
        'off_email_subject' => '重要: サーバー \'%LABEL%\' がダウンしています！',
        'off_email_body' => 'サーバーへの接続に失敗しました:<br><br>Server: %LABEL%<br>IP:
 %IP%<br>ポート: %PORT%<br>エラー: %ERROR%<br>日時: %DATE%',
        'off_pushover_title' => 'サーバー \'%LABEL%\' がダウンしています！',
        'off_pushover_message' => 'サーバーへの接続に失敗しました:<br/><br/>Server: %LABEL%<br/>IP:
 %IP%<br/>ポート: %PORT%<br/>エラー: %ERROR%<br/>日時: %DATE%',
        'off_telegram_message' => 'サーバーへの接続に失敗しました:<br/><br/>Server: %LABEL%<br/>IP:
 %IP%<br/>ポート: %PORT%<br/>エラー: %ERROR%<br/>日時: %DATE%',
        'on_sms' => 'サーバー \'%LABEL%\' は動作しています: ip=%IP%, port=%PORT%, it was down for
 %LAST_OFFLINE_DURATION%',
        'on_email_subject' => '重要: サーバー \'%LABEL%\' は動作しています',
        'on_email_body' => 'サーバー \'%LABEL%\' は動作中です。
 この期間の間ダウンしていました:
 %LAST_OFFLINE_DURATION%:<br/><br/>サーバー: %LABEL%<br/>IP: %IP%<br/>ポート:
 %PORT%<br/>日時: %DATE%',
        'on_pushover_title' => 'サーバー \'%LABEL%\' は動作しています',
        'on_pushover_message' => 'サーバー \'%LABEL%\' は動作中です。
 この期間の間ダウンしていました:
 %LAST_OFFLINE_DURATION%:<br/><br/>サーバー: %LABEL%<br/>IP: %IP%<br/>ポート:
 %PORT%<br/>日時: %DATE%',
        'on_telegram_message' => 'サーバー \'%LABEL%\' は動作中です。
 この期間の間ダウンしていました: <br/><br/>サーバー:
 %LABEL%<br/>IP: %IP%<br/>ポート: %PORT%<br/>ダウンタイム:
 %LAST_OFFLINE_DURATION%<br/>日時: %DATE%',
        'combi_off_email_message' => '<ul><li>サーバー: %LABEL%</li><li>IP: %IP%</li><li>ポート:
 %PORT%</li><li>エラー: %ERROR%</li><li>日時: %DATE%</li></ul>',
        'combi_off_pushover_message' => '<ul><li>サーバー: %LABEL%</li><li>IP: %IP%</li><li>ポート:
 %PORT%</li><li>エラー: %ERROR%</li><li>日時: %DATE%</li></ul>',
        'combi_off_telegram_message' => '- サーバー: %LABEL%<br/>- IP: %IP%<br/>- ポート: %PORT%<br/>-
 エラー: %ERROR%<br/>- 日時: %DATE%<br/><br/>',
        'combi_on_email_message' => '<ul><li>サーバー: %LABEL%</li><li>IP: %IP%</li><li>ポート:
 %PORT%</li><li>ダウンタイム: %LAST_OFFLINE_DURATION%</li><li>日時:
 %DATE%</li></ul>',
        'combi_on_pushover_message' => '<ul><li>サーバー: %LABEL%</li><li>IP: %IP%</li><li>ポート:
 %PORT%</li><li>ダウンタイム: %LAST_OFFLINE_DURATION%</li><li>日時:
 %DATE%</li></ul>',
        'combi_on_telegram_message' => '- サーバー: %LABEL%<br/>- IP: %IP%<br/>- ポート: %PORT%<br/>-
 ダウンタイム: %LAST_OFFLINE_DURATION%<br/>- 日時: %DATE%<br/><br/>',
        'combi_email_subject' => '重要: \'%UP%\' サーバーは動作を再開しました。 \'%DOWN%\'
 サーバーはダウンしています。',
        'combi_pushover_subject' => '\'%UP%\' サーバーは動作を再開しました。 \'%DOWN%\'
 サーバーはダウンしています。',
        'combi_email_message' => '<b>以下のサーバーはダウンしています:
 </b><br/>%DOWN_SERVERS%<br/><b>以下のサーバーは動作を再開しました:</b><br/>%UP_SERVERS%',
        'combi_pushover_message' => '<b>以下のサーバーはダウンしています:
 </b><br/>%DOWN_SERVERS%<br/><b>以下のサーバーは動作を再開しました:</b><br/>%UP_SERVERS%',
        'combi_telegram_message' => '<b>以下のサーバーはダウンしています:
 </b><br/>%DOWN_SERVERS%<br/><b>以下のサーバーは動作を再開しました:</b><br/>%UP_SERVERS%',
    ),
    'login' => array(
        'welcome_usermenu' => 'ようこそ、 %user_name%',
        'title_sign_in' => 'サインインしてください。',
        'title_forgot' => 'パスワードを忘れましたか？',
        'title_reset' => 'パスワードをリセットする',
        'submit' => '送信',
        'remember_me' => 'ログイン状態を保持する',
        'login' => 'ログイン',
        'logout' => 'ログアウト',
        'username' => 'ユーザー名',
        'password' => 'パスワード',
        'password_repeat' => 'パスワードを繰り返してください',
        'password_forgot' => 'パスワードを忘れましたか？',
        'password_reset' => 'パスワードをリセットする',
        'password_reset_email_subject' => 'PHP Server Monitorのパスワードをリセットする',
        'password_reset_email_body' => 'パスワードをリセットするには、次のリンクを使用してください。
 1時間で期限切れになりますのでご注意ください。<br /><br
 /> %link%',
        'error_user_incorrect' => '指定されたユーザー名が見つかりませんでした。',
        'error_login_incorrect' => '情報が間違っています。',
        'error_login_passwords_nomatch' => '指定されたパスワードが一致しません。',
        'error_reset_invalid_link' => '指定したリセットリンクは無効です。',
        'success_password_forgot' => 'パスワードをリセットする方法に関する情報が電子メールで送信されました。',
        'success_password_reset' => 'パスワードは正常にリセットされました。ログインしてください。',
    ),
    'error' => array(
        '401_unauthorized' => '未認証',
        '401_unauthorized_description' => 'このページを表示する権限がありません。',
    ),
);
