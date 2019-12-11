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

namespace psm\Module\User\Controller;

use psm\Module\AbstractController;
use psm\Service\Database;

class LoginController extends AbstractController
{

    public function __construct(Database $db, \Twig_Environment $twig)
    {
        parent::__construct($db, $twig);

        $this->setMinUserLevelRequired(PSM_USER_ANONYMOUS);

        $this->setActions(array(
            'login', 'forgot', 'reset',
        ), 'login');

        $this->addMenu(false);
    }

    protected function executeLogin()
    {
        if (isset($_POST['user_name']) && isset($_POST['user_password'])) {
            $rememberme = (isset($_POST['user_rememberme'])) ? true : false;
            $result = $this->getUser()->loginWithPostData(
                $_POST['user_name'],
                $_POST['user_password'],
                $rememberme
            );

            if ($result) {
                // success login, redirect
                header('Location: ' .
                    psm_build_url(
                        empty($_SERVER["QUERY_STRING"]) ? null : $_SERVER["QUERY_STRING"]
                    ));
                die();
            } else {
                $this->addMessage(psm_get_lang('login', 'error_login_incorrect'), 'error');
            }
        }

        $tpl_data = array(
            'title_sign_in' => psm_get_lang('login', 'title_sign_in'),
            'label_username' => psm_get_lang('login', 'username'),
            'label_password' => psm_get_lang('login', 'password'),
            'label_remember_me' => psm_get_lang('login', 'remember_me'),
            'label_login' => psm_get_lang('login', 'login'),
            'label_password_forgot' => psm_get_lang('login', 'password_forgot'),
            'value_user_name' => (isset($_POST['user_name'])) ? $_POST['user_name'] : '',
            'value_rememberme' => (isset($rememberme) && $rememberme) ? 'checked="checked"' : '',
        );

        return $this->twig->render('module/user/login/login.tpl.html', $tpl_data);
    }

    /**
     * Show/process the password forgot form (before the mail)
     *
     * @return string
     */
    protected function executeForgot()
    {
        if (isset($_POST['user_name'])) {
            $user = $this->getUser()->getUserByUsername($_POST['user_name']);

            if (!empty($user)) {
                $token = $this->getUser()->generatePasswordResetToken($user->user_id);
                // we have a token, send it along
                $this->sendPasswordForgotMail(
                    $user->user_id,
                    $user->email,
                    $token
                );

                $this->addMessage(psm_get_lang('login', 'success_password_forgot'), 'success');
                return $this->executeLogin();
            } else {
                $this->addMessage(psm_get_lang('login', 'error_user_incorrect'), 'error');
            }
        }

        $tpl_data = array(
            'title_forgot' => psm_get_lang('login', 'title_forgot'),
            'label_username' => psm_get_lang('login', 'username'),
            'label_submit' => psm_get_lang('login', 'submit'),
            'label_go_back' => psm_get_lang('system', 'go_back'),
        );
        return $this->twig->render('module/user/login/forgot.tpl.html', $tpl_data);
    }

    /**
     * Show/process the password reset form (after the mail)
     */
    protected function executeReset()
    {
        $service_user = $this->getUser();
        $user_id = (isset($_GET['user_id'])) ? intval($_GET['user_id']) : 0;
        $token = (isset($_GET['token'])) ? $_GET['token'] : '';

        if (!$service_user->verifyPasswordResetToken($user_id, $token)) {
            $this->addMessage(psm_get_lang('login', 'error_reset_invalid_link'), 'error');
            return $this->executeLogin();
        }

        if (!empty($_POST['user_password_new']) && !empty($_POST['user_password_repeat'])) {
            if ($_POST['user_password_new'] !== $_POST['user_password_repeat']) {
                $this->addMessage(psm_get_lang('login', 'error_login_passwords_nomatch'), 'error');
            } else {
                $result = $service_user->changePassword($user_id, $_POST['user_password_new']);

                if ($result) {
                    $this->addMessage(psm_get_lang('login', 'success_password_reset'), 'success');
                    return $this->executeLogin();
                } else {
                    $this->addMessage(psm_get_lang('login', 'error_login_incorrect'), 'error');
                }
            }
        }
        $user = $service_user->getUser($user_id);

        $tpl_data = array(
            'title_reset' => psm_get_lang('login', 'title_reset'),
            'label_username' => psm_get_lang('login', 'username'),
            'label_password' => psm_get_lang('login', 'password'),
            'label_password_repeat' => psm_get_lang('login', 'password_repeat'),
            'label_reset' => psm_get_lang('login', 'password_reset'),
            'label_go_back' => psm_get_lang('system', 'go_back'),
            'value_user_name' => $user->user_name,
        );
        return $this->twig->render('module/user/login/reset.tpl.html', $tpl_data);
    }

    /**
     * Sends the password-reset-email.
     * @param int $user_id
     * @param string $user_email
     * @param string $user_password_reset_hash
     */
    protected function sendPasswordForgotMail($user_id, $user_email, $user_password_reset_hash)
    {
        $mail = psm_build_mail();
        $mail->Subject = psm_get_lang('login', 'password_reset_email_subject');

        $url = psm_build_url(array(
            'action' => 'reset',
            'user_id' => $user_id,
            'token' => $user_password_reset_hash,
        ), true, false);
        $body = psm_get_lang('login', 'password_reset_email_body');
        $body = str_replace('%link%', $url, $body);
        $mail->Body = $body;
        $mail->AltBody = str_replace('<br/>', "\n", $body);

        $mail->AddAddress($user_email);
        $mail->Send();
    }
}
