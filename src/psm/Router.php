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
 * @since       phpservermon 3.0
 **/

namespace psm;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * The router class opens the controller and initializes the module.
 *
 * It uses a so-called $mod param to determine which controller to load.
 * The $mod of run() has 2 components, separated by an underscore. The first part determines
 * the module to load, the second on the controller. It uses the keys defined in
 * the module config. If the controller part is absent, it will always try to load
 * the controller with the same name as the module.
 */
class Router {

	/**
	 * Service container
	 * @var \Symfony\Component\DependencyInjection\ContainerBuilder $container
	 */
	protected $container;

	public function __construct() {
		$this->container = $this->buildServiceContainer();
	}

	/**
	 * Run a module.
	 *
	 * The $mod param is in the format $module_$controller.
	 * If the "_$controller" part is omitted, it will attempt to load
	 * the controller with the same name as the module.
	 *
	 * @param string $mod
	 * @throws \InvalidArgumentException
	 * @throws \LogicException
	 */
	public function run($mod) {
		$user = $this->container->get('user');

		if(strpos($mod, '_') !== false) {
			list($mod, $controller) = explode('_', $mod);
		} else {
			$controller = $mod;
		}

		$controller = $this->getController($mod, $controller);

		// get min required level for this controller and make sure the user matches
		$min_lvl = $controller->getMinUserLevelRequired();
		$action = null;

		if($min_lvl < PSM_USER_ANONYMOUS) {
			// if user is not logged in, load login module
			if(!$user->isUserLoggedIn()) {
				$controller = $this->getController('user', 'login');
			} elseif($user->getUserLevel() > $min_lvl) {
				$controller = $this->getController('error');
				$action = '401';
			}
		}

		$response = $controller->initialize($action);

		if(!($response instanceof Response)) {
			throw new \LogicException('Controller did not return a Response object.');
		}
		$response->send();
	}

	/**
	 * Get an instance of the requested controller.
	 * @param string $module_id
	 * @param string $controller_id if NULL, default controller will be used
	 * @return \psm\Module\ControllerInterface
	 * @throws \InvalidArgumentException
	 */
	public function getController($module_id, $controller_id = null) {
		if($controller_id === null) {
			// by default, we use the controller with the same id as the module.
			$controller_id = $module_id;
		}

		$module = $this->getModule($module_id);
		$controllers = $module->getControllers();
		if(!isset($controllers[$controller_id]) || !class_exists($controllers[$controller_id])) {
			throw new \InvalidArgumentException('Controller "' . $controller_id . '" is not registered or does not exist.');
		}
		$controller = new $controllers[$controller_id](
			$this->container->get('db'),
			$this->container->get('twig')
		);

		if(!$controller instanceof \psm\Module\ControllerInterface) {
			throw new \Exception('Controller does not implement ControllerInterface');
		}
		$controller->setContainer($this->container);

		return $controller;
	}

	/**
	 * Get service from container
	 * @param string $id
	 * @return mixed FALSE on failure, service otherwise
	 * @throws \InvalidArgumentException
	 */
	public function getService($id) {
		return $this->container->get($id);
	}

	/**
	 * Get a module
	 * @param string $module_id
	 * @return \psm\Module\ModuleInterface
	 * @throws \InvalidArgumentException
	 */
	protected function getModule($module_id) {
		return $this->container->get('module.' . $module_id);
	}

	/**
	 * Build a new service container
	 * @return \Symfony\Component\DependencyInjection\ContainerBuilder
	 * @throws \InvalidArgumentException
	 */
	protected function buildServiceContainer() {
		$builder = new ContainerBuilder();
		$loader = new XmlFileLoader($builder, new FileLocator(PSM_PATH_CONFIG));
		$loader->load('services.xml');

		return $builder;
	}
}