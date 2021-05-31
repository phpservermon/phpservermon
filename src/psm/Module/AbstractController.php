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

namespace psm\Module;

use psm\Service\Database;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

abstract class AbstractController implements ControllerInterface
{
    use ContainerAwareTrait;

    /**
     * Current action
     * @var string $action
     */
    protected $action;

    /**
     * Default action
     * @var string $action_default
     * @see setActions()
     */
    protected $action_default;

    /**
     * Actions available for this module
     * @var array $actions
     * @see setActions()
     * @see getAction()
     */
    protected $actions = array();

    /**
     * Add footer to page?
     * @var boolean $add_footer
     * @see addFooter()
     */
    protected $add_footer = true;

    /**
     * Add menu to page?
     * @var boolean $add_menu
     * @see addMenu()
     */
    protected $add_menu = true;

    /**
     * @var string $csrf_key
     */
    protected $csrf_key;

    /**
     * Messages to show the user
     * @var array $messages
     * @see addMessage()
     */
    protected $messages = array();

    /**
     * Sidebar to add
     * @var \psm\Util\Module\Sidebar $sidebar
     */
    protected $sidebar;

    /**
     * array of Modal to add
     * @var \psm\Util\Module\ModalInterface[] $modal
     */
    protected $modal = array();

    /**
     * html code of header accessories
     * @var string $header_accessories
     */
    protected $header_accessories;

    /**
     * Database object
     * @var \psm\Service\Database $db
     */
    protected $db;

    /**
     * Twig object
     * @var \Twig_Environment $twig
     */
    protected $twig;

    /**
     * User service
     * @var \psm\Service\User $user
     */
    protected $user;

    /**
     * Required user level for this module
     * @var int $user_level_required
     * @see setMinUserLevelRequired()
     */
    protected $user_level_required = (PSM_PUBLIC && PSM_PUBLIC_PAGE) ? PSM_USER_ANONYMOUS : PSM_USER_USER;

    /**
     * Required user level for certain actions
     * @var int $user_level_required_actions
     * @see setMinUserLevelRequiredForAction()
     */
    protected $user_level_required_actions = array();

    /*
     * Required using black background layout
     * @var boolean $black_background
     */
    protected $black_background = false;

    /**
     * XHR mode?
     * @var boolean $xhr
     * @see isXHR()
     */
    protected $xhr = false;

    public function __construct(Database $db, \Twig_Environment $twig)
    {
        $this->db = $db;
        $this->twig = $twig;
    }

    /**
     * Run the controller.
     *
     * @param string $action if NULL, the action will be retrieved from user input (GET/POST)
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function run($action = null)
    {
        if ($action === null) {
            $action = psm_GET('action', psm_POST('action', $this->action_default));
        }
        $this->xhr = (bool) psm_GET('xhr', psm_POST('xhr', false));

        $result = $this->runAction($action);

        if (!in_array($action, $this->actions) || !$result) {
            $result = $this->runAction($this->action_default);
        }

        if ($result instanceof Response) {
            return $result;
        }

        // no response returned from execute, create regular HTML
        return $this->createHTML($result);
    }

    /**
     * Run a specified action
     *
     * For it to run, the "execute$action" method must exist.
     * @param string $action
     * @return mixed FALSE when action couldnt be initialized, response otherwise
     */
    protected function runAction($action)
    {
        if (isset($this->user_level_required_actions[$action])) {
            if ($this->getUser()->getUserLevel() > $this->user_level_required_actions[$action]) {
                // user is not allowed to access this action..
                return false;
            }
        }
        $method = 'execute' . ucfirst($action);
        if (method_exists($this, $method)) {
            $this->action = $action;
            $result = $this->$method();
            // if result from execute is null, no return value given so return true to indicate a successful execute
            return ($result === null) ? true : $result;
        }
        return false;
    }

    /**
     * Create the HTML code for the module.
     *
     * If XHR is on, no main template will be added.
     *
     * @param string $html HTML code to add to the main body
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function createHTML($html = null)
    {
        if (!$this->xhr) {
            // in XHR mode, we will not add the main template
            $tpl_data = array(
                'title' => psm_get_conf('site_title', strtoupper(psm_get_lang('system', 'title'))),
                'label_back_to_top' => psm_get_lang('system', 'back_to_top'),
                'add_footer' => $this->add_footer,
                'version' => 'v' . PSM_VERSION,
                'messages' => $this->getMessages(),
                'html_content' => $html,
            );

            // add menu to page?
            if ($this->add_menu) {
                $tpl_data['html_menu'] = $this->createHTMLMenu();
            }
            // add header accessories to page ?
            if ($this->header_accessories) {
                $tpl_data['header_accessories'] = $this->header_accessories;
            }
            // add modal dialog to page ?
            if (sizeof($this->modal)) {
                $html_modal = '';
                foreach ($this->modal as $modal) {
                    $html_modal .= $modal->createHTML();
                }
                $tpl_data['html_modal'] = $html_modal;
            }
            // add sidebar to page?
            if ($this->sidebar !== null) {
                $tpl_data['html_sidebar'] = $this->sidebar->createHTML();
            }

            if (psm_update_available()) {
                $tpl_data['update_available'] = str_replace(
                    '{version}',
                    'v' .
                    psm_get_conf('version_update_check'),
                    psm_get_lang('system', 'update_available')
                );
            }

            if ($this->black_background) {
                $tpl_data['body_class'] = 'black_background';
            }
            $html = $this->twig->render('main/body.tpl.html', $tpl_data);
        }

        $response = new Response($html);

        return $response;
    }

    /**
     * Create HTML code for the menu
     * @return string
     */
    protected function createHTMLMenu()
    {
        $ulvl = $this->getUser()->getUserLevel();

        $tpl_data = array(
            'label_help' => psm_get_lang('menu', 'help'),
            'label_profile' => psm_get_lang('users', 'profile'),
            'label_logout' => psm_get_lang('login', 'logout'),
            'url_profile' => psm_build_url(array('mod' => 'user_profile')),
            'url_logout' => psm_build_url(array('logout' => 1)),
            'label_current' => psm_get_lang('system', 'current'),
        );

        switch ($ulvl) {
            case PSM_USER_ADMIN:
                $items = array('server_status', 'server', 'server_log', 'user', 'config', 'server_update');
                break;
            case PSM_USER_USER:
                $items = array('server_status', 'server', 'server_log', 'server_update');
                break;
            default:
                $items = array();
                break;
        }
        $tpl_data['menu'] = array();
        foreach ($items as $key) {
            $tpl_data['menu'][] = array(
                'active' => ($key == psm_GET('mod')) ? 'active' : '',
                'url' => psm_build_url(array('mod' => $key)),
                'label' => psm_get_lang('menu', $key),
            );
        }

        if ($ulvl != PSM_USER_ANONYMOUS) {
            $user = $this->getUser()->getUser();
            $tpl_data['label_usermenu'] = str_replace(
                '%user_name%',
                $user->name,
                psm_get_lang('login', 'welcome_usermenu')
            );
        }
        return $this->twig->render('main/menu.tpl.html', $tpl_data);
    }

    /**
     * Hide or show the footer of the page
     * @param boolean $value
     */
    protected function addFooter($value)
    {
        $this->add_footer = $value;
    }

    /**
     * Hide or show the menu of the page
     * @param boolean $value
     */
    protected function addMenu($value)
    {
        $this->add_menu = $value;
    }

    /**
     * Set actions available
     * @param string|array $actions
     * @param string $default default action
     * @param boolean $append if TRUE, the actions will be added to the current actions
     * @return psm\Module\AbstractModule
     * @see getAction()
     */
    protected function setActions($actions, $default = null, $append = true)
    {
        if (!is_array($actions)) {
            $actions = array($actions);
        }
        if ($append) {
            $this->actions = array_merge($actions);
        } else {
            $this->actions = $actions;
        }
        if ($default !== null) {
            $this->action_default = $default;
        }
        return $this;
    }

    /**
     * Get the current action
     * @return string
     * @see setActions()
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Add one or multiple message to the stack to be displayed to the user
     * @param string|array $msg
     * @param string $shortcode primary/success/warning/danger
     * @return \psm\Module\ControllerInterface
     * @see getMessages()
     */
    public function addMessage($msg, $shortcode = 'primary')
    {
        if (!is_array($msg)) {
            $msg = array($msg);
        }
        $class = $shortcode;
        switch ($shortcode) {
            case 'error':
                $icon = 'exclamation-circle';
                $class = 'danger';
                break;
            case 'success':
                $icon = 'check-circle';
                break;
            case 'warning':
                $icon = 'exclamation-triangle';
                break;
            case 'primary':
            default:
                $icon = 'info-circle';
                $shortcode = 'info';
                break;
        }

        foreach ($msg as $m) {
            $this->messages[] = array(
                'message' => $m,
                'shortcode' => $shortcode,
                'class' => $class,
                'icon' => $icon,
            );
        }
        return $this;
    }

    /**
     * Get all messages (and optionally clear them)
     * @param boolean $clear
     * @return array
     * @see addMessage()
     */
    public function getMessages($clear = true)
    {
        $msgs = $this->messages;
        if ($clear) {
            $this->messages = array();
        }
        return $msgs;
    }

    /**
     * Set the minimum required user level for this controller
     * @param int $level
     * @return \psm\Module\AbstractController
     */
    public function setMinUserLevelRequired($level)
    {
        $this->user_level_required = intval($level);
        return $this;
    }

    /**
     * Get the minimum required user level for this controller
     * @return int
     */
    public function getMinUserLevelRequired()
    {
        return $this->user_level_required;
    }

    /**
     * Set the minimum required user level for a certain action.
     *
     * Use this only if one of the access is more restricted than the entire controller
     * @param int $level
     * @param string|array $actions one or more actions to set this level for
     * @return \psm\Module\AbstractController
     * @see setMinUserLevelRequired()
     */
    public function setMinUserLevelRequiredForAction($level, $actions)
    {
        if (!is_array($actions)) {
            $actions = array($actions);
        }
        foreach ($actions as $action) {
            $this->user_level_required_actions[$action] = intval($level);
        }
        return $this;
    }

    /**
     * Add a sidebar to the page
     * @param \psm\Util\Module\SidebarInterface $sidebar
     * @return \psm\Module\ControllerInterface
     */
    public function setSidebar(\psm\Util\Module\SidebarInterface $sidebar)
    {
        $this->sidebar = $sidebar;
        return $this;
    }

    /**
     * Add a modal dialog to the page
     * @param \psm\Util\Module\ModalInterface $modal
     * @return \psm\Module\ControllerInterface
     */
    public function addModal(\psm\Util\Module\ModalInterface $modal)
    {
        $this->modal[$modal->getModalID()] = $modal;
        return $this;
    }

    /**
     * Set the html code of the header accessories
     * @param string $html
     */
    public function setHeaderAccessories($html)
    {
        $this->header_accessories = $html;
    }

    /**
     * Check if XHR is on
     * @return boolean
     */
    public function isXHR()
    {
        return $this->xhr;
    }

    /**
     * Get user service
     * @return \psm\Service\User
     */
    public function getUser()
    {
        return $this->container->get('user');
    }

    /**
     * Get custom key for CSRF validation
     * @return string
     */
    public function getCSRFKey()
    {
        return $this->csrf_key;
    }

    /**
     * Set CSRF key for validation
     * @param string $key
     * @return \psm\Module\ControllerInterface
     */
    protected function setCSRFKey($key)
    {
        $this->csrf_key = $key;
        $this->twig->addGlobal('csrf_key', $key);
        return $this;
    }
}
