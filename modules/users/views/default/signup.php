<?php
/**
 * @var yii\base\View $this
 * @var yii\widgets\ActiveForm $form
 * @var app\models\LoginForm $model
 */
 
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Registration';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?php echo Html::encode($this->title); ?></h1>

<?php if (Yii::$app->session->hasFlash('success')): ?>
	<div class="alert alert-success">
		User was succeseful created!
	</div>
<?php return; endif; ?>

<p>Please fill out the following fields to register:</p>

<?php echo $this->render('_form', array('model' => $model)) ?>
