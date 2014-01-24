<?php
namespace common\modules\blogs\modules\categories\models\query;

use yii\db\ActiveQuery;
use common\modules\blogs\modules\categories\models\Category;

/**
 * Class CategoryQuery
 * @package common\modules\blogs\models\query
 * Класс кастомных запросов модели [[Category]]
 */
class CategoryQuery extends ActiveQuery
{
	/**
	 * Выбираем только опубликованные записи.
	 * @param ActiveQuery $query
	 */
	public function published()
	{
		$this->andWhere('status_id = :status', [':status' => Category::STATUS_PUBLISHED]);
		return $this;
	}

	/**
	 * Выбираем только неопубликованные записи.
	 * @param ActiveQuery $query
	 */
	public function unpublished()
	{
		$this->andWhere('status_id = :status', [':status' => Category::STATUS_UNPUBLISHED]);
		return $this;
	}
}