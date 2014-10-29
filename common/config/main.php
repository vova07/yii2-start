<?php

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'timeZone' => 'Europe/Moscow',
    'modules' => [
        'users' => [
            'class' => 'vova07\users\Module',
            'robotEmail' => 'no-reply@domain.com',
            'robotName' => 'Robot'
        ],
        'blogs' => [
            'class' => 'vova07\blogs\Module'
        ],
        'comments' => [
            'class' => 'vova07\comments\Module'
        ]
    ],
    'components' => [
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'vova07\users\models\User',
            'loginUrl' => ['/users/guest/login']
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@root/cache',
            'keyPrefix' => 'yii2start'
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'suffix' => '/'
        ],
        'assetManager' => [
            'linkAssets' => true
        ],
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
            'defaultRoles' => [
                'user'
            ],
            'itemFile' => '@vova07/rbac/data/items.php',
            'assignmentFile' => '@vova07/rbac/data/assignments.php',
            'ruleFile' => '@vova07/rbac/data/rules.php',
        ],
        'formatter' => [
            'dateFormat' => 'dd.MM.y',
            'datetimeFormat' => 'HH:mm:ss dd.MM.y'
        ],
        'db' => require(__DIR__ . '/db.php')
    ],
    'params' => require(__DIR__ . '/params.php')
];
