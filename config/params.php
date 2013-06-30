<?php

return array(
	'adminEmail' => 'admin@example.com',

	'components.db' => array(
		'class' => 'yii\db\Connection',
		'dsn' => 'mysql:host=localhost;dbname=yii2',
		'username' => 'root',
		'password' => '',
	),

	'components.cache' => array(
		'class' => 'yii\caching\FileCache',
	),
);