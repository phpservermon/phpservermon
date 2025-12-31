<?php

/**
 * REMITK MONITORING
 * Monitor your servers and websites.
 *
 * This file is part of REMITK MONITORING.
 * REMITK MONITORING is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * REMITK MONITORING is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with REMITK MONITORING.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package     phpservermon
 * @author      Pepijn Over <pep@mailbox.org>
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 * @since       phpservermon 3.2
 **/

namespace psm\Module\User\Event;

use Symfony\Contracts\EventDispatcher\Event;

class UserEvent extends Event
{

    protected $user_id;

    protected $user_id_by;

    public function __construct($user_id, $user_id_by = null)
    {
        $this->user_id = $user_id;
        $this->user_id_by = $user_id_by;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getUserIdBy()
    {
        return $this->user_id_by;
    }
}
