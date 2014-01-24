<?php
namespace common\modules\users;

use Yii;
use yii\base\Module;

/**
 * Общий модуль [[Users]]
 * Осуществляет всю работу с пользователями.
 */
class Users extends Module
{
	/**
	 * @var integer Количество записей на главной странице модуля.
	 */
	public $recordsPerPage = 18;

	/**
	 * @var boolean Если данное значение false, пользователи при регистрации должны будут подтверждать свои электронные адреса
	 */
	public $activeAfterRegistration = false;

	/**
	 * @var string Ссылка на которую будет перенаправляен пользователь после деавторизации.
	 */
	public $afterLogoutRedirectUrl = ['/site/default/index'];

	/**
	 * @var array Доступные расширения загружаемых аватар-ов
	 */
	public $avatarAllowedExtensions = ['jpg', 'png', 'gif'];

	/**
	 * @var integer Ширина аватар-а пользователя
	 */
	public $avatarWidth = 100;

	/**
	 * @var integer Высота аватар-а пользователя
	 */
	public $avatarHeight = 100;

	/**
	 * @var integer Максимальная ширина аватар-а пользователя
	 */
	public $avatarMaxWidth = 1000;

	/**
	 * @var integer Максимальная высота аватар-а пользователя
	 */
	public $avatarMaxHeight = 1000;

	/**
	 * @var integer Максимальный размер загружаемого аватар-а
	 */
	public $avatarMaxSize = 3145728; // 3*1024*1024 = 3MB

	/**
	 * @param string $image Имя изображения
	 * @return string Путь к папке где хранятся аватар-ы или путь к конкретному аватар-у
	 */
	public function avatarPath($image = null)
	{
		$path = '@root/statics/web/uploads/avatars/';
		if ($image !== null) {
			$path .= '/' . $image;
		}
		return Yii::getAlias($path);
	}

	/**
	 * @param string $image Имя изображения
	 * @return string Путь к временной папке где хранятся аватар-ы или путь к конкретному аватар-у
	 */
	public function avatarTempPath($image = null)
	{
		$path = '@root/statics/tmp/avatars/';
		if ($image !== null) {
			$path .= '/' . $image;
		}
		return Yii::getAlias($path);
	}

	/**
	 * @var string URL к папке где хранятся аватар-ы с публичным доступом.
	 */
	public function avatarUrl($image = null)
	{
		$url = '/uploads/avatars/';
		if ($image !== null) {
			$url .= $image;
		}
		if (isset(Yii::$app->params['staticsDomain'])) {
			$url = Yii::$app->params['staticsDomain'] . $url;
		}
		return $url;
	}

	/**
	 * @return string URL дефолтной аватар картинки.
	 */
	public function avatarDefaultUrl() {
		$url = '/defaults/avatar/default-avatar.png';
		if (isset(Yii::$app->params['staticsDomain'])) {
			$url = Yii::$app->params['staticsDomain'] . $url;
		}
		return $url;
	}
}