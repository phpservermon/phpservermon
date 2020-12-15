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
 * @author      Panique <https://github.com/panique/php-login-advanced/>
 * @author      Pepijn Over <pep@mailbox.org>
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 * @since       phpservermon 3.0.0
 **/

namespace psm\Service;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * This is a heavily modified version of the php-login-advanced project by Panique.
 *
 * It uses the Session classes from the Symfony HttpFoundation component.
 *
 * @author Panique
 * @author Pepijn Over
 * @link http://www.php-login.net
 * @link https://github.com/panique/php-login-advanced/
 * @license http://opensource.org/licenses/MIT MIT License
 */
class User
{

    /**
     * The database connection
     * @var \PDO $db_connection
     */
    protected $db_connection = null;

    /**
     * Local cache of user data
     * @var array $user_data
     */
    protected $user_data = array();

    /**
     * Session object
     * @var \Symfony\Component\HttpFoundation\Session\Session $session
     */
    protected $session;

    /**
     * Current user id
     * @var int $user_id
     */
    protected $user_id;

    /**
     *Current user preferences
     * @var array $user_preferences
     */
    protected $user_preferences;

    /**
     * The user's login status
     * @var boolean $user_is_logged_in
     */
    protected $user_is_logged_in = false;

    /**
     * Open a new user service
     *
     * @param \psm\Service\Database $db
     * @param \Symfony\Component\HttpFoundation\Session\SessionInterface $session if NULL, one will be created
     */
    public function __construct(Database $db, SessionInterface $session = null)
    {
        $this->db_connection = $db->pdo();

        if (!psm_is_cli()) {
            if ($session == null) {
                $session = new Session();
                $session->start();
            }
            $this->session = $session;

            if (PSM_PUBLIC === true && PSM_PUBLIC_PAGE === true) {
                $query_user = $this->db_connection->prepare('SELECT * FROM ' .
                    PSM_DB_PREFIX . 'users WHERE user_name = :user_name and level = :level');
                $query_user->bindValue(':user_name', "__PUBLIC__", \PDO::PARAM_STR);
                $query_user->bindValue(':level', PSM_USER_ANONYMOUS, \PDO::PARAM_STR);
                $query_user->execute();

                // get result row (as an object)
                $this->setUserLoggedIn($query_user->fetchObject()->user_id);
            }

            if ((!defined('PSM_INSTALL') || !PSM_INSTALL)) {
                // check the possible login actions:
                // 1. login via session data (happens each time user opens a page on your php project AFTER
                // he has successfully logged in via the login form)
                // 2. login via cookie

                // if user has an active session on the server
                if (!$this->loginWithSessionData()) {
                    $this->loginWithCookieData();
                }
            }
        }
    }

    /**
     * Get user by id, or get current user.
     * @param int $user_id if null it will attempt current user id
     * @param boolean $flush if TRUE it will query db regardless of whether we already have the data
     * @return object|boolean FALSE if user not found, object otherwise
     */
    public function getUser($user_id = null, $flush = false)
    {
        if ($user_id == null) {
            if (!$this->isUserLoggedIn()) {
                return false;
            } else {
                $user_id = $this->getUserId();
            }
        }

        if (!isset($this->user_data[$user_id]) || $flush) {
            $query_user = $this->db_connection->prepare('SELECT * FROM ' .
                PSM_DB_PREFIX . 'users WHERE user_id = :user_id');
            $query_user->bindValue(':user_id', $user_id, \PDO::PARAM_INT);
            $query_user->execute();
            // get result row (as an object)
            $this->user_data[$user_id] = $query_user->fetchObject();
        }
        return $this->user_data[$user_id];
    }

    /**
     * Search into database for the user data of user_name specified as parameter
     * @return object|boolean user data as an object if existing user
     */
    public function getUserByUsername($user_name)
    {
        // database query, getting all the info of the selected user
        $query_user = $this->db_connection->prepare('SELECT * FROM ' .
            PSM_DB_PREFIX . 'users WHERE user_name = :user_name');
        $query_user->bindValue(':user_name', $user_name, \PDO::PARAM_STR);
        $query_user->execute();
        // get result row (as an object)
        return $query_user->fetchObject();
    }

    /**
     * Logs in with SESSION data.
     *
     * @return boolean
     */
    protected function loginWithSessionData()
    {
        if (!$this->session->has('user_id')) {
            return false;
        }
        $user = $this->getUser($this->session->get('user_id'));

        if (!empty($user)) {
            $this->setUserLoggedIn($user->user_id);
            return true;
        } else {
            // user no longer exists in database
            // call logout to clean up session vars
            $this->doLogout();
            return false;
        }
    }

    /**
     * Logs in via the Cookie
     * @return bool success state of cookie login
     */
    private function loginWithCookieData()
    {
        if (isset($_COOKIE['rememberme'])) {
            // extract data from the cookie
            list ($user_id, $token, $hash) = explode(':', $_COOKIE['rememberme']);
            // check cookie hash validity
            if ($hash == hash('sha256', $user_id . ':' . $token . PSM_LOGIN_COOKIE_SECRET_KEY) && !empty($token)) {
                // cookie looks good, try to select corresponding user
                // get real token from database (and all other data)
                $user = $this->getUser($user_id);

                if (!empty($user) && $token === $user->rememberme_token) {
                    $this->setUserLoggedIn($user->user_id, true);

                    // Cookie token usable only once
                    $this->newRememberMeCookie();
                    return true;
                }
            }
            // call logout to remove invalid cookie
            $this->doLogout();
        }
        return false;
    }

    /**
     * Logs in with the data provided in $_POST, coming from the login form
     * @param string $user_name
     * @param string $user_password
     * @param boolean $user_rememberme
     * @return boolean
     */
    public function loginWithPostData($user_name, $user_password, $user_rememberme = false)
    {
        $user_name = trim($user_name);
        $user_password = trim($user_password);
        $ldapauthstatus = false;

        if (empty($user_name) && empty($user_password)) {
            return false;
        }

        $dirauthconfig = psm_get_conf('dirauth_status');
        
        // LDAP auth enabled
        if ($dirauthconfig === '1') {
            $ldaplibpath = realpath(
                PSM_PATH_SRC . '..' . DIRECTORY_SEPARATOR .
                'vendor' . DIRECTORY_SEPARATOR .
                'viharm' . DIRECTORY_SEPARATOR .
                'psm-ldap-auth' . DIRECTORY_SEPARATOR .
                'psmldapauth.php'
            );
            // If the library is found
            if ($ldaplibpath) {
                // Delegate the authentication to the PsmLDAPauth module.
                // If LDAP auth fails or if library not found, fall back to native auth
                include_once($ldaplibpath);
                $ldapauthstatus = psmldapauth($user_name, $user_password, $GLOBALS['sm_config'], $this->db_connection);
            }
        }

        $user = $this->getUserByUsername($user_name);

        // Authenticated
        if ($ldapauthstatus === true) {
          // Remove password to prevent it from being saved in the DB.
          // Otherwise, user may still be authenticated if LDAP is disabled later.
          $user_password = null;
          @fn_Debug('Authenticated', $user);
        } else {

          // using PHP 5.5's password_verify() function to check if the provided passwords
          // fits to the hash of that user's password
          if (!isset($user->user_id)) {
              password_verify($user_password, 'dummy_call_against_timing');
              return false;
          } elseif (!password_verify($user_password, $user->password)) {
              return false;
          }
        } // not authenticated

        $this->setUserLoggedIn($user->user_id, true);

        // if user has check the "remember me" checkbox, then generate token and write cookie
        if ($user_rememberme) {
            $this->newRememberMeCookie();
        }

        // recalculate the user's password hash
        // DELETE this if-block if you like, it only exists to recalculate
        // users's hashes when you provide a cost factor,
        // by default the script will use a cost factor of 10 and never change it.
        // check if the have defined a cost factor in config/hashing.php
        if (defined('PSM_LOGIN_HASH_COST_FACTOR')) {
            // check if the hash needs to be rehashed
            if (password_needs_rehash($user->password, PASSWORD_DEFAULT, array('cost' => PSM_LOGIN_HASH_COST_FACTOR))) {
                $this->changePassword($user->user_id, $user_password);
            }
        }
        return true;
    }

    /**
     * Set the user logged in
     * @param int $user_id
     * @param boolean $regenerate regenerate session id against session fixation?
     */
    protected function setUserLoggedIn($user_id, $regenerate = false)
    {
        if ($regenerate) {
            $this->session->invalidate();
        }
        $this->session->set('user_id', $user_id);
        $this->session->set('user_logged_in', 1);

        // declare user id, set the login status to true
        $this->user_id = $user_id;
        $this->user_is_logged_in = true;
    }

    /**
     * Create all data needed for remember me cookie connection on client and server side
     */
    protected function newRememberMeCookie()
    {
        // generate 64 char random string and store it in current user data
        $random_token_string = hash('sha256', mt_rand());
        $sth = $this->db_connection->prepare('UPDATE ' .
            PSM_DB_PREFIX . 'users SET rememberme_token = :user_rememberme_token WHERE user_id = :user_id');
        $sth->execute(array(':user_rememberme_token' => $random_token_string, ':user_id' => $this->getUserId()));

        // generate cookie string that consists of userid, randomstring and combined hash of both
        $cookie_string_first_part = $this->getUserId() . ':' . $random_token_string;
        $cookie_string_hash = hash('sha256', $cookie_string_first_part . PSM_LOGIN_COOKIE_SECRET_KEY);
        $cookie_string = $cookie_string_first_part . ':' . $cookie_string_hash;

        // set cookie
        setcookie('rememberme', $cookie_string, time() + PSM_LOGIN_COOKIE_RUNTIME, "/", PSM_LOGIN_COOKIE_DOMAIN);
    }

    /**
     * Delete all data needed for remember me cookie connection on client and server side
     */
    protected function deleteRememberMeCookie()
    {
        // Reset rememberme token
        if ($this->session->has('user_id')) {
            $sth = $this->db_connection->prepare('UPDATE ' .
                PSM_DB_PREFIX . 'users SET rememberme_token = NULL WHERE user_id = :user_id');
            $sth->execute(array(':user_id' => $this->session->get('user_id')));
        }

        // set the rememberme-cookie to ten years ago (3600sec * 365 days * 10).
        // that's obivously the best practice to kill a cookie via php
        // @see http://stackoverflow.com/a/686166/1114320
        setcookie('rememberme', false, time() - (3600 * 3650), '/', PSM_LOGIN_COOKIE_DOMAIN);
    }

    /**
     * Perform the logout, resetting the session
     */
    public function doLogout()
    {
        $this->deleteRememberMeCookie();

        $this->session->clear();
        $this->session->invalidate();

        $this->user_is_logged_in = false;
    }

    /**
     * Simply return the current state of the user's login
     * @return bool user's login status
     */
    public function isUserLoggedIn()
    {
        return $this->user_is_logged_in;
    }

    /**
     * Sets a random token into the database (that will verify the user when he/she comes back via the link
     * in the email) and returns it
     * @param int $user_id
     * @return string|boolean FALSE on error, string otherwise
     */
    public function generatePasswordResetToken($user_id)
    {
        $user_id = intval($user_id);

        if ($user_id == 0) {
            return false;
        }
        // generate timestamp (to see when exactly the user (or an attacker) requested the password reset mail)
        $temporary_timestamp = time();
        // generate random hash for email password reset verification (40 char string)
        $user_password_reset_hash = sha1(uniqid(mt_rand(), true));

        $query_update = $this->db_connection->prepare('UPDATE ' .
            PSM_DB_PREFIX . 'users SET password_reset_hash = :user_password_reset_hash,
            password_reset_timestamp = :user_password_reset_timestamp
            WHERE user_id = :user_id');
        $query_update->bindValue(':user_password_reset_hash', $user_password_reset_hash, \PDO::PARAM_STR);
        $query_update->bindValue(':user_password_reset_timestamp', $temporary_timestamp, \PDO::PARAM_INT);
        $query_update->bindValue(':user_id', $user_id, \PDO::PARAM_INT);
        $query_update->execute();

        // check if exactly one row was successfully changed:
        if ($query_update->rowCount() == 1) {
            return $user_password_reset_hash;
        } else {
            return false;
        }
    }

    /**
     * Checks if the verification string in the account verification mail is valid and matches to the user.
     *
     * Please note it is valid for 1 hour.
     * @param int $user_id
     * @param string $token
     * @return boolean
     */
    public function verifyPasswordResetToken($user_id, $token)
    {
        $user_id = intval($user_id);

        if (empty($user_id) || empty($token)) {
            return false;
        }
        $user = $this->getUser($user_id);

        if (isset($user->user_id) && $user->password_reset_hash == $token) {
            $runtime = (defined('PSM_LOGIN_RESET_RUNTIME')) ? PSM_LOGIN_RESET_RUNTIME : 3600;
            $timestamp_max_interval = time() - $runtime;

            if ($user->password_reset_timestamp > $timestamp_max_interval) {
                return true;
            }
        }
        return false;
    }

    /**
     * Change the password of a user
     * @param int|\PDOStatement $user_id
     * @param string $password
     * @return boolean TRUE on success, FALSE on failure
     */
    public function changePassword($user_id, $password)
    {
        $user_id = intval($user_id);

        if (empty($user_id) || empty($password)) {
            return false;
        }
        // now it gets a little bit crazy: check if we have a constant
        // PSM_LOGIN_HASH_COST_FACTOR defined (in src/includes/psmconfig.inc.php),
        // if so: put the value into $hash_cost_factor, if not, make $hash_cost_factor = null
        $hash_cost_factor = (defined('PSM_LOGIN_HASH_COST_FACTOR') ? PSM_LOGIN_HASH_COST_FACTOR : null);

        // crypt the user's password with the PHP 5.5's password_hash() function, results in a 60 character hash string
        // the PASSWORD_DEFAULT constant is defined by the PHP 5.5,
        // or if you are using PHP 5.3/5.4, by the password hashing
        // compatibility library. the third parameter looks a little bit shitty, but that's how those PHP 5.5 functions
        // want the parameter: as an array with, currently only used with 'cost' => XX.
        $user_password_hash = password_hash($password, PASSWORD_DEFAULT, array('cost' => $hash_cost_factor));

        // write users new hash into database
        $query_update = $this->db_connection->prepare('UPDATE ' .
            PSM_DB_PREFIX . 'users SET password = :user_password_hash,
				password_reset_hash = NULL, password_reset_timestamp = NULL
				WHERE user_id = :user_id');
        $query_update->bindValue(':user_password_hash', $user_password_hash, \PDO::PARAM_STR);
        $query_update->bindValue(':user_id', $user_id, \PDO::PARAM_STR);
        $query_update->execute();

        // check if exactly one row was successfully changed:
        if ($query_update->rowCount() == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Gets the user id
     * @return int
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Gets the username
     * @return string
     */
    public function getUsername()
    {
        $user = $this->getUser();
        return (isset($user->user_name) ? $user->user_name : null);
    }

    /**
     * Gets the user level
     * @return int
     */
    public function getUserLevel()
    {
        $user = $this->getUser();

        if (isset($user->level)) {
            return $user->level;
        } else {
            return PSM_USER_ANONYMOUS;
        }
    }

    /**
     * read current user preferences from the database
     * @return boolean return false is user not connected
     */
    protected function loadPreferences()
    {
        if ($this->user_preferences === null) {
            if (!$this->getUser()) {
                return false;
            }

            $this->user_preferences = array();
            foreach (
                $this->db_connection->query('SELECT `key`,`value` FROM `' .
                PSM_DB_PREFIX . 'users_preferences` WHERE `user_id` = ' . $this->user_id) as $row
            ) {
                $this->user_preferences[$row['key']] = $row['value'];
            }
        }
        return true;
    }

    /**
     * Get a user preference value
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getUserPref($key, $default = '')
    {
        if (!$this->loadPreferences() || !isset($this->user_preferences[$key])) {
            return $default;
        }

        $value = $this->user_preferences[$key];
        settype($value, gettype($default));
        return $value;
    }

    /**
     * Set a user preference value
     * @param string $key
     * @param mixed $value
     */
    public function setUserPref($key, $value)
    {
        if ($this->loadPreferences()) {
            if (isset($this->user_preferences[$key])) {
                if ($this->user_preferences[$key] == $value) {
                    return; // no change
                }
                $sql = 'UPDATE `' . PSM_DB_PREFIX . 'users_preferences` SET `key` = ?, `value` = ? WHERE `user_id` = ?';
            } else {
                $sql = 'INSERT INTO `' . PSM_DB_PREFIX . 'users_preferences` SET `key` = ?, `value` = ?, `user_id` = ?';
            }
            $sth = $this->db_connection->prepare($sql);
            $sth->execute(array($key, $value, $this->user_id));
            $this->user_preferences[$key] = $value;
        }
    }

    /**
     * Get session object
     * @return \Symfony\Component\HttpFoundation\Session\SessionInterface
     */
    public function getSession()
    {
        return $this->session;
    }
}
