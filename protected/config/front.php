<?php 
return CMap::mergeArray(
		//dynamically merge either the development settings, beta settings, or the main settings
		DEVELOPMENT?(require(dirname(__FILE__).'/development.php')):(BETA?require(dirname(__FILE__).'/beta.php'):require(dirname(__FILE__).'/main.php')),
		array(
				// Put front-end settings here
				// (for example, url rules).
				'modules'=>array(
						'account'=>array(
								'returnUrl'=>'/profile/index',
						),
						'resume'=>array(
								'returnUrl'=>'/profile/index',
						),
				),
				'components'=>array(
						'user'=>array(
								// enable cookie-based authentication
								'allowAutoLogin'=>true,
								'loginUrl'=>array('/auth/login'),
								'returnUrl'=>array('/profile/index'),
						),
						'urlManager'=>array(
								'urlFormat'=>'path',
								'showScriptName'=>false,
								'rules'=>array(
										'auth/<_a>'=>'account/auth/<_a>',
										'register/<_a>'=>'account/register/<_a>',
										'profile/view/<id:\d+>'=>'account/profile/viewProfile',
										'profile/<_a>'=>'account/profile/<_a>',
										'resume/files/<name>'=>'resume/file/download',
										'resume/viewCat/<jobCat:\d+>'=>'resume/resumePost/viewCat',
										'resume/edit/<jobTitle:\d+>'=>'resume/resumePost/editJob',
										'resume/delete/<stuJobID:\d+>'=>'resume/resumePost/deleteJob',
										'resume/interviews'=>'resume/studentInterview/index',
										'resume/hired'=>'resume/studentHired/index',
										'resume/<_a>'=>'resume/resumePost/<_a>',
										'employer/downloadResume/<name>'=>'resume/file/downloadResume',
										'employer/downloadResumeZip'=>'resume/file/downloadResumeZip',
										'employer/fav/<stu_job_id:\d+>'=>'resume/employerFav/fav',
										'employer/deleteFav/<id:\d+>'=>'resume/employerFav/delete',
										'employer/deleteInterview/<id:\d+>'=>'resume/employerInterview/delete',
										'employer/favorites'=>'resume/employerFav/index',
										'employer/hired'=>'resume/employerHired/index',
										'employer/interviewList'=>'resume/employerInterview/index',
										'employer/hire/<stu_job_id:\d+>'=>'resume/employerHired/hire',
										'employer/unhire/<stu_job_id:\d+>'=>'resume/employerHired/unhire',
										'employer/workshop'=>'workshop/workshop/manage',
										'employer/requestWorkshop'=>'workshop/workshop/create',
										'employer/<_a>'=>'resume/employer/<_a>',
										'community/<_a>'=>'community/forum/<_a>',
										'studentEvent/<_a>'=>'event/studentEvent/<_a>',
										'event/<_a>'=>'event/event/<_a>',
										'studentWorkshop/<_a>'=>'workshop/studentWorkshop/<_a>',
										'workshop/<_a>'=>'workshop/workshop/<_a>',
                                        'workshop/files/<name>'=>'workshop/file/download',
										'site/page/<view>'=>'site/page',
										'<controller:\w+>/<id:\d+>'=>'<controller>/view',
										'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
										'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
										
									 
										
								),
								//define any url routes that needed to be in HTTPS mode
								'secureRoutes' => array(
										
										//'account/auth',   // auth controller
										//'account/register',  // register controller
										//'account/profile',
										//'resume/resumePost',
										//'resume/studentInterview',
										//'resume/studentHired',
										//'resume/employer',
										//'resume/employerFav',
										//'resume/employerInterview',
										//'resume/employerHired',
										//'event/studentEvent',
										//'workshop/studentWorkshop',
										//'workshop/workshop/create',
										//'workshop/workshop/manage',
										//'workshop/workshop/delete',
										//'workshop/workshop/update',
										
										//'resume/file',
                                        //'community/forum'                                        
								),
						),

				),

		)
);
?>
