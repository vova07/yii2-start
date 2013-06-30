<?php
/**
 * @var yii\base\View $this
 * @var app\modules\users\models\User $model
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Edit user';
?>
<div class="page-header">
	<h1><?php echo Html::encode($this->title); ?></h1>
</div>

<?php if (Yii::$app->session->hasFlash('success')): ?>
	<div class="alert alert-success">
		User has been successfully updated!
	</div>
<?php return; endif; ?>

<?php echo $this->render('_form', array('model' => $model)); ?>