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
    'name' => 'Thai',
    'locale' => array(
        '0' => 'th_TH.UTF-8',
        '1' => 'th_TH',
        '2' => 'thai',
        '3' => 'thai-th',
        'theme' => 'Theme',
        'theme_light' => 'Light',
        'theme_dark' => 'Dark',
        'theme_blue' => 'Blue',
        'theme_green' => 'Light Green',
    ),
    'locale_tag' => 'th',
    'locale_dir' => 'ltr',
    'system' => array(
        'title' => 'Server Monitor',
        'install' => 'ติดตั้ง',
        'action' => 'Action',
        'save' => 'บันทึก',
        'edit' => 'แก้ไข',
        'delete' => 'ลบ',
        'view' => 'ดู',
        'date' => 'วันที่',
        'message' => 'ข้อความ',
        'yes' => 'ใช่',
        'no' => 'ไม่ใช่',
        'insert' => 'แทรก',
        'add_new' => 'เพิ่มใหม่',
        'update_available' => 'มีเวอร์ชันใหม่ ({version}) ให้ดาวน์โหลดแล้ว คลิก <a href="https://github.com/phpservermon/phpservermon/releases/latest" target="_blank" rel="noopener">ที่นี่</a> เพื่อดาวน์โหลดการอัปเดต',
        'back_to_top' => 'กลับไปยังด้านบน',
        'go_back' => 'ถอยกลับ',
        'ok' => 'ตกลง',
        'bad' => 'ล้มเหลว',
        'cancel' => 'ยกเลิก',
        'none' => 'ไม่มี',
        'activate' => 'เปิดใช้งาน',
        'short_day_format' => '%B %e',
        'long_day_format' => '%B %e, %Y',
        'yesterday_format' => 'Yเมื่อวานตอน %k:%M',
        'other_day_format' => '%A ตอน %k:%M',
        'never' => 'ไม่มี',
        'hours_ago' => '%d ชั่วโมงก่อน',
        'an_hour_ago' => 'ประมาณหนึ่งชั่วโมงที่แล้ว',
        'minutes_ago' => '%d นาทีที่แล้ว',
        'a_minute_ago' => 'ประมาณหนึ่งนาทีที่แล้ว',
        'seconds_ago' => '%d วินาทีที่แล้ว',
        'a_second_ago' => 'เมื่อวินาทีที่แล้ว',
        'year' => 'ปี',
        'years' => 'ปี',
        'month' => 'เดือน',
        'months' => 'เดือน',
        'day' => 'วัน',
        'days' => 'วัน',
        'hour' => 'ชั่วโมง',
        'hours' => 'ชั่วโมง',
        'minute' => 'นาที',
        'minutes' => 'นาที',
        'second' => 'วินาที',
        'seconds' => 'วินาที',
        'millisecond' => 'มิลลิวินาที',
        'milliseconds' => 'มิลลิวินาที',
        'current' => 'ปัจจุบัน',
        'settings' => 'การตั้งค่า',
        'search' => 'ค้นหา',
    ),
    'menu' => array(
        'config' => 'การกำหนดค่า',
        'server' => 'เซิร์ฟเวอร์',
        'server_log' => 'Log',
        'server_status' => 'สถานะ',
        'server_update' => 'อัปเดต',
        'user' => 'ผู้ใช้',
        'help' => 'ช่วยเหลือ',
    ),
    'users' => array(
        'user' => 'ผู้ใช้',
        'name' => 'ชื่อ',
        'user_name' => 'ชื่อผู้ใช้',
        'password' => 'รหัสผ่าน',
        'password_repeat' => 'รหัสผ่านอีกครั้ง',
        'password_leave_blank' => 'ปล่อยว่างไว้เพื่อไม่ให้เปลี่ยนแปลง',
        'level' => 'ระดับ',
        'level_10' => 'ผู้ดูแลระบบ',
        'level_20' => 'ผู้ใช้',
        'level_30' => 'ไม่ระบุตัวตน',
        'level_description' => '<b>ผู้ดูแลระบบ</b>มีสิทธิ์เข้าถึงเต็มรูปแบบ: พวกเขาสามารถจัดการเซิร์ฟเวอร์ ผู้ใช้ และแก้ไขการกำหนดค่าทั่วโลกได้ <br><b>ผู้ใช้</b>สามารถดูและเรียกใช้โปรแกรมอัปเดตสำหรับเซิร์ฟเวอร์ที่ได้รับมอบหมายให้เท่านั้น',
        'mobile' => 'มือถือ',
        'email' => 'อีเมล',
        'pushover' => 'Pushover',
        'pushover_description' => 'Pushover เป็นบริการที่ช่วยให้รับการแจ้งเตือนแบบเรียลไทม์ได้อย่างง่ายดาย ดูข้อมูลเพิ่มเติมได้ที่ <a href="https://pushover.net/" target="_blank">เว็บไซต์</a>',
        'pushover_device_description' => 'ชื่ออุปกรณ์ที่จะส่งข้อความถึง ปล่อยว่างไว้หากต้องการส่งไปยังอุปกรณ์ทั้งหมด.',
        'discord' => 'Discord',
        'discord_label' => 'Discord',
        'discord_description' => 'วาง <a href="https://discordjs.guide/popular-topics/webhooks.html" target="_blank">webhook</a> ของคุณไว้ที่นี่',
        'telegram' => 'Telegram',
        'telegram_description' => '<a href="https://telegram.org/" target="_blank">Telegram</a> คือแอปแชทที่ทำให้การรับการแจ้งเตือนแบบเรียลไทม์เป็นเรื่องง่าย เยี่ยมชม <a href="http://docs.phpservermonitor.org/" target="_blank">เอกสาร</a> เพื่อดูข้อมูลเพิ่มเติมและคำแนะนำในการติดตั้ง',
        'telegram_chat_id' => 'Telegram chat id',
        'telegram_chat_id_description' => 'ข้อความจะถูกส่งไปยังห้องแชทที่เกี่ยวข้อง',
        'telegram_get_chat_id' => 'คลิกที่นี่เพื่อรับ chat id ของคุณ',
        'activate_telegram_description' => 'อนุญาตให้ส่งการแจ้งเตือนของ Telegram ไปยัง ID แชทที่ระบุ หากไม่ได้รับอนุญาต Telegram จะไม่อนุญาตให้เราส่งการแจ้งเตือนถึงคุณ',
    ),
);