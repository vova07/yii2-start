<?php
namespace backend\modules\comments\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\comments\models\Comment;
use common\modules\users\models\User;

/**
 * Модели поиска по [[Comment]] записям.
 *
 * @property string $title Заголовок.
 * @property string $alias Алиас.
 * @property integer $category_id Категория.
 * @property integer $author_id Автор.
 * @property integer $status_id Статус публикации.
 */
class CommentSearch extends Model
{
	/**
	 * @var string Заголовок.
	 */
	public $title;

	/**
	 * @var string Алиас.
	 */
	public $alias;

	/**
	 * @var integer Категория.
	 */
	public $category_id;

	/**
	 * @var integer Автор.
	 */
	public $author_id;

	/**
	 * @var integer Статус публикации.
	 */
	public $status_id;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
		    // Безопасные атрибуты
			[['title', 'alias', 'author_id'], 'string'],

			// Категория [[category_id]]
			['category_id', 'number', 'integerOnly' => true],
			
			// Статус [[status_id]]
			['status_id', 'in', 'range' => array_keys(Comment::getStatusArray())],
		];
	}

	/**
	 * Поиск записей по переданным критериям.
	 * @param array|null Массив с критериями для выборки.
	 * @return yii\data\ActiveDataProvider dataProvider с результатами поиска.
	 */
	public function search($params)
	{
		$query = Comment::find();
		$dataProvider = new ActiveDataProvider([
			'query' => $query
		]);

		if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
		}

		$this->addCondition($query, 'title', true);
		$this->addCondition($query, 'alias', true);
		$this->addCondition($query, 'status_id');
		$this->addWithCondition($query, 'author_id', 'author', User::tableName() . '.username', true);

		return $dataProvider;
	}

	/**
	 * Функция добавления условий поиска по связаным моделям.
	 * @param yii\db\Query $query Экземпляр выборки.
	 * @param string $attribute Имя отрибута с переданым значением.
	 * @param string $relation Имя связи.
	 * @param string $targetAttribute Имя удаленного отрибута по которому нужно искать.
	 * @param boolean $partialMatch Тип добавляемого сравнения. Строгое совпадение или частичное.
	 */
	protected function addWithCondition($query, $attribute, $relation, $targetAttribute, $partialMatch = false) 
    {
        $value = $this->$attribute;
        if (trim($value) === '') {
            return;
        }
        if ($partialMatch) {
        	$query->innerJoinWith([$relation])
        	      ->andWhere(['like', $targetAttribute, $value]);
        } else {
            $query->innerJoinWith([$relation])
                  ->andWhere([$targetAttribute => $value]);
        }
    }

	/**
	 * Функция добавления условий поиска.
	 * @param yii\db\Query $query Экземпляр выборки.
	 * @param string $attribute Имя отрибута по которому нужно искать.
	 * @param boolean $partialMatch Тип добавляемого сравнения. Строгое совпадение или частичное.
	 */
	protected function addCondition($query, $attribute, $partialMatch = false) 
    { 
        $value = $this->$attribute;
        if (trim($value) === '') {
            return;
        }
        if ($partialMatch) {
            $query->andWhere(['like', $attribute, $value]);
        } else {
            $query->andWhere([$attribute => $value]);
        }
    }
}
