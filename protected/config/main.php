<?php

// uncomment the following to define a path alias
 //Yii::setPathOfAlias('local','path/to/local-folder');
Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');

//set the patch alias for files folder
Yii::setPathOfAlias('site.files', dirname(__FILE__).'/../../files');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'collegecornerstone',

	// preloading 'log' component
	'preload'=>array('log','bootstrap',),

	'sourceLanguage'=>'00',
	'language'=>'en',
	'timeZone'=>'America/Toronto',
	
	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
        'application.modules.community.models.*',
        'application.modules.workshop.models.*',
        'application.modules.event.models.*',
		'application.modules.account.components.*',
		'application.modules.account.models.user.*',
                'application.modules.article.models.*',
        'application.modules.account.models.*',
		'ext.YiiMailer.*',
		'ext.YiiMailer.PHPMailer.*',
		'ext.YiiMailer.PHPMailer.class.phpmailer.php',
		
	),
	

	'behaviors'=>array(
		'runEnd'=>array(
			'class'=>'application.components.WebApplicationEndBehavior',
		),
		'application.components.AppLanguageBehavior',
	),
	
	'modules'=>array(
	'mail' => array(
                'class' => 'ext.YiiMailer.YiiMailer',
                'transportType'=>'smtp',
                'transportOptions'=>array(
                        'host'=>'smtp.teksavvy.com',
                        
                        'port'=>'25',                       
                ),
                'viewPath' => '/protected/views/mail',             
        ),
	
	'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'password',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
			'account',
                        'article'=>array(
					'moduleDependencies'=>array(
							'account.models.*',
							'account.models.user.*',
							'community.models.PostItem',
							'community.models.PostItemSearch',
							)),
			'resume'=>array(
					'moduleDependencies'=>array(
							'account.models.*',
							'account.models.user.*',
							'account.models.views.ViewStudent')),
			'community'=>array('moduleDependencies'=>array('account.models.user.*')),
			'event'=>array(
					'moduleDependencies'=>array(
							'account.models.*',
							'account.models.user.*',
							'community.models.PostItem',
							'community.models.PostItemSearch',
							)),
			'workshop'=>array(
					'moduleDependencies'=>array(
							'account.models.*',
							'account.models.user.*',
							'community.models.PostItem',
							'community.models.PostItemSearch',)),
			'certificate'=>array(
					'moduleDependencies'=>array(
							'account.models.*',
							'account.models.user.*',
							'community.models.PostItem',
							'community.models.PostItemSearch',)),
	),

	// application components
	'components'=>array(

                 'browser' => array(
                         'class' => 'application.extensions.browser.CBrowserComponent',
                  ),
		
		'bootstrap'=>array(
					'class'=>'bootstrap.components.Bootstrap',
					'responsiveCss' => true,
					'fontAwesomeCss'=>true,
			),
		'user'=>array(
			'class'=>'application.modules.account.components.WebUser',
			// enable cookie-based authentication
			'allowAutoLogin'=>false,
			'autoUpdateFlash' => false,
		),
             'timeagoFormat' => array(
            'class' => 'application.extensions.timeago.TimeagoFormatter'),
		/* 'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		), */
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=colcnstprod',
			//'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			//'charset' => 'utf8',
			'tablePrefix'=>'tbl_',
		),
		
		
		/*
		'db'=>array(				'connectionString' => 'mysql:host=colcnstprod.db.10437204.hostedresource.com;dbname=colcnstprod',				'emulatePrepare' => true,				'username' => 'colcnstprod',				'password' => 'T6x5!@Wk',				'charset' => 'utf8',				'tablePrefix'=>'tbl_',		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
*/
		'urlManager' => array(
            'class' => 'UrlManager',
            'urlFormat' => 'path',
          //  'hostInfo' => 'http://collegecornerstone.com',
          //  'secureHostInfo' => 'https://collegecornerstone.com',
            
        ),
		
		'format'=>array('class'=>'Formatter'),
		
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
                                array(
					'class'=>'CFileLogRoute',
					'levels'=>'log',
                                        'logFile' => 'debug.log'
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
                                        'levels'=>'error, warning, info',
                                        'showInFireBug' => false
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		//'adminEmail'=>'makbar24@hotmail.com',
		'nonReplyEmail'=>'non-reply@collegecornerstone.com',
		'dbCacheInterval'=>1800,
		'dbCacheIntervalLong'=>3600,
		'maxResumeJobTitles'=>5,
		'defaultPageLimit'=>10,
		'backendPath'=>'/backend',

        'defaultLatestReplyDays' => 1,
        'defaultLatestWorkshopsToGet' => 5,
        'defaultLatestEventsToGet' => 5,

        'posting_max_text_length' => 500,
            
        'article_max_homepage_length' => 256
	),
);
