<?php
/**
 * Представление формы комментариев.
 * @var yii\web\View $this Представление
 * @var yii\widgets\ActiveForm $form Форма
 * @var common\modules\comments\models\Comment $model Модель
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
	'enableClientValidation' => false,
	'enableAjaxValidation' => true,
	'validateOnChange' => false
]);
    echo $form->field($model, 'status_id')->dropDownList($statusArray, [
            'prompt' => Yii::t('comments', 'Выберите статус')
         ]) .
         $form->field($model, 'content')->textarea();
    if ($model->isNewRecord) {
        echo Html::activeHiddenInput($model, 'parent_id') .
             Html::activeHiddenInput($model, 'post_id');
    }
    echo Html::submitButton($model->isNewRecord ? Yii::t('comments', 'Сохранить') : Yii::t('comments', 'Обновить'), [
        'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'
    ]);
ActiveForm::end();