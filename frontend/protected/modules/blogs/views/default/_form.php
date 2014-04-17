<?php
/**
 * Представление формы статей.
 * @var yii\base\View $this
 * @var common\modules\blogs\models\Post $model
 * @var string|array $action Action формы
 * @var string $method Тип запроса
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;
use common\extensions\tinymce\Tinymce;
use common\extensions\fileapi\FileAPIAdvanced;

$formOptions = [
    'enableClientValidation' => false,
    'enableAjaxValidation' => true,
    'validateOnChange' => false,
    'beforeValidate' => new JsExpression('function ($form, attribute, messages) { if (attribute.name === "content") { tinymce.triggerSave(); } return true; }')
];
if (isset($method) && $method) {
    $formOptions['method'] = $method;
}
if (isset($action) && $action) {
    $formOptions['validationUrl'] = $action;
}
?>
<?php $form = ActiveForm::begin($formOptions); ?>
    <div class="row">
        <div class="col-lg-12">
            <?= $form->field($model, 'title') .
                $form->field($model, 'categoryIds')->listBox($categoryArray, ['multiple' => true, 'unselect' => '']) ?>
        </div>
        <div class="col-lg-6">
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
            ]) ?>
        </div>
        <div class="col-lg-6">
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
            ]) ?>
        </div>
        <div class="col-lg-12">
            <?= $form->field($model, 'content')->widget(Tinymce::className(), [
                    'settings' => [
                        'pagebreak_separator' => Yii::$app->params['moreTag']
                    ]
                ]) .
                Html::submitInput($model->isNewRecord ? Yii::t('blogs', 'Сохранить') : Yii::t('blogs', 'Обновить'), [
                    'class' => 'btn btn-primary pull-right'
                ]); ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>