<?php
namespace app\modules\comments\widgets\comments;

use yii\base\Widget;

use app\modules\comments\models\Comment;

class Comments extends Widget
{
	public $view = 'comments/views',
	       $model;

	public function run()
	{
		$model = new Comment();
		$model->model_id = $this->model['id'];
		$models = $model->getAll($this->model);

    	echo $this->render('index', array('model' => $model, 'models' => $models));
  	}
}