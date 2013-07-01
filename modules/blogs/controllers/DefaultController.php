<?php
namespace app\modules\blogs\controllers;

use Yii;
use yii\web\HttpException;
use yii\data\Pagination;

use app\modules\site\components\FController;
use app\modules\blogs\models\Blog;
use app\modules\users\models\User;

class DefaultController extends FController
{
	public function behaviors()
	{
		return array(
			'access' => array(
				'class' => \yii\web\AccessControl::className(),
				'only' => array('create', 'edit', 'delete'),
				'rules' => array(
				    // allow authenticated users
					array(
						'allow' => true,
						'roles' => array(User::ROLE_USER)
					),
					// deny all
					array(
						'allow' => false
					)
				)
			)
		);
	}

	public function actionIndex()
	{
		$query = Blog::find()->published()->asArray();
		$countQuery = clone $query;
		$pages = new Pagination($countQuery->count());
		$pages->pageSize = $this->module->recordsPerPage;
		$models = $query->offset($pages->offset)
		          ->limit($pages->limit)
		          ->all();
		echo $this->render('index', array(
			'models' => $models,
			'pages' => $pages,
		));
	}

	public function actionView($id) {
		$model = Blog::find($id);
		echo $this->render('view', array('model' => $model));
	}

	public function actionCreate()
	{
		$model = new Blog();
		if ($model->load($_POST)) {
			if ($model->save())
				return Yii::$app->response->redirect(array('view', 'id' => $model->id));
		} else {
			echo $this->render('create', array('model' => $model));
		}
	}

	public function actionEdit($id)
	{
		if ($model = Blog::find($id)) {
			if (Yii::$app->user->checkAccess('editOwnBlog', array('blog' => $model)) || Yii::$app->user->checkAccess('editBlog')) {
				if ($model->load($_POST)) {
					if ($model->save())
						return Yii::$app->response->redirect(array('view', 'id' => $model->id));
				} else {
					echo $this->render('edit', array('model' => $model));
				}
			} else {
				throw new HttpException(403);
			}
		} else {
			throw new HttpException(404);
		}
	}

	public function actionDelete($id)
	{
		if ($model = Blog::find($id)) {
			if (Yii::$app->user->checkAccess('deleteOwnBlog', array('blog' => $model)) || Yii::$app->user->checkAccess('deleteBlog')) {
				if ($model->delete())
					return Yii::$app->response->redirect(array('index'));
			} else {
				throw new HttpException(403);
			}
		} else {
			throw new HttpException(404);
		}
	}
}