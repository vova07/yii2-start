<?php
namespace backend\modules\users\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\users\models\User;

/**
 * Модели поиска по [[User]] записям.
 *
 * @property string $name Имя
 * @property string $surname Фамилия
 * @property string $username Логин
 * @property string $email E-mail
 * @property integer $status_id Статус
 * @property integer $role_id Роль
 */
class UserSearch extends Model
{
	/**
	 * @var string Имя пользователя.
	 */
	public $name;

	/**
	 * @var string Фамилия пользователя.
	 */
	public $surname;

	/**
	 * @var string Логин пользователя.
	 */
	public $username;

	/**
	 * @var string E-mail пользователя.
	 */
	public $email;

	/**
	 * @var string Роль пользователя.
	 */
	public $role_id;

	/**
	 * @var string Статус пользователя.
	 */
	public $status_id;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
		    // Безопасные атрибуты
		    [['name', 'surname', 'username', 'email'], 'string'],

			// Роль [[role_id]]
			['role_id', 'in', 'range' => array_keys(User::getRoleArray())],

			// Статус [[status_id]]
			['status_id', 'in', 'range' => array_keys(User::getStatusArray())]
		];
	}

	/**
	 * Поиск записей по переданным критериям.
	 * @param array|null Массив с критериями для выборки.
	 * @return yii\data\ActiveDataProvider dataProvider с результатами поиска.
	 */
	public function search($params)
	{
		$query = User::find();
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
			    'pageSize' => Yii::$app->getModule('users')->recordsPerPage
			]
		]);
		
		if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
		}

		$this->addCondition($query, 'name', true);
		$this->addCondition($query, 'surname', true);
        $this->addCondition($query, 'username', true);
        $this->addCondition($query, 'email', true);
        $this->addCondition($query, 'role_id');
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
