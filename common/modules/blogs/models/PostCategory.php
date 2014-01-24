<?php
namespace common\modules\blogs\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Class PostCategory
 * @package common\modules\blogs\models
 * Модель связей между постами и категориями.
 *
 * @property integer $post_id ID поста
 * @property integer $category_id ID категории
 */
class PostCategory extends ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%post_category}}';
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'post_id' => Yii::t('blogs', 'ID поста'),
			'category_id' => Yii::t('blogs', 'ID категории'),
		];
	}
}
