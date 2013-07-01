<?php
namespace app\modules\comments\controllers;

use Yii;
use yii\web\HttpException;

use app\modules\site\components\FController;
use app\modules\comments\models\Comment;
use app\modules\users\models\User;

class DefaultController extends FController
{
	public function behaviors()
	{
		return array(
			'access' => array(
				'class' => \yii\web\AccessControl::className(),
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

	public function actionCreate($returnUrl)
	{
		$model = new Comment();
		if ($model->load($_POST)) {
			if ($model->save()) {
				return Yii::$app->response->redirect($returnUrl);
			}
		} else {
			echo $this->render('create', array('model' => $model));
		}
	}

	public function actionEdit($id, $returnUrl)
	{
		if ($model = Comment::find($id)) {
			if (Yii::$app->user->checkAccess('editOwnComment', array('comment' => $model)) || Yii::$app->user->checkAccess('editComment')) {
				if ($model->load($_POST)) {
					if ($model->save())
						return Yii::$app->response->redirect($returnUrl);
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

	public function actionDelete($id, $returnUrl)
	{
		if ($model = Comment::find($id)) {
			if (Yii::$app->user->checkAccess('deleteOwnComment', array('comment' => $model)) || Yii::$app->user->checkAccess('deleteComment')) {
				if ($model->delete())
					return Yii::$app->response->redirect($returnUrl);
			} else {
				throw new HttpException(403);
			}
		} else {
			throw new HttpException(404);
		}
	}
}