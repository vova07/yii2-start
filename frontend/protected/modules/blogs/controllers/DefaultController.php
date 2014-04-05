<?php
namespace frontend\modules\blogs\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\HttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use common\modules\blogs\models\Post;
use common\modules\blogs\models\search\PostSearch;
use common\modules\blogs\modules\categories\models\Category;
use common\extensions\fileapi\actions\UploadAction;
use common\extensions\fileapi\actions\DeleteAction;
use frontend\modules\site\components\Controller;

/**
 * Основной контроллер frontend-модуля [[Blogs]]
 */
class DefaultController extends Controller
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'actions' => ['index', 'view'],
						'roles' => ['?', '@']
					],
					[
						'allow' => true,
						'actions' => ['create', 'update', 'delete', 'uploadTempImage', 'uploadTempPreview', 'deleteImage', 'deletePreview'],
						'roles' => ['createPost', '@']
					],
					[
						'allow' => false
					]
				]
			],
			'verbs' => [
			    'class' => VerbFilter::className(),
			    'actions' => [
			        'create' => ['POST'],
			        'update' => ['PUT'],
			        'delete' => ['DELETE'],
			        'uploadTempImage' => ['POST', 'PUT'],
			        'uploadTempPreview' => ['POST', 'PUT'],
			        'deleteImage' => ['DELETE'],
			        'deletePreview' => ['DELETE']
			    ]
			]
		];
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
		        'types' => $this->module->imageAllowedExtensions
		    ],
		    'uploadTempPreview' => [
		        'class' => UploadAction::className(),
		        'path' => $this->module->previewTempPath(),
		        'types' => $this->module->imageAllowedExtensions,
		        'minHeight' => $this->module->previewHeight,
		        'minWidth' => $this->module->previewWidth
		    ]
		];
	}

	/**
	 * Выводим все записи.
	 */
	public function actionIndex()
	{
		$model = new Post(['scenario' => 'create']);
		$searchModel = new PostSearch;
		$dataProvider = $searchModel->search(Yii::$app->request->get());
		$categoryArray = Category::getCategoryArray();
		// Рендерим представление
		return $this->render('index', [
			'model' => $model,
			'dataProvider' => $dataProvider,
			'categoryArray' => $categoryArray
		]);
	}

	/**
	 * Выводим одну запись.
	 * @param string $username
	 */
	public function actionView($id, $alias)
	{
		if ($model = Post::findPublishedByIdAlias($id, $alias)) {
			$model->setScenario('update');
			$categoryArray = Category::getCategoryArray();

			return $this->render('view', [
				'model' => $model,
				'categoryArray' => $categoryArray
			]);
		} else {
			throw new HttpException(404);
		}
	}

	/**
	 * Создаём новую запись.
	 * В случае успеха, пользователь будет перенаправлен на view метод.
	 */
	public function actionCreate()
	{
		$model = new Post(['scenario' => 'create']);
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model['id'], 'alias' => $model['alias']]);
		} else {
			Yii::$app->response->format = Response::FORMAT_JSON;
			return ActiveForm::validate($model);
		}
	}

	/**
	 * Обновление модели.
	 */
	public function actionUpdate($id, $alias)
	{
		if ($model = Post::findPublishedByIdAlias($id, $alias)) {
			if (Yii::$app->user->checkAccess('updateOwnPost', ['model' => $model])) {
				$model->setScenario('update');
				if ($model->load(Yii::$app->request->post()) && $model->save()) {
					return $this->redirect(['view', 'id' => $model['id'], 'alias' => $model['alias']]);
				} else {
					Yii::$app->response->format = Response::FORMAT_JSON;
					return ActiveForm::validate($model);
				}
			} else {
				throw new HttpException(403);
			}
		} else {
			throw new HttpException(404);
		}
	}

	/**
	 * Удаление модели.
	 */
	public function actionDelete($id, $alias)
	{
		if ($model = Post::findByIdAlias($id, $alias)) {
			if (Yii::$app->user->checkAccess('deleteOwnPost', ['model' => $model])) {
				return $model->delete();
			} else {
				throw new HttpException(403);
			}
		} else {
			throw new HttpException(404);
		}
	}

	/**
	 * Удаляем изображение поста.
	 */
	function actionDeleteImage()
	{
		if ($id = Yii::$app->request->getDelete('id')) {
			if ($model = Post::find((int) $id)) {
				$model->setScenario('delete-image');
				$model->save(false);
			} else {
				throw new HttpException(404);
			}
		} else {
			throw new HttpException(400);
		}
	}

	/**
	 * Удаляем vbyb-изображение поста.
	 */
	function actionDeletePreview()
	{
		if ($id = Yii::$app->request->getDelete('id')) {
			if ($model = Post::find((int) $id)) {
				$model->setScenario('delete-preview');
				$model->save(false);
			} else {
				throw new HttpException(404);
			}
		} else {
			throw new HttpException(400);
		}
	}
}