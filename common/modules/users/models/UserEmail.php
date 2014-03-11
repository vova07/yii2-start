<?php
namespace common\modules\users\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Security;
use yii\behaviors\TimestampBehavior;

/**
 * Class UserEmail
 * @package common\modules\users\models
 * Модель e-mail адресов пользователя, которые доступны для подтверждения.
 *
 * @property integer $id ID
 * @property integer $user_id ID связаного пользователя
 * @property string $email E-mail
 * @property string $key Ключ подвтерждения
 * @property int $valide_time Срок действия ключа
 *
 *@property string $oldemail Текущий E-mail
 */
class UserEmail extends ActiveRecord
{
	/**
	 * @var string Текущий E-mail.
	 */
	public $oldemail;

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%user_email}}';
	}

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'timestamp' => [
				'class' => TimestampBehavior::className(),
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => ['valide_time'],
				],
				'value' => [self::className(), 'expire']
			]
		];
	}

	/**
	 * Определяем срок валидности ключя подтверждения смены E-mail адреса.
	 * @return integer Текущее время + 2 часа
	 */
	public static function expire()
	{
		return strtotime('+2 hours');
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			// E-mail [[email]]
			['email', 'filter', 'filter' => 'trim'],
			['email', 'required'],
			['email', 'email'],
			['email', 'string', 'max' => 100],
			['email', 'compare', 'compareAttribute' => 'oldemail', 'operator' => '!==', 'message' => Yii::t('users', 'Новый e-mail адрес не должен совпадать с текущим адресом.')],
			['email', 'unique', 'targetClass' => User::className(), 'targetAttribute' => 'email', 'message' => Yii::t('users', 'Данный e-mail адрес используется другим пользователем.')],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function scenarios()
	{
		return [
			'create' => ['email'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'email' => Yii::t('users', 'Новый E-mail'),
			'oldemail' => Yii::t('users', 'Текущий E-mail'),
		];
	}

	/**
	 * @return \yii\db\ActiveRelation Пользователь к которому привязана запись модели.
	 */
	public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

	/**
	 * @inheritdoc
	 */
	public function beforeSave($insert)
	{
		if (parent::beforeSave($insert)) {
			if ($this->isNewRecord) {
				// Присваиваем текщий ID пользователя
				if (!$this->user_id) {
					$this->user_id = Yii::$app->user->identity->id;
				}
				// Генерируем уникальный ключ
				$this->token = Security::generateRandomKey();
			}
			return true;
		}
		return false;
	}
}
