<?php
namespace frontend\modules\users;

use Yii;
use common\extensions\consoleRunner\ConsoleRunner;

/**
 * Frontend-модуль [[Users]]
 */
class Users extends \common\modules\users\Users
{
	/**
	 * @inheritdoc
	 */
	public $controllerNamespace = 'frontend\modules\users\controllers';

	/**
	 * Отправляем ключ активации учётной записи на указаный при регистарции e-mail.
	 * Вызывается только если $this->activeAfterRegistration = false.
	 * @param User $event
	 * @return boolean
	 */
	public function onSignup($event)
	{
		$model = $event->sender;
		$cr = new ConsoleRunner();
		return $cr->run('users/signup ' . $model['email'] . ' ' . $model['auth_key']);
	}

	/**
	 * Данная функция срабатывает в момент повторной отправки кода активации, новому пользователю.
	 * @param User $event
	 * @return boolean
	 */
	public function onResend($event)
	{
		$model = $event->sender;
		$cr = new ConsoleRunner();
		return $cr->run('users/resend ' . $model['email'] . ' ' . $model['auth_key']);
	}

	/**
	 * Данная функция срабатывает в момент запроса восстановления пароля.
	 * @param User $event
	 * @return boolean
	 */
	public function onRecoveryConfirm($event) {
		$model = $event->sender;
		$cr = new ConsoleRunner();
		return $cr->run('users/recovery-confirm ' . $model['email'] . ' ' . $model['auth_key']);
	}

	/**
	 * Данная функция срабатывает в момент подтверждения запроса на восстановление пароля.
	 * @param User $event
	 * @return boolean
	 */
	public function onRecoveryPassword($event) {
		$model = $event->sender;
		$cr = new ConsoleRunner();
		return $cr->run('users/recovery-password ' . $model['email'] . ' ' . $model['password']);
	}

	/**
	 * Данная функция срабатывает в момент смены почтового адреса.
	 * @param UserEmail $event
	 * @return boolean
	 */
	public function onEmailChange($event) {
		$model = $event->sender;
		$cr = new ConsoleRunner();
		return $cr->run('users/email ' . $model['email'] . ' ' . $model['token']);
	}
}