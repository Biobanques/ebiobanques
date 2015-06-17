<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'ebiobanques Console Application',
    // preloading 'log' component
    'preload' => array('log'),
    'import' => array(
        'application.models.*',
        'application.components.*',
        'ext.MongoDbSuite.*',
        'ext.MongoDbSuite.extra.*',
        'application.modules.auditTrail.models.AuditTrail',
        'application.modules.auditTrail.behaviors.LoggableBehavior',
    ),
    // application components
    'components' => array(
        'mongodb' => array(
            'class' => 'EMongoDB',
            'connectionString' => CommonProperties::$CONNECTION_STRING,
            'dbName' => 'biocap',
            'fsyncFlag' => false,
            'safeFlag' => false,
            'useCursor' => false
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            ),
        ),
    ),
    'params' => array(
        'adminEmail' => CommonProperties::$ADMIN_EMAIL,
        //variable pour activer systeme de mail
        'mailSystemActif' => true,
        'mailRelanceExport' => false,
    ),
);
