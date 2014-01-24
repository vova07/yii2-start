<?php
/**
 * Представление страницы всех постов.
 * @var yii\base\View $this Представление
 * @var backend\modules\blogs\models\search\PostSearch $searchModel Поисковая модель
 * @var common\modules\blogs\models\Post $dataProvider Дата провайдер
 */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\grid\CheckboxColumn;
use yii\grid\SerialColumn;
use yii\widgets\Menu;

$this->title = Yii::t('blogs', 'Посты');
$this->params['control'] = [
    'brandLabel' => Html::encode($this->title),
    'gridId' => 'blogs-grid'
];

echo GridView::widget([
    'id' => 'blogs-grid',
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
            'attribute' => 'title',
            'format' => 'html',
            'value' => function ($model) {
                return Html::a($model['title'], ['view', 'id' => $model['id']]);
            },
        ],
        'alias',
        [
            'attribute' => 'author_id',
            'format' => 'html',
            'value' => function ($model) {
                return Html::a($model->author['username'], ['/users/default/view', 'id' => $model->author['id']]);
            }
        ],
        [
            'attribute' => 'categoryIds',
            'format' => 'html',
            'value' => function ($model) {
                $categories = '';
                foreach ($model->categories as $key => $category) {
                    if ($key !== 0) {
                        $categories .= '<br />';
                    }
                    $categories .= Html::a($category['title'], ['/categories/default/index', 'id' => $category['id']]);
                }
                return $categories;
            },
            'filter' => Html::activeDropDownList($searchModel, 'category_id', $categoryArray, ['class' => 'form-control', 'prompt' => Yii::t('blogs', 'Категория')])
        ],
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