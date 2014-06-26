<?php

//if (($_SERVER['HTTP_HOST'] == 'localhost'))
$mergeWith = dirname(__FILE__) . '/main_dev.php';
//else
//    $mergeWith = dirname(__FILE__) . '/main.php';

return CMap::mergeArray(
                require($mergeWith), array(
            'components' => array(
                'fixture' => array(
                    'class' => 'ext.YiiMongoDbSuite.test.EMongoDbFixtureManager',
//				'class'=>'system.test.CDbFixtureManager',
                ),
                'mongodb' => array(
                    'class' => 'EMongoDB',
                    'connectionString' => CommonProperties::$CONNECTION_STRING_DEV,
                    'dbName' => 'interop',
                    'fsyncFlag' => true,
                    'safeFlag' => true,
                    'useCursor' => false
                ),
            ),
                )
);
