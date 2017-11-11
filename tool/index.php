<?php
//echo __DIR__;
session_start();
ini_set('session.cookie_httponly', 1);
date_default_timezone_set('Asia/Ho_Chi_Minh');
ini_set('memory_limit', '-1');

/**
* @project mvc 
* @author duong bien
* @email bien.duongvan@yahoo.com 
* @date 13/7/2015
* @time 21:43
* @copyright 2015 Copyright duong bien
* @license duong bien
* @version 1.0.0
*/

// Base url
define("BASE_URL", 'http://115.146.126.195/app_web/tool/');
define("WSDL_URL", "");

define('DS', 				DIRECTORY_SEPARATOR);
define('PS', 				PATH_SEPARATOR);
define('ROOT_DIR', 	        dirname(__FILE__));
define('CONFIG_DIR',        ROOT_DIR . DS . 'config');
define('CORE_DIR',	        ROOT_DIR . DS . 'core');
define('HOOKS_DIR',	        ROOT_DIR . DS . 'hooks');
define('LIB_DIR',	        ROOT_DIR . DS . 'library');
define('TEMPLATE_DIR',      ROOT_DIR . DS . 'templates');
define('TEMP_DIR',	        ROOT_DIR . DS . 'temp');
define('SKIN_URL',          BASE_URL . 'skin');
define('CONTROL_DIR',       ROOT_DIR . DS . 'controllers');
define('SERVICES_DIR',      ROOT_DIR . DS . 'services');


define('ENVIRONMENT', 'development');
if (defined('ENVIRONMENT')){
	switch (ENVIRONMENT){
		case 'development':
			error_reporting(E_ALL);
		break;
		case 'production':
			error_reporting(0);
		break;

		default:
			exit('The application environment is not set correctly.');
	}
}

// Define file
require_once LIB_DIR.DS.'define.php';

// DB
require_once CONFIG_DIR.DS.'db.php';


// Use autoloader;
require CORE_DIR.DS."Bootstrap.php";
$app = new Core_Bootstrap();
$app->init();

function __autoload($class){
    
    // Load Core Class
    $class = str_replace("Core_","",$class);
    if (file_exists(CORE_DIR . DS . $class . '.php')){
        require_once CORE_DIR . DS . $class . '.php';
        return true;
    }
    
    // Load Services Class
    $Sclass = str_replace("Services_","",$class);
    
    if (file_exists(SERVICES_DIR . DS . $Sclass . '.php')){
        require_once SERVICES_DIR . DS . $Sclass . '.php';
        return true;
    }
    
    return false;
}