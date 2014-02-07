<?php
/**
 * Верхнее меню frontend-приложения.
 * @var yii\base\View $this Представление
 * @var array $params Основные параметры представления
 */

use yii\bootstrap\Nav;

$items = [
    [
        'label' => Yii::t('site', 'Пользователи'),
        'url' => ['/users/default/index']
    ],
    [
        'label' => Yii::t('site', 'Блоги'),
        'url' => ['/blogs/default/index']
    ],
    [
        'label' => Yii::t('site', 'О нас'),
        'url' => ['/site/default/about']
    ],
    [
        'label' => Yii::t('site', 'Обратная связь'),
        'url' => ['/site/default/contact']
    ]
];

if (Yii::$app->user->isGuest) {
    $items[] = [
        'label' => Yii::t('site', 'Регистрация'),
        'url' => ['/users/default/signup']
    ];
    $items[] = [
        'label' => Yii::t('site', 'Вход'),
        'url' => ['/users/default/login']
    ];
} else {
    $items[] = [
        'label' => Yii::$app->user->identity->username . ' - ' . Yii::t('site', 'Личный кабинет'),
        'url' => ['/users/default/view', 'username' => Yii::$app->user->identity->username],
        'items' => [
            [
                'label' => Yii::t('site', 'Редактирование личных данных'),
                'url' => ['/users/default/update']
            ],
            [
                'label' => Yii::t('site', 'Смена E-mail адреcа'),
                'url' => ['/users/default/request-email-change']
            ],
            [
                'label' => Yii::t('site', 'Смена пароля'),
                'url' => ['/users/default/password']
            ]
        ]
    ];
    $items[] = [
        'label' => Yii::t('site', 'Выход'),
        'url' => ['/users/default/logout']
    ];
}

echo Nav::widget([
    'id' => 'topmenu',
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $items
]);