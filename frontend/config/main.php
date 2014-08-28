<?php

return [
    'id' => 'app-frontend',
    'name' => 'Yii2-Start',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'site/default/index',
    'modules' => [
        'site' => [
            'class' => 'frontend\modules\site\Module'
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
            'theme' => [
                'pathMap' => [
                    '@frontend/views' => '@frontend/themes/site/views',
                    '@frontend/modules' => '@frontend/themes/site/modules'
                ]
            ]
        ],
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => [
                    'sourcePath' => '@frontend/themes/site',
                    'css' => [
                        'css/bootstrap.min.css'
                    ]
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'sourcePath' => '@frontend/themes/site',
                    'js' => [
                        'js/bootstrap.min.js'
                    ]
                ]
            ]
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
        ],
        'i18n' => [
            'translations' => [
                'site' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@frontend/modules/site/messages',
                    'forceTranslation' => true
                ],
                'themes*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@frontend/themes/site/messages',
                ]
            ]
        ]
    ],
    'params' => require(__DIR__ . '/params.php')
];
