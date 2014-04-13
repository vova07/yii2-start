<?php
namespace common\modules\blogs\modules\categories\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use common\behaviors\TransliterateBehavior;
use common\behaviors\PurifierBehavior;
use common\modules\blogs\modules\categories\models\query\CategoryQuery;

/**
 * Class Category
 * @package common\modules\blogs\modules\categories\models
 * Модель категорий постов.
 *
 * @property integer $id ID.
 * @property string $alias Алиас.
 * @property string $title Заголовок.
 * @property integer $ordering Порядок отображения категории.
 * @property integer $status_id Статус публикации.
 */
class Category extends ActiveRecord
{
	/**
	 * Статусы публикации записей модели.
	 */
	const STATUS_PUBLISHED = 1;
	const STATUS_UNPUBLISHED = 0;

	/**
	 * Ключи кэша которые использует модель.
	 */
	const CACHE_CATEGORIES_LIST_DATA = 'categoriesListData';

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'transliterateBehavior' => [
			    'class' => TransliterateBehavior::className(),
			    'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => ['title' => 'alias'],
					ActiveRecord::EVENT_BEFORE_UPDATE => ['title' => 'alias']
				]
			],
			'purifierBehavior' => [
			    'class' => PurifierBehavior::className(),
				'textAttributes' => [
					ActiveRecord::EVENT_BEFORE_UPDATE => ['title'],
					ActiveRecord::EVENT_BEFORE_INSERT => ['title'],
				],
				'purifierOptions' => [
				    'HTML.AllowedElements' => Yii::$app->params['allowHtmlTags']
				]
			]
		];
	}

	/**
	 * @inheritdoc
	 */
	public static function tableName($config = [])
	{
		return '{{%posts_categories}}';
	}

	/**
	 * @inheritdoc
	 */
	public static function find()
    {
        return new CategoryQuery(get_called_class());
    }

	/**
	 * @return array Массив с статусами постов.
	 */
	public static function getStatusArray()
	{
		return [
		    self::STATUS_UNPUBLISHED => Yii::t('blogs', 'Не опубликована'),
		    self::STATUS_PUBLISHED => Yii::t('blogs', 'Опубликована')
		];
	}

	/**
	 * @return string Читабельный статус поста.
	 */
	public function getStatus()
	{
		$status = self::getStatusArray();
		return $status[$this->status_id];
	}

	/**
	 * @return array [[DropDownList]] массив категорий.
	 */
	public static function getCategoryArray()
	{
		$key = self::CACHE_CATEGORIES_LIST_DATA;
		$value = Yii::$app->getCache()->get($key);
		if ($value === false || empty($value)) {
			$value = self::find()->select(['id', 'title'])->orderBy('ordering ASC, title ASC')->published()->asArray()->all();
			$value = ArrayHelper::map($value, 'id', 'title');
			Yii::$app->cache->set($key, $value);
		}
		return $value;
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
		    // Общие правила
			[['title', 'alias'], 'filter', 'filter' => 'trim'],

			// Заголовок [[title]]
			[['title', 'status_id'], 'required'],

			// Статус [[status_id]]
			['status_id', 'in', 'range' => array_keys(self::getStatusArray())],

			// Порядок вывода [[ordering]]
			['ordering', 'number', 'integerOnly' => true, 'min' => 0],
			['ordering', 'default', 'value' => 0]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function scenarios()
	{
		return [
			'admin' => ['title', 'alias', 'description', 'status_id', 'ordering']
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
		    'id' => Yii::t('categories', 'ID'),
			'title' => Yii::t('categories', 'Заголовок'),
			'alias' => Yii::t('categories', 'Алиас'),
			'ordering' => Yii::t('categories', 'Позиция'),
			'status_id' => Yii::t('categories', 'Статус')
		];
	}

	/**
	 * @inheritdoc
	 */
	public function beforeSave($insert)
	{
		if(parent::beforeSave($insert)) {
			Yii::$app->getCache()->delete(self::CACHE_CATEGORIES_LIST_DATA);
			return true;
		}
		return false;
	}
}