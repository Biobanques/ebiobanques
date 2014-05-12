<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',

	// preloading 'log' component
		'preload'=>array('log'),
'import'=>array(
		
		'application.models.*',
		'application.components.*',
		'ext.YiiMongoDbSuite.*',
		'ext.YiiMongoDbSuite.extra.*',
		'application.modules.auditTrail.models.AuditTrail',
			'application.modules.auditTrail.behaviors.LoggableBehavior',
				
		),

	// application components
	'components'=>array(
			

			'mongodb' => array(
					'class'            => 'EMongoDB',
					'connectionString' => 'mongodb://ebiobanques:ebiobanques@localhost/interop',
					'dbName'           => 'interop',
					'fsyncFlag'        => false,
					'safeFlag'         => false,
					'useCursor'        => false
			),
// 		'db'=>array(
// 			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
// 		),
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
		'params'=>array(
				// this is used in contact page
				//'adminEmail'=>'nicolas@malservet.eu',
                               'adminEmail'=>'admin@mail.com',
				//variable pour activer systeme de mail
				'mailSystemActif'=>true,
				'mailRelanceExport'=>false,
		),
);