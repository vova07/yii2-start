<?php
/**
 * Представление страницы одного пользователя.
 * @var yii\base\View $this представление
 * @var common\modules\users\models\User $model Модель
 */

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->fio;
$this->params['control'] = [
    'brandLabel' => Html::encode($this->title),
    'modelId' => $model['id']
];

echo DetailView::widget([
	'model' => $model,
	'attributes' => [
	    'id',
        [
            'name' => 'avatar_url',
            'format' => 'html',
            'value' => ($model->avatar !== null) ? Html::img($model->avatar) : ''
        ],
        'name',
        'surname',
	    'username',
        'email',
        [
            'name' => 'status_id',
            'value' => $model->status
        ],
	    [
	        'name' => 'role_id',
	        'value' => $model->role
	    ],
	    [
	        'name' => 'create_time',
	        'format' => ['date', 'd/m/Y']
	    ],
        [
            'name' => 'update_time',
            'format' => ['date', 'd/m/Y']
        ]
	]
]);