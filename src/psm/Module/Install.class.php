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
 * @since		phpservermon 2.1.0
 **/

namespace psm\Module;
use psm\Service\Database;
use psm\Service\Template;

class Install extends AbstractModule {

	/**
	 * Result messages to add to the main template
	 * @var array $install_results
	 * @see addResult()
	 */
	protected $install_results = array();

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

	function __construct(Database $db, Template $tpl) {
		parent::__construct($db, $tpl);

		$this->path_config = PSM_PATH_SRC . '../config.php';
		$this->path_config_old = PSM_PATH_SRC . '../config.inc.php';

		$this->setActions(array(
			'index', 'config', 'install'
		), 'index');
	}

	protected function createHTML() {
		$tpl_id_custom = $this->getTemplateId();
		$this->setTemplateId('install', 'install.tpl.html');
		$html_install = ($tpl_id_custom) ? $this->tpl->getTemplate($tpl_id_custom) : '';

		$html_results = '';
		if(!empty($this->install_results)) {
			$this->tpl->newTemplate('install_results', 'install.tpl.html');
			$this->tpl->addTemplateDataRepeat('install_results', 'resultmsgs', $this->install_results);
			$html_results = $this->tpl->getTemplate('install_results');
		}
		$this->tpl->addTemplateData($this->getTemplateId(), array(
			'html_install' => $html_install,
			'html_results' => $html_results,
		));

		return parent::createHTML();
	}

	/**
	 * Generate the main install page with prerequisites
	 */
	protected function executeIndex() {
		$this->addMenu(false);
		$tpl_data = array();

		// build prerequisites
		$errors = 0;

		$phpv = phpversion();
		if(version_compare($phpv, '5.3.0', '<')) {
			$errors++;
			$this->addResult('PHP 5.3+ is required to run PHP Server Monitor.', 'error');
		} else {
			$this->addResult('PHP version: ' . $phpv);
		}
		if(!function_exists('curl_init')) {
			$this->addResult('PHP is installed without the cURL module. Please install cURL.', 'warning');
		} else {
			$this->addResult('cURL installed');
		}
		if(!in_array('mysql', \PDO::getAvailableDrivers())) {
			$errors++;
			$this->addResult('The PDO MySQL driver needs to be installed.', 'error');
		}

		if($errors > 0) {
			// cannot continue
			$this->addResult($errors . ' error(s) have been encountered. Please fix them and refresh this page.', 'error');
		} else {
			if(defined('PSM_CONFIG')) {
				$this->addResult('Configuration file found.');
				return $this->executeInstall();
			} else {
				return $this->executeConfig();
			}
		}
	}

	/**
	 * Help the user create a new config file
	 */
	protected function executeConfig() {
		if(defined('PSM_CONFIG')) {
			return $this->executeInstall();
		}
				// first detect "old" config file (2.0)
		if(file_exists($this->path_config_old)) {
			// oldtimer huh
			$this->addResult('Configuration file for v2.0 found.');
			$this->addResult(
				'The location of the config file has been changed since the previous version.<br/>' .
				'We will attempt to create a new config file for you.'
			, 'warning');
			$values = $this->parseConfig20();
		} else {
			// fresh install
			$values = $_POST;
		}

		$config = array(
			'host' => 'localhost',
			'name' => '',
			'user' => '',
			'pass' => '',
			'prefix' => 'psm_',
		);
		$this->setTemplateId('install_config_new', 'install.tpl.html');

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
				$config['host'],
				$config['user'],
				$config['pass'],
				$config['name']
			);

			if($this->db->status()) {
				$this->addResult('Connection to MySQL successful.');
				$config_php = $this->writeConfigFile($config);
				if($config_php === true) {
					$this->addResult('Configuration file written successfully.');
					return $this->executeInstall();
				} else {
					$this->addResult('Config file is not writable, we cannot save it for you.', 'error');
					$this->tpl->newTemplate('install_config_new_copy', 'install.tpl.html');
					$tpl_data['html_config_copy'] = $this->tpl->getTemplate('install_config_new_copy');
					$tpl_data['php_config'] = $config_php;
				}
			} else {
				$this->addResult('Unable to connect to MySQL. Please check your information.', 'error');
			}
		}

		$this->tpl->addTemplateData($this->getTemplateId(), $tpl_data);
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
		);
		$pattern = "/define\('SM_DB_{key}', '(.*?)'/u";

		foreach($vars as $key => $value) {
			$pattern_key = str_replace('{key}', strtoupper($key), $pattern);
			preg_match($pattern_key, $config_old, $value_matches);
			$vars[$key] = (isset($value_matches[1])) ? $value_matches[1] : '';
		}

		return $vars;
	}

	/**
	 * Execute the upgrade process to a newer version
	 */
	protected function executeInstall() {
		if(!defined('PSM_CONFIG')) {
			$this->addResult('No valid configuration found.', 'error');
			return $this->executeConfig();
		}
		if(!$this->db->status()) {
			$this->addResult('MySQL connection failed.', 'error');
			return;
		}
		$logger = array($this, 'addResult');
		$installer = new \psm\Util\Install\Installer($this->db, $logger);
		$installer->install();

		$this->setTemplateId('install_success', 'install.tpl.html');
	}

	/**
	 * Write config file with db variables
	 * @param array $db_vars prefix,user,pass,name,host
	 * @return boolean|string TRUE on success, string with config otherwise
	 */
	protected function writeConfigFile($db_vars) {
		$config =
			"<?php".PHP_EOL .
			"define('PSM_CONFIG', true);".PHP_EOL;

		foreach($db_vars as $key => $value) {
			$line = "define('PSM_DB_{key}', '{value}');".PHP_EOL;
			$line = str_replace(
				array('{key}', '{value}'),
				array(strtoupper($key), $value),
				$line
			);
			$config .= $line;
		}
		$config .= "?>".PHP_EOL;
		if(is_writeable($this->path_config)) {
			file_put_contents($this->path_config, $config);
			return true;
		} else {
			return $config;
		}
	}

	/**
	 * Add install result to be added to the main template
	 * @param string|array $msg
	 * @param string $status success/warning/error
	 * @return \psm\Module\Install
	 */
	public function addResult($msg, $status = 'success') {
		if(!is_array($msg)) {
			$msg = array($msg);
		}
		if($status == 'error') {
			$shortcode = 'important';
		} else {
			$shortcode = $status;
		}

		foreach($msg as $m) {
			$this->install_results[] = array(
				'message' => $m,
				'status' => strtoupper($status),
				'shortcode' => $shortcode,
			);
		}
		return $this;
	}
}

?>