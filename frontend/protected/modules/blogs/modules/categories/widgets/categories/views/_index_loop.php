<?php
/**
 * Представление цикла комментариев.
 * @var yii\base\View $this
 * @var common\modules\comments\models\Comment $models
 */

if ($models) { ?>
    <div class="list-group">
		<?php foreach ($models as $model) {
			echo $this->render('_index_item', [
				'model' => $model,
				'level' => $level,
				'maxLevel' => $maxLevel
			]);
		} ?>
	</div>
<?php }