<?php
/**
 * Представление цикла последних постов.
 * @var yii\base\View $this Представление
 * @var common\modules\blogs\models\Post $models Массив моделей
 */

if ($models) {
	foreach ($models as $model) {
		echo $this->render('_index_item', [
			'model' => $model,
		]);
	}
}