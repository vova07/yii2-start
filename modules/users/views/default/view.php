<?php
/**
 * @var yii\base\View $this
 * @var app\modules\users\models\User $model
 */

use yii\base\Formatter;
use yii\helpers\Html;
use yii\widgets\LinkPager;

use app\modules\users\models\User;

$this->title = 'User profile';
$Formatter = new Formatter();
?>
<div class="page-header">
	<h1><?php echo Html::encode($this->title); ?></h1>
</div>
<p>Id: <?php echo $model['id']; ?></p>
<p>Username: <?php echo $model['username']; ?></p>
<p>Role: <?php echo $model['role'] == User::ROLE_ADMIN ? 'Admin' : 'User'; ?></p>
<p>Status: <?php if ($model['status'] == User::STATUS_ACTIVE) { echo 'Active'; } elseif($model['status'] == User::STATUS_INACTIVE) { echo 'Inactive'; } else { echo 'Delete'; } ?></p>
<p>Created: <?php echo Html::encode($Formatter->asDate($model['create_time'], 'm/d/Y')); ?></p>
<p>Updated: <?php echo Html::encode($Formatter->asDate($model['update_time'], 'm/d/Y')); ?></p>