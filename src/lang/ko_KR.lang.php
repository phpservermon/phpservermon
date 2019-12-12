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
 * @author      Ik-Jun
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

$sm_lang = array(
    'name' => '한국 - Korean',
    'locale' => array(
        '0' => 'ko_KR.UTF-8',
        '1' => 'ko_KR',
        '2' => 'korean',
    ),
    'locale_tag' => 'ko',
    'locale_dir' => 'ltr',
    'system' => array(
        'save' => '저장',
        'edit' => '수정',
        'delete' => '삭제',
        'date' => '날짜',
        'message' => '메세지',
        'yes' => '예',
        'no' => '아니오',
        'insert' => '삽입',
        'add_new' => '새계정 추가',
        'update_available' => '새로운 업데이트가 있습니다 ({version}). 다음사이트를 방문 해
 주십시오. <a href="https://github.com/phpservermon/phpservermon/releases/latest"
 target="_blank" rel="noopener">http://www.phpservermonitor.org</a>.',
    ),
    'menu' => array(
        'config' => '설정',
        'server' => '서버목록',
        'server_log' => '로그',
        'server_update' => '업데이트',
        'user' => '사용자',
        'help' => '도움말',
    ),
    'users' => array(
        'user' => '사용자',
        'name' => '이름',
        'mobile' => '휴대폰',
        'updated' => '수정되었습니다.',
        'inserted' => '추가되었습니다.',
    ),
    'log' => array(
        'type' => '속성',
        'status' => '상태',
        'email' => 'email',
        'sms' => 'sms',
        'pushover' => 'Pushover',
        'telegram' => 'Telegram',
    ),
    'servers' => array(
        'server' => '서버',
        'last_check' => '최근체크',
        'last_online' => '최근접속',
        'monitoring' => '확인중',
        'email' => '메일 전송',
        'send_email' => '메일 전송',
        'sms' => 'SMS 전송',
        'send_sms' => 'SMS 전송',
        'updated' => '서버가 수정되었습니다.',
        'inserted' => '서버가 추가되었습니다.',
        'latency' => '응답',
    ),
    'config' => array(
        'general' => '일반',
        'language' => '언어',
        'show_update' => '매주 업데이트를 확인하시겠습니까?',
        'email_status' => '메일전송 허용',
        'email_from_email' => 'Email 주소',
        'email_from_name' => 'Email 사용자',
        'sms_status' => 'SMS전송 허용',
        'sms_gateway' => '메세지 전송을 위한 게이트웨이 허용',
        'alert_type' => '알림을 원하면 다음과 같이 변경하십시오.',
        'alert_type_description' => '<b>상태 변경: </b><br>서버 상태가 변경이되면 알림을
 받습니다. online -> offline -> online.<br><br><b>오프라인:
 </b><br>서버가 첫번째로 오프라인이 되었을 때 알림을
 받습니다. 예를들어, cron이 매 15분이고 오전1시 부터
 오전6시까지 다운되었을때 오전1시에 한번 알림을
 받습니다.<br /><br><b>항상: </b><br>사이트가 다운되었을 때
 매시간 알림을 받습니다.',
        'alert_type_status' => '상태 변경',
        'alert_type_offline' => '오프라인',
        'alert_type_always' => '항상',
        'log_status' => '로그 상태',
        'log_status_description' => '로그상태가 TRUE이면 알림설정이 통과할때마다 이벤트를
 기록합니다.',
        'log_email' => '이메일로 로그를 전송하시겠습니까?',
        'log_sms' => 'SMS로 로그를 전송하시겠습니까?',
        'updated' => '설정이 수정되었습니다.',
        'tab_email' => 'Email',
        'tab_sms' => 'SMS',
        'tab_pushover' => 'Pushover',
        'settings_email' => 'Email 설정',
        'settings_sms' => 'SMS 설정',
        'settings_notification' => '알림 설정',
        'settings_log' => '로그 설정',
        'auto_refresh_description' => '서버페이지를 자동으로 새로고침.<br><span class="small">시간은
 초(sec)로 설정을 하고, 0은 새로고침을 하지 않습니다.</span>',
    ),
    'notifications' => array(
        'off_sms' => '서버(\'%LABEL%\')가 다운되었습니다. : ip=%IP%, port=%PORT%. Error=%ERROR%',
        'off_email_subject' => '중요: 서버(\'%LABEL%\')가 다운되었습니다.',
        'off_email_body' => '서버 접속을 실패하였습니다.<br><br>Server: %LABEL%<br>IP: %IP%<br>Port:
 %PORT%<br>Error: %ERROR%<br>Date: %DATE%',
        'off_pushover_title' => '서버(\'%LABEL%\')가 다운되었습니다.',
        'off_pushover_message' => '서버 접속을 실패하였습니다.<br><br>Server: %LABEL%<br>IP: %IP%<br>Port:
 %PORT%<br>Error: %ERROR%<br>Date: %DATE%',
        'on_sms' => '서버(\'%LABEL%\') 가동중: ip=%IP%, port=%PORT%, it was down for %LAST_OFFLINE_DURATION%',
        'on_email_subject' => '중요: 서버(\'%LABEL%\')가 가동중입니다.',
        'on_email_body' => '서버(\'%LABEL%\')가 재가동됩니다., it was down for
 %LAST_OFFLINE_DURATION%:<br><br>Server: %LABEL%<br>IP: %IP%<br>Port: %PORT%<br>Date:
 %DATE%',
        'on_pushover_title' => '서버(\'%LABEL%\')가 가동중입니다.',
        'on_pushover_message' => '서버(\'%LABEL%\')가 재가동됩니다., it was down for
 %LAST_OFFLINE_DURATION%:<br><br>Server: %LABEL%<br>IP: %IP%<br>Port: %PORT%<br>Date:
 %DATE%',
    ),
);
