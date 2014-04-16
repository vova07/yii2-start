<?php
namespace backend\modules\users\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\web\HttpException;
use yii\widgets\ActiveForm;
use backend\modules\admin\components\Controller;
use backend\modules\users\models\search\UserSearch;
use common\modules\users\models\User;
use common\modules\users\models\LoginForm;
use common\extensions\fileapi\actions\UploadAction;
use common\extensions\fileapi\actions\DeleteAction;

/**
 * Основной контроллер backend-модуля [[Users]]
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
		    'actions' => ['login', 'recovery'],
		    'roles' => ['?']
		];
		$behaviors['access']['rules'][] = [
		    'allow' => true,
		    'actions' => ['logout'],
		    'roles' => ['@']
		];
		return $behaviors;
	}

	/**
	 * @inheritdoc
	 */
	public function actions()
	{
		return [
		    // Загрузка временного аватар-а.
		    'uploadTempAvatar' => [
		        'class' => UploadAction::className(),
		        'path' => $this->module->avatarTempPath(),
		        'types' => $this->module->avatarAllowedExtensions,
		        'minHeight' => $this->module->avatarHeight,
		        'maxHeight' => $this->module->avatarMaxHeight,
		        'minWidth' => $this->module->avatarWidth,
		        'maxWidth' => $this->module->avatarMaxWidth,
		        'maxSize' => $this->module->avatarMaxSize
		    ],
		    // Удаление временного аватар-а.
		    'deleteTempAvatar' => [
		        'class' => DeleteAction::className(),
		        'path' => $this->module->avatarTempPath(),
		    ]
		];
	}

	/**
	 * Выводим все записи.
	 */
	public function actionIndex()
	{
		$searchModel = new UserSearch;
		$dataProvider = $searchModel->search(Yii::$app->request->get());
		$roleArray = User::getRoleArray();
		$statusArray = User::getStatusArray();

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'searchModel' => $searchModel,
			'roleArray' => $roleArray,
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
			'model' => $this->findModel($id),
		]);
	}

	/**
	 * Создаём новую запись.
	 * В случае успеха, пользователь будет перенаправлен на "view" метод.
	 */
	public function actionCreate()
	{
		$model = new User(['scenario' => 'admin-create']);
		$roleArray = User::getRoleArray();
		$statusArray = User::getStatusArray();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model['id']]);
		} elseif (Yii::$app->request->isAjax) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			return ActiveForm::validate($model);
		} else {
			return $this->render('create', [
				'model' => $model,
				'roleArray' => $roleArray,
				'statusArray' => $statusArray
			]);
		}
	}

	/**
	 * Обновляем запись.
	 * @param integer $id Идентификатор модели.
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		$model->setScenario('admin-update');
		$roleArray = User::getRoleArray();
		$statusArray = User::getStatusArray();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model['id']]);
		} elseif (Yii::$app->request->isAjax) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			return ActiveForm::validate($model);
		} else {
			return $this->render('update', [
				'model' => $model,
				'roleArray' => $roleArray,
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
	 * Удаляем аватар
	 */
	function actionDeleteAvatar()
	{
		if ($id = Yii::$app->request->getDelete('id')) {
			$model = $this->findModel($id);
			$model->setScenario('delete-avatar');
			$model->save(false);
		} else {
			throw new HttpException(400);
		}
	}

	/**
	 * Авторизуем пользователя
	 */
	public function actionLogin()
	{
		// В случае если пользователь не гость, то мы перенаправляем его на главную страницу.
		if (!Yii::$app->user->isGuest) {
			$this->goHome();
		}
		$this->layout = '/login';
		$model = new LoginForm(['scenario' => 'admin']);
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			// В случае успешной авторизации, перенаправляем пользователя обратно на предыдущию страницу.
			return $this->goHome();
		} elseif (Yii::$app->request->isAjax) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			return ActiveForm::validate($model);
		} else {
			// Рендерим представление
			return $this->render('login', [
				'model' => $model
			]);
		}
	}

	/**
	 * Деавторизуем пользователя
	 */
	public function actionLogout()
	{
		Yii::$app->user->logout();
		return $this->redirect(['login']);
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
			$model = User::find()->where(['id' => $id])->all();
		} else {
			$model = User::findOne($id);
		}
		if ($model !== null) {
			return $model;
		} else {
			throw new HttpException(404);
		}
	}
}