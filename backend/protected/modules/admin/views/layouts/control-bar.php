<?php
/**
 * Верхнее меню backend-приложения.
 * @var yii\base\View $this Предсталвение
 * @var array $params Основные параметры представления
 */

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

$options = [
    'id' => 'control-bar',
    'renderInnerContainer' => false,
    'brandUrl' => ['index'],
    'options' => [
        'class' => 'navbar-default',
    ]
];
$items = [];

if (isset($this->params['control']['brandLabel'])) {
    $options['brandLabel'] = $this->params['control']['brandLabel'];
}

if (isset($this->params['control']['create'])) {
    if (is_array($this->params['control']['create'])) {
        $items[] = [
            'label' => '<span class="glyphicon glyphicon-plus-sign"></span> ' . $this->params['control']['create']['label'],
            'url' => $this->params['control']['create']['url']
        ];
    }
} else {
    $items[] = [
        'label' => '<span class="glyphicon glyphicon-plus-sign"></span> ' . Yii::t('admin', 'Создать'),
        'url' => ['create']
    ];
}

if (isset($this->params['control']['modelId'])) {
    $modelId = $this->params['control']['modelId'];
    $items[] = [
        'label' => '<span class="glyphicon glyphicon-pencil"></span> ' . Yii::t('admin', 'Редактировать'),
        'url' => ['update', 'id' => $modelId]
    ];
    $items[] = [
        'label' => '<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('admin', 'Удалить'),
        'url' => ['delete', 'id' => $modelId]
    ];
} elseif (isset($this->params['control']['gridId'])) {
    $items[] = [
        'label' => '<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('admin', 'Удалить'),
        'url' => ['batch-delete'],
        'linkOptions' => [
            'id' => 'delete-all',
            'data-confirm' => Yii::t('admin', 'Вы уверены что хотите удалить эти записи?')
        ]
    ];
} else {
    $items[] = [
        'label' => '<span class="glyphicon glyphicon-remove-sign"></span> ' . Yii::t('admin', 'Отмена'),
        'url' => ['index']
    ];
}
NavBar::begin($options);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'encodeLabels' => false,
        'items' => $items
    ]);
NavBar::end();

if (isset($this->params['control']['gridId'])) {
    $id = $this->params['control']['gridId'];
    $this->registerJs("jQuery(document).on('click', '#delete-all', function (e) {
        e.preventDefault();
        var keys = jQuery('#$id').yiiGridView('getSelectedRows');
        if (keys == '') {
            alert('" . Yii::t('admin', 'Вы должны выбрать одну или более записей!') . "');
        } else {
            jQuery.ajax({
                url: jQuery(this).attr('href'),
                data: { ids: keys}
            });
        }
        console.log(keys);
    });");
}