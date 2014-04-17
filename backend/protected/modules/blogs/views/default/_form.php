<?php
/**
 * Представление формы поста.
 * @var yii\web\View $this Представление
 * @var yii\widgets\ActiveForm $form Форма
 * @var common\modules\blogs\models\Post $model Модель
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;
use common\extensions\fileapi\FileAPIAdvanced;

$form = ActiveForm::begin([
	'enableClientValidation' => false,
	'enableAjaxValidation' => true,
	'validateOnChange' => false,
    'beforeValidate' => new JsExpression('function ($form, attribute, messages) { if (attribute.name === "content") { tinymce.triggerSave(); } return true; }')
]); ?>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'title') .
                $form->field($model, 'alias') .
                $form->field($model, 'author_id')->dropDownList($userArray, [
                    'prompt' => Yii::t('blogs', 'Выберите автора')
                ]) .
                $form->field($model, 'status_id')->dropDownList($statusArray, [
                    'prompt' => Yii::t('blogs', 'Выберите статус')
                ]) .
                $form->field($model, 'categoryIds')->listBox($categoryArray, ['multiple' => true, 'unselect' => '']);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'image_url')->widget(FileAPIAdvanced::className(), [
                'url' => $this->context->module->imageUrl(),
                'deleteUrl' => Url::toRoute('/blogs/default/delete-image'),
                'deleteTempUrl' => Url::toRoute('/blogs/default/deleteTempImage'),
                'settings' => [
                    'url' => Url::toRoute('uploadTempImage'),
                    'imageTransform' => [
                        'imageOriginal' => false,
                        'width' => $this->context->module->imageWidth,
                        'height' => $this->context->module->imageHeight,
                        'preview' => true
                    ]
                ]
             ]); ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'preview_url')->widget(FileAPIAdvanced::className(), [
                'url' => $this->context->module->previewUrl(),
                'deleteUrl' => Url::toRoute('/blogs/default/delete-preview'),
                'deleteTempUrl' => Url::toRoute('/blogs/default/deleteTempPreview'),
                'settings' => [
                    'url' => Url::toRoute('uploadTempPreview'),
                    'imageTransform' => [
                        'imageOriginal' => false,
                        'width' => $this->context->module->previewWidth,
                        'height' => $this->context->module->previewHeight,
                        'preview' => true
                    ]
                ]
             ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'content')->widget('common\extensions\tinymce\Tinymce', [
                    'admin' => true,
                    'settings' => [
                        'pagebreak_separator' => Yii::$app->params['moreTag']
                    ]
                ]) .
                Html::submitButton($model->isNewRecord ? Yii::t('blogs', 'Сохранить') : Yii::t('blogs', 'Обновить'), [
                    'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'
                ]); ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>