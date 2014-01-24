<?php
namespace backend\modules\users\modules\rbac\controllers;

use Yii;
use yii\web\AccessControl;
use backend\modules\admin\components\Controller;
use common\modules\users\models\User;

/**
 * Основной контроллер backend-модуля [[RBAC]]
 */
class DefaultController extends Controller
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
				    // Разрешаем доступ нужным пользователям
					[
						'allow' => true,
						'actions' => ['create'],
						'roles' => ['@', User::ROLE_ADMIN, User::ROLE_SUPERADMIN]
					],
					// Запрещаем доступ всем остальным пользователям
					[
						'allow' => false
					]
				]
			]
		];
	}

	/**
	 * Создаём иерархию авторизации
	 */
	public function actionCreate()
	{
		$auth = Yii::$app->getAuthManager();

		// Операции
		$auth->createOperation('createPost', 'Cоздание записи');
		$auth->createOperation('viewPost', 'Просмотр записи');
		$auth->createOperation('updatePost', 'Редактирование записи');
		$auth->createOperation('deletePost', 'Удаление записи');

		$auth->createOperation('createComment', 'Cоздание комментария');
		$auth->createOperation('viewComment', 'Просмотр комментария');
		$auth->createOperation('updateComment', 'Редактирование комментария');
		$auth->createOperation('deleteComment', 'Удаление комментария');

		$auth->createOperation('updateUser', 'Редактирование пользователя');
		$auth->createOperation('deleteUser', 'Удаление пользователя');

		// Действия
		$bizRule = 'return Yii::$app->user->id === $params["model"]["author_id"];';
		$task = $auth->createTask('updateOwnPost', 'Редактирование своей записи', $bizRule);
		$task = $auth->createTask('deleteOwnPost', 'Удаление своей записи', $bizRule);

		$task = $auth->createTask('updateOwnComment', 'Редактирование своего комментария', $bizRule);
		$task = $auth->createTask('deleteOwnComment', 'Удаление своего комментария', $bizRule);

		// Роли
		$bizRule = 'return Yii::$app->user->isGuest;';
		$role = $auth->createRole('guest', 'Гость', $bizRule);
		$role->addChild('viewPost');
		$role->addChild('viewComment');

		$bizRule = 'return !Yii::$app->user->isGuest;';
		$role = $auth->createRole(User::ROLE_USER, 'Пользователь', $bizRule);
		$role->addChild('guest');
		$role->addChild('createPost');
		$role->addChild('updateOwnPost');
		$role->addChild('deleteOwnPost');
		$role->addChild('createComment');
		$role->addChild('updateOwnComment');
		$role->addChild('deleteOwnComment');

		$role = $auth->createRole(User::ROLE_MODERATOR, 'Модератор');
		$role->addChild(User::ROLE_USER);
		$role->addChild('updatePost');
		$role->addChild('deletePost');
		$role->addChild('updateComment');
		$role->addChild('deleteComment');

		$role = $auth->createRole(User::ROLE_ADMIN, 'Администратор');
		$role->addChild(User::ROLE_MODERATOR);

		$role = $auth->createRole(User::ROLE_SUPERADMIN, 'Супер-администратор');
		$role->addChild(User::ROLE_ADMIN);

		$auth->save();

		$this->redirect(['index']);
	}
}