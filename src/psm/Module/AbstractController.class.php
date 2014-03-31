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
 * @author      Pepijn Over <pep@neanderthal-technology.com>
 * @copyright   Copyright (c) 2008-2014 Pepijn Over <pep@neanderthal-technology.com>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

namespace psm\Module;
use psm\Service\Database;
use psm\Service\Template;

abstract class AbstractController implements ControllerInterface {

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
	 * Database object
	 * @var \psm\Service\Database $db
	 */
	protected $db;

	/**
	 * Template object
	 * @var \psm\Service\Template $tpl
	 */
	protected $tpl;

	/**
	 * Template Id that should be added to the main template
	 * @var string
	 * @see setTemplateId() getTemplateId()
	 */
	protected $tpl_id;

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
	protected $user_level_required = PSM_USER_USER;

	/**
	 * Required user level for certain actions
	 * @var int $user_level_required_actions
	 * @see setMinUserLevelRequiredForAction()
	 */
	protected $user_level_required_actions = array();

	function __construct(Database $db, Template $tpl) {
		$this->db = $db;
		$this->tpl = $tpl;
	}

	/**
	 * Initialize the module
	 */
	public function initialize() {
		$action = psm_GET('action', psm_POST('action', $this->action_default));

		if(!in_array($action, $this->actions) || !$this->initializeAction($action)) {
			$this->initializeAction($this->action_default);
		}

		$this->createHTML();
	}

	/**
	 * Run a specified action
	 *
	 * For it to run, the "execute$action" method must exist.
	 * @param string $action
	 * @return boolean whether action has been initialized successfully
	 */
	protected function initializeAction($action) {
		if(isset($this->user_level_required_actions[$action])) {
			$ulvl = ($this->user) ? $this->user->getUserLevel() : PSM_USER_ANONYMOUS;

			if($ulvl > $this->user_level_required_actions[$action]) {
				// user is not allowed to access this action..
				return false;
			}
		}
		$method = 'execute' . ucfirst($action);
		if(method_exists($this, $method)) {
			$this->action = $action;
			$this->$method();
			return true;
		}
		return false;
	}

	/**
	 * Create the HTML code for the module.
	 * First the createHTMLLabels() will be called to add all labels to the template,
	 * Then the tpl_id set in $this->getTemplateId() will be added to the main template automatically
	 */
	protected function createHTML() {
		$tpl_data = array();

		if(!empty($this->messages)) {
			$this->tpl->addTemplateDataRepeat('main', 'messages', $this->messages);
		}
		// add menu to page?
		if($this->add_menu) {
			$tpl_data['html_menu'] = $this->createHTMLMenu();
		}
		// add sidebar to page?
		if($this->sidebar !== null) {
			$tpl_data['html_sidebar'] = $this->sidebar->createHTML();
			$tpl_data['content_span'] = '10';
		} else {
			$tpl_data['content_span'] = '12';
		}
		// add footer to page?
		if($this->add_footer) {
			$this->tpl->newTemplate('main_footer', 'main.tpl.html');
			$tpl_data['html_footer'] = $this->tpl->getTemplate('main_footer');
		}

		$tpl_id_content = $this->getTemplateId();
		if($tpl_id_content) {
			$tpl_data['content'] = $this->tpl->getTemplate($tpl_id_content);
		}

		if(psm_update_available()) {
			$tpl_data['update_available'] = str_replace('{version}', 'v'.psm_get_conf('version_update_check'), psm_get_lang('system', 'update_available'));
		}

		// add the module's custom template to the main template to get some content
		$this->setTemplateId('main');
		$this->tpl->addTemplatedata($this->getTemplateId(), $tpl_data);
		$this->createHTMLLabels();

		// display main template
		echo $this->tpl->display($this->getTemplateId());
	}

	/**
	 * Create HTML code for the menu
	 * @return string
	 */
	protected function createHTMLMenu() {
		$ulvl = ($this->user) ? $this->user->getUserLevel() : PSM_USER_ANONYMOUS;

		$tpl_id = 'main_menu';
		$this->tpl->newTemplate($tpl_id, 'main.tpl.html');

		$tpl_data = array(
			'label_help' => psm_get_lang('menu', 'help'),
			'label_profile' => psm_get_lang('users', 'profile'),
			'label_logout' => psm_get_lang('login', 'logout'),
			'url_profile' => psm_build_url(array('mod' => 'user_profile')),
			'url_logout' => psm_build_url(array('logout' => 1)),
		);

		switch($ulvl) {
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
		$menu = array();
		foreach($items as $key) {
			$menu[] = array(
				'active' => ($key == psm_GET('mod')) ? 'active' : '',
				'url' => psm_build_url(array('mod' => $key)),
				'label' => psm_get_lang('menu', $key),
			);
		}
		if(!empty($menu)) {
			$this->tpl->addTemplateDataRepeat($tpl_id, 'menu', $menu);
		}

		if($ulvl != PSM_USER_ANONYMOUS) {
			$user = $this->user->getUser();
			$tpl_data['label_usermenu'] = str_replace(
				'%user_name%',
				$user->name,
				psm_get_lang('login', 'welcome_usermenu')
			);
		}
		$this->tpl->addTemplateData($tpl_id, $tpl_data);

		return $this->tpl->getTemplate($tpl_id);
	}

	/**
	 * Use this to add language specific labels to template
	 *
	 * @see createHTML()
	 */
	protected function createHTMLLabels() {
		global $type;

		$this->tpl->addTemplateData(
			'main',
			array(
				'title' => strtoupper(psm_get_lang('system', 'title')),
				'label_back_to_top' => psm_get_lang('system', 'back_to_top'),
			)
		);
	}

	/**
	 * Set a template id that will be added to the main template automatically
	 * once you call the parent::createHTML()
	 *
	 * @param string $tpl_id
	 * @param string $tpl_file if given, the tpl_id will be created automatically from this file
	 * @see getTemplateId() createHTML()
	 */
	public function setTemplateId($tpl_id, $tpl_file = null) {
		$this->tpl_id = $tpl_id;

		if($tpl_file != null) {
			// tpl_file given, try to load the template..
			$this->tpl->newTemplate($tpl_id, $tpl_file);
		}
	}

	/**
	 * Get the mpalte id that will be added to the main template
	 *
	 * @return string
	 * @see setTemplateId()
	 */
	public function getTemplateId() {
		return $this->tpl_id;
	}

	/**
	 * Hide or show the footer of the page
	 * @param boolean $value
	 */
	protected function addFooter($value) {
		$this->add_footer = $value;
	}

	/**
	 * Hide or show the menu of the page
	 * @param boolean $value
	 */
	protected function addMenu($value) {
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
	protected function setActions($actions, $default = null, $append = true) {
		if(!is_array($actions)) {
			$actions = array($actions);
		}
		if($append) {
			$this->actions = array_merge($actions);
		} else {
			$this->actions = $actions;
		}
		if($default !== null) {
			$this->action_default = $default;
		}
		return $this;
	}

	/**
	 * Get the current action
	 * @return string
	 * @see setActions()
	 */
	public function getAction() {
		return $this->action;
	}

	/**
	 * Add one or multiple message to the stack to be displayed to the user
	 * @param string|array $msg
	 * @param string $shortcode info/success/warning/error
	 * @return \psm\Module\AbstractModule
	 */
	public function addMessage($msg, $shortcode = 'info') {
		if(!is_array($msg)) {
			$msg = array($msg);
		}
		switch($shortcode) {
			case 'error':
				$icon = 'exclamation-sign';
				break;
			case 'success':
				$icon = 'ok-sign';
				break;
			case 'warning':
				$icon = 'question-sign';
				break;
			default:
				$icon = 'info-sign';
				break;
		}

		foreach($msg as $m) {
			$this->messages[] = array(
				'message' => $m,
				'shortcode' => $shortcode,
				'icon' => $icon,
			);
		}
		return $this;
	}

	/**
	 * Set user service
	 * @param \psm\Service\User $user
	 */
	public function setUser(\psm\Service\User $user) {
		$this->user = $user;
	}

	/**
	 * Set the minimum required user level for this module
	 * @param int $level
	 * @return \psm\Module\AbstractController
	 */
	public function setMinUserLevelRequired($level) {
		$this->user_level_required = intval($level);
		return $this;
	}

	/**
	 * Get the minimum required user level for this module
	 * @return int
	 */
	public function getMinUserLevelRequired() {
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
	public function setMinUserLevelRequiredForAction($level, $actions) {
		if(!is_array($actions)) {
			$actions = array($actions);
		}
		foreach($actions as $action) {
			$this->user_level_required_actions[$action] = intval($level);
		}
		return $this;
	}

	/**
	 * Add a sidebar to the page
	 * @param \psm\Util\Module\SidebarInterface $sidebar
	 * @return \psm\Module\ControllerInterface
	 */
	public function setSidebar(\psm\Util\Module\SidebarInterface $sidebar) {
		$this->sidebar = $sidebar;
		return $this;
	}
}
