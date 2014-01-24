<?php
namespace frontend\modules\blogs\modules\categories\widgets\categories;

use Yii;
use yii\base\Widget;
use common\modules\blogs\modules\categories\models\Category;

/**
 * Виджет [[Categories]]
 * Данный виджет выводит дерево категорий постов.
 */
class Categories extends Widget
{
	/**
	 * @var string Заголовок блока комментариев.
	 */
	public $title;

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		if ($this->title === null) {
			$this->title = Yii::t('categories', 'Категории');
		}
	}

	/**
	 * @inheritdoc
	 */
	public function run()
	{
		$models = Category::find()->published()->orderBy('ordering')->asArray()->all();
		
		// Рендерим представление
    	echo $this->render('index', [
    		'models' => $models,
    		'title' => $this->title
    	]);
  	}
}