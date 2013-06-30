<?php
/**
 * @var yii\base\View $this
 * @var app\modules\blogs\models\Blog $models
 * @var yii\data\Pagination $pages
 */

use yii\base\Formatter;
use yii\helpers\Html;
use yii\widgets\Menu;
use yii\widgets\LinkPager;

$this->title = 'Blogs';
?>
<div class="row">
	<?php if (!Yii::$app->user->isGuest) { ?>
		<div class="span3">
			<?php echo Menu::widget(array(
				'options' => array('class' => 'nav nav-pills nav-stacked'),
				'items' => array(
					array('label' => 'User menu', 'itemOptions' => array('class' => 'nav-header')),
					array('label' => 'Create new blog', 'url' => array('blogs/default/create'))
				)
			)); ?>
		</div>
	<?php } ?>
	<div class="<?php echo Yii::$app->user->isGuest ? 'span12' : 'span9'; ?>">
		<div class="page-header">
			<h1><?php echo Html::encode($this->title); ?></h1>
		</div>
		<?php foreach ($models as $model) { ?>
	    	<article>
	    		<h2><a href="<?php echo $this->context->createUrl('view', array('id' => $model['id'])); ?>"><?php echo $model['title']; ?></a></h2>
	    		<p><?php echo $model['content']; ?></p>
	    		<p>Posted on: <?php $Formatter = new Formatter(); echo $Formatter->asDate($model['create_time']); ?></p>
	    	</article>
		<?php } ?>
		<?php echo LinkPager::widget(array('pagination' => $pages)); ?>
	</div>
</div>