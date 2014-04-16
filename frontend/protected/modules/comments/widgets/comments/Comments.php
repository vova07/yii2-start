<?php
namespace frontend\modules\comments\widgets\comments;

use Yii;
use yii\base\Widget;
use common\modules\comments\models\Comment;
use frontend\modules\comments\widgets\comments\assets\CommentsAsset;
use frontend\modules\comments\widgets\comments\assets\CommentsGuestAsset;

/**
 * Виджет [[Comments]]
 * Данный виджет реализует процесс добавления и вывода комментариев.
 */
class Comments extends Widget
{
	/**
	 * @var yii\db\ActiveRecord Экземпляр модели к которой привязываются комментарии.
	 */
	public $model;

	/**
	 * @var string Заголовок блока комментариев.
	 */
	public $title;

	/**
	 * @var string Текст кнопки отправки комментария.
	 */
	public $sendButtonText;

	/**
	 * @var string Текст кнопки отмены комментирования.
	 */
	public $cancelButtonText;

	/**
	 * @var string Текст кнопки добавления нового комментария.
	 */
	public $createButtonTxt;

	/**
	 * @var integer Масимальный визуальный уровень вложености комментариев.
	 */
	public $maxLevel = 6;

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		if ($this->title === null) {
			$this->title = Yii::t('comments', 'Комментарии');
		}
		if ($this->sendButtonText === null) {
			$this->sendButtonText = Yii::t('comments', 'Добавить');
		}
		if ($this->createButtonTxt === null) {
			$this->createButtonTxt = Yii::t('comments', 'Добавить комментарий');
		}
		if ($this->cancelButtonText === null) {
			$this->cancelButtonText = Yii::t('comments', 'Отмена');
		}
	}

	/**
	 * @inheritdoc
	 */
	public function run()
	{
		$model = self::baseComment();
		$models = $model->getComments();
		$this->registerClientScript();
		// Рендерим представление
    	echo $this->render('index', [
    		'id' => $this->getId(),
    		'model' => $model,
    		'models' => $models,
    		'title' => $this->title,
    		'level' => 0,
    		'maxLevel' => $this->maxLevel,
    		'sendButtonText' => $this->sendButtonText,
    		'cancelButtonText' => $this->cancelButtonText,
    		'createButtonTxt' => $this->createButtonTxt
    	]);
  	}

  	/**
	 * Регистрируем AssetBundle-ы виджета.
	 */
	public function registerClientScript()
	{
		$view = $this->getView();
		if (Yii::$app->user->can('createComment')) {
			CommentsAsset::register($view);
			$view->registerJs("jQuery('#comment-form').comments();");
		} else {
			CommentsGuestAsset::register($view);
		}
	}

  	/**
	 * Создаем базовый каркас комментария (модели)
	 * В данной функции присваиваются нужные значения модели, которые потом используются в выборке запрашиваемых комментариев
	 */
  	protected function baseComment()
	{
		$model = new Comment(['scenario' => 'create']);
        $model->post_id = $this->model->id;
        return $model;
	}
}