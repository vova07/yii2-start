<?php
/**
 * Представление страницы создания пользователя.
 * @var yii\base\View $this Представление
 * @var common\modules\users\models\User $model Модель
 * @var array $roleArray Массив ролей пользователя
 * @var array $statusArray Массив статусов пользователя
 */

use yii\helpers\Html;

$this->title = Yii::t('app', 'Новый пользователь');
$this->params['control'] = [
    'brandLabel' => Html::encode($this->title)
];

echo $this->render('_form', [
	'model' => $model,
	'roleArray' => $roleArray,
    'statusArray' => $statusArray
]);