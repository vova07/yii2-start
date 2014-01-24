<?php
namespace common\modules\comments\models\query;

use yii\db\ActiveQuery;
use common\modules\comments\models\Comment;

/**
 * Class PostQuery
 * @package common\modules\blogs\models\query
 * Класс кастомных запросов модели [[Comment]]
 */
class CommentQuery extends ActiveQuery
{
	/**
	 * Выбираем только опубликованые посты.
	 * @param ActiveQuery $query
	 */
	public function published()
	{
		$this->andWhere(Comment::tableName() . '.status_id = :status', [':status' => Comment::STATUS_PUBLISHED]);
		return $this;
	}
}