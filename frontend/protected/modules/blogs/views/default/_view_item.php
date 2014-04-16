<?php
/**
 * Представление одной статьи.
 * @var yii\base\View $this
 */

$user = Yii::$app->user;
$author = $model->author;
?>
<div class="col-lg-2">
	<img src="<?php echo $model->author->getAvatar('medium'); ?>" alt="<?php echo $model->author->fio; ?>" class="avatar" />
</div>
<div class="col-lg-10">
	<h1><?php echo $model['title']; ?></h1>
	<span class="author"><?php echo $model->author->fio; ?></span>
	<time pubdate datetime="<?php echo $model->createTime; ?>"><?php echo $model->createTime; ?></time>
	<div class="content">
		<?php echo $model['content']; ?>
	</div>

	<?php if (Yii::$app->user->can('updateOwnPost', ['model' => $model])) : ?>
		<p class="manage">
		    <a href="#" class="update"><?php echo Yii::$app->getModule('site')->t('MOD_SITE_MANAGE_UPDATE'); ?></a>
		    <?php if (Yii::$app->user->can('deleteOwnPost', array('model' => $model)) || Yii::$app->user->checkAccess('deletePost')) { ?>
		        <a href="<?php echo $this->context->module->getUrlView($model['id']); ?>" class="delete"><?php echo Yii::$app->getModule('site')->t('MOD_SITE_MANAGE_DELETE'); ?></a>
			<?php } ?>
		</p>
	<?php endif; ?>
</div>