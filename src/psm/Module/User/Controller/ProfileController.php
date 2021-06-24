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
 * @since       phpservermon 3.0.0
 **/

namespace psm\Module\User\Controller;

use psm\Module\AbstractController;
use psm\Service\Database;

class ProfileController extends AbstractController
{

    /**
     * Editable fields for the profile
     * @var array $profile_fields
     */
    protected $profile_fields =
        array('name', 'user_name', 'email', 'mobile', 'pushover_key', 'pushover_device', 'discord', 'webhook_url', 'webhook_json', 'telegram_id', 'jabber');

    public function __construct(Database $db, \Twig_Environment $twig)
    {
        parent::__construct($db, $twig);

        $this->setActions(array(
            'index', 'save',
        ), 'index');
        $this->setCSRFKey('profile');
    }

    /**
     * Show the profile page
     * @return string
     */
    protected function executeIndex()
    {
        $this->twig->addGlobal('subtitle', psm_get_lang('users', 'profile'));
        $user = $this->getUser()->getUser(null, true);

        $modal = new \psm\Util\Module\Modal(
            $this->twig,
            'activate' . ucfirst('telegram'),
            \psm\Util\Module\Modal::MODAL_TYPE_OKCANCEL
        );
        $this->addModal($modal);
        $modal->setTitle(psm_get_lang('users', 'activate_telegram'));
        $modal->setMessage(psm_get_lang('users', 'activate_telegram_description'));
        $modal->setOKButtonLabel(psm_get_lang('system', 'activate'));

        $tpl_data = array(
            'label_general' => psm_get_lang('config', 'general'),
            'label_name' => psm_get_lang('users', 'name'),
            'label_user_name' => psm_get_lang('users', 'user_name'),
            'label_password' => psm_get_lang('users', 'password'),
            'label_password_repeat' => psm_get_lang('users', 'password_repeat'),
            'label_level' => psm_get_lang('users', 'level'),
            'label_mobile' => psm_get_lang('users', 'mobile'),
            'label_webhook' => psm_get_lang('users', 'webhook'),
            'label_webhook_description' => psm_get_lang('users', 'webhook_description'),
            'label_webhook_url' => psm_get_lang('users', 'webhook_url'),
            'label_webhook_url_description' => psm_get_lang('users', 'webhook_url_description'),
            'label_webhook_json' => psm_get_lang('users', 'webhook_json'),
            'label_webhook_json_description' => psm_get_lang('users', 'webhook_json_description'),
            'label_pushover' => psm_get_lang('users', 'pushover'),
            'label_pushover_description' => psm_get_lang('users', 'pushover_description'),
            'label_pushover_key' => psm_get_lang('users', 'pushover_key'),
            'label_pushover_device' => psm_get_lang('users', 'pushover_device'),
            'label_pushover_device_description' => psm_get_lang('users', 'pushover_device_description'),

            'label_discord' => psm_get_lang('users', 'discord'),
            'label_discord_description' => psm_get_lang('users', 'discord_description'),

            'label_telegram' => psm_get_lang('users', 'telegram'),
            'label_telegram_description' => psm_get_lang('users', 'telegram_description'),
            'label_telegram_chat_id' => psm_get_lang('users', 'telegram_chat_id'),
            'label_telegram_chat_id_description' => psm_get_lang('users', 'telegram_chat_id_description'),
            'label_activate_telegram' => psm_get_lang('users', 'activate_telegram'),
            'label_telegram_get_chat_id' => psm_get_lang('users', 'telegram_get_chat_id'),
            'telegram_get_chat_id_url' => PSM_TELEGRAM_GET_ID_URL,
            'label_jabber' => psm_get_lang('users', 'jabber'),
            'label_jabber_description' => psm_get_lang('users', 'jabber_description'),
            'label_email' => psm_get_lang('users', 'email'),
            'label_save' => psm_get_lang('system', 'save'),
            'form_action' => psm_build_url(array(
                'mod' => 'user_profile',
                'action' => 'save',
            )),
            'level' => psm_get_lang('users', 'level_' . $user->level),
            'placeholder_password' => psm_get_lang('users', 'password_leave_blank'),
        );
        foreach ($this->profile_fields as $field) {
            $tpl_data[$field] = (isset($user->$field)) ? $user->$field : '';
        }
        return $this->twig->render('module/user/profile.tpl.html', $tpl_data);
    }

    /**
     * Save the profile
     */
    protected function executeSave()
    {
        if (empty($_POST)) {
            // dont process anything if no data has been posted
            return $this->executeIndex();
        }
        $validator = $this->container->get('util.user.validator');
        $fields = $this->profile_fields;
        $fields[] = 'password';
        $fields[] = 'password_repeat';

        $clean = array();
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                $clean[$field] = trim(strip_tags($_POST[$field]));
            } else {
                $clean[$field] = '';
            }
        }

        // validate the lot
        try {
            $validator->username($clean['user_name'], $this->getUser()->getUserId());
            $validator->email($clean['email']);

            // always validate password for new users,
            // but only validate it for existing users when they change it.
            if ($clean['password'] != '') {
                $validator->password($clean['password'], $clean['password_repeat']);
            }
        } catch (\InvalidArgumentException $e) {
            $this->addMessage(psm_get_lang('users', 'error_' . $e->getMessage()), 'error');
            return $this->executeIndex();
        }
        if (!empty($clean['password'])) {
            $password = $clean['password'];
        }
        unset($clean['password']);
        unset($clean['password_repeat']);

        $this->db->save(PSM_DB_PREFIX . 'users', $clean, array('user_id' => $this->getUser()->getUserId()));
        $this->container->get('event')->dispatch(
            \psm\Module\User\UserEvents::USER_EDIT,
            new \psm\Module\User\Event\UserEvent($this->getUser()->getUserId())
        );
        if (isset($password)) {
            $this->getUser()->changePassword($this->getUser()->getUserId(), $password);
        }
        $this->addMessage(psm_get_lang('users', 'profile_updated'), 'success');
        if (!empty($_POST['activate_telegram'])) {
            $this->activateTelegram();
        }
        return $this->executeIndex();
    }

    /**
     * Allow the bot to send notifications to chat_id
     *
     */
    protected function activateTelegram()
    {
        $telegram = psm_build_telegram();
        $apiToken = psm_get_conf('telegram_api_token');

        if (empty($apiToken)) {
            $this->addMessage(psm_get_lang('config', 'telegram_error_notoken'), 'error');
            return;
        }

        $result = $telegram->getBotUsername();

        if (isset($result['ok']) && $result['ok'] != false) {
            $url = "https://t.me/" . $result["result"]["username"];
            $this->addMessage(sprintf(psm_get_lang('users', 'telegram_bot_username_found'), $url), 'success');
            return;
        }

        if (isset($result['error_code']) && $result['error_code'] == 401) {
            $error = psm_get_lang('users', 'telegram_bot_username_error_token');
        } elseif (isset($result['description'])) {
            $error = $result['description'];
        } else {
            $error = 'Unknown';
        }
        $this->addMessage(sprintf(psm_get_lang('users', 'telegram_bot_error'), $error), 'error');
    }
}
