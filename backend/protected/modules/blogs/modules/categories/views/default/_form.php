<?php
/**
 * Представление формы категорий.
 * @var yii\web\View $this Предсталение
 * @var common\modules\blogs\modules\category\models\Category $model Модель
 * @var yii\widgets\ActiveForm $form Форма
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
	'enableClientValidation' => false,
	'enableAjaxValidation' => true,
	'validateOnChange' => false
]);
    echo $form->field($model, 'title') .
         $form->field($model, 'alias') .
         $form->field($model, 'ordering') .
         $form->field($model, 'status_id')->dropDownList($statusArray, [
            'prompt' => Yii::t('comments', 'Выберите статус')
         ]) .
         Html::submitButton($model->isNewRecord ? Yii::t('categories', 'Сохранить') : Yii::t('categories', 'Обновить'), [
            'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'
        ]);
ActiveForm::end();