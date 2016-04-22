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
 * @author      Pepijn Over <pep@peplab.net>
 * @copyright   Copyright (c) 2008-2015 Pepijn Over <pep@peplab.net>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 * @since		phpservermon 3.0
 **/

namespace psm;
use Symfony\Component\HttpFoundation\Response;

/**
 * The router class opens the controller and initializes the module.
 *
 * The router has the list of available modules, and it will check them for
 * available controllers.
 * It uses a so-called $mod param to determine which controller to load.
 * The $mod can either be passed as GET var or directly to the run() method.
 * The $mod has 2 components, separated by an underscore. The first part determines
 * the module to load, the second on the controller. It uses the keys defined in
 * the module config. If the controller part is absent, it will always try to load
 * the controller with the same name as the module.
 */
class Router {

	/**
	 * Default module (if none given or invalid one)
	 * @var string $default_module
	 */
	public $default_module = 'server_status';

	/**
	 * Controller map
	 * @var array $map
	 */
	protected $map = array();

	/**
	 * Registered services
	 * @var array $services
	 */
	protected $services = array();

	public function __construct() {
		global $db;
		$this->services['db'] = $db;
		$this->services['user'] = new \psm\Service\User($db);

		$loader = new \Twig_Loader_Filesystem(PSM_PATH_TPL . PSM_THEME);
		$this->services['twig'] = new \Twig_Environment($loader);
		if(PSM_DEBUG) {
			$this->services['twig']->enableDebug();
		}

		$modules = $this->getModules();

		foreach($modules as $id => $module) {
			$this->map[$id] = $module->getControllers();
		}
	}

	/**
	 * Get registered modules
	 *
	 * Note, the index of each module is also the key used for mapping getvars.
	 * @return array
	 */
	public function getModules() {
		return array(
			'config' => new Module\Config\ConfigModule(),
			'error' => new Module\Error\ErrorModule(),
			'server' => new Module\Server\ServerModule(),
			'user' => new Module\User\UserModule(),
			'install' => new Module\Install\InstallModule(),
		);
	}

	/**
	 * Run.
	 *
	 * The $mod param is in the format $module_$controller.
	 * If the "_$controller" part is omitted, it will attempt to load
	 * the controller with the same name as the module.
	 * If no mod is given it will attempt to load the default module.
	 * @param string $mod if empty, the mod getvar will be used, or fallback to default
	 * @throws \InvalidArgumentException
	 * @throws \LogicException
	 */
	public function run($mod = null) {
		if(!psm_is_cli() && isset($_GET["logout"])) {
			$this->services['user']->doLogout();
			// logged out, redirect to login
			header('Location: ' . psm_build_url());
			die();
		}

		if($mod === null) {
			$mod = psm_GET('mod', $this->default_module);
		}

		try {
			$controller = $this->getController($mod);
		} catch(\InvalidArgumentException $e) {
			// invalid module, try the default one
			// it that somehow also doesnt exist, we have a bit of an issue
			// and we really have no reason catch it
			$controller = $this->getController($this->default_module);
		}
		// get min required level for this controller and make sure the user matches
		$min_lvl = $controller->getMinUserLevelRequired();
		$action = null;

		if($min_lvl < PSM_USER_ANONYMOUS) {
			// if user is not logged in, load login module
			if(!$this->services['user']->isUserLoggedIn()) {
				$controller = $this->getController('user_login');
			} elseif($this->services['user']->getUserLevel() > $min_lvl) {
				$controller = $this->getController('error');
				$action = '401';
			}
		}

		$controller->setUser($this->services['user']);
		$response = $controller->initialize($action);

		if(!($response instanceof Response)) {
			throw new \LogicException('Controller did not return a Response object.');
		}
		$response->send();
	}

	/**
	 * Get an instance of the requested mod.
	 * @param string $mod
	 * @return \psm\Module\ControllerInterface
	 * @throws \InvalidArgumentException
	 */
	public function getController($mod) {
		$controller = $this->getControllerClass($mod);

		if($controller === false) {
			throw new \InvalidArgumentException('Controller is not registered');
		}
		$controller = new $controller($this->services['db'], $this->services['twig']);

		if(!$controller instanceof \psm\Module\ControllerInterface) {
			throw new \Exception('Controller does not use ControllerInterface');
		}

		return $controller;
	}

	/**
	 * Get the classname of the controller for the provided mod
	 * @param string $mod
	 * @return string|false FALSE if not found, string otherwise
	 */
	protected function getControllerClass($mod) {
		if(strpos($mod, '_') !== false) {
			list($mod, $controller) = explode('_', $mod);
		} else {
			$controller = $mod;
		}

		if(!isset($this->map[$mod][$controller]) || !class_exists($this->map[$mod][$controller])) {
			return false;
		} else {
			return $this->map[$mod][$controller];
		}
	}
}