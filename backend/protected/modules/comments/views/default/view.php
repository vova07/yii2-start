<?php
/**
 * Представление страницы комментария.
 * @var yii\base\View $this Представление
 * @var common\modules\comments\models\Comment $model Модель
 */

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Комментарий #' . $model['id'];
$this->params['control'] = [
    'brandLabel' => Html::encode($this->title),
    'modelId' => $model['id'],
    'create' => [
        'label' => Yii::t('comments', 'Комментировать'),
        'url' => ['create', 'parentId' => $model['id'], 'postId' => $model['post_id']]
    ]
];

echo DetailView::widget([
	'model' => $model,
	'attributes' => [
	    'id',
        [
            'attribute' => 'author_id',
            'format' => 'html',
            'value' => Html::a($model->author->getFio(true), ['/users/default/view', 'id' => $model->author->id])
        ],
        [
            'attribute' => 'post_id',
            'format' => 'html',
            'value' => Html::a($model->post->title, ['/blogs/default/view', 'id' => $model->post->id])
        ],
        [
            'attribute' => 'parent_id',
            'format' => 'html',
            'value' => $model->commentParent ? Html::a($model->commentParent->id, ['/comments/default/view', 'id' => $model->commentParent->id]) : ''
        ],
        'content:html',
	    [
            'attribute' => 'status_id',
            'value' => $model->status
        ],
        'create_time:date',
        'update_time:date'
	]
]);