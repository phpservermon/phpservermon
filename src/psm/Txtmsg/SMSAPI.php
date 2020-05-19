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
 * @author      Mateusz Małek <tajgeer@gmail.com>
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 * @since       phpservermon 3.5
 **/

namespace psm\Txtmsg;

class SMSAPI extends Core
{
    const VARIANT_INTERNATIONAL = 1;
    const VARIANT_POLISH = 2;

    /**
     * SMSAPI comes with two variants - designed for polish or international customers.
     *
     * @var int
     */
    private $variant = self::VARIANT_INTERNATIONAL;

    /**
     * Name of the sender. As a default the sender name is set to "Test".
     * Only verified names are being accepted.
     * Sender name may be set after logging into Customer Portal on Sendernames.
     * @see https://www.smsapi.com/docs/#2-single-sms
     *
     * @var string
     */
    protected $originator;

    /**
     * Token used to authenticate in SMSAPI system.
     * @see https://www.smsapi.com/docs/#authentication
     *
     * @var string
     */
    protected $password;

    /**
     * Send sms using the SMSAPI
     *
     * @var string $message
     * @var array $this->recipients
     * @var array $this->originator
     * @var string $this->password
     * @var array $recipients_chunk
     * @var string $host
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
        $tld = ($this->variant === static::VARIANT_INTERNATIONAL) ? "com" : "pl";
        $host = "api.smsapi.{$tld}";
        $backupHost = "api2.smsapi.{$tld}";

        // One user at a time.
        $recipients_chunk = array_chunk($this->recipients, 1);
        foreach ($recipients_chunk as $recipient) {
            try {
                $response = $this->processSendOperation($host, $recipient, $message);
            } catch (\RuntimeException $e) {
                try {
                    $response = $this->processSendOperation($backupHost, $recipient, $message);
                } catch (\RuntimeException $e) {
                    return "({$recipient}) " . $e->getMessage();
                }
            }

            if (isset($response->error)) {
                return $response->message;
            }

            return 1;
        }
    }

    /**
     * Perform actual SMS sending operation
     *
     * @param $host
     * @param $recipient
     * @param $message
     * @return object
     * @throws RuntimeException
     */
    private function processSendOperation($host, $recipient, $message)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://{$host}/sms.do");
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
            "access_token" => $this->password,
            "from" => $this->originator,
            "to" => $recipient,
            "message" => $message,
            "encoding" => "utf-8",
            "normalize" => "1",
            "format" => "json"
        )));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);

        $result = curl_exec($ch);

        $error = false;
        if (curl_errno($ch)) {
            $error = curl_error($ch);
        }

        curl_close($ch);

        if ($error !== false) {
            throw new \RuntimeException($error);
        }

        return json_decode($result);
    }
}
