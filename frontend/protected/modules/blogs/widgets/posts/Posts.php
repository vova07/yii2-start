<?php
namespace frontend\modules\blogs\widgets\posts;

use Yii;
use yii\base\Widget;
use common\modules\blogs\models\Post;
use frontend\modules\blogs\widgets\posts\assets\PostsAsset;

/**
 * Виджет [[Posts]]
 * Данный виджет выводит последние N статей.
 */
class Posts extends Widget
{
	/**
	 * @var string Заголовок блока комментариев.
	 */
	public $title;

	/**
	 * @var integer Количество выводимых постов.
	 */
	public $postSize = 3;

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		if ($this->title === null) {
			$this->title = Yii::t('categories', 'Последние посты');
		}
	}

	/**
	 * @inheritdoc
	 */
	public function run()
	{
		$models = Post::find()->published()->orderBy('create_time DESC')->limit($this->postSize)->all();
		$view = $this->getView();
		PostsAsset::register($view);
		
		// Рендерим представление
    	echo $this->render('index', [
    		'models' => $models,
    		'title' => $this->title
    	]);
  	}
}