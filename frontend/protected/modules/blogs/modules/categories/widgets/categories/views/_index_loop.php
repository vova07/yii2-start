<?php
/**
 * Представление цикла категорий.
 * @var yii\base\View $this Представление
 * @var common\modules\blogs\modules\categories\models\Category $models Масив моделей
 */

if ($models) { ?>
    <div class="list-group">
		<?php foreach ($models as $model) {
			echo $this->render('_index_item', [
				'model' => $model
			]);
		} ?>
	</div>
<?php }