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
	]
];