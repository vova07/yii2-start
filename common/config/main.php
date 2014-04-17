<?php
use yii\helpers\ArrayHelper;

$rootDir = dirname(dirname(__DIR__));
Yii::setAlias('root', $rootDir);
Yii::setAlias('common', dirname(__DIR__));
Yii::setAlias('frontend', $rootDir . DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR . 'protected');

$params = ArrayHelper::merge(
	require(__DIR__ . '/params.php'),
	require(__DIR__ . '/params-local.php')
);

return [
	'vendorPath' => $rootDir . DIRECTORY_SEPARATOR . 'vendor',
	'sourceLanguage' => 'en',
	'language' => 'ru',
	'charset' => 'utf-8',
	'timeZone' => 'Europe/Moscow',
	'extensions' => require($rootDir . '/vendor/yiisoft/extensions.php'),
	'components' => [
		'request' => [
            'enableCsrfValidation' => true,
			'enableCookieValidation' => true
        ],
		'urlManager' => [
			'enablePrettyUrl' => true,
			'enableStrictParsing' => true,
			'showScriptName' => false,
			'suffix' => '/',
		],
		'db' => $params['components.db'],
		'cache' => $params['components.cache'],
		'user' => [
			'class' => 'yii\web\User',
			'identityClass' => 'common\modules\users\models\User',
			'loginUrl' => ['/users/default/login']
		],
		'authManager' => [
			'class' => 'common\modules\users\modules\rbac\components\PhpManager',
			'defaultRoles' => ['guest'],
		],
		'i18n' => [
			'translations' => [
			    'users' => [
					'class' => 'yii\i18n\PhpMessageSource',
					'sourceLanguage' => 'ru',
					'basePath' => '@common/modules/users/messages',
				],
				'blogs' => [
					'class' => 'yii\i18n\PhpMessageSource',
					'sourceLanguage' => 'ru',
					'basePath' => '@common/modules/blogs/messages',
				],
				'categories' => [
					'class' => 'yii\i18n\PhpMessageSource',
					'sourceLanguage' => 'ru',
					'basePath' => '@common/modules/blogs/modules/categories/messages',
				],
				'comments' => [
					'class' => 'yii\i18n\PhpMessageSource',
					'sourceLanguage' => 'ru',
					'basePath' => '@common/modules/comments/messages',
				],
			]
		],
		'log' => [
			'traceLevel' => YII_DEBUG ? 3 : 0,
			'targets' => [
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['error', 'warning'],
				]
			]
		],
		'mail' => $params['components.mail']
	],
	'params' => isset($params['app']) ? $params['app'] : []
];