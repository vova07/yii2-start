<?php
return [
	'app' => [
	    'siteDomain' => 'http://my-site.com',
	    'staticsDomain' => 'http://statics.my-site.com',
		'adminEmail' => 'admin@my-site.com',
		'robotEmail' => 'robot@my-site.com',
		'allowHtmlTags' => 'p,span,strong,ul,ol,li,em,u,strike,br,hr,img,a',
		'moreTag' => '<!--more-->',
		'morePattern' => '<p><!--more--></p>',
	],
	'components.db' => [
		'class' => 'yii\db\Connection',
		'dsn' => 'mysql:host=127.0.0.1;dbname=yii2-start',
		'username' => 'root',
		'password' => '',
		'charset' => 'utf8',
		'tablePrefix' => 'mk3u_'
	],
	'components.cache' => [
		'class' => 'yii\caching\MemCache',
		'keyPrefix' => 'yii2start'
	],
	'components.mail' => [
	    'class' => 'yii\swiftmailer\Mailer',
	    'viewPath' => '@common/mails'
	]
];