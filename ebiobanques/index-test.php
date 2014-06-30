<?php
/**
 * This is the bootstrap file for test application.
 * This file should be removed when the application is deployed for production.
 */
include dirname(__FILE__) . '/CommonProperties.php';
//// change the following paths if necessary
$yii = dirname(__FILE__) . '/yii-1.1.15/framework/yii.php';
$config = dirname(__FILE__) . '/protected/config/test.php';
require_once($yii);
// remove the following line when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', true);
Yii::createWebApplication($config)->run();
