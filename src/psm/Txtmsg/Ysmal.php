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
 * @author      Perri Vardy-Mason
 * @author      Dylan Ysmal <dylan@ysmal.fr>
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 * @since       phpservermon 3.5
 **/

namespace psm\Txtmsg;

class Ysmal extends Core
{

    /**
     * Send sms using the Hermes SMS API on Ysmal.fr
     * @var string $message
     * @var array $this->recipients
     * @var string $this->password
     *
     * @var mixed $result
     * @var array $headers
     *
     * @var int $success
     * @var string $error
     *
     * @return bool|string
     */

    public function sendSMS($message)
    {
        $success = 1;
        $error = '';

        foreach ($this->recipients as $recipient) {
            $opts['http'] = [
                'method' => 'POST',
                'header' => "Content-Type: application/x-www-form-urlencoded\r\n" .
                    'User-Agent: PHPServerMonitor (+https://phpservermonitor.org)',
                'content' => http_build_query([
                    'key' => $this->password,
                    'number' => $recipient,
                    'message' => $message
                ]),
                'ignore_errors' => true
            ];

            $api = 'https://sms-api.ysmal.fr/';
            $ctx = stream_context_create($opts);
            $res = file_get_contents($api, false, $ctx);

            $json = json_decode($res, true);
            if ($json === NULL) {
                $success = 0;
                $error = "($recipient) json_decode_error";
                break;
            }

            if ($json['status'] !== 'success') {
                $success = 0;
                $error = "($recipient) $json[error]";
                break;
            }
        }

        if ($success) {
            return 1;
        }
        return $error;
    }
}
