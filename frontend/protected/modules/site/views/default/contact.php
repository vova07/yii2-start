<?php
/**
 * Представление страницы "Обратной связи".
 * @var yii\base\View $this
 * @var yii\widgets\ActiveForm $form
 * @var frontend\modules\site\models\ContactForm $model
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;
use frontend\modules\blogs\widgets\posts\Posts;

$this->title = Yii::t('yii', 'Обратная связь');
$this->params['breadcrumbs'][] = $this->title; ?>
<div class="row">
	<div class="col-sm-6">
	    <h1><?php echo Html::encode($this->title); ?></h1>
        <p>Если у вас есть вопросы или предложения, вы можете написать нам заполнив форму ниже. Спасибо!</p>
		<?php $form = ActiveForm::begin(); ?>
			<?= $form->field($model, 'name') ?>
			<?= $form->field($model, 'email') ?>
			<?= $form->field($model, 'subject') ?>
			<?= $form->field($model, 'body')->textArea(['rows' => 6]) ?>
			<?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
				'captchaAction' => '/site/default/captcha',
				'options' => ['class' => 'form-control'],
				'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-9">{input}</div></div>',
			]) ?>
			<?= Html::submitButton(Yii::t('app', 'Отправить'), ['class' => 'btn btn-primary']) ?>
		<?php ActiveForm::end(); ?>
	</div>
	<div class="col-md-offset-2 col-sm-4">
	    <?= Posts::widget() ?>
	</div>
</div>