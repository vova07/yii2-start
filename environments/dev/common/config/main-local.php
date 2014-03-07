<?php
return [
    'preload' => [
		'debug',
	],
	'modules' => [
		'gii' => [
			'class' => 'yii\gii\Module'
		],
		'debug' => [
			'class' => 'yii\debug\Module'
		]
	],
	'components' => [
		'urlManager' => [
			'rules' => [
				'<_m:debug>/<_c:\w+>/<_a:\w+>' => '<_m>/<_c>/<_a>',
			]
		],
	]
];