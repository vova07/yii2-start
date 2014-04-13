<?php
/**
 * Представление одного комментария в цикле всех записей.
 * @var yii\base\View $this Представление
 * @var integer $level Уровень вложености комментария
 * @var integer $maxLevel максимальный уровень вложености комментариев
 */

use yii\helpers\Html;

$class = 'row comment lvl-' . $level;

if ($model->isDeleted) {
	$class .= ' deleted';
}
if ($model->isBanned) {
	$class .= ' banned';
} ?>

<div class="<?= $class ?>" id="comment-<?= $model['id'] ?>" data-parent="<?= $model['parent_id'] ?>">
	<div class="col-sm-2">
	    <?= Html::img($model->author->avatar) ?>
	</div>
	<div class="col-sm-10">
		<p class="author">
			<?= $model->author->getFio(true) ?>
		</p>
		<?php if ($model->isPublished && Yii::$app->user->can('createComment')) { ?>
	    	<p class="manage">
	    	    <span>&nbsp;&#8212;&nbsp;</span>
	    	    <a href="#" class="reply" data-id="<?= $model['id'] ?>" data-level="<?= $level ?>">
	    	        <?= Yii::t('comments', 'Ответить'); ?>
	    	    </a>
	    	    <?php if (Yii::$app->user->can('updateOwnComment', ['model' => $model])) { ?>
	    	    	<span>&nbsp;|&nbsp;</span>
	    	    	<a href="#" class="update" data-id="<?= $model['id']; ?>" data-href="<?= Yii::$app->getUrlManager()->createUrl('/comments/' . $model['id']) ?>">
	    	    	    <?= Yii::t('comments', 'Редактировать') ?>
	    	    	</a>
	    	    <?php } ?>
	    	    <?php if (Yii::$app->user->can('deleteOwnComment', ['model' => $model])) { ?>
	    	    	<span>&nbsp;|&nbsp;</span>
	    	    	<a href="#" class="delete" data-id="<?= $model['id']; ?>" data-href="<?= Yii::$app->getUrlManager()->createUrl('/comments/' . $model['id']) ?>" data-confirm="<?= Yii::t('comments', 'Вы уверены что хотите удалить комментарий?') ?>">
	    	    	    <?= Yii::t('comments', 'Удалить') ?>
	    	    	</a>
	    	    <?php } ?>
	    	</p>
	    <?php } ?>
	    <div class="date">
		    <?php if ($model['parent_id']) { ?>
		        <?= Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', '#comment-' . $model['parent_id'], ['class' => 'parent-link']) ?>
		    <?php } ?>
		    <time pubdate datetime="<?= $model->createTime ?>"><?= $model->createTime ?></time>
	    </div>
	    <div class="content"><?= $model['content'] ?></div>
	</div>
</div>

<?php if ($model->children) {
	if ($level < $maxLevel) {
		$level++;
	}
	echo $this->render('_index_loop', [
		'models' => $model->children,
		'level' => $level,
		'maxLevel' => $maxLevel
	]);
}