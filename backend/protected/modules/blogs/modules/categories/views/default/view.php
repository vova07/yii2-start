<?php
/**
 * Представление страницы категории.
 * @var yii\base\View $this Представление
 * @var common\modules\blogs\modules\category\models\Category $model Модель
 */

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model['title'];
$this->params['control'] = [
    'brandLabel' => Html::encode($this->title),
    'modelId' => $model['id']
];

echo DetailView::widget([
	'model' => $model,
	'attributes' => [
	    'id',
        'ordering',
	    'title',
        'alias',
	    [
            'attribute' => 'status_id',
            'value' => $model->status
        ]
	]
]);