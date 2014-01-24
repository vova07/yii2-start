<?php
namespace common\modules\blogs\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\blogs\models\Post;
use common\modules\blogs\modules\categories\models\Category;

/**
 * Class PostSearch
 * Класс поисковой модели [[Post]]
 *
 * @property string $category Алиас категории
 */
class PostSearch extends Model
{
	/**
	 * @var string Алиас категории.
	 */
	public $category;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
		    // Алиас [[category]]
		    ['category', 'match', 'pattern' => '/^[a-z0-9_-]+$/i']
		];
	}

	/**
	 * Поиск постов по переданным параметрам.
	 * @param array|null Массив с критериями выборки.
	 * @return yii\data\ActiveDataProvider dataProvider с найдеными моделями.
	 */
	public function search($params)
	{
		$query = Post::find()->with(['author', 'categories'])->published()->orderBy('fixed DESC, create_time DESC');
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
			    'pageSize' => Yii::$app->getModule('blogs')->recordsPerPage
			]
		]);
		
		if (!($this->load($params, '') && $this->validate())) {
			return $dataProvider;
		}

		$this->addWithCondition($query, 'category', 'categories', Category::tableName() . '.alias');

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