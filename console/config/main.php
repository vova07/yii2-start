<?php
use yii\helpers\ArrayHelper;

$rootDir = dirname(dirname(__DIR__));
Yii::setAlias('root', $rootDir);
Yii::setAlias('common', $rootDir . DIRECTORY_SEPARATOR . 'common');
Yii::setAlias('console', $rootDir . DIRECTORY_SEPARATOR . 'console');

$params = ArrayHelper::merge(
	require($rootDir . '/common/config/params.php'),
	require($rootDir . '/common/config/params-local.php'),
	require(__DIR__ . '/params.php'),
	require(__DIR__ . '/params-local.php')
);

return [
	'id' => 'app-console',
	'vendorPath' => $rootDir . DIRECTORY_SEPARATOR . 'vendor',
	'sourceLanguage' => 'en',
	'language' => 'ru',
	'charset' => 'utf-8',
	'timeZone' => 'Europe/Moscow',
	'basePath' => dirname(__DIR__),
	'controllerNamespace' => 'console\controllers',
	'extensions' => require($rootDir . '/vendor/yiisoft/extensions.php'),
	'components' => [
		'urlManager' => [
			'enablePrettyUrl' => true,
			'enableStrictParsing' => true,
			'showScriptName' => false,
			'suffix' => '/',
			'baseUrl' => $params['app']['siteDomain'],
			'rules' => [
				'<action:(activation|email|recovery)>' => 'users/default/<action>',
			]
		],
		'db' => $params['components.db'],
		'cache' => $params['components.cache'],
		'log' => [
			'targets' => [
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['error', 'warning'],
				],
			],
		],
		'i18n' => [
			'translations' => [
				'mailer' => [
					'class' => 'yii\i18n\PhpMessageSource',
					'basePath' => '@frontend/modules/mailer/messages',
				]
			]
		],
		'mail' => $params['components.mail'],
	],
	'params' => $params['app'],
];
