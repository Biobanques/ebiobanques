<?php

/**
 * boostrap file loaded first for phpunit.<br>
 * load common properties and static files at the root.
 *
 */
//properties to load url db etc.

require_once __DIR__ . '/../../../vendor/autoload.php';
include dirname(__FILE__) . '/../../CommonProperties.php';
//include dirname(__FILE__) . '/../../TestProperties.php';
//includes fichiers statiques à la racine
require_once dirname(__FILE__) . '/../../CommonMailer.php';
require_once dirname(__FILE__) . '/../../CommonTools.php';
require_once dirname(__FILE__) . '/../../SmartResearcherTool.php';
//require_once dirname(__FILE__) . '/../../ExtractContactCommand.php';
//yii include path
$yiit = dirname(__FILE__) . '/../../yii-1.1.17/framework/yiit.php';
$config = dirname(__FILE__) . '/../config/test.php';
require_once ($yiit);
Yii::createWebApplication($config);
