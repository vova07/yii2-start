<?php
use yii\helpers\ArrayHelper;

$params = ArrayHelper::merge(
	require(__DIR__ . '/params.php'),
	require(__DIR__ . '/params-local.php')
);

return [
	'id' => 'app-frontend',
	'name' => 'Yii2 - демо приложение',
	'basePath' => dirname(__DIR__),
	'defaultRoute' => 'site/default/index',
	'layoutPath' => '@frontend/modules/site/views/layouts',
	'viewPath' => '@frontend/modules/site/views',
	'modules' => [
		'site' => [
			'class' => 'frontend\modules\site\Site'
		],
		'users' => [
		    'class' => 'frontend\modules\users\Users'
		],
		'blogs' => [
			'class' => 'frontend\modules\blogs\Blogs'
		],
		'comments' => [
			'class' => 'frontend\modules\comments\Comments'
		]
	],
	'components' => [
		'urlManager' => [
			'rules' => [
				// Модуль [[Site]]
				'' => 'site/default/index',
				'<_a:(about|contact|error|captcha)>' => 'site/default/<_a>',

				// Общие правила
				'<_m:(users|blogs)>' => '<_m>/default/index',

				// Модуль [[Users]]
				'<_a:(login|logout|signup|activation|recovery|resend|email|avatar)>' => 'users/default/<_a>',
				'my/settings/email' => 'users/default/request-email-change',
				'my/settings/<_a:[\w\-]+>' => 'users/default/<_a>',
				'<_m:users>/<username:[a-zA-Z0-9_-]{3,20}+>' => '<_m>/default/view',

				// CRUD [[Blogs]]
				'PUT <_m:blogs>/<id:\d+>-<alias:[a-zA-Z0-9_-]+>' => '<_m>/default/update',
				'DELETE <_m:blogs>/<id:\d+>-<alias:[a-zA-Z0-9_-]+>' => '<_m>/default/delete',
				// Модуль [[Blogs]]
				'<_m:blogs>/<id:\d+>-<alias:[a-zA-Z0-9_-]+>' => '<_m>/default/view',
				'<_m:blogs>/<category:[\w\-]+>' => '<_m>/default/index',

				// Общие CRUD правила
				'POST <_m:[\w\-]+>' => '<_m>/default/create',
				'POST <_m:[\w\-]+>/<id:\d+>' => '<_m>/default/update',
				'DELETE <_m:[\w\-]+>/<id:\d+>' => '<_m>/default/delete'
			]
		],
		'errorHandler' => [
			'errorAction' => 'site/default/error',
		],
		'i18n' => [
			'translations' => [
				'site' => [
					'class' => 'yii\i18n\PhpMessageSource',
					'sourceLanguage' => 'ru',
					'basePath' => '@frontend/modules/site/messages',
				]
			]
		]
	],
	'params' => isset($params['app']) ? $params['app'] : []
];