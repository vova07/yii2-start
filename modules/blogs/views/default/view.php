<?php
/**
 * @var yii\base\View $this
 * @var app\modules\blogs\models\Blog $model
 */

use yii\helpers\Html;
use yii\widgets\Menu;

use app\modules\comments\widgets\comments\Comments;

$this->title = $model['title'];
?>
<div class="row">
	<?php if (!Yii::$app->user->isGuest) { ?>
		<div class="span3">
			<?php echo Menu::widget(array(
				'options' => array('class' => 'nav nav-pills nav-stacked'),
				'items' => array(
					array(
						'label' => 'User menu',
						'itemOptions' => array('class' => 'nav-header')
					),
					array(
						'label' => 'Create new blog',
						'url' => array('blogs/default/create')
					),
					array(
						'label' => 'Edit blog',
						'url' => array(
							'blogs/default/edit',
							'id' => $model['id']
						),
						'visible' => (Yii::$app->user->checkAccess('editOwnBlog', array('blog' => $model)) || Yii::$app->user->checkAccess('editBlog'))
					),
					array(
						'label' => 'Delete blog',
						'url' => array(
							'blogs/default/delete',
							'id' => $model['id']
						),
						'visible' => (Yii::$app->user->checkAccess('deleteOwnBlog', array('blog' => $model)) || Yii::$app->user->checkAccess('deleteBlog'))
					)
				)
			)); ?>
		</div>
	<?php } ?>
	<div class="<?php echo Yii::$app->user->isGuest ? 'span12' : 'span9'; ?>">
		<div class="page-header">
			<h1><?php echo Html::encode($this->title); ?></h1>
		</div>
		<p><?php echo $model['content']; ?></p>
		<?php echo Comments::widget(array('model' => $model)); ?>
	</div>
</div>