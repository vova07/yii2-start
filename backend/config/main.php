<?php

Yii::setAlias('backend', dirname(__DIR__));

return [
    'id' => 'app-backend',
    'name' => 'Yii2-Start',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'admin/default/index',
    'modules' => [
        'admin' => [
            'class' => 'vova07\admin\Module'
        ],
        'users' => [
            'controllerNamespace' => 'vova07\users\controllers\backend'
        ],
        'blogs' => [
            'controllerNamespace' => 'vova07\blogs\controllers\backend'
        ],
        'comments' => [
            'isBackend' => true
        ],
        'rbac' => [
            'class' => 'vova07\rbac\Module',
            'isBackend' => true
        ]
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => '7fdsf%dbYd&djsb#sn0mlsfo(kj^kf98dfh',
            'baseUrl' => '/backend'
        ],
        'urlManager' => [
            'rules' => [
                '' => 'admin/default/index',
                '<_m>/<_c>/<_a>' => '<_m>/<_c>/<_a>'
            ]
        ],
        'view' => [
            'theme' => 'vova07\themes\admin\Theme'
        ],
        'errorHandler' => [
            'errorAction' => 'admin/default/error'
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning']
                ]
            ]
        ]
    ],
    'params' => require(__DIR__ . '/params.php')
];
