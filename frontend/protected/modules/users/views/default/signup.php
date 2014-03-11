<?php
/**
 * Страница регистрации нового пользователя.
 * @var yii\base\View $this
 * @var yii\widgets\ActiveForm $form
 * @var common\modules\users\models\User $model
 */
 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\extensions\fileapi\FileAPIAdvanced;

$this->title = Yii::t('users', 'Регистрация');
$this->params['breadcrumbs'][] = $this->title;
$this->params['page-id'] = 'signup';
?>
<h1><?php echo Html::encode($this->title); ?></h1>

<?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-5">
	        <?= $form->field($model, 'name') .
	            $form->field($model, 'username') .
	            $form->field($model, 'password')->passwordInput() ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($model, 'avatar_url')->widget(FileAPIAdvanced::className(), [
	    	    'url' => $this->context->module->avatarUrl(),
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
	        ]) ?>
        </div>
        <div class="col-sm-5">
            <?= $form->field($model, 'surname') .
                $form->field($model, 'email') .
                $form->field($model, 'repassword')->passwordInput() ?>
        </div>
    </div>
    <?= Html::submitButton(Yii::t('users', 'Зарегистрироватся'), ['class' => 'btn btn-success btn-large pull-right']).
        Html::a(Yii::t('users', 'Повторная отправка активационного ключа'), ['resend']);
ActiveForm::end(); ?>