<?php
$params = require(__DIR__ . '/params.php');
return array(
	'id' => 'bootstrap',
	'basePath' => dirname(__DIR__),
	'preload' => array('log'),
	'defaultRoute' => 'site/default/index',
	'layoutPath' => '@app/modules/site/views/layouts',
	'viewPath' => '@app/modules/site/views',
	'modules' => array(
//		'debug' => array(
//			'class' => 'yii\debug\Module',
//		)
		'site' => array(
			'class' => 'app\modules\site\Site'
		),
		'users' => array(
			'class' => 'app\modules\users\Users'
		),
		'blogs' => array(
			'class' => 'app\modules\blogs\Blogs'
		),
		'comments' => array(
			'class' => 'app\modules\comments\Comments'
		),
		'rbac' => array(
			'class' => 'app\modules\rbac\Rbac'
		)
	),
	'components' => array(
		'urlManager'=>array(
			'enablePrettyUrl' => true,
			'enableStrictParsing' => true,
			'showScriptName' => false,
			'suffix' => '/',
			'rules' => array(
				'/'=>'site/default/index',
				'<module:\w+>/<action:\w+>/<id:\d+>' => '<module>/default/<action>',
				'<module:\w+>' => '<module>/default/index',
				'<module:\w+>/<action:\w+>' => '<module>/default/<action>',
			)
		),
		'authManager' => array(
			'class' => 'app\modules\rbac\components\PhpManager',
			'defaultRoles' => array('guest'),
		),

		'db' => $params['components.db'],
		'cache' => $params['components.cache'],

		'user' => array(
			'class' => 'yii\web\User',
			'identityClass' => 'app\modules\users\models\User',
		),
		'assetManager' => array(
			'bundles' => require(__DIR__ . '/assets.php'),
		),
		'log' => array(
			'class' => 'yii\logging\Router',
			'targets' => array(
				array(
					'class' => 'yii\logging\FileTarget',
					'levels' => array('error', 'warning'),
				),
//				array(
//					'class' => 'yii\logging\DebugTarget',
//				)
			),
		),
	),
	'params' => $params,
);
