<?php
return [
    'bootstrap' => [
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
				'<_m:(debug|gii)>/<_c:\w+>/<_a:\w+>' => '<_m>/<_c>/<_a>',
			]
		],
	]
];