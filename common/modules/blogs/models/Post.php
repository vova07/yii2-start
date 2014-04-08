<?php
namespace common\modules\blogs\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\behaviors\TimestampBehavior;
use common\behaviors\TransliterateBehavior;
use common\behaviors\PurifierBehavior;
use common\extensions\fileapi\behaviors\UploadBehavior;
use common\modules\users\models\User;
use common\modules\blogs\models\query\PostQuery;
use common\modules\blogs\modules\categories\models\Category;
use common\modules\comments\models\Comment;

/**
 * Class Post
 * @package common\modules\blogs\models
 * Модель постов.
 *
 * @property integer $id ID
 * @property integer $author_id ID автора
 * @property string $title Заголовок
 * @property string $alias Алиас
 * @property string $snippet Введение
 * @property string $content Контент
 * @property string $image_url Изображение поста
 * @property string $preview_url Превью изображение поста
 * @property integer $status_id Статус публикации
 * @property integer $fixed Статус закрепления поста вверху выборки
 * @property integer $views Количество просмотров
 * @property integer $create_time Время создания
 * @property integer $update_time Время обновления
 */
class Post extends ActiveRecord
{
	/**
	 * Статусы публикации записей модели.
	 */
	const STATUS_UNPUBLISHED = 0;
	const STATUS_PUBLISHED = 1;
	const STATUS_NOT_APPROVED = 2;

	/**
	 * Константы определяющие фиксацию записи.
	 */
	const ISNT_FIXED = 0;
	const IS_FIXED = 1;

	/**
	 * @var array Идентификаторы категории поста.
	 * Используется для получения ID категорий поста.
	 * Так же используется для определения выбраных категорий поста в момент его редактирования.
	 */
	protected $_categoryIds;

	/**
	 * @var array Текущие идентификаторы категории поста.
	 * Позволяет определить если категории поста были изменены.
	 */
	protected $_oldCategoryIds;

	/**
	 * @var string Полный URL до изображения поста.
	 */
	protected $_image;

	/**
	 * @var string Полный URL до мини-изображения поста.
	 */
	protected $_preview;

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
			'transliterateBehavior' => [
			    'class' => TransliterateBehavior::className(),
			    'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => ['title' => 'alias'],
					ActiveRecord::EVENT_BEFORE_UPDATE => ['title' => 'alias']
				]
			],
			'purifierBehavior' => [
			    'class' => PurifierBehavior::className(),
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_UPDATE => ['content'],
					ActiveRecord::EVENT_BEFORE_INSERT => ['content'],
				],
				'textAttributes' => [
					ActiveRecord::EVENT_BEFORE_UPDATE => ['title'],
					ActiveRecord::EVENT_BEFORE_INSERT => ['title'],
				],
				'purifierOptions' => [
				    'HTML.AllowedElements' => Yii::$app->params['allowHtmlTags']
				]
			],
			'uploadBehavior' => [
				'class' => UploadBehavior::className(),
				'attributes' => ['image_url', 'preview_url'],
				'scenarios' => ['create', 'update', 'admin'],
				'deleteScenarios' => [
				    'image_url' => 'delete-image',
				    'preview_url' => 'delete-preview'
				],
				'path' => [
				    'image_url' => Yii::$app->getModule('blogs')->imagePath(),
				    'preview_url' => Yii::$app->getModule('blogs')->previewPath(),
				],
				'tempPath' => [
				    'image_url' => Yii::$app->getModule('blogs')->imageTempPath(),
				    'preview_url' => Yii::$app->getModule('blogs')->previewTempPath()
				]
			]
		];
	}

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%posts}}';
	}

	/**
	 * @inheritdoc
	 */
	public static function find()
    {
        return new PostQuery(get_called_class());
    }

	/**
	 * Выбор записи по [[id]] и [[alias]]
	 * @param string $username
	 */
	public static function findByIdAlias($id, $alias)
	{
		return static::find()->where(['and', 'id = :id', 'alias = :alias'], [':id' => $id, ':alias' => $alias])->one();
	}

	/**
	 * Выбор опубликованной записи по [[id]] и [[alias]]
	 * @param string $username
	 */
	public static function findPublishedByIdAlias($id, $alias)
	{
		return static::find()->where(['and', 'id = :id', 'alias = :alias'], [':id' => $id, ':alias' => $alias])->published()->one();
	}

	/**
	 * Сеттер атрибута [[_categoriesId]].
	 * @param array|null $value Для целесности логики работы с категориями поста принимается только массив.
	 * @return array|null
	 */
	public function setCategoryIds($value) {
		if (is_array($value)) {
			$this->_categoryIds = $value;
		}
	}

	/**
	 * Геттер атрибута [[_categoriesId]].
	 * @return array| Простой массив с значениями ключей категорий текущего поста, или null в случае новой записи.
	 * Используется для определения выбраных категорий в момент редактирования поста.
	 */
	public function getCategoryIds()
	{
		if (!$this->isNewRecord && $this->_categoryIds === null) {
			if ($this->categories) {
				$ids = [];
				foreach ($this->categories as $category) {
					$ids[] = $category['id'];
				}
				$this->_categoryIds = $this->_oldCategoryIds = $ids;
			}
		}
		return $this->_categoryIds;
	}

	/**
	 * @return boolean Определяем если пост фиксирован.
	 */
	public function getIsFixed()
	{
		return $this->fixed == self::IS_FIXED;
	}

	/**
	 * @return Читабельный формат времени создания поста.
	 */
	public function getCreateTime()
	{
		return Yii::$app->formatter->asDate($this->create_time, 'd.m.Y');
	}

	/**
	 * @return string|null Полный URL адрес до изображения поста.
	 */
	public function getImage()
	{
		if ($this->_image === null && $this->image_url) {
			$this->_image = Yii::$app->getModule('blogs')->imageUrl($this->image_url);
		}
		return $this->_image;
	}

	/**
	 * @return string|null Полный URL адрес до мини-изображения поста.
	 */
	public function getPreview()
	{
		if ($this->_preview === null && $this->preview_url) {
			$this->_preview = Yii::$app->getModule('blogs')->previewUrl($this->preview_url);
		}
		return $this->_preview;
	}

	/**
	 * @return array Массив с статусами постов.
	 */
	public static function getStatusArray()
	{
		return [
		    self::STATUS_UNPUBLISHED => Yii::t('blogs', 'Не опубликован'),
		    self::STATUS_PUBLISHED => Yii::t('blogs', 'Опубликован'),
		    self::STATUS_NOT_APPROVED => Yii::t('blogs', 'На модерации'),
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
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
		    // Обязательные поля
		    [['title', 'content', 'categoryIds'], 'required'],

			// Заголовок [[title]]
			['title', 'filter', 'filter' => 'trim'],
			['title', 'string', 'max' => 100],

			// Текст [[content]]

			// Категории [[categoryIds]]
			// Возможно в будущем будет служить как красивое решение если будет решено https://github.com/yiisoft/yii2/issues/1792
			// ['categoryIds', 'exist', 'targetClass' => Category::className(), 'targetAttribute' => 'id']
			['categoryIds', 'validateCategoryIds']
		];
	}

	/**
	 * @inheritdoc
	 */
	public function scenarios()
	{
		return [
			'create' => ['title', 'content', 'image_url', 'preview_url', 'categoryIds'],
			'update' => ['title', 'content', 'image_url', 'preview_url', 'categoryIds'],
			'admin' => ['title', 'alias', 'fixed', 'content', 'image_url', 'preview_url', 'categoryIds', 'author_id', 'status_id'],
			'delete-image' => '',
			'delete-preview' => ''
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
		    'id' => Yii::t('blogs', 'ID'),
		    'author_id' => Yii::t('blogs', 'Автор'),
			'title' => Yii::t('blogs', 'Заголовок'),
			'alias' => Yii::t('blogs', 'Алиас'),
			'snippet' => Yii::t('blogs', 'Введение'),
			'content' => Yii::t('blogs', 'Текст'),
			'image_url' => Yii::t('blogs', 'Изображение'),
			'preview_url' => Yii::t('blogs', 'Мини-изображение'),
			'fixed' => Yii::t('blogs', 'Зафиксирована'),
			'status_id' => Yii::t('blogs', 'Статус'),
			'views' => Yii::t('blogs', 'Просмотры'),
			'create_time' => Yii::t('blogs', 'Дата создания'),
			'update_time' => Yii::t('blogs', 'Дата обновления'),
			'categoryIds' => Yii::t('blogs', 'Категории')
		];
	}

	/**
	 * Валидация категорий.
	 * В правилах модели метод назначен как валидатор атрибута модели.
	 * @return boolean
	 */
	public function validateCategoryIds()
	{
		if (!$this->hasErrors()) {
			$query = new Query;
			$count = $query->from(Category::tableName())
			               ->where(['id' => $this->categoryIds])
			               ->count();
			if ($count != count($this->categoryIds)) {
				$this->addError('categoryIds', Yii::t('blogs', 'Неправильное значение «Категории».'));
			}
		}
	}

	/**
	 * @return \yii\db\ActiveRelation Автор поста.
	 */
	public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    /**
	 * @return \yii\db\ActiveRelation Категории поста.
	 */
	public function getCategories()
	{
		return $this->hasMany(Category::className(), ['id' => 'category_id'])->viaTable(PostCategory::tableName(), ['post_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveRelation Связь поста с категориями.
	 */
	public function getPostCategory()
	{
		return $this->hasMany(PostCategory::className(), ['post_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveRelation Комментарии поста.
	 */
	public function getComments()
    {
        return $this->hasMany(Comment::className(), ['post_id' => 'id']);
    }

	/**
	 * @inheritdoc
	 */
	public function beforeSave($insert)
	{
		if(parent::beforeSave($insert)) {
			// Проверяем если это новая запись.
			if ($this->isNewRecord) {
				// Определяем автора в случае его отсутсвия.
				if (!$this->author_id) {
					$this->author_id = Yii::$app->user->identity->id;
				}
				// Определяем статус.
				if (!$this->status_id) {
					$this->status_id = self::STATUS_NOT_APPROVED;
				}
			}
			// Определяем снипет поста.
			$snippet = explode(Yii::$app->params['morePattern'], $this->content, 2);
			if (isset($snippet[1])) {
				$this->snippet = $snippet[0];
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
		// Сохраняем категории поста.
		if ($this->categoryIds !== $this->_oldCategoryIds) {
			PostCategory::deleteAll(['post_id' => $this->id]);
			$values = [];
			foreach ($this->categoryIds as $id) {
				$values[] = [$this->id, $id];
			}
			self::getDb()->createCommand()
			             ->batchInsert(PostCategory::tableName(), ['post_id', 'category_id'], $values)->execute();
		}
		parent::afterSave($insert);
	}

	/**
	 * @inheritdoc
	 */
	public function beforeDelete()
	{
		if (parent::beforeDelete()) {
			if ($this->comments) {
				foreach ($this->comments as $comment) {
					$comment->delete();
				}
			}
			return true;
		}
		return false;
	}
}