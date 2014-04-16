<?php
namespace backend\modules\blogs\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\web\HttpException;
use yii\filters\AccessControl;
use yii\widgets\ActiveForm;
use backend\modules\admin\components\Controller;
use backend\modules\blogs\models\search\PostSearch;
use common\modules\blogs\models\Post;
use common\modules\users\models\User;
use common\modules\blogs\modules\categories\models\Category;
use common\extensions\fileapi\actions\UploadAction;
use common\extensions\fileapi\actions\DeleteAction;

/**
 * Основной контроллер backend-модуля [[Blogs]]
 */
class DefaultController extends Controller
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$behaviors = parent::behaviors();
		$behaviors['access']['rules'][] = [
		    'allow' => true,
		    'actions' => ['uploadTempImage', 'uploadTempPreview'],
		    'verbs' => ['POST']
		];
		$behaviors['access']['rules'][] = [
		    'allow' => true,
		    'actions' => ['deleteTempImage', 'deleteTempPreview'],
		    'verbs' => ['DELETE']
		];
		return $behaviors;
	}

	/**
	 * @inheritdoc
	 */
	public function actions()
	{
		return [
		    'uploadTempImage' => [
		        'class' => UploadAction::className(),
		        'path' => $this->module->imageTempPath(),
		        'types' => $this->module->imageAllowedExtensions,
		        'minHeight' => $this->module->imageHeight,
		        'minWidth' => $this->module->imageWidth
		    ],
		    'deleteTempImage' => [
		        'class' => DeleteAction::className(),
		        'path' => $this->module->imageTempPath()
		    ],
		    'uploadTempPreview' => [
		        'class' => UploadAction::className(),
		        'path' => $this->module->previewTempPath(),
		        'types' => $this->module->previewAllowedExtensions,
		        'minHeight' => $this->module->previewHeight,
		        'minWidth' => $this->module->previewWidth
		    ],
		    'deleteTempPreview' => [
		        'class' => DeleteAction::className(),
		        'path' => $this->module->previewTempPath()
		    ]
		];
	}

	/**
	 * Выводим все записи.
	 */
	public function actionIndex()
	{
		$searchModel = new PostSearch;
		$dataProvider = $searchModel->search(Yii::$app->request->get());
		$statusArray = Post::getStatusArray();
		$categoryArray = Category::getCategoryArray();

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'searchModel' => $searchModel,
			'statusArray' => $statusArray,
			'categoryArray' => $categoryArray
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
		$model = new Post(['scenario' => 'admin']);
		$statusArray = Post::getStatusArray();
		$categoryArray = Category::getCategoryArray();
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
				'categoryArray' => $categoryArray,
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
		$model->setScenario('admin');
		$statusArray = Post::getStatusArray();
		$categoryArray = Category::getCategoryArray();
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
				'categoryArray' => $categoryArray,
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
	 * Удаляем изображение поста.
	 */
	function actionDeleteImage()
	{
		if ($id = Yii::$app->request->getDelete('id')) {
			$model = $this->findModel($id);
			$model->setScenario('delete-image');
			$model->save(false);
		} else {
			throw new HttpException(400);
		}
	}

	/**
	 * Удаляем изображение поста.
	 */
	function actionDeletePreview()
	{
		if ($id = Yii::$app->request->getDelete('id')) {
			$model = $this->findModel($id);
			$model->setScenario('delete-preview');
			$model->save(false);
		} else {
			throw new HttpException(400);
		}
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
			$model = Post::find()->where(['id' => $id])->all();
		} else {
			$model = Post::findOne($id);
		}
		if ($model !== null) {
			return $model;
		} else {
			throw new HttpException(404);
		}
	}
}
