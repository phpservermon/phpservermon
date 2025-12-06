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
use Symfony\Component\HttpFoundation\JsonResponse;

class ProfileController extends AbstractController
{

    /**
     * Editable fields for the profile
     * @var array $profile_fields
     */
    protected $profile_fields =
        array('name', 'user_name', 'email', 'mobile', 'telegram_id');

    /**
     * Available theme preferences.
     *
     * @var string[]
     */
    private $theme_options = array('light', 'dark', 'blue', 'green');

    public function __construct(Database $db, \Twig\Environment $twig)
    {
        parent::__construct($db, $twig);

        $this->setActions(array(
            'index', 'save', 'saveTheme',
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
            'label_telegram' => psm_get_lang('users', 'telegram'),
            'label_telegram_description' => psm_get_lang('users', 'telegram_description'),
            'label_telegram_chat_id' => psm_get_lang('users', 'telegram_chat_id'),
            'label_telegram_chat_id_description' => psm_get_lang('users', 'telegram_chat_id_description'),
            'label_activate_telegram' => psm_get_lang('users', 'activate_telegram'),
            'label_telegram_get_chat_id' => psm_get_lang('users', 'telegram_get_chat_id'),
            'telegram_get_chat_id_url' => PSM_TELEGRAM_GET_ID_URL,
            'label_email' => psm_get_lang('users', 'email'),
            'label_theme' => psm_get_lang('users', 'theme'),
            'theme_options' => $this->getThemeOptionLabels(),
            'theme' => $this->normalizeTheme($this->getUser()->getUserPref('theme', 'light')),
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
                $clean[$field] = $this->sanitizePostedField($_POST[$field]);
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
        $theme = isset($_POST['theme']) ? $this->normalizeTheme($this->sanitizePostedField($_POST['theme'])) : 'light';
        $this->getUser()->setUserPref('theme', $theme);
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
     * Normalize and sanitize incoming POST values to avoid runtime errors.
     *
     * @param mixed $value
     * @return string
     */
    private function sanitizePostedField($value)
    {
        if (is_array($value)) {
            return '';
        }

        return trim(strip_tags((string) $value));
    }

    /**
     * Normalize incoming theme values to allowed options.
     *
     * @param string $value
     * @return string
     */
    private function normalizeTheme($value)
    {
        $theme = in_array($value, $this->theme_options, true) ? $value : 'light';
        return $theme;
    }

    /**
     * Get available theme options with labels.
     *
     * @return array
     */
    private function getThemeOptionLabels()
    {
        $options = array();
        foreach ($this->theme_options as $option) {
            $options[] = array(
                'value' => $option,
                'label' => psm_get_lang('users', 'theme_' . $option),
            );
        }

        return $options;
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

    /**
     * Save the theme preference for the current user via XHR.
     *
     * @return JsonResponse
     */
    protected function executeSaveTheme()
    {
        if (!$this->isXHR()) {
            return $this->executeIndex();
        }

        $theme = $this->normalizeTheme(psm_POST('theme', 'light'));
        $this->getUser()->setUserPref('theme', $theme);

        return new JsonResponse(array('theme' => $theme));
    }
}
