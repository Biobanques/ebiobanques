<?php

date_default_timezone_set('Europe/Paris');
//include common properties
include dirname(__FILE__) . '/../CommonProperties.php';
include dirname(__FILE__) . '/../CommonTools.php';
include dirname(__FILE__) . '/../CommonMailer.php';

// change the following paths if necessary
$yiic = dirname(__FILE__) . '/../yii-1.1.17/framework/yiic.php';
$config = dirname(__FILE__) . '/config/console.php';

require_once($yiic);
