<?php

//define your development configurations
return CMap::mergeArray(
		require(dirname(__FILE__).'/main.php'),
		
		array(
				
				
				'modules'=>array(
						// uncomment the following to enable the Gii tool

						'gii'=>array(
								'class'=>'system.gii.GiiModule',
								'password'=>'123qwe',//set your gii pw
								// If removed, Gii defaults to localhost only. Edit carefully to taste.
								'ipFilters'=>array('127.0.0.1','::1'),
								'generatorPaths'=>array(
										'bootstrap.gii',
										'application.gii',
								),
						),
				),
				'components'=>array(
						'db'=>array(
					'connectionString' => 'mysql:host=localhost;dbname=colcnstprod',
								'emulatePrepare' => true,
								'username' => 'root',
								'password' => '',
								'charset' => 'utf8',
								'tablePrefix'=>'tbl_',
						),
						'urlManager' => array(
								'hostInfo' => 'http://localhost',
								'secureHostInfo' => 'https://localhost',
						
						),
						),
				'params'=>array(
						// this is used in contact page
						'adminEmail'=>'mntrentadue@gmail.com',
				),
		)

);
