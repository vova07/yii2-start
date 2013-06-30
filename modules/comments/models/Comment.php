<?php
/**
 * Class Comment
 * @package app\modules\comments\models
 *
 * @property integer $id
 * @property integer $author_id
 * @property integer $model_id
 * @property string $content
 * @property integer $status
 * @property integer $create_time
 * @property integer $update_time
 */

namespace app\modules\comments\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\HtmlPurifier;

class Comment extends ActiveRecord
{
	const STATUS_DRAFT = 0;
	const STATUS_PUBLISHED = 1;
	const STATUS_BANNED = 2;

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

	public function getId()
	{
		return $this->id;
	}

	public function rules()
	{
		return array(
			array('content', 'required'),
			
			array('model_id', 'required')
		);
	}

	public function beforeSave($insert)
	{
		if(parent::beforeSave($insert)) {
			if($this->isNewRecord) {
				$this->author_id = Yii::$app->user->identity->id;
			}
			$Purifier = new HtmlPurifier();
			$this->content = $Purifier->process($this->content);

			return true;
		}
		return false;
	}

	public function getAll($model)
	{
		return static::find()->where(array('model_id' => $model->id))->all();
	}

	/**
	 * Exemple of Yii2 relation.
	 */
	public function getAuthor()
	{
		return $this->hasOne('app\modules\users\models\User', array('id' => 'author_id'));
	}
}
