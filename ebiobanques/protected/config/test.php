<?php

return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),
	array(
		'components'=>array(
			'fixture'=>array(
				'class'=>'system.test.CDbFixtureManager',
			),
			'mongodb' => array(
				'class'            => 'EMongoDB',
				'connectionString' => $GLOBALS["CONNECTION_STRING_DEV"],
				'dbName'           => 'interop',
				'fsyncFlag'        => true,
				'safeFlag'         => true,
				'useCursor'        => false
		),
                    ),
	)
);
