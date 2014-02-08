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
 * @link        http://phpservermon.neanderthal-technology.com/
 **/

namespace psm\Module;
use psm\Service\Database;
use psm\Service\Template;

abstract class AbstractModule implements ModuleInterface {

	/**
	 * Current mode. Can be used by modules to determine
	 * what to do
	 * @var string $mode
	 */
	public $mode;

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
	 * @see getMessage()
	 */
	protected $messages = array();

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

	function __construct(Database $db, Template $tpl) {
		$this->db = $db;
		$this->tpl = $tpl;
	}

	/**
	 * Initialize the module
	 */
	public function initialize() {
		// yeh baby, "initialize" me..
		// right, anyway, lets determine the aciton
		$action = null;

		if(isset($_GET['action'])) {
			$action = $_GET['action'];
		} elseif(isset($_POST['action'])) {
			$action = $_POST['action'];
		}
		if($action !== null && in_array($action, $this->actions)) {
			// we have an action
			$this->initializeAction($action);
		} elseif($this->action_default !== null) {
			$this->initializeAction($this->action_default);
		} else {
			// else what..?
		}

		$this->createHTML();
	}

	/**
	 * Run a specified action
	 *
	 * For it to run, the "execute$action" method must exist
	 * @param string $action
	 */
	protected function initializeAction($action) {
		$this->action = $action;
		$method = 'execute' . ucfirst($action);
		if(method_exists($this, $method)) {
			$this->$method();
		}
	}

	/**
	 * Create the HTML code for the module.
	 * First the createHTMLLabels() will be called to add all labels to the template,
	 * Then the tpl_id set in $this->getTemplateId() will be added to the main template automatically
	 */
	protected function createHTML() {
		if(psm_get_conf('show_update')) {
			// user wants updates, lets see what we can do
			$this->createHTMLUpdateAvailable();
		}
		$tpl_data = array(
			'message' => (empty($this->messages)) ? '&nbsp' : implode('<br/>', $this->messages),
		);
		// add menu to page?
		if($this->add_menu) {
			$this->tpl->newTemplate('main_menu', 'main.tpl.html');
			$tpl_data['html_menu'] = $this->tpl->getTemplate('main_menu');
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

		// add the module's custom template to the main template to get some content
		$this->setTemplateId('main');
		$this->tpl->addTemplatedata($this->getTemplateId(), $tpl_data);
		$this->createHTMLLabels();

		// display main template
		echo $this->tpl->display($this->getTemplateId());
	}

	/**
	 * First check if an update is available, if there is add a message
	 * to the main template
	 */
	protected function createHTMLUpdateAvailable() {
		// check for updates?

		if(psm_check_updates()) {
			// yay, new update available =D
			$this->addMessage(psm_get_lang('system', 'update_available'));
		}
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
				'subtitle' => psm_get_lang('system', $type),
				'active_' . $type => 'active',
				'label_servers' => psm_get_lang('system', 'servers'),
				'label_users' => psm_get_lang('system', 'users'),
				'label_log' => psm_get_lang('system', 'log'),
				'label_status' => psm_get_lang('system', 'status'),
				'label_config' => psm_get_lang('system', 'config'),
				'label_update' => psm_get_lang('system', 'update'),
				'label_help' => psm_get_lang('system', 'help'),
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
	 * @return \psm\Module\AbstractModule
	 */
	public function addMessage($msg) {
		if(!is_array($msg)) {
			$msg = array($msg);
		}
		$this->messages = array_merge($this->messages, $msg);
		return $this;
	}
}

?>