<?php
namespace app\modules\users;

use Yii;
use yii\base\Module;

class Users extends Module
{
	/**
	 * If is false, after user registration wi'll be send a confirmation email.
	 */
	public $activeAfterRegistration = false;

	/**
	 * @var integer number of records per page
	 */
	public $recordsPerPage = 10;

	/**
	 * This method is called after new user inserting. This is an exemple of [[Event]] $hendler
	 * @param ActiveRecord app\modules\users\models\User $event
	 * @return boolean or mail() error
	 */
	public function onNewUser($event)
	{
		$model = $event->sender;

		$url = Yii::$app->urlManager->createAbsoluteUrl('users/default/activation', array('username' => $model['username'], 'key' => $model['activkey']));
		$message = 'Thank you for registering. Your activation <a href="' . $url . '">url</a>.';

		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

		return mail($model['email'], 'Email confirmation', $message, $headers);
	}
}