<?php
/**
 * @var yii\base\View $this
 * @var app\modules\users\models\User $models
 * @var yii\data\Pagination $pages
 */

use yii\base\Formatter;
use yii\helpers\Html;
use yii\widgets\LinkPager;

use app\modules\users\models\User;

$this->title = 'Users';
$Formatter = new Formatter();
?>
<div class="page-header">
	<h1><?php echo Html::encode($this->title); ?></h1>
</div>

<table class="table table-striped table-hover">
	<tr>
		<td>#</td>
		<td>Username</td>
		<td>Role</td>
		<td>Status</td>
		<td>Created</td>
		<td>Updated</td>
		<td>Edit</td>
	</tr>
	<?php foreach ($models as $model): ?>
	<tr>
		<td><?php echo Html::encode($model['id']); ?></td>
		<td><?php echo Html::a(Html::encode($model['username']), array('users/default/view', 'username' => $model['username'])); ?></td>
		<td><?php echo $model['role'] == User::ROLE_ADMIN ? 'Admin' : 'User'; ?></td>
		<td><?php if ($model['status'] == User::STATUS_ACTIVE) { echo 'Active'; } elseif($model['status'] == User::STATUS_INACTIVE) { echo 'Inactive'; } else { echo 'Delete'; } ?></td>
		<td><?php echo Html::encode($Formatter->asDate($model['create_time'], 'm/d/Y')); ?></td>
		<td><?php echo Html::encode($Formatter->asDate($model['update_time'], 'm/d/Y')); ?></td>
		<td>
			<?php if (Yii::$app->user->checkAccess('editOwnProfile', array('user' => $model)) || Yii::$app->user->checkAccess('editProfile')) {
				echo Html::a(NULL, array('users/default/edit', 'username' => $model['username']), array('class'=>'icon icon-edit'));
			}
			if (Yii::$app->user->checkAccess('deleteOwnProfile', array('user' => $model)) || Yii::$app->user->checkAccess('deleteProfile')) {
				echo Html::a(NULL, array('users/default/delete', 'username' => $model['username']), array('class'=>'icon icon-trash'));
			} ?>
		</td>
	</tr>
	<?php endforeach; ?>
</table>
<?php echo LinkPager::widget(array('pagination' => $pages)); ?>