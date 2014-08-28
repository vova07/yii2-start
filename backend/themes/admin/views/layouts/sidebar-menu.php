<?php

/**
 * Sidebar menu layout.
 *
 * @var \yii\web\View $this View
 */

use backend\themes\admin\widgets\Menu;

echo Menu::widget(
    [
        'options' => [
            'class' => 'sidebar-menu'
        ],
        'items' => [
            [
                'label' => Yii::t('themes', 'Dashboard'),
                'url' => Yii::$app->homeUrl,
                'icon' => 'fa-dashboard',
                'active' => Yii::$app->request->url === Yii::$app->homeUrl
            ],
            [
                'label' => Yii::t('themes', 'Users'),
                'url' => ['/users/default/index'],
                'icon' => 'fa-group'
            ],
            [
                'label' => Yii::t('themes', 'Blogs'),
                'url' => ['/blogs/default/index'],
                'icon' => 'fa-book'
            ]
        ]
    ]
);