<?php

return [
    'id' => 'app-frontend',
    'name' => 'Yii2-Start',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'site/default/index',
    'modules' => [
        'site' => [
            'class' => 'vova07\site\Module'
        ],
        'blogs' => [
            'controllerNamespace' => 'vova07\blogs\controllers\frontend'
        ],
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'sdi8s#fnj98jwiqiw;qfh!fjgh0d8f',
            'baseUrl' => ''
        ],
        'urlManager' => [
            'rules' => [
                '' => 'site/default/index',
                '<_a:(about|contacts|captcha)>' => 'site/default/<_a>'
            ]
        ],
        'view' => [
            'theme' => 'vova07\themes\site\Theme'
        ],
        'errorHandler' => [
            'errorAction' => 'site/default/error'
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
