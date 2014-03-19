<?php
/**
 * Представление формы пользователя.
 * @var yii\web\View $this Представление
 * @var yii\widgets\ActiveForm $form Форма
 * @var common\modules\users\models\User $model Модель
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\extensions\fileapi\FileAPIAdvanced;

$form = ActiveForm::begin([
	'enableClientValidation' => false,
	'enableAjaxValidation' => true,
	'validateOnChange' => false
]);
echo $form->field($model, 'name') .
     $form->field($model, 'surname') .
	 $form->field($model, 'username') .
	 $form->field($model, 'email') .
     $form->field($model, 'password')->passwordInput() .
     $form->field($model, 'repassword')->passwordInput() .
     $form->field($model, 'status_id')->dropDownList($statusArray, [
        'prompt' => Yii::t('users', 'Выберите статус')
     ]) .
     $form->field($model, 'role_id')->dropDownList($roleArray, [
        'prompt' => Yii::t('users', 'Выберите роль')
     ]) .
     $form->field($model, 'avatar_url')->widget(FileAPIAdvanced::className(), [
        'url' => $this->context->module->avatarUrl(),
        'deleteUrl' => Url::toRoute('/users/default/delete-avatar'),
        'deleteTempUrl' => Url::toRoute('/users/default/deleteTempAvatar'),
        'crop' => true,
        'cropResizeWidth' => $this->context->module->avatarWidth,
        'cropResizeHeight' => $this->context->module->avatarHeight,
        'settings' => [
            'url' => Url::toRoute('uploadTempAvatar'),
            'imageSize' =>  [
		        'minWidth' => $this->context->module->avatarWidth,
		        'minHeight' => $this->context->module->avatarHeight
		    ]
        ]
     ]) .
     Html::submitButton($model->isNewRecord ? Yii::t('users', 'Сохранить') : Yii::t('users', 'Обновить'), [
     	'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'
     ]);
ActiveForm::end();