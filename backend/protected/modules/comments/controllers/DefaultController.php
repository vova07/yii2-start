<?php
namespace backend\modules\comments\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\web\HttpException;
use yii\widgets\ActiveForm;
use backend\modules\admin\components\Controller;
use backend\modules\comments\models\search\CommentSearch;
use common\modules\comments\models\Comment;
use common\modules\users\models\User;

/**
 * Основной контроллер backend-модуля [[Comments]]
 */
class DefaultController extends Controller
{
	/**
	 * Выводим все записи.
	 */
	public function actionIndex()
	{
		$searchModel = new CommentSearch;
		$dataProvider = $searchModel->search(Yii::$app->request->get());
		$statusArray = Comment::getStatusArray();

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'searchModel' => $searchModel,
			'statusArray' => $statusArray
		]);
	}

	/**
	 * Выводим одну запись.
	 * @param integer $id Идентификатор модели.
	 */
	public function actionView($id)
	{
		return $this->render('view', [
			'model' => $this->findModel($id)
		]);
	}

	/**
	 * Создаём новую запись.
	 * В случае успеха, пользователь будет перенаправлен на "view" метод.
	 * @param integer $parentId ID родительского комментария
	 * @param integer $postId ID поста к которому привязан комментарий.
	 */
	public function actionCreate($parentId, $postId)
	{
		$model = new Comment(['scenario' => 'admin-create']);
		$model->parent_id = $parentId;
		$model->post_id = $postId;
		$statusArray = Comment::getStatusArray();
		$userArray = User::getUserArray();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model['id']]);
		} elseif (Yii::$app->request->isAjax) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			return ActiveForm::validate($model);
		} else {
			return $this->render('create', [
				'model' => $model,
				'statusArray' => $statusArray,
				'userArray' => $userArray
			]);
		}
	}

	/**
	 * Обновляем запись.
	 * В случае успеха, пользователь будет перенаправлен на "view" метод.
	 * @param integer $id Идентификатор модели.
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		$model->setScenario('admin-update');
		$statusArray = Comment::getStatusArray();
		$userArray = User::getUserArray();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model['id']]);
		} elseif (Yii::$app->request->isAjax) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			return ActiveForm::validate($model);
		} else {
			return $this->render('update', [
				'model' => $model,
				'statusArray' => $statusArray,
				'userArray' => $userArray
			]);
		}
	}

	/**
	 * Удаляем запись.
	 * В случае успеха, пользователь будет перенаправлен на "index" метод.
	 * @param integer $id Идентификатор модели.
	 */
	public function actionDelete($id)
	{
		$model = $this->findModel($id);
		$model->delete();
		return $this->redirect(['index']);
	}

	/**
	 * Удаляем несколько записей.
	 * В случае успеха, пользователь будет перенаправлен на "index" метод.
	 * @param array $ids Массив с идентификаторами записей которые нужно удалить.
	 */
	public function actionBatchDelete(array $ids)
	{
		$models = $this->findModel($ids);
		foreach ($models as $model) {
			$model->delete();
		}
		return $this->redirect(['index']);
	}

	/**
	 * Поиск модели по первичному ключу.
	 * Если модель не найдена, будет вызвана 404 ошибка.
	 * @param integer|array $id Идентификатор модели.
	 * @return Post Найденая модель.
	 * @throws HttpException Если модель не найдена.
	 */
	protected function findModel($id)
	{
		if (is_array($id)) {
			$model = Comment::find()->where(['id' => $id])->all();
		} else {
			$model = Comment::findOne($id);
		}
		if ($model !== null) {
			return $model;
		} else {
			throw new HttpException(404);
		}
	}
}
