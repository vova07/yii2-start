<?php
namespace backend\modules\blogs\modules\categories\controllers;

use Yii;
use yii\web\Response;
use yii\web\HttpException;
use yii\widgets\ActiveForm;
use backend\modules\admin\components\Controller;
use backend\modules\blogs\modules\categories\models\search\CategorySearch;
use common\modules\blogs\modules\categories\models\Category;

/**
 * Основной контроллер backend-модуля [[Categories]]
 */
class DefaultController extends Controller
{
	/**
	 * Выводим все записи.
	 */
	public function actionIndex()
	{
		$searchModel = new CategorySearch;
		$dataProvider = $searchModel->search($_GET);
		$statusArray = Category::getStatusArray();

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'searchModel' => $searchModel,
			'statusArray' => $statusArray,
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
	 */
	public function actionCreate()
	{
		$model = new Category(['scenario' => 'admin']);
		$statusArray = Category::getStatusArray();

		if ($model->load($_POST) && $model->save()) {
			return $this->redirect(['view', 'id' => $model['id']]);
		} elseif (Yii::$app->request->isAjax) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			return ActiveForm::validate($model);
		} else {
			return $this->render('create', [
				'model' => $model,
				'statusArray' => $statusArray
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
		$model->setScenario('admin');
		$statusArray = Category::getStatusArray();

		if ($model->load($_POST) && $model->save()) {
			return $this->redirect(['view', 'id' => $model['id']]);
		} elseif (Yii::$app->request->isAjax) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			return ActiveForm::validate($model);
		} else {
			return $this->render('update', [
				'model' => $model,
				'statusArray' => $statusArray
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
			$model = Category::find()->where(['id' => $id])->all();
		} else {
			$model = Category::findOne($id);
		}
		if ($model !== null) {
			return $model;
		} else {
			throw new HttpException(404);
		}
	}
}