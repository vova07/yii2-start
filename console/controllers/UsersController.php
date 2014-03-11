<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

/**
 * Контроллер для фоновой работы с пользователями.
 * Кончольный контроллер модуля [[Users]]
 */
class UsersController extends Controller
{
	/**
	 * Отправляем ключ активации учётной записи на указаный при регистарции e-mail.
	 * @param string $email Электронный адрес на который будет отправлено письмо
	 * @param string $key Ключ активации
	 * @return boolean
	 */
	public function actionSignup($email, $key)
	{
		$subject = 'Активационный ключ - ' . Yii::$app->name;
		return $this->send($subject, $email, 'users/signup', ['email' => $email, 'key' => $key]);
	}

	/**
	 * Функция отправляет повторной письмо с ключем активации учётной записи пользователя.
	 * @param string $email электронный адрес на который будет отправлено письмо
	 * @return boolean
	 */
	public function actionResend($email, $key)
	{
		$subject = 'Активационный ключ - ' . Yii::$app->name;
		return $this->send($subject, $email, 'users/signup', ['email' => $email, 'key' => $key]);
	}

	/**
	 * Функция отправляет письмо с ключем восстановления пароля.
	 * @param string $email электронный адрес на который будет отправлено письмо
	 * @return boolean
	 */
	public function actionRecoveryConfirm($email, $key)
	{
		$subject = 'Подтверждение смены пароля - ' . Yii::$app->name;
		return $this->send($subject, $email, 'users/recovery-confirm', ['email' => $email, 'key' => $key]);
	}

	/**
	 * Функция отправляет письмо с новым паролем.
	 * @param string $email электронный адрес на который будет отправлено письмо
	 * @param string $password новый пароль
	 * @return boolean
	 */
	public function actionRecoveryPassword($email, $password)
	{
		$subject = 'Новый пароль - ' . Yii::$app->name;
		return $this->send($subject, $email, 'users/recovery-password', ['password' => $password]);
	}

	/**
	 * Функция отправляет письмо для подтверждения нового e-mail адреса.
	 * @param string $key случайны код
	 * @return boolean
	 */
	public function actionEmail($email, $key)
	{
		$subject = 'Подтверждение смены email адреса - ' . Yii::$app->name;
		return $this->send($subject, $email, 'users/email', ['email' => $email, 'key' => $key]);
	}

	/**
	 * Отправляем непосредственно письмо с учётом указанных параметров.
	 * @var string $subject Тема письма
	 * @var string $to Адрес получателя
	 * @var string|array|null $from Адрес отправителя
	 * @var string $composeView Имя шаблона письма
	 * @var array $composeParams Параметры шаблона письма
	 */
	protected function send($subject, $to, $composeView = null, $composeParams = [], $from = null)
	{
		$from = $from !== null ? $from : [Yii::$app->params['robotEmail'] => Yii::$app->name . ' - robot'];
		Yii::$app->mail
		         ->compose($composeView, $composeParams)
			     ->setFrom($from)
			     ->setTo($to)
			     ->setSubject($subject)
			     ->send();
	}
}