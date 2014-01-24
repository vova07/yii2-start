<?php
/**
 * Представление цикла комментариев.
 * @var yii\base\View $this Представление
 * @var common\modules\comments\models\Comment $models Массив моделей
 * @var integer $level Уровень вложености комментария
 * @var integer $maxLevel максимальный уровень вложености комментариев
 */

if ($models) {
	foreach ($models as $model) {
		echo $this->render('_index_item', [
			'model' => $model,
			'level' => $level,
			'maxLevel' => $maxLevel
		]);
	}
}