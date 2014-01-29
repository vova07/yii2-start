<?php
/**
 * Верхнее меню backend-приложения.
 * @var yii\base\View $this Предсталвение
 * @var array $params Основные параметры представления
 */

use yii\bootstrap\Nav;

$leftItems = [
    [
        'label' => Yii::t('admin', 'Пользователи'),
        'url' => ['/users/default/index']
    ],
    [
        'label' => Yii::t('admin', 'Блоги'),
        'url' => ['/blogs/default/index'],
        'items' => [
            [
                'label' => Yii::t('admin', 'Посты'),
                'url' => ['/blogs/default/index']
            ],
            [
                'label' => Yii::t('admin', 'Категории'),
                'url' => ['/blogs/categories/default/index']
            ]
        ]
    ],
    [
        'label' => Yii::t('admin', 'Комментарии'),
        'url' => ['/comments/default/index']
    ]
];

$rightItems = [
    [
        'label' => Yii::t('admin', 'Перейти на сайт'),
        'url' => Yii::$app->params['siteDomain']
    ]
];
if (!Yii::$app->user->isGuest) {
    $rightItems[] = [
        'label' => Yii::t('admin', 'Выход'),
        'url' => ['/users/default/logout']
    ];
}

echo Nav::widget([
    'id' => 'topmenu',
    'options' => ['class' => 'navbar-nav navbar-left'],
    'items' => $leftItems
]);

echo Nav::widget([
    'id' => 'topmenu',
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $rightItems
]);