<?php
/**
 * Представление формы виджета комментариев.
 * @var yii\base\View $this Представление
 * @var frontend\modules\comments\models\Comment $model Модель
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
    'id' => 'comment-form',
    'action' => ['/comments'],
    'fieldConfig' => [
        'template' => "{input}\n{hint}\n{error}"
    ],
    'enableClientValidation' => false,
    'enableAjaxValidation' => false,
    'validateOnChange' => false
]);
    echo $form->field($model, 'content')->textarea() .
         Html::activeHiddenInput($model, 'post_id') .
         Html::activeHiddenInput($model, 'parent_id') .
         Html::hiddenInput('level', null, ['id' => 'comment-level']) .
         Html::submitInput($sendButtonText, [
            'class' => 'btn btn-primary pull-right'
         ]) .
         Html::button($cancelButtonText, [
            'class' => 'btn btn-link cancel pull-right'
         ]);
ActiveForm::end();