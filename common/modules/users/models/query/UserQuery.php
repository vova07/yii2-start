<?php
namespace common\modules\users\models\query;

use yii\db\ActiveQuery;
use common\modules\users\models\User;

/**
 * Class PostQuery
 * @package common\modules\blogs\models\query
 * Класс кастомных запросов модели [[User]]
 */
class UserQuery extends ActiveQuery
{
	/**
	 * Выбираем только активных пользователей
	 * @param ActiveQuery $query
	 */
	public function active()
	{
		$this->andWhere('status_id = :status', [':status' => User::STATUS_ACTIVE]);
		return $this;
	}

	/**
	 * Выбираем только неактивных пользователей
	 * @param ActiveQuery $query
	 */
	public function inactive()
	{
		$this->andWhere('status_id = :status', [':status' => User::STATUS_INACTIVE]);
		return $this;
	}

	/**
	 * Выбираем только забаненных пользователей
	 * @param ActiveQuery $query
	 */
	public function banned()
	{
		$this->andWhere('status_id = :status', [':status' => User::STATUS_INACTIVE]);
		return $this;
	}

	/**
	 * Выбираем только простых пользователей
	 * @param ActiveQuery $query
	 */
	public function registered()
	{
		$this->andWhere('role_id = :role_user', [':role_user' => User::ROLE_USER]);
		return $this;
	}
}