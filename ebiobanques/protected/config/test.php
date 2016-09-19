
<?php

$mergeWith = dirname(__FILE__) . '/main.php';

return CMap::mergeArray(
                require($mergeWith), array(
            'import' => array(
                'application.controllers.*'
            ),
            'components' => array(
                'fixture' => array(
                    'class' => 'ext.YiiMongoDbSuite.test.EMongoDbFixtureManager',
//				'class'=>'system.test.CDbFixtureManager',
                ),
                'mongodb' => array(
                    'class' => 'EMongoDB',
                    'connectionString' => CommonProperties::$CONNECTION_STRING,
                    'dbName' => 'interop',
                    'fsyncFlag' => true,
                    'safeFlag' => true,
                    'useCursor' => false
                ),
                'urlManager' => array(
                    'urlFormat' => 'get',
                    'baseUrl' => CommonProperties::$SERVERTESTURL
                )
            ),
                )
);
