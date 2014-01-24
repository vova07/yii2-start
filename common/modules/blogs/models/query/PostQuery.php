<?php
namespace common\modules\blogs\models\query;

use yii\db\ActiveQuery;
use common\modules\blogs\models\Post;

/**
 * Class PostQuery
 * @package common\modules\blogs\models\query
 * Класс кастомных запросов модели [[Post]]
 */
class PostQuery extends ActiveQuery
{
	/**
	 * Выбираем только опубликованые посты.
	 * @param ActiveQuery $query
	 */
	public function published()
	{
		$this->andWhere(Post::tableName() . '.status_id = :status', [':status' => Post::STATUS_PUBLISHED]);
		return $this;
	}

	/**
	 * Выбираем только неопубликованые посты.
	 * @param ActiveQuery $query
	 */
	public function unpublished()
	{
		$this->andWhere(Post::tableName() . '.status_id = :status', [':status' => Post::STATUS_UNPUBLISHED]);
		return $this;
	}

	/**
	 * Выбираем только посты которые не прошли модерацию.
	 * @param ActiveQuery $query
	 */
	public function notapproved()
	{
		$this->andWhere(Post::tableName() . '.status_id = :status', [':status' => Post::STATUS_NOT_APPROVED]);
		return $this;
	}
}