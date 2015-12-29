<?php

// change the following paths if necessary
$yii=dirname(__FILE__).'/yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/front.php';

// remove the following lines when in production mode
// defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
// defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
defined('DEVELOPMENT') or define('DEVELOPMENT',false);
defined('BETA') or define('BETA',false);
defined('OPEN_BETA') or define('OPEN_BETA',false);

//check for the beta flag
if (BETA && !OPEN_BETA) {
	//if in beta
	//check for the beta password by redirecting all request to beta/login.php if no invalid session found
	session_start();
	if (!isset($_SESSION['beta_auth_check']) || $_SESSION['beta_auth_check']===false) {
		header('Location: '.(str_replace('index.php', 'beta/login.php', $_SERVER['PHP_SELF'])));
		exit();
	}
}

//by default run the application
require_once($yii);
$browser = Yii::app()->browser->getBrowser();
print_r($browser);







