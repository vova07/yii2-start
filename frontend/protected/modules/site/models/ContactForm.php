<?php 
namespace frontend\modules\site\models;

use Yii;
use yii\base\Model;

/**
 * Class ContactForm
 * @package frontend\modules\site\models
 * Модель обратной связи.
 *
 * @property string $name Имя
 * @property string $email E-mail
 * @property string $subject Тема
 * @property string $body Сообщение
 * @property string $verifyCode Код верификации
 */
class ContactForm extends Model
{
	public $name;
	public $email;
	public $subject;
	public $body;
	public $verifyCode;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			// [[name]], [[email]], [[subject]] и [[body]] обязательны к заполнению
			[['name', 'email', 'subject', 'body'], 'required'],

			// [[email]] должен быть валидным E-mail
			['email', 'email'],

			// [[verifyCode]] должен быть введен правильно
			['verifyCode', 'captcha', 'captchaAction' => 'site/default/captcha']
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
		    'name' => 'ФИО',
		    'email' => 'E-mail адрес',
		    'subject' => 'Тема',
		    'body' => 'Сообщение',
			'verifyCode' => 'Код верификации',
		];
	}

	/**
	 * Отправляем собраную ифнормацию с помощью текущей модели на указаный E-mail адрес.
     * @param string $email E-mail адрес на который будет обправлено сообщение
     * @return boolean Статус валидации модели
     */
    public function contact($email)
    {
    	if ($this->validate()) {
    		Yii::$app->mail->compose()
    		               ->setTo($email)
                           ->setFrom([$this->email => $this->name])
                           ->setSubject($this->subject)
                           ->setTextBody($this->body)
                           ->send();
            return true;
        } else {
        	return false;
        }
    }
}