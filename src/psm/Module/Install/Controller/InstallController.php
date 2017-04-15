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
 * @since		phpservermon 2.1.0
 **/

namespace psm\Module\Install\Controller;
use psm\Module\AbstractController;
use psm\Service\Database;

class InstallController extends AbstractController {

	/**
	 * Full path to config file
	 * @var string $path_config
	 */
	protected $path_config;

	/**
	 * Full path to old config file (2.0)
	 * @var string $path_config_old
	 */
	protected $path_config_old;

	function __construct(Database $db, \Twig_Environment $twig) {
		parent::__construct($db, $twig);

		$this->setMinUserLevelRequired(PSM_USER_ANONYMOUS);
		$this->setCSRFKey('install');
		$this->addMenu(false);

		$this->path_config = PSM_PATH_SRC . '../config.php';
		$this->path_config_old = PSM_PATH_SRC . '../config.inc.php';

		$this->setActions(array(
			'index', 'config', 'install'
		), 'index');

		$this->twig->addGlobal('subtitle', psm_get_lang('system,', 'install'));
	}

	/**
	 * Say hi to our new user
	 */
	protected function executeIndex() {
		// build prerequisites
		$errors = 0;

		$phpv = phpversion();
		if(version_compare($phpv, '5.3.7', '<')) {
			$errors++;
			$this->addMessage('PHP 5.3.7+ is required to run PHP Server Monitor.', 'error');
		} else {
			$this->addMessage('PHP version: ' . $phpv, 'success');
		}
		if(!function_exists('curl_init')) {
			$this->addMessage('PHP is installed without the cURL module. Please install cURL.', 'warning');
		} else {
			$this->addMessage('PHP cURL module found', 'success');
		}
		if(!in_array('mysql', \PDO::getAvailableDrivers())) {
			$errors++;
			$this->addMessage('The PDO MySQL driver needs to be installed.', 'error');
		}
		if(!ini_get('date.timezone')) {
			$this->addMessage('You should set a timezone in your php.ini file (e.g. \'date.timezone = UTC\'). See <a href="http://www.php.net/manual/en/timezones.php" target="_blank">this page</a> for more info.', 'warning');
		}

		if($errors > 0) {
			$this->addMessage($errors . ' error(s) have been encountered. Please fix them and refresh this page.', 'error');
		}

		return $this->twig->render('module/install/index.tpl.html', array(
			'messages' => $this->getMessages()
		));
	}

	/**
	 * Help the user create a new config file
	 */
	protected function executeConfig() {
		$tpl_name = 'module/install/config_new.tpl.html';
		$tpl_data = array();

		if(!defined('PSM_DB_PREFIX')) {
			// first detect "old" config file (2.0)
			if(file_exists($this->path_config_old)) {
				// oldtimer huh
				$this->addMessage('Configuration file for v2.0 found.', 'success');
				$this->addMessage(
					'The location of the config file has been changed since v2.0.<br/>' .
					'We will attempt to create a new config file for you.'
				, 'warning');
				$values = $this->parseConfig20();
			} else {
				// fresh install
				$values = $_POST;
			}

			$config = array(
				'db_host' => 'localhost',
				'db_port' => '3306',
				'db_name' => '',
				'db_user' => '',
				'db_pass' => '',
				'db_prefix' => 'psm_',
				'base_url' => $this->getBaseUrl(),
			);

			$changed = false;
			foreach($config as $ckey => &$cvalue) {
				if(isset($values[$ckey])) {
					$changed = true;
					$cvalue = $values[$ckey];
				}
			}
			// add config to template data for prefilling the form
			$tpl_data = $config;

			if($changed) {
				// test db connection
				$this->db = new \psm\Service\Database(
					$config['db_host'],
					$config['db_user'],
					$config['db_pass'],
					$config['db_name'],
                    $config['db_port']
				);

				if($this->db->status()) {
					$this->addMessage('Connection to MySQL successful.', 'success');
					$config_php = $this->writeConfigFile($config);
					if($config_php === true) {
						$this->addMessage('Configuration file written successfully.', 'success');
					} else {
						$this->addMessage('Config file is not writable, we cannot save it for you.', 'error');
						$tpl_data['include_config_new_copy'] = true;
						$tpl_data['php_config'] = $config_php;
					}
				} else {
					$this->addMessage('Unable to connect to MySQL. Please check your information.', 'error');
				}
			}
		}

		if(defined('PSM_DB_PREFIX')) {
			if($this->db->status()) {
				if($this->isUpgrade()) {
					// upgrade
					if(version_compare($this->getPreviousVersion(), '3.0.0', '<')) {
						// upgrade from before 3.0, does not have passwords yet.. create new user first
						$this->addMessage('Your current version does not have an authentication system, but since v3.0 access to the monitor is restricted by user accounts. Please set up a new account to be able to login after the upgrade, and which you can use to change the passwords for your other accounts.', 'info');
						$tpl_name = 'module/install/config_new_user.tpl.html';
					} else {
						$tpl_name = 'module/install/config_upgrade.tpl.html';
						$tpl_data['version'] = PSM_VERSION;
					}
				} else {
					// fresh install ahead
					$tpl_name = 'module/install/config_new_user.tpl.html';

					$tpl_data['username'] = (isset($_POST['username'])) ? $_POST['username'] : '';
					$tpl_data['email'] = (isset($_POST['email'])) ? $_POST['email'] : '';
				}
			} else {
				$this->addMessage('Configuration file found, but unable to connect to MySQL. Please check your information.', 'error');
			}
		}
		$tpl_data['messages'] = $this->getMessages();
		return $this->twig->render($tpl_name, $tpl_data);
	}

	/**
	 * Execute the install and upgrade process to a newer version
	 */
	protected function executeInstall() {
		if(!defined('PSM_DB_PREFIX') || !$this->db->status()) {
			return $this->executeConfig();
		}
		$add_user = false;

		// check if user submitted username + password in previous step
		// this would only be the case for new installs, and install from
		// before 3.0
		$new_user = array(
			'user_name' => psm_POST('username'),
			'name' => psm_POST('username'),
			'password' => psm_POST('password'),
			'password_repeat' => psm_POST('password_repeat'),
			'email' => psm_POST('email', ''),
			'mobile' => '',
			'level' => PSM_USER_ADMIN,
			'pushover_key' => '',
			'pushover_device' => '',
		);

		$validator = $this->container->get('util.user.validator');

		$logger = array($this, 'addMessage');
		$installer = new \psm\Util\Install\Installer($this->db, $logger);

		if($this->isUpgrade()) {
			$this->addMessage('Upgrade process started.', 'info');

			$version_from = $this->getPreviousVersion();
			if($version_from === false) {
				$this->addMessage('Unable to locate your previous version. Please run a fresh install.', 'error');
			} else {
				if(version_compare($version_from, PSM_VERSION, '=')) {
					$this->addMessage('Your installation is already at the latest version.', 'success');
				} elseif(version_compare($version_from, PSM_VERSION, '>')) {
					$this->addMessage('This installer does not support downgrading, sorry.', 'error');
				} else {
					$this->addMessage('Upgrading from ' . $version_from . ' to ' . PSM_VERSION, 'info');
					$installer->upgrade($version_from, PSM_VERSION);

				}
				if(version_compare($version_from, '3.0.0', '<')) {
					$add_user = true;
				}
			}
		} else {
			// validate the lot
			try {
				$validator->email($new_user['email']);
				$validator->password($new_user['password'], $new_user['password_repeat']);
			} catch(\InvalidArgumentException $e) {
				$this->addMessage(psm_get_lang('users', 'error_' . $e->getMessage()), 'error');
				return $this->executeConfig();
			}

			$this->addMessage('Installation process started.', 'success');
			$installer->install();
			// add user
			$add_user = true;
		}

		if($add_user) {
			unset($new_user['password_repeat']);
			$user_id = $this->db->save(PSM_DB_PREFIX.'users', $new_user);
			if(intval($user_id) > 0) {
				$this->getUser()->changePassword($user_id, $new_user['password']);
				$this->addMessage('User account has been created successfully.', 'success');
			} else {
				$this->addMessage('There was an error adding your user account.', 'error');
			}
		}

		return $this->twig->render('module/install/success.tpl.html', array(
			'messages' => $this->getMessages()
		));
	}

	/**
	 * Write config file with db variables
	 * @param array $array_config prefix,user,pass,name,host
	 * @return boolean|string TRUE on success, string with config otherwise
	 */
	protected function writeConfigFile($array_config) {
		$config = "<?php".PHP_EOL;

		foreach($array_config as $key => $value) {
			$line = "define('PSM_{key}', '{value}');".PHP_EOL;
			$line = str_replace(
				array('{key}', '{value}'),
				array(strtoupper($key), $value),
				$line
			);
			$config .= $line;
		}
		if(is_writeable($this->path_config)) {
			file_put_contents($this->path_config, $config);
			return true;
		} else {
			return $config;
		}
	}

	/**
	 * Parse the 2.0 config file for prefilling
	 * @return array
	 */
	protected function parseConfig20() {
		$config_old = file_get_contents($this->path_config_old);
		$vars = array(
			'prefix' => '',
			'user' => '',
			'pass' => '',
			'name' => '',
			'host' => '',
			'port' => '3306'
		);
		$pattern = "/define\('SM_{key}', '(.*?)'/u";

		foreach($vars as $key => $value) {
			$pattern_key = str_replace('{key}', strtoupper($key), $pattern);
			preg_match($pattern_key, $config_old, $value_matches);
			$vars[$key] = (isset($value_matches[1])) ? $value_matches[1] : '';
		}

		return $vars;
	}

	/**
	 * Is it an upgrade or install?
	 */
	protected function isUpgrade() {
		if(!$this->db->status()) {
			return false;
		}
		return $this->db->ifTableExists(PSM_DB_PREFIX.'config');
	}

	/**
	 * Get the previous version from the config table
	 * @return boolean|string FALSE on failure, string otherwise
	 */
	protected function getPreviousVersion() {
		if(!$this->isUpgrade()) {
			return false;
		}
		$version_conf = $this->db->selectRow(PSM_DB_PREFIX . 'config', array('key' => 'version'), array('value'));
		if(empty($version_conf)) {
			return false;
		} else {
			$version_from = $version_conf['value'];
			if(strpos($version_from, '.') === false) {
				// yeah, my bad.. previous version did not follow proper naming scheme
				$version_from = rtrim(chunk_split($version_from, 1, '.'), '.');
			}
			return $version_from;
		}
	}

	/**
	 * Get base url of the current application
	 * @return string
	 */
	protected function getBaseUrl() {
		$sym_request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

		return $sym_request->getSchemeAndHttpHost() . $sym_request->getBasePath();
	}
}
