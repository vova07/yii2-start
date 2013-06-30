<?php
$params = require(__DIR__ . '/params.php');
return array(
	'id' => 'bootstrap-console',
	'basePath' => dirname(__DIR__),
	'preload' => array('log'),
	'modules' => array(
	),
	'components' => array(
		'db' => $params['components.db'],
		'cache' => $params['components.cache'],
		'log' => array(
			'class' => 'yii\logging\Router',
			'targets' => array(
				array(
					'class' => 'yii\logging\FileTarget',
					'levels' => array('error', 'warning'),
				),
			),
		),
	),
);
