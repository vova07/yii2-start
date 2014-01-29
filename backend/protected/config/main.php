<?php
use yii\helpers\ArrayHelper;

Yii::setAlias('backend', dirname(__DIR__));

$params = ArrayHelper::merge(
	require(__DIR__ . '/params.php'),
	require(__DIR__ . '/params-local.php')
);

return [
	'id' => 'app-backend',
	'name' => 'Yii2 - демо приложение админ панель',
	'basePath' => dirname(__DIR__),
	'defaultRoute' => 'admin/default/index',
	'layoutPath' => '@app/modules/admin/views/layouts',
	'viewPath' => '@app/modules/admin/views',
	'modules' => [
	    'admin' => [
			'class' => 'backend\modules\admin\Admin'
		],
	    'users' => [
			'class' => 'backend\modules\users\Users'
		],
		'rbac' => [
			'class' => 'backend\modules\users\modules\rbac\Rbac'
		],
		'blogs' => [
			'class' => 'backend\modules\blogs\Blogs',
			'modules' => [
			    'categories' => [
					'class' => 'backend\modules\blogs\modules\categories\Categories'
				],
			]
		],
		'comments' => [
			'class' => 'backend\modules\comments\Comments'
		],
	],
	'components' => [
		'urlManager' => [
			'rules' => [
				// Модуль [[Admin]]
				'' => 'admin/default/index',

				// Модуль [[Users]]
				'<_a:(login|logout)>' => 'users/default/<_a>',

				// Общие правила
				'<_m:[\w\-]+>/<_sm:[\w\-]+>/<_c:[\w\-]+>/<_a:[\w\-]+>' => '<_m>/<_sm>/<_c>/<_a>',
				'<_m:[\w\-]+>/<_c:[\w\-]+>/<_a:[\w\-]+>' => '<_m>/<_c>/<_a>',
			]
		],
		'errorHandler' => [
			'errorAction' => 'admin/default/error',
		],
		'i18n' => [
			'translations' => [
				'admin' => [
					'class' => 'yii\i18n\PhpMessageSource',
					'sourceLanguage' => 'ru',
					'basePath' => '@backend/modules/admin/messages',
				]
			]
		]
	],
	'params' => isset($params['app']) ? $params['app'] : []
];