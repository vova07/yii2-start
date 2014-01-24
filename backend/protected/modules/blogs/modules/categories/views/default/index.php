<?php
/**
 * Представление страницы всех категорий.
 * @var yii\base\View $this Представление
 * @var common\modules\blogs\modules\category\models\Category $dataProvider Дата провайдер
 * @var backend\modules\blogs\modules\categories\models\search\CategorySearch $searchModel Поисковая модель
 */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\grid\CheckboxColumn;
use yii\grid\SerialColumn;
use yii\widgets\Menu;

$this->title = Yii::t('categories', 'Категории постов');
$this->params['control'] = [
    'brandLabel' => Html::encode($this->title),
    'gridId' => 'categories-grid'
];

echo GridView::widget([
    'id' => 'categories-grid',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        [
            'class' => CheckboxColumn::classname()
        ],
        [
            'class' => SerialColumn::className(),
        ],
        [
            'attribute' => 'ordering',
            'headerOptions' => [
                'class' => 'sort-ordinal'
            ]
        ],
        [
            'attribute' => 'title',
            'format' => 'html',
            'value' => function ($model) {
                return Html::a($model['title'], ['view', 'id' => $model['id']]);
            },
        ],
        'alias',
        [
            'attribute' => 'status_id',
            'value' => function ($model) {
                return $model->status;
            },
            'filter' => Html::activeDropDownList($searchModel, 'status_id', $statusArray, ['class' => 'form-control', 'prompt' => Yii::t('blogs', 'Статус')])
        ],
        [
            'class' => ActionColumn::className(),
            'header' => Yii::t('blogs', 'Управление')
        ]
    ]
]);