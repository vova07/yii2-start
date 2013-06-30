<?php
/**
 * @var yii\base\View $this
 * @var yii\widgets\ActiveForm $form
 * @var app\models\LoginForm $model
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-header">
	<h1><?php echo Html::encode($this->title); ?></h1>
</div>

<p>Please fill out the following fields to login:</p>

<?php $form = ActiveForm::begin(array('options' => array('class' => 'form-horizontal'))); ?>
	<?php echo $form->field($model, 'username')->textInput(); ?>
	<?php echo $form->field($model, 'password')->passwordInput(); ?>
	<?php echo $form->field($model, 'rememberMe')->checkbox(); ?>
	<div class="form-actions">
		<?php echo Html::submitButton('Login', array('class' => 'btn btn-primary')) . '&nbsp;&nbsp;&nbsp;&nbsp;'; ?>
		<?php echo Html::a('Sign up', array('users/default/signup')); ?>
	</div>
<?php ActiveForm::end(); ?>
