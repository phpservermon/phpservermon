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
 * @author      Axel Wehner <mail@axelwehner.de>
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 * @since       phpservermon 3.2.1
 **/

namespace psm\Txtmsg;

/**
 * CMBulkSMS - Class for CM Telecom's Bulk SMS Gateway API
 *
 * Sending SMS notifications via the CM Telecom Bulk SMS Gateway
 * Please use the gateway password field in your configuration for the CM API-Token
 *
 * Requirements: cURL v7.18.1+ and OpenSSL 0.9.8j+
 */
class CMBulkSMS extends Core
{
    /** @var bool True when cURL request succeeded */
    public $result = true;

    /** @var string Contains error message if cURL request failed */
    public $error = '';

    /** @var bool Set to true for debug output/logging */
    protected $debug = false;

    /** @var bool Set to false if your operator isn't able to handle multipart messages */
    protected $multipartMessage = true;

    /** @var string|null Gateway API URL uses const GATEWAY_URL_XML or GATEWAY_URL_JSON */
    protected $apiUrl;

    /** @var string Gateway API Type: Use 'json' (default) or 'xml' */
    protected $apiType = 'json';

    /** @var string|null JSON or XML message for cURL request */
    protected $request;

    /** @var string|null HTTP Content-Type for cURL request */
    protected $contentType;

    /** @var string|null Raw sms text message */
    protected $messageBody;

    /** @var string JSON Gateway API URL */
    const GATEWAY_URL_JSON = "https://gw.cmtelecom.com/v1.0/message";

    /** @var string XML Gateway API URL */
    const GATEWAY_URL_XML = "https://sgw01.cm.nl/gateway.ashx";

    /**
     * Build the message and send cURL request to the sms gateway
     *
     * @see https://docs.cmtelecom.com/bulk-sms/v1.0#/send_a_message%7Csample_requests
     * @param string $message Your text message
     * @return bool|string true when cURL request was successful, otherwise string with error message
     */
    public function sendSMS($message)
    {
        // Check if recipient and text message are available
        if (count($this->recipients) < 1 || empty($message)) {
            return false;
        }

        // Prepare the message in CM's XML or JSON format
        switch ($this->apiType) {
            case 'xml':
                $this->request = $this->buildMessageXml();
                $this->contentType = 'Content-Type: application/xml';
                $this->apiUrl = self::GATEWAY_URL_XML;
                break;

            case 'json':
            default:
                $this->request = $this->buildMessageJson();
                $this->contentType = 'Content-Type: application/json';
                $this->apiUrl = self::GATEWAY_URL_JSON;
                break;
        }

        $request = $this->executeCurlRequest();

        return $request;
    }

    /**
     * Create a JSON batch sms message using CM's format
     *
     * @see https://docs.cmtelecom.com/bulk-sms/v1.0#/send_a_message%7Cbatch_messages
     * @see https://docs.cmtelecom.com/bulk-sms/v1.0#/send_a_message%7Csample_requests
     * @see https://docs.cmtelecom.com/bulk-sms/v1.0#/send_a_message%7Cmultipart
     * @return string JSON message object
     */
    protected function buildMessageJson()
    {
        // Prepare recipient array for batch message
        $recipients = array();
        foreach ($this->recipients as $recipient) {
            $recipients[] = array('number' => $recipient);
        }

        // Build message array in CM's Bulk SMS format
        $msgArray = array(
            'messages' => array(
                'authentication' => array(
                    'producttoken' => $this->password
                ),
                'msg' => array(
                    array(
                        'from' => substr($this->originator, 0, 15),
                        'to' => $recipients,
                        'body' => array(
                            'content' => $message
                        )
                    )
                )
            )
        );

        // Multipart message
        if ($this->multipartMessage) {
            $msgArray['messages']['msg'][0]['minimumNumberOfMessageParts'] = 1;
            $msgArray['messages']['msg'][0]['maximumNumberOfMessageParts'] = 8;
        }

        // Convert array in JSON object
        return json_encode($msgArray);
    }

    /**
     * Create a XML batch sms message in CM's format
     *
     * @see https://docs.cmtelecom.com/bulk-sms/v1.0#/send_a_message%7Cbatch_messages
     * @see https://docs.cmtelecom.com/bulk-sms/v1.0#/send_a_message%7Csample_requests
     * @see https://docs.cmtelecom.com/bulk-sms/v1.0#/send_a_message%7Cmultipart
     * @return string XML message
     */
    protected function buildMessageXml()
    {
        // Create XML string
        $xml = new \SimpleXMLElement('<MESSAGES/>');

        // API-Token
        $auth = $xml->addChild('AUTHENTICATION');
        $auth->addChild('PRODUCTTOKEN', $this->password);

        // Message
        $msg = $xml->addChild('MSG');

        // From
        $msg->addChild('FROM', substr($this->originator, 0, 15));

        // Recipients
        foreach ($this->recipients as $recipient) {
            $msg->addChild('TO', $recipient);
        }

        // Multipart message
        if ($this->multipartMessage) {
            $msg->addChild('MINIMUMNUMBEROFMESSAGEPARTS', 1);
            $msg->addChild('MAXIMUMNUMBEROFMESSAGEPARTS', 8);
        }

        // Add body text
        $msg->addChild('BODY', $message);

        return $xml->asXML();
    }

    /**
     * Create and execute the curl request
     *
     * @return boolean|string boolean if message is sent, else string
     */

    protected function executeCurlRequest()
    {
        $cr = curl_init();
        curl_setopt_array($cr, array(
                CURLOPT_URL => $this->apiUrl,
                CURLOPT_HTTPHEADER => array($this->contentType),
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $this->request,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FAILONERROR => true
            ));

        // execute curl request and fetch the response/error
        $cResponse = curl_exec($cr);
        $cError = curl_error($cr);
        $cErrorCode = curl_errno($cr);
        curl_close($cr);

        // set result and log error if needed
        if ($cError) {
            $this->error = 'Response: CM SMS API:' . $cResponse . ' cURL Error Code: ' .
                $cErrorCode . '"' . $cError . '"';
            error_log($this->error, E_USER_ERROR);
            $this->result = false;
        }

        // Debug output
        // Note: CM's XML gateway gives no response when message is sent successfully :/
        if ($this->debug || PSM_DEBUG) {
            $debug = '<pre>Request: ' . $this->request . '<br>Response: ' . $cResponse . '</pre>';
            error_log("Request: $this->request\r\nResponse: $cResponse", E_USER_NOTICE);
            echo $debug;
        }

        return $this->result ? $this->result : $this->error;
    }
}
