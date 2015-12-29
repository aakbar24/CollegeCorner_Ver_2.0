<?php
//this is the beta configuration of the application
//it uses the beta database and disable the gii module
return array(


				'modules'=>array(
						// uncomment the following to enable the Gii tool

						/* 'gii'=>array(
								'class'=>'system.gii.GiiModule',
								'password'=>'123qwe',//set your gii pw
								// If removed, Gii defaults to localhost only. Edit carefully to taste.
								'ipFilters'=>array('127.0.0.1','::1'),
								'generatorPaths'=>array(
										'bootstrap.gii',
								),
						), */
				),
				'components'=>array(
						'db'=>array(
								'connectionString' => 'mysql:host=colcnstbeta.db.10437204.hostedresource.com;dbname=colcnstbeta',
								'emulatePrepare' => true,
								'username' => 'colcnstbeta',
								'password' => 'C0!cNstb3t@',
								'charset' => 'utf8',
								'tablePrefix'=>'tbl_',
						),
						
				),
				

);