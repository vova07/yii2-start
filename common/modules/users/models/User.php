<?php
namespace common\modules\users\models;

use Yii;
use yii\base\ModelEvent;
use yii\db\ActiveRecord;
use yii\helpers\Security;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;
use yii\behaviors\TimestampBehavior;
use common\extensions\fileapi\behaviors\UploadBehavior;
use common\modules\blogs\models\Post;
use common\modules\comments\models\Comment;
use common\modules\users\models\query\UserQuery;

/**
 * Class User
 * @package common\modules\users\models
 * Модель пользователя.
 *
 * @property integer $id ID
 * @property string $username Логин
 * @property string $email E-mail
 * @property string $password_hash Зашифрованый пароль
 * @property string $auth_key Ключ активации учётной записи
 * @property string $name Имя
 * @property string $surname Фамилия
 * @property string $avatar_url Ссылка на аватар
 * @property integer $role_id Роль
 * @property integer $status_id Статус пользователя (активен, не активен, заблокирован)
 * @property integer $create_time Время создания
 * @property integer $update_time Время последнего обновления
 *
 * @property string $password Пароль в чистом виде
 * @property string $repassword Повторный пароль
 * @property string $oldpassword Старый пароль
 */
class User extends ActiveRecord implements IdentityInterface
{
	/**
	 * Статусы записей модели.
	 * - Неактивный
	 * - Активный
	 * - Забанненый
	 * - Удаленный
	 */
	const STATUS_INACTIVE = 0;
	const STATUS_ACTIVE = 1;
	const STATUS_BANNED = 2;
	const STATUS_DELETED = 3;

	/**
	 * Роли пользователей.
	 */
	const ROLE_USER = 0;
	const ROLE_ADMIN = 1;
	const ROLE_SUPERADMIN = 2;
	const ROLE_MODERATOR = 3;

	/**
	 * События модели.
	 */
	const EVENT_AFTER_VALIDATE_SUCCESS = 'afterValidateSuccess';

	/**
	 * Ключи кэша которые использует модель.
	 */
	const CACHE_USERS_LIST_DATA = 'usersListData';

	/**
	 * Переменная используется для сбора пользовательской информации, но не сохраняется в базу.
	 * @var string $password Пароль
	 */
	public $password;

	/**
	 * Переменная используется для сбора пользовательской информации, но не сохраняется в базу.
	 * @var string $repassword Повторный пароль
	 */
	public $repassword;

	/**
	 * Переменная используется для сбора пользовательской информации, но не сохраняется в базу.
	 * @var string $oldpassword Старый пароль
	 */
	public $oldpassword;

	/**
	 * Вспомогательная приватная переменная.
	 * @var string $_fio ФИО
	 */
	protected $_fio;

	/**
	 * Вспомогательная приватная переменная.
	 * @var string $_avatar Полный путь к аватар-у пользователя
	 */
	protected $_avatar;

	/**
	 * @var string Читабельная роль пользователя.
	 */
	protected $_role;

	/**
	 * @var string Читабельный статус пользователя.
	 */
	protected $_status;

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
		    'timestampBehavior' => [
				'class' => TimestampBehavior::className(),
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => ['create_time', 'update_time'],
					ActiveRecord::EVENT_BEFORE_UPDATE => 'update_time',
				]
			],
			'uploadBehavior' => [
				'class' => UploadBehavior::className(),
				'attributes' => ['avatar_url'],
				'deleteScenarios' => [
				    'avatar_url' => 'delete-avatar',
				],
				'scenarios' => ['signup', 'update', 'admin-update', 'admin-create'],
				'path' => Yii::$app->getModule('users')->avatarPath(),
				'tempPath' => Yii::$app->getModule('users')->avatarTempPath()
			]
		];
	}

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%users}}';
	}

	/**
	 * @inheritdoc
	 */
	public static function find()
    {
        return new UserQuery(get_called_class());
    }

    /**
	 * @inheritdoc
	 */
	public static function findIdentityByAccessToken($token)
	{
		throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
	}

	/**
	 * Выбор пользователя по [[id]]
	 * @param integer $id
	 */
	public static function findIdentity($id)
	{
		return static::findOne($id);
	}

	/**
	 * Выбор пользователя по [[username]]
	 * @param string $username
	 */
	public static function findByUsername($username)
	{
		return static::find()->where('username = :username', [':username' => $username])->one();
	}

	/**
	 * Выбор активного пользователя по [[username]]
	 * @param string $username
	 */
	public static function findActiveByUsername($username)
	{
		return static::find()->where('username = :username', [':username' => $username])->active()->one();
	}

	/**
	 * Выборка неактивного пользователя по [[username]]
	 * @param string $username
	 */
	public static function findInactiveByUsername($username)
	{
		return static::find()->where('username = :username', [':username' => $username])->inactive()->one();
	}

	/**
	 * Выборка админа по [[username]]
	 * @param string $username
	 */
	public static function findActiveAdminByUsername($username)
	{
		return static::find()->where(['and', 'username = :username', ['or', 'role_id = ' . self::ROLE_ADMIN,  'role_id = ' . self::ROLE_SUPERADMIN]], [':username' => $username])->active()->one();
	}

	/**
	 * @return integer ID пользователя.
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return string Ключ авторизации пользователя.
	 */
	public function getAuthKey()
	{
		return $this->auth_key;
	}

	/**
	 * @return string Полное имя пользователя.
	 */
	public function getFio($username = false)
	{
		if ($this->_fio === null) {
			$this->_fio = $this->name . ' ' . $this->surname;
			if ($username !== false) {
				$this->_fio .= ' [' . $this->username . ']';
			}
		}
		return $this->_fio;
	}

	/**
	 * @return string|null URL текущего аватар-а пользователя.
	 */
	public function getAvatar()
	{
		if ($this->_avatar === null) {
			$this->_avatar = $this->avatar_url ? Yii::$app->getModule('users')->avatarUrl($this->avatar_url) : Yii::$app->getModule('users')->avatarDefaultUrl();
		}
		return $this->_avatar;
	}

	/**
	 * @return string Читабельная роли пользователя.
	 */
	public function getRole()
	{
		if ($this->_role === null) {
			$roles = self::getRoleArray();
			$this->_role = $roles[$this->role_id];
		}
		return $this->_role;
	}

	/**
	 * @return array Массив доступных ролей пользователя.
	 */
	public static function getRoleArray()
	{
		return [
		    self::ROLE_USER => Yii::t('users', 'Обычный пользователь'),
		    self::ROLE_MODERATOR => Yii::t('users', 'Модератор'),
		    self::ROLE_ADMIN => Yii::t('users', 'Админ'),
		    self::ROLE_SUPERADMIN => Yii::t('users', 'Супер-админ')
		];
	}

	/**
	 * @return string Читабельный статус пользователя.
	 */
	public function getStatus()
	{
		if ($this->_status === null) {
			$statuses = self::getStatusArray();
			$this->_status = $statuses[$this->status_id];
		}
		return $this->_status;
	}

	/**
	 * @return array Массив доступных ролей пользователя.
	 */
	public static function getStatusArray()
	{
		return [
		    self::STATUS_ACTIVE => Yii::t('users', 'Активен'),
		    self::STATUS_INACTIVE => Yii::t('users', 'Неактивен'),
		    self::STATUS_BANNED => Yii::t('users', 'Забанен')
		];
	}

	/**
	 * @return array [[DropDownList]] массив пользователей.
	 */
	public static function getUserArray()
	{
		$key = self::CACHE_USERS_LIST_DATA;
		$value = Yii::$app->getCache()->get($key);
		if ($value === false || empty($value)) {
			$value = self::find()->select(['id', 'username'])->orderBy('username ASC')->asArray()->all();
			$value = ArrayHelper::map($value, 'id', 'username');
			Yii::$app->cache->set($key, $value);
		}
		return $value;
	}

	/**
	 * Валидация ключа авторизации.
	 * @param string $authKey
	 * @return boolean
	 */
	public function validateAuthKey($authKey)
	{
		return $this->auth_key === $authKey;
	}

	/**
	 * Валидация пароля.
	 * @param string $password
	 * @return boolean
	 */
	public function validatePassword($password)
	{
		return Security::validatePassword($password, $this->password_hash);
	}

	/**
	 * Валидация старого пароля.
	 * В правилах модели метод назначен как валидатор атрибута модели.
	 * @return boolean
	 */
	public function validateOldPassword()
	{
		if (!$this->validatePassword($this->oldpassword)) {
			$this->addError('oldpassword', Yii::t('users', 'Неверный текущий пароль.'));
		}
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			// Логин [[username]]
			['username', 'filter', 'filter' => 'trim', 'on' => ['signup', 'admin-update', 'admin-create']],
			['username', 'required', 'on' => ['signup', 'admin-update', 'admin-create']],
			['username', 'match', 'pattern' => '/^[a-zA-Z0-9_-]+$/', 'on' => ['signup', 'admin-update', 'admin-create']],
			['username', 'string', 'min' => 3, 'max' => 30, 'on' => ['signup', 'admin-update', 'admin-create']],
			['username', 'unique', 'on' => ['signup', 'admin-update', 'admin-create']],

			// E-mail [[email]]
			['email', 'filter', 'filter' => 'trim', 'on' => ['signup', 'resend', 'recovery', 'admin-update', 'admin-create']],
			['email', 'required', 'on' => ['signup', 'resend', 'recovery', 'admin-update', 'admin-create']],
			['email', 'email', 'on' => ['signup', 'resend', 'recovery', 'admin-update', 'admin-create']],
			['email', 'string', 'max' => 100, 'on' => ['signup', 'resend', 'recovery', 'admin-update', 'admin-create']],
			['email', 'unique', 'on' => ['signup', 'admin-update', 'admin-create']],
			['email', 'exist', 'on' => ['resend', 'recovery'], 'message' => Yii::t('users', 'Пользователь с указанным адресом не существует.')],

			// Пароль [[password]]
			['password', 'required', 'on' => ['signup', 'login', 'password', 'admin-create']],
			['password', 'string', 'min' => 6, 'max' => 30, 'on' => ['signup', 'login', 'password', 'admin-update', 'admin-create']],
			['password', 'compare', 'compareAttribute' => 'oldpassword', 'operator' => '!==', 'on' => 'password'],

			// Подтверждение пароля [[repassword]]
			['repassword', 'required', 'on' => ['signup', 'password', 'admin-create']],
			['repassword', 'string', 'min' => 6, 'max' => 30, 'on' => ['signup', 'password', 'admin-update', 'admin-create']],
			['repassword', 'compare', 'compareAttribute' => 'password', 'on' => ['signup', 'password', 'admin-create']],
			['repassword', 'compare', 'compareAttribute' => 'password', 'skipOnEmpty' => false, 'on' => 'admin-update'],

			// Старый пароль [[oldpassword]]
			['oldpassword', 'required', 'on' => 'password'],
			['oldpassword', 'string', 'min' => 6, 'max' => 30, 'on' => 'password'],
			['oldpassword', 'validateOldPassword', 'on' => 'password'],

			// Имя и Фамилия [[name]] & [[surname]]
			[['name', 'surname'], 'required', 'on' => ['signup', 'update', 'admin-update', 'admin-create']],
			[['name', 'surname'], 'string', 'max' => 50, 'on' => ['signup', 'update', 'admin-update', 'admin-create']],
			['name', 'match', 'pattern' => '/^[a-zа-яё]+$/iu', 'on' => ['signup', 'update', 'admin-update', 'admin-create']],
			['surname', 'match', 'pattern' => '/^[a-zа-яё]+(-[a-zа-яё]+)?$/iu', 'on' => ['signup', 'update', 'admin-update', 'admin-create']],

			// Роль [[role_id]]
			['role_id', 'in', 'range' => array_keys(self::getRoleArray()), 'on' => ['admin-update', 'admin-create']],

			// Статус [[status_id]]
			['status_id', 'in', 'range' => array_keys(self::getStatusArray()), 'on' => ['admin-update', 'admin-create']]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function scenarios()
	{
		return [
		    // Frontend scenarios
			'signup' => ['name', 'surname', 'username', 'email', 'password', 'repassword', 'avatar_url'],
			'activation' => [],
			'login' => ['username', 'password'],
			'update' => ['name', 'surname', 'avatar_url'],
			'delete' => [],
			'resend' => ['email'],
			'recovery' => ['email'],
			'password' => ['password', 'repassword', 'oldpassword'],
			'delete-avatar' => [],
			// Backend scenarios
			'admin-update' => ['name', 'surname', 'username', 'email', 'password', 'repassword', 'avatar_url', 'status_id', 'role_id'],
			'admin-create' => ['name', 'surname', 'username', 'email', 'password', 'repassword', 'avatar_url', 'status_id', 'role_id']
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'name' => Yii::t('users', 'Имя'),
			'surname' => Yii::t('users', 'Фамилия'),
			'username' => Yii::t('users', 'Логин'),
			'email' => Yii::t('users', 'E-mail'),
			'new_email' => Yii::t('users', 'Новый E-mail'),
			'avatar_url' => Yii::t('users', 'Аватар'),
			'password' => Yii::t('users', 'Пароль'),
			'repassword' => Yii::t('users', 'Подвердите пароль'),
			'oldpassword' => Yii::t('users', 'Старый пароль'),
			'role_id' => Yii::t('users', 'Роль'),
			'status_id' => Yii::t('users', 'Статус'),
			'avatar_url' => Yii::t('users', 'Аватар'),
			'create_time' => Yii::t('users', 'Дата регистрации'),
			'update_time' => Yii::t('users', 'Дата обновления'),
		];
	}

	/**
	 * @return \yii\db\ActiveRelation Посты пользователя.
	 */
	public function getPosts()
    {
        return $this->hasMany(Post::className(), ['author_id' => 'id']);
    }

    /**
	 * @return \yii\db\ActiveRelation Комментарии пользователя.
	 */
	public function getComments()
    {
        return $this->hasMany(Comment::className(), ['author_id' => 'id']);
    }

	/**
	 * @inheritdoc
	 */
	public function afterValidate()
	{
		/* Добавляем событие модели которое доступно только после её успешной валидации.
		   Это событие обычно используется для повторных отправок электронных писем. */
		if (!$this->hasErrors() && ($this->scenario === 'resend' || $this->scenario === 'recovery')) {
			$event = new ModelEvent;
			$event->sender = self::find()->where(['email' => $this->email])->one();
			$this->trigger(self::EVENT_AFTER_VALIDATE_SUCCESS, $event);
		}
		parent::afterValidate();
	}

	/**
	 * @inheritdoc
	 */
	public function beforeSave($insert)
	{
		if (parent::beforeSave($insert)) {
			// Проверяем если это новая запись
			if ($this->isNewRecord) {
				// Хэшируем пароль
				if (!empty($this->password)) {
					$this->password_hash = Security::generatePasswordHash($this->password);
				}
				// Задаём статус записи
				if (!$this->status_id) {
					if (Yii::$app->getModule('users')->activeAfterRegistration) {
						$this->status_id = self::STATUS_ACTIVE;
					} else {
						$this->status_id = self::STATUS_INACTIVE;
					}
				}
				// Генерируем уникальный ключ
				$this->auth_key = Security::generateRandomKey();
			} else {
				// Активируем пользователя если был отправлен запрос активации
				if ($this->scenario === 'activation') {
					$this->status_id = self::STATUS_ACTIVE;
					$this->auth_key = Security::generateRandomKey();
				}
				// Обновляем пароль и ключ если был отправлен запрос восстановления пароля
				if ($this->scenario === 'recovery') {
					$this->password = Security::generateRandomKey(8);
					$this->auth_key = Security::generateRandomKey();
					$this->password_hash = Security::generatePasswordHash($this->password);
				}
				// Обновляем пароль если был отправлен запрос для его смены
				if ($this->scenario === 'password') {
					$this->password_hash = Security::generatePasswordHash($this->password);
				}
				// Удаляем аватар
				if ($this->scenario === 'delete-avatar') {
					$avatar = Yii::$app->getModule('users')->avatarPath($this->avatar_url);
					if (is_file($avatar) && unlink($avatar)) {
						$this->avatar_url = '';
					}
				}
				// Удаляем пользователя
				if ($this->scenario === 'delete') {
					$this->status_id = self::STATUS_DELETED;
				}
			}
			return true;
		}
		return false;
	}

	/**
	 * @inheritdoc
	 */
	public function afterSave($insert)
	{
		// Удаляем все записи пользователя.
		if ($this->scenario === 'delete') {
			if ($this->posts) {
				foreach ($this->posts as $post) {
					$post->delete();
				}
			}
			if ($this->comments) {
				foreach ($this->comments as $comment) {
					$comment->setScenario('delete');
					$comment->save(false);
				}
			}
		}
		parent::afterSave($insert);
	}
}