<?php

// change the following paths if necessary
$yii=dirname(__FILE__).'/yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/front.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',10);
defined('DEVELOPMENT') or define('DEVELOPMENT',true);
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
Yii::createWebApplication($config)->runEnd('front');

//Yii::app()->db;
// END of ORIGINAL

//For Yii2
/*
// include the customized Yii class described below
require(__DIR__ . '/components/Yii.php');

// configuration for Yii 2 application
$yii2Config = require(__DIR__ . '/basic/config/web.php');
new yii\web\Application($yii2Config); // Do NOT call run()

// configuration for Yii 1 application
$yii1Config = require(__DIR__ . '/protected/config/front.php');
Yii::createWebApplication($yii1Config)->run();
//End for yii2
*/