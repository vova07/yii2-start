<?php
/**
 * @var yii\base\View $this
 * @var app\modules\users\models\User $model
 */

use yii\helpers\Html;

$this->title = 'User activation';
?>
<div class="page-header">
	<h1><?php echo Html::encode($this->title); ?></h1>
</div>

<?php if (Yii::$app->session->hasFlash('success')): ?>
	<div class="alert alert-success">
		Thank You! Your account has been activated. You may now log in and begin using it.
	</div>
<?php return; endif; ?>

<div class="alert alert-error">
	Invalid activation url!
</div>