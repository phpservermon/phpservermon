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

namespace psm\Service;

class Telegram {

    private $apiKey;

    public function __construct($apiKey) {
        if(empty($apiKey)) {
            throw new \Exception('ApiKey is not defined');
        }
        $this->apiKey = $apiKey;
    }

    private function getUrl() {
        return 'https://api.telegram.org/bot' . $this->apiKey . '/';
    }

    private function doGet ($method) {
        $request = file_get_contents($this->getUrl() . $method);
        return json_decode($request);
    } 

    /**
     * Available Telegram Methods
     */
    public function sendMessage($obj) {
        return $this->doGet('sendMessage?' . http_build_query($obj));
    }

    public function getMe() {
        return $this->doGet('getMe');
    }

    public function getUpdates($offset = null) {
        if(is_null($offset))
            return $this->doGet('getUpdates');
        else
            return $this->doGet('getUpdates?offset=' . $offset);
    }

}