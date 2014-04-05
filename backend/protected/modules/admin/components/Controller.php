<?php
namespace backend\modules\admin\components;

use yii\filters\AccessControl;
use common\modules\users\models\User;

/**
 * Основной контроллер backend-приложения.
 * От данного контроллера унаследуются все остальные контроллеры backend-приложения.
 */
class Controller extends \yii\web\Controller
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
				    // Разрешаем доступ нужным пользователям.
					[
						'allow' => true,
						'roles' => [User::ROLE_ADMIN, User::ROLE_SUPERADMIN]
					]
				]
			]
		];
	}
}