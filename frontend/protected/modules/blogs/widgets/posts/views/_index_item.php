<?php
/**
 * Представление одного поста.
 * @var yii\base\View $this Представление
 * @var common\modules\blogs\models\Post $model Модель
 */

use yii\helpers\Html;
use common\helpers\TextHelper; ?>
<article class="post">
	<?php if ($model->preview) {
		echo Html::img($model->preview, [
			'title' => $model['title'],
			'alt' => $model['title']
		]);
	} ?>
	<h3><?= Html::a($model['title'], ['/blogs/default/view', 'id' => $model['id'], 'alias' => $model['alias']]) ?></h3>
	<?= TextHelper::snippet($model['content'], 110) ?>
	<?= Html::a('Подробнее&#133;', ['/blogs/default/view', 'id' => $model['id'], 'alias' => $model['alias']], ['class' => 'readmore']) ?>
</article>