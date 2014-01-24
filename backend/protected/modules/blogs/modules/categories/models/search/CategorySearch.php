<?php
namespace backend\modules\blogs\modules\categories\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\blogs\modules\categories\models\Category;

/**
 * Модели поиска по [[Category]] записям.
 *
 * @property string $title Заголовок.
 * @property string $alias Алиас.
 * @property integer $status_id Статус публикации.
 */
class CategorySearch extends Model
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
			[['title', 'alias'], 'string'],
			
			// Статус [[status_id]]
			['status_id', 'in', 'range' => array_keys(Category::getStatusArray())]
		];
	}

	/**
	 * Поиск записей по переданным критериям.
	 * @param array|null Массив с критериями для выборки.
	 * @return yii\data\ActiveDataProvider dataProvider с результатами поиска.
	 */
	public function search($params)
	{
		$query = Category::find();
		$dataProvider = new ActiveDataProvider([
			'query' => $query
		]);

		if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
		}

		$this->addCondition($query, 'title', true);
		$this->addCondition($query, 'alias', true);
		$this->addCondition($query, 'status_id');

		return $dataProvider;
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