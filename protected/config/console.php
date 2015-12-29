<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return 
CMap::mergeArray(
		//dynamically merge either the development settings, beta settings, or the main settings
		DEVELOPMENT?(require(dirname(__FILE__).'/developmentConsole.php')):(BETA?require(dirname(__FILE__).'/betaConsole.php'):array()),
	array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',

	// preloading 'log' component
	'preload'=>array('log'),

	// application components
	'components'=>array(
		
		// uncomment the following to use a MySQL database
		/*
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=testdrive',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		*/
		'db'=>array(
				'connectionString' => 'mysql:host=colcnstprod.db.10437204.hostedresource.com;dbname=colcnstprod',
				'emulatePrepare' => true,
				'username' => 'colcnstprod',
				'password' => 'C0!cNstp%0D',
				'charset' => 'utf8',
				'tablePrefix'=>'tbl_',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),
));