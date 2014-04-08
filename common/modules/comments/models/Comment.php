<?php
namespace common\modules\comments\models;

use Yii;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\HtmlPurifier;
use yii\behaviors\TimestampBehavior;
use common\behaviors\PurifierBehavior;
use common\modules\blogs\models\Post;
use common\modules\users\models\User;
use common\modules\comments\models\query\CommentQuery;

/**
 * Class Comment
 * @package common\modules\comments\models
 * Модель комментариев.
 *
 * @property integer $id ID.
 * @property integer $parent_id Родительский комментарий.
 * @property integer $author_id Автор.
 * @property integer $post_id ID связаного поста.
 * @property string $content Текст.
 * @property integer $status_id Статус публикации.
 * @property integer $create_time Дата создания.
 * @property integer $update_time Дата обновления.
 */
class Comment extends ActiveRecord
{
	/**
	 * Статусы записей модели.
	 */
	const STATUS_DELETED = 0;
	const STATUS_PUBLISHED = 1;
	const STATUS_BANNED = 2;

	/**
	 * @var Используется для хранения потомков (древовидные комменты).
	 */
	protected $_children;

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
			'purifierBehavior' => [
			    'class' => PurifierBehavior::className(),
				'textAttributes' => [
					ActiveRecord::EVENT_BEFORE_UPDATE => ['content'],
					ActiveRecord::EVENT_BEFORE_INSERT => ['content'],
				]
			]
		];
	}

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%comments}}';
	}

	/**
	 * @inheritdoc
	 */
	public static function find()
    {
        return new CommentQuery(get_called_class());
    }

	/**
	 * @return читабельный формат времени создания комментария.
	 */
	public function getCreateTime()
	{
		return Yii::$app->formatter->asDate($this->create_time, 'd.m.Y');
	}

	/**
	 * @return array Массив с статусами постов.
	 */
	public static function getStatusArray()
	{
		return [
		    self::STATUS_DELETED => Yii::t('comments', 'Удалён'),
		    self::STATUS_PUBLISHED => Yii::t('comments', 'Опубликован'),
		    self::STATUS_BANNED => Yii::t('comments', 'Забанен'),
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
	 * @return array or NULL потомки комментария.
	 */
	public function getChildren()
	{
		return $this->_children;
	}

	/**
	 * Задает нужное значение свойству $_childs.
	 */
	public function setChildren($value)
	{
		$this->_children = $value;
	}

	/**
	 * @return boolean Удалён комментарий или нет.
	 */
	public function getIsDeleted()
	{
		return $this->status_id == self::STATUS_DELETED;
	}

	/**
	 * @return boolean Забанен комментарий или нет.
	 */
	public function getIsBanned()
	{
		return $this->status_id == self::STATUS_BANNED;
	}

	/**
	 * @return boolean Опубликован комментарий или нет.
	 */
	public function getIsPublished()
	{
		return $this->status_id == self::STATUS_PUBLISHED;
	}

	/**
	 * Выборка запрашиваемых комментариев.
	 * @return yii\db\ActiveRecord древовидный массив комментариев.
	 */
	public function getComments() {
        $comments = self::find()
                    ->where(['post_id' => $this->post_id])
                    ->orderBy(['parent_id' => 'ASC', 'create_time' => 'ASC'])
                    ->with('author')
                    ->all();
        if ($comments) {
        	$comments = self::buildTree($comments);
        }
        return $comments;
    }
	
	/**
	 * Создаем дерево комментариев
	 * @param array $data массив который нужно обработать
	 * @param int $rootID parent_id комментария родителя
	 * @return древовидный массив комментариев
	 */
	protected function buildTree(&$data, $rootId = 0) {
        $tree = [];
        foreach ($data as $id => $node) {
            if ($node->parent_id == $rootId) {
                unset($data[$id]);
                $node->children = self::buildTree($data, $node->id);
                $tree[] = $node;
            }
        }
        return $tree;
    }

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
		    // Обязательные поля
			[['content'], 'required'],
			[['post_id', 'parent_id'], 'required', 'on' => 'admin-create'],

			// ID поста [[post_id]]
			['post_id', 'exist', 'targetClass' => Post::className(), 'targetAttribute' => 'id'],

			// ID родителя [[parent_id]]
			['parent_id', 'exist', 'targetAttribute' => 'id']
		];
	}

	/**
	 * @inheritdoc
	 */
	public function scenarios()
	{
		return [
			'admin-create' => ['content', 'parent_id', 'post_id', 'status_id'],
			'admin-update' => ['content', 'status_id'],
			'create' => ['content', 'parent_id', 'post_id'],
			'update' => ['content'],
			'delete' => ''
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
		    'id' => Yii::t('comments', 'ID'),
		    'parent_id' => Yii::t('comments', 'Родительский комментарий'),
		    'author_id' => Yii::t('comments', 'Автор'),
		    'post_id' => Yii::t('comments', 'Пост'),
			'content' => Yii::t('comments', 'Комментарий'),
			'status_id' => Yii::t('comments', 'Статус'),
			'create_time' => Yii::t('comments', 'Дата создания'),
			'update_time' => Yii::t('comments', 'Дата обновления'),
		];
	}

	/**
	 * @return \yii\db\ActiveRelation Автор комментария.
	 */
	public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    /**
	 * @return \yii\db\ActiveRelation Пост к которому был написан комментарий.
	 */
	public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }

    /**
	 * @return \yii\db\ActiveRelation Родительский комментарий.
	 */
	public function getCommentParent()
    {
        return $this->hasOne(self::className(), ['id' => 'parent_id']);
    }

	/**
	 * @inheritdoc
	 */
	public function beforeSave($insert)
	{
		if (parent::beforeSave($insert)) {
			if ($this->isNewRecord) {
				if (!$this->author_id) {
					$this->author_id = Yii::$app->user->id;
				}
				if (!$this->status_id) {
					$this->status_id = self::STATUS_PUBLISHED;
				}
				if (!$this->parent_id) {
					$this->parent_id = 0;
				}
			} else {
				// Удаляем комментарий
				if ($this->scenario === 'delete') {
					$this->status_id = self::STATUS_DELETED;
					$this->content = Yii::t('comments', 'Комментарий был удалён его автором.');
				}
				// Блокируем комментарий
				if ($this->scenario === 'admin-delete') {
					$this->status_id = self::STATUS_BANNED;
					$this->content = Yii::t('comments', 'Комментарий был удалён модератором.');
				}
			}
			return true;
		}
		return false;
	}
}