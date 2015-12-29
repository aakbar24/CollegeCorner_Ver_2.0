<?php 
$backend=dirname(dirname(__FILE__));
return CMap::mergeArray(
		//dynamically merge either the development settings, beta settings, or the main settings
		DEVELOPMENT?(require(dirname(__FILE__).'/development.php')):(BETA?require(dirname(__FILE__).'/beta.php'):require(dirname(__FILE__).'/main.php')),
		array(
				'homeUrl'=>array('/admin/index'),
				'name'=>'Admin - College CornerStone',
				'modules'=>array(
						'account'=>array(
								'returnUrl'=>'/admin',
						),
				),
				// Put back-end settings there.
				'components'=>array(
						'user'=>array(
								// disable cookie-based authentication
								'allowAutoLogin'=>false,
								'loginUrl'=>array('/admin/login'),
								'returnUrl'=>array('/admin/index'),
						),
						'errorHandler'=>array(
								// use 'admin/error' action to display errors
								'errorAction'=>'admin/error',
						),
						'urlManager'=>array(
								'urlFormat'=>'path',
								'showScriptName'=>false,
								'rules'=>array(
										//'http://admin.localhost/colcl'=>'backend',
										//'backend/account'=>'account',
										'backend/auth'=>'account/auth',
										'backend/auth'=>'account/auth/index',
										
										'backend/auth/<_a>'=>'account/auth/<_a>',
										'backend/user'=>'account/user',
										'backend/user/<_a>'=>'account/user/<_a>',
										'backend/event'=>'event/event',
										'backend/event/<_a>'=>'event/event/<_a>',
										'backend/workshop'=>'workshop/workshop',
                                        					'backend/workshop/files/<name>'=>'workshop/file/download',
										'backend/workshop/<_a>'=>'workshop/workshop/<_a>',
										'backend/workshopcat/<_a>'=>'workshop/workshopCat/<_a>',
										'backend/workshopfac/<_a>'=>'workshop/workshopFacilitator/<_a>',
                                        					'backend/workshop-planned/<_a>'=>'workshop/workshopPlanned/<_a>',
										'backend/thread'=>'community/thread',
										'backend/thread/<_a>'=>'community/thread/<_a>',
										'backend/post'=>'community/post',
										'backend/post/<_a>'=>'community/post/<_a>',
                                                                                'backend/complaint'=>'community/complaint',
										'backend/complaint/<_a>'=>'community/complaint/<_a>',
                                                                                'backend/article'=>'article/article',
										'backend/article/<_a>'=>'article/article/<_a>',
										'backend/certificate/<_a>'=>'certificate/certification/<_a>',
										'backend/certificateCat/<_a>'=>'certificate/certificationCat/<_a>',
										/* 'backend/account/<_c>'=>'account/<_c>',
										'backend/account/<_c>/<_a>'=>'account/<_c>/<_a>', */
										'backend'=>'account/auth/index',
										'backend/<_c>'=>'<_c>',
										'backend/<_c>/<_a>'=>'<_c>/<_a>',
								),
								'secureRoutes' => array(
										
										//'account/auth',
									//	'account/user',
									//	'event/event',
									//	'workshop/workshop',
									//	'workshop/workshopCat',
									//	'workshop/workshopFacilitator',
									//	'admin',
										//'account/auth/login',   
										
								),
						),
				),

		)
);
?>
