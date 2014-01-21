<?php

// Include paths
define('PSM_PATH_SRC', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('PSM_PATH_VENDOR', PSM_PATH_SRC . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR);
define('PSM_PATH_INC', PSM_PATH_SRC . 'includes' . DIRECTORY_SEPARATOR);
define('PSM_PATH_TPL', PSM_PATH_SRC . 'templates' . DIRECTORY_SEPARATOR);
define('PSM_PATH_LANG', PSM_PATH_SRC . 'lang' . DIRECTORY_SEPARATOR);

// set autoloader, make sure to set $prepend = true so that our autoloader is called first
function __autoload($class) {
	// remove leading \
	$class = ltrim($class, '\\');
	$path_parts = explode('\\', $class);

	$filename = array_pop($path_parts);
	$path = implode(DIRECTORY_SEPARATOR, $path_parts) .
			DIRECTORY_SEPARATOR .
			$filename . '.class.php'
	;
	// search in these dirs:
	$basedirs = array(
		PSM_PATH_SRC,
		PSM_PATH_VENDOR
	);
	foreach($basedirs as $dir) {
		if(file_exists($dir . $path)) {
			require_once $dir . $path;
			return;
		}
	}
}

// auto-find all include files
$includes = glob(PSM_PATH_INC . '*.inc.php');
foreach($includes as $file) {
	include_once $file;
}

if(!defined('PSM_CONFIG')) {
	// redirect to install.php
	die('Failed to locate config file. Please read README.md for more information on how to setup PHP Server Monitor.');
}

// init db connection
$db = new psm\Service\Database();

psm_load_conf();

$lang = psm_get_conf('language');

if(!$lang) {
	$lang = 'en';
}
psm_load_lang($lang);

?>
