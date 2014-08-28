<?php

/**
 * Top menu view.
 *
 * @var \yii\web\View $this View
 */

use frontend\themes\site\widgets\Menu;

echo Menu::widget(
    [
        'options' => [
            'class' => isset($footer) ? 'pull-right' : 'nav navbar-nav navbar-right'
        ],
        'items' => [
            [
                'label' => Yii::t('themes', 'Blogs'),
                'url' => ['/blogs/default/index']
            ],
            [
                'label' => Yii::t('themes', 'Contacts'),
                'url' => ['/site/default/contacts']
            ],
            [
                'label' => Yii::t('themes', 'Sign In'),
                'url' => ['/users/guest/login'],
                'visible' => Yii::$app->user->isGuest
            ],
            [
                'label' => Yii::t('themes', 'Sign Up'),
                'url' => ['/users/guest/signup'],
                'visible' => Yii::$app->user->isGuest
            ],
            [
                'label' => Yii::t('themes', 'Settings'),
                'url' => '#',
                'template' => '<a href="{url}" class="dropdown-toggle" data-toggle="dropdown">{label} <i class="icon-angle-down"></i></a>',
                'visible' => !Yii::$app->user->isGuest,
                'items' => [
                    [
                        'label' => Yii::t('themes', 'Edit profile'),
                        'url' => ['/users/user/update']
                    ],
                    [
                        'label' => Yii::t('themes', 'Change email'),
                        'url' => ['/users/user/email']
                    ],
                    [
                        'label' => Yii::t('themes', 'Change password'),
                        'url' => ['/users/user/password']
                    ]
                ]
            ],
            [
                'label' => Yii::t('themes', 'Sign Out'),
                'url' => ['/users/user/logout'],
                'visible' => !Yii::$app->user->isGuest
            ]
        ]
    ]
);