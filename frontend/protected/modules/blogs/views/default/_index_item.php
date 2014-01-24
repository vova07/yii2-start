<?php
/**
 * Представление одной статьи в цикле вывода всех записей.
 * @var yii\base\View $this
 */

use yii\helpers\Html;
?>
<div class="col-xs-12">
	<h2><?= Html::a($model['title'], ['view', 'id' => $model['id'], 'alias' => $model['alias']]) ?></h2>
	<ul class="info">
		<li><span class="glyphicon glyphicon-user"></span> <?= $model->author->fio ?></li>
		<li><span class="glyphicon glyphicon-eye-open"></span> <?= $model['views'] ?></li>
		<li class="last"><span  class="glyphicon glyphicon-calendar"></span> <time pubdate datetime="<?= $model->createTime ?>"><?= $model->createTime ?></time></li>
	</ul>
	<?php if ($model->image) {
		echo Html::img($model->image, [
			'title' => $model['title'],
			'alt' => $model['title'],
			'class' => 'image'
		]);
	} ?>
	<?php if ($model['snippet']) {
		echo $model['snippet'];
	} ?>
	<?= Html::a(Yii::t('blogs', 'Подробнее&hellip;'), ['view', 'id' => $model['id'], 'alias' => $model['alias']], ['class' => 'btn btn-default pull-right']) ?>
</div>