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
 * @since       phpservermon 3.0.0
 **/

namespace psm\Util\User;

/**
 * The UserValidator helps you to check input data for user accounts.
 */
class UserValidator
{

    /**
     * Available editable user levels
     * @var array $user_levels
     */
    protected $user_levels = array(PSM_USER_ADMIN, PSM_USER_USER, PSM_USER_ANONYMOUS);

    /**
     * User service
     * @var \psm\Service\User $user
     */
    protected $user;

    public function __construct(\psm\Service\User $user)
    {
        $this->user = $user;
    }

    /**
     * Check if the user id exists
     * @param int $user_id
     * @return boolean
     * @throws \InvalidArgumentException
     */
    public function userId($user_id)
    {
        $user = $this->user->getUser($user_id);
        if (empty($user)) {
            throw new \InvalidArgumentException('user_no_match');
        }
        return true;
    }

    /**
     * Check username on:
     *
     * - Length (2-64 chars)
     * - Contents (alphabetic chars and digits only)
     * - Unique
     * @param string $username
     * @param int $user_id to check whether the username is unique
     * @return boolean
     * @throws \InvalidArgumentException
     */
    public function username($username, $user_id = 0)
    {
        if (strlen($username) > 64 || strlen($username) < 2) {
            throw new \InvalidArgumentException('user_name_bad_length');
        }
        if (!preg_match('/^[a-zA-Z\d_\.]{2,64}$/i', $username)) {
            throw new \InvalidArgumentException('user_name_invalid');
        }
        $user_exists = $this->user->getUserByUsername($username);

        if (!empty($user_exists) && ($user_id == 0 || $user_id != $user_exists->user_id)) {
            throw new \InvalidArgumentException('user_name_exists');
        }
        return true;
    }

    /**
     * Check user password
     * @param string $password
     * @param string $password_repeat
     * @return boolean
     * @throws \InvalidArgumentException
     */
    public function password($password, $password_repeat)
    {
        if (empty($password) || empty($password_repeat)) {
            throw new \InvalidArgumentException('user_password_invalid');
        }
        if ($password !== $password_repeat) {
            throw new \InvalidArgumentException('user_password_no_match');
        }
        return true;
    }

    /**
     * Install only; Check username on:
     *
     * - Length (2-64 chars)
     * - Contents (alphabetic chars and digits only)
     * @param string $username
     * @return boolean
     * @throws \InvalidArgumentException
     */
    public function usernameNew($username)
    {
        if (strlen($username) > 64 || strlen($username) < 2) {
            throw new \InvalidArgumentException('user_name_bad_length');
        }
        if (!preg_match('/^[a-zA-Z\d_\.]{2,64}$/i', $username)) {
            throw new \InvalidArgumentException('user_name_invalid');
        }
        return true;
    }

    /**
     * Check email
     * @param string $email
     * @return boolean
     * @throws \InvalidArgumentException
     */
    public function email($email)
    {
        if (strlen($email) > 255 || strlen($email) < 5) {
            throw new \InvalidArgumentException('user_email_bad_length');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('user_email_invalid');
        }
        return true;
    }

    /**
     * Check user level
     * @param int $level
     * @return boolean
     * @throws \InvalidArgumentException
     */
    public function level($level)
    {
        if (!in_array($level, $this->user_levels)) {
            throw new \InvalidArgumentException('user_level_invalid');
        }
        return true;
    }

    /**
     * Get list of all available user levels
     * @return array
     */
    public function getUserLevels()
    {
        return $this->user_levels;
    }
}
