<?php

/**
 * Contacts page view.
 *
 * @var \yii\web\View $this View
 * @var \yii\widgets\ActiveForm $form Form
 * @var \frontend\modules\site\models\ContactForm $model Model
 */

use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('site', 'CONTACTS_TITLE');
$this->params['breadcrumbs'] = [
    $this->title
]; ?>
<div class="row">
    <div class="col-sm-7">
        <p><?= Yii::t('site', 'CONTACTS_FORM_INFO') ?></p>
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'subject') ?>
        <?= $form->field($model, 'body')->textArea(['rows' => 6]) ?>
        <?=
        $form->field($model, 'verifyCode')->widget(
            Captcha::className(),
            [
                'captchaAction' => '/site/default/captcha',
                'options' => ['class' => 'form-control'],
                'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-9">{input}</div></div>',
            ]
        ) ?>
        <?= Html::submitButton(Yii::t('site', 'CONTACTS_SUBMIT_BTN'), ['class' => 'btn btn-primary btn-lg']) ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>