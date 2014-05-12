<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'ebiobanques.fr',
		//par defaut en français
		'language'=>'fr',
	//'theme'=>'abound',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'ext.YiiMongoDbSuite.*',
		'ext.YiiMongoDbSuite.extra.*',
		'application.models.*',
		'application.components.*',
		'application.modules.auditTrail.models.AuditTrail',
			'application.modules.auditTrail.behaviors.LoggableBehavior',
	),

	'modules'=>array(
			'auditTrail'=>array(),
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			//tell the application to use your WebUser class instead of the default CWebUser
			'class'=>'WebUser',
				
		),
		
		'mongodb' => array(
				'class'            => 'EMongoDB',
				'connectionString' => $GLOBALS["CONNECTION_STRING_PROD"],
				'dbName'           => 'interop',
				'fsyncFlag'        => true,
				'safeFlag'         => true,
				'useCursor'        => false,


		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
		'ePdf' => array(
				'class'         => 'ext.yii-pdf-03.EYiiPdf',
				'params'        => array(
						'mpdf'     => array(
								'librarySourcePath' => 'application.vendors.MPDF57.*',
								'constants'         => array(
										'_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
								),
								'class'=>'mpdf', // the literal class filename to be loaded from the vendors folder
								/*'defaultParams'     => array( // More info: http://mpdf1.com/manual/index.php?tid=184
										'mode'              => '', //  This parameter specifies the mode of the new document.
										'format'            => 'A4', // format A4, A5, ...
										'default_font_size' => 0, // Sets the default document font size in points (pt)
										'default_font'      => '', // Sets the default font-family for the new document.
										'mgl'               => 15, // margin_left. Sets the page margins for the new document.
										'mgr'               => 15, // margin_right
										'mgt'               => 16, // margin_top
										'mgb'               => 16, // margin_bottom
										'mgh'               => 9, // margin_header
										'mgf'               => 9, // margin_footer
						'orientation'       => 'P', // landscape or portrait orientation
						)*/
						),
		
						),
						),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
	// this is used in contact page
	'adminEmail'=>$GLOBALS["ADMIN_EMAIL"],
	//variable pour activer systeme de mail
	'mailSystemActif'=>true,
	'mailRelanceExport'=>false,
	),
);