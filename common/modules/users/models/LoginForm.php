<?php 
namespace common\modules\users\models;

use Yii;
use yii\base\Model;

/**
 * Class LoginForm
 * @package common\modules\users\models
 * Модель формы авторизации.
 *
 * @property string $username Логин
 * @property string $password Пароль
 * @property boolean $rememberMe Запомнить меня
 */
class LoginForm extends Model
{
	/**
	 * Переменная используется для сбора пользовательской информации, но не сохраняются в базу данных.
	 * @var string $username Логин
	 */
	public $username;

	/**
	 * Переменная используется для сбора пользовательской информации, но не сохраняются в базу данных.
	 * @var string $password Пароль
	 */
	public $password;

	/**
	 * Переменная используется для сбора пользовательской информации, но не сохраняются в базу данных.
	 * @var boolean rememberMe Запомнить меня
	 */
	public $rememberMe = true;

	/**
	 * @var boolean|ActiveRecord Экземпляр пользователя
	 */
	protected $_user = false;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			// Логин и пароль обязательны для заполнения.
			[['username', 'password'], 'required'],

			// Пароль валидируется функцией validatePassword().
			['password', 'validatePassword'],

			// [[rememberMe]] должен быть булево значение.
			['rememberMe', 'boolean']
		];
	}

	/**
	 * @inheritdoc
	 */
	public function scenarios()
	{
		$scenarios = parent::scenarios();
		$scenarios['admin'] = ['username', 'password', 'rememberMe'];
		return $scenarios;
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'username' => Yii::t('users', 'Логин'),
			'password' => Yii::t('users', 'Пароль'),
			'rememberMe' => Yii::t('users', 'Запомнить меня')
		];
	}

	/**
	 * Валидация пароля.
	 * В правилах модели метод назначен как валидатор атрибута модели.
	 * @return boolean
	 */
	public function validatePassword()
	{
		$user = $this->getUser();
		if (!$user || !$user->validatePassword($this->password)) {
			$this->addError('password', Yii::t('users', 'Неверный логин или пароль'));
		}
	}

	/**
	 * Выполняем авторизацию пользователя на базе переданного логина и пароля.
	 * @return boolean Статус авторизации пользователя.
	 */
	public function login()
	{
		if ($this->validate()) {
			return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
		} else {
			return false;
		}
	}

	/**
	 * Выбор пользователя по [[username]]
	 * @return User|null
	 */
	protected function getUser()
	{
		if ($this->_user === false) {
			if ($this->scenario === 'admin') {
				$this->_user = User::findActiveAdminByUsername($this->username);
			} else {
				$this->_user = User::findActiveByUsername($this->username);
			}
		}
		return $this->_user;
	}
}
