<?php

Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    // 'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'ebiobanques.fr',
    //par defaut en français
    'language' => 'fr',
    //'theme'=>'abound',
    // preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        'ext.*',
        //'ext.YiiMongoDbSuite.*',
        'ext.MongoDbSuite.*',
        'ext.MongoDbSuite.extra.*',
        //  'ext.YiiMongoDbSuite.extra.*',
        'ext.editMe.*',
        'ext.editMe.widgets.*',
        'application.models.*',
        'application.components.*',
        'application.modules.auditTrail.models.AuditTrail',
        'application.modules.auditTrail.behaviors.LoggableBehavior',
    ),
    'theme' => 'bootstrap',
    'modules' => array(
        'auditTrail' => array(),
    ),
    // application components
    'components' => array(
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
            //tell the application to use your WebUser class instead of the default CWebUser
            'class' => 'WebUser',
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'rules' => array(
                // REST patterns ( to ldif exchange with BBMRI)
                array('api/getBiobanksLDIF', 'verb' => 'GET'),
            ),
        ),
        'mongodb' => array(
            'class' => 'EMongoDB',
            'connectionString' => CommonProperties::$CONNECTION_STRING,
            'dbName' => 'interop',
            'fsyncFlag' => true,
            'safeFlag' => true,
            'useCursor' => false,
            'gridFStemporaryFolder' => '/tmp/mongo'
        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'bootstrap' => array(
            'class' => 'bootstrap.components.Bootstrap',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ), array(
                    'class' => 'CPhpMailerLogRoute',
                    'levels' => 'error, warning',
                    'emails' => CommonProperties::$ADMIN_EMAIL,
                    'except' => array('exception.CHttpException.404')
                ),
                CommonProperties::$DEV_MODE ?
                        array(
                    'class' => 'CWebLogRoute',
                    'levels' => 'error, warning,info',
                        ) : array('class' => 'CWebLogRoute',
                    'levels' => 'none',
                        ),
            ),
        ),
        'ePdf' => array(
            'class' => 'ext.yii-pdf-03.EYiiPdf',
            'params' => array(
                'mpdf' => array(
                    'librarySourcePath' => 'application.vendors.MPDF57.*',
                    'constants' => array(
                        '_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
                    ),
                    'class' => 'mpdf', // the literal class filename to be loaded from the vendors folder
                ),
            ),
        ),
        
        'clientScript'=>array(
            'packages'=>array(
                'jquery'=>array(
                    'baseUrl'=>'//ajax.googleapis.com/ajax/libs/jquery/1/',
                    'js'=>array('jquery.min.js'),
                )
            ),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => CommonProperties::$ADMIN_EMAIL,
        //variable pour activer systeme de mail
        'mailSystemActif' => CommonProperties::$MAIL_SYSTEM_ACTIVE,
        'mailRelanceExport' => CommonProperties::$MAIL_RELANCE_EXPORT,
    ),
);
