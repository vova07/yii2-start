<?php
/**
 * Представление страницы всех пользователей.
 * @var yii\base\View $this Представление
 * @var common\modules\users\models\User $dataProvider Дата провайдер
 */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\grid\CheckboxColumn;
use yii\grid\SerialColumn;

$this->title = Yii::t('users', 'Пользователи');
$this->params['control'] = [
    'brandLabel' => Html::encode($this->title),
    'gridId' => 'users-grid'
];

echo GridView::widget([
    'id' => 'users-grid',
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
            'attribute' => 'username',
            'format' => 'html',
            'value' => function ($model) {
                return Html::a($model['username'], ['view', 'id' => $model['id']]);
            }
        ],
        'name',
        'surname',
        'email',
        [
            'attribute' => 'status_id',
            'value' => function ($model) {
                return $model->status;
            },
            'filter' => Html::activeDropDownList($searchModel, 'status_id', $statusArray, ['class' => 'form-control', 'prompt' => Yii::t('users', 'Статус')])
        ],
        [
            'attribute' => 'role_id',
            'value' => function ($model) {
                return $model->role;
            },
            'filter' => Html::activeDropDownList($searchModel, 'role_id', $roleArray, ['class' => 'form-control', 'prompt' => Yii::t('users', 'Роль')])
        ],
        [
            'class' => ActionColumn::className(),
            'header' => Yii::t('users', 'Управление')
        ]
    ]
]);