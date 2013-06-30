<?php
/**
 * Class Blog
 * @package app\modules\blogs\models
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property integer $status
 * @property integer $create_time
 * @property integer $update_time
 */

namespace app\modules\blogs\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\HtmlPurifier;

class Blog extends ActiveRecord
{
	const STATUS_DRAFT = 0;
	const STATUS_PUBLISHED = 1;

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
			array('title', 'required'),
			array('title', 'string', 'max' => 255),

			array('content', 'required')
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

	/**
	 * Exemple of Yii2 scope.
	 * @param yii\db\Query
	 */
	public function published($query)
	{
		return $query->andWhere('status = ' . self::STATUS_PUBLISHED);
	}
}
