<?php
/**
 * Представление страницы всех комментариев.
 * @var yii\base\View $this Представление
 * @var common\modules\comments\models\Comment $dataProvider Дата провайдер
 * @var backend\modules\comments\models\search\CommentSearch $searchModel Поисковая модель
 */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\grid\CheckboxColumn;
use yii\grid\SerialColumn;
use yii\widgets\Menu;

$this->title = Yii::t('comments', 'Комментарии');
$this->params['control'] = [
    'brandLabel' => Html::encode($this->title),
    'gridId' => 'comments-grid',
    'create' => false
];

echo GridView::widget([
    'id' => 'comments-grid',
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
            'label' => '',
            'format' => 'html',
            'value' => function ($model) {
                return Html::a(Yii::t('comments', 'Комментировать'), ['create', 'parentId' => $model['id'], 'postId' => $model['post_id']]);
            },
        ],
        [
            'attribute' => 'content',
            'format' => 'html',
            'value' => function ($model) {
                return Html::a($model['content'], ['view', 'id' => $model['id']]);
            },
        ],
        [
            'attribute' => 'author_id',
            'format' => 'html',
            'value' => function ($model) {
                return Html::a($model->author['username'], ['/users/default/view', 'id' => $model->author['id']]);
            }
        ],
        [
            'attribute' => 'status_id',
            'value' => function ($model) {
                return $model->status;
            },
            'filter' => Html::activeDropDownList($searchModel, 'status_id', $statusArray, ['class' => 'form-control', 'prompt' => Yii::t('comments', 'Статус')])
        ],
        'create_time:date',
        'update_time:date',
        [
            'class' => ActionColumn::className(),
            'header' => Yii::t('comments', 'Управление')
        ]
    ]
]);