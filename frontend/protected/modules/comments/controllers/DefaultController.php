<?php
namespace frontend\modules\comments\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\HttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;
use frontend\modules\site\components\Controller;
use common\modules\comments\models\Comment;

/**
 * Основной контроллер frontend-модуля [[Comments]]
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
						'roles' => ['createComment']
					]
				]
			],
			'verbs' => [
			    'class' => VerbFilter::className(),
			    'actions' => [
			        'create' => ['POST'],
			        'update' => ['PUT', 'POST'],
			        'delete' => ['DELETE']
			    ]
			]
		];
	}

	/**
	 * Создаём новую запись.
	 */
	public function actionCreate()
	{
		$model = new Comment(['scenario' => 'create']);
		Yii::$app->response->format = Response::FORMAT_JSON;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$level = Yii::$app->request->get('level');
			if ($level !== null) {
				$level = $level < $this->module->maxLevel ? $level + 1 : $this->module->maxLevel;
			} else {
				$level = 0;
			}

			return [
			    'success' => $this->renderPartial('@frontend/modules/comments/widgets/comments/views/_index_item', [
			    	'model' => $model,
			    	'level' => $level,
			    	'maxLevel' => $this->module->maxLevel
			    ])
			];
		} else {
			return ['errors' => ActiveForm::validate($model)];
		}
	}

	/**
	 * Обновляем запись.
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		if (Yii::$app->user->checkAccess('updateOwnComment', ['model' => $model])) {
			$model->setScenario('update');
			Yii::$app->response->format = Response::FORMAT_JSON;

			if ($model->load(Yii::$app->request->post()) && $model->save()) {
				return ['success' => $model['content']];
			} else {
				return ['errors' => ActiveForm::validate($model)];
			}
		} else {
			throw new HttpException(403);
		}
	}

	/**
	 * Удаляем запись.
	 */
	public function actionDelete($id)
	{
		$model = $this->findModel($id);
		if (Yii::$app->user->checkAccess('deleteOwnComment', ['model' => $model])) {
			$model->setScenario('delete');
			if ($model->save(false)) {
				Yii::$app->response->format = Response::FORMAT_JSON;
				return ['success' => $model['content']];
			}
		} else {
			throw new HttpException(403);
		}
	}

	/**
	 * Поиск записи по первичному ключу.
	 * Если запись не найдена, будет вызвана 404 ошибка.
	 * @param integer $id Идентификатор модели.
	 * @return Comment Найденая запись.
	 * @throws HttpException Если запись не найдена.
	 */
	protected function findModel($id)
	{
		if (($model = Comment::find()->where(['id' => $id])->published()->one()) !== null) {
			return $model;
		} else {
			throw new HttpException(404);
		}
	}
}