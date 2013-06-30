<?php
/**
 * Class User
 * @package app\modules\users\models
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $auth_key
 * @property integer $role
 * @property integer $status
 * @property integer $create_time
 * @property integer $update_time
 */

namespace app\modules\users\models;

use Yii;
use yii\base\ModelEvent;
use yii\db\ActiveRecord;
use yii\helpers\SecurityHelper;
use yii\web\Identity;

class User extends ActiveRecord implements Identity
{
	/**
	 * @var string the raw password. Used to collect password input and isn't saved in database
	 */
	public $password;
	public $repassword;
	public $oldpassword;

	/**
	 * @var Module yii\base\Module of model
	 */
	protected $_module;

	const STATUS_INACTIVE = 0;
	const STATUS_ACTIVE = 1;
	const STATUS_DELETED = 2;

	const ROLE_USER = 0;
	const ROLE_ADMIN = 1;

	const EVENT_NEW_USER = 'newUser';

	public function behaviors()
	{
		return array(
			'timestamp' => array(
				'class' => 'yii\behaviors\AutoTimestamp',
				'attributes' => array(
					ActiveRecord::EVENT_BEFORE_INSERT => array('create_time', 'update_time'),
					ActiveRecord::EVENT_BEFORE_UPDATE => 'update_time',
				),
			),
		);
	}

	public static function findIdentity($id)
	{
		return static::find($id);
	}

	public static function findByUsername($username)
	{
		return static::find(array('username' => $username));
	}

	public function getId()
	{
		return $this->id;
	}

	public function getAuthKey()
	{
		return $this->auth_key;
	}

	public function getModule()
	{
		if ($this->_module === NULL)
			$this->_module = Yii::$app->getModule('users');

		return $this->_module;
	}

	public function validateAuthKey($authKey)
	{
		return $this->auth_key === $authKey;
	}

	public function validatePassword($password)
	{
		return SecurityHelper::validatePassword($password, $this->password_hash);
	}

	public function validateUpdatePassword()
	{
		if (!empty($this->password)) {
			if (empty($this->repassword))
				$this->addError('repassword', 'Confirm password cannot be blank.');
			if (empty($this->oldpassword))
				$this->addError('oldpassword', 'Current password cannot be blank.');
		}
	}

	public function validateOldPassword()
	{
		if (!$this->validatePassword($this->oldpassword))
			$this->addError('oldpassword', 'Invalid current password.');
	}

	public function rules()
	{
		return array(
			array('username', 'filter', 'filter' => 'trim'),
			array('username', 'required'),
			array('username', 'string', 'min' => 3, 'max' => 25),
			array('username', 'unique', 'message' => 'This username has already been taken.'),

			array('email', 'filter', 'filter' => 'trim'),
			array('email', 'required'),
			array('email', 'email'),
			array('email', 'unique', 'message' => 'This email address has already been taken.'),

			array('password', 'required', 'on' => array('signup', 'login')),
			array('password', 'string', 'min' => 6, 'max' => 30),
			array('password', 'validateUpdatePassword', 'on' => 'update'),

			array('repassword', 'required', 'on' => array('signup')),
			array('repassword', 'string', 'min' => 6, 'max' => 30, 'on' => array('signup', 'update')),
			array('repassword', 'compare', 'compareAttribute'=>'password', 'on' => array('signup', 'update')),

			array('oldpassword', 'string', 'min' => 6, 'max' => 30, 'on' => array('update')),
			array('oldpassword', 'compare', 'compareAttribute'=>'password', 'operator' => '!==', 'on' => array('update')),
			array('oldpassword', 'validateOldPassword', 'on' => array('update')),
		);
	}

	public function scenarios()
	{
		return array(
			'update' => array('email', 'password', 'repassword', 'oldpassword', 'status', 'role'),
			'signup' => array('username', 'email', 'password', 'repassword'),
			'login' => array('username', 'password'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'repassword' => 'Confirm password',
			'oldpassword' => 'Current password',
		);
	}

	public function beforeSave($insert)
	{
		if(parent::beforeSave($insert)) {
			if ($this->isNewRecord) {
				if (!empty($this->password))
					$this->password_hash = SecurityHelper::generatePasswordHash($this->password);
				if ($this->module->activeAfterRegistration)
					$this->status = self::STATUS_ACTIVE;
				$this->activkey = SecurityHelper::generateRandomKey();
			} else {
				if ($this->scenario === 'activation')
					$this->activkey = SecurityHelper::generateRandomKey();
				if ($this->scenario === 'update')
					$this->password_hash = SecurityHelper::generatePasswordHash($this->password);
			}
			return true;
		}
		return false;
	}

	/**
	 * It's just an exemple of an own event. In realy app you can use [[self::EVENT_AFTER_INSERT]]
	 */
	public function afterSave($insert)
	{
		$event = new ModelEvent;
		$this->trigger(self::EVENT_NEW_USER, $event);

		parent::afterSave($insert);
	}

	/**
	 * Exemple of Yii2 scope.
	 * @param yii\db\Query
	 */
	public function active($query)
	{
		return $query->andWhere('status = ' . self::STATUS_ACTIVE);
	}
}
