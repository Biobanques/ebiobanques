<?php
//locale du serveur en francais si besoin
setlocale (LC_ALL, 'fr_FR.utf8','fra');
//timezone des dates
date_default_timezone_set('Europe/Paris');

include dirname(__FILE__).'/CommonProperties.php';

// change the following paths if necessary
$yii=dirname(__FILE__).'/yii-1.1.13/framework/yii.php';
//chargement de la conf de dev ou prod selon le cas
if(($_SERVER['HTTP_HOST']=='localhost'))
    $config=dirname(__FILE__).'/protected/config/main_dev.php';
    else
    $config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();
