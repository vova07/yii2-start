<?php 
namespace backend\modules\admin\controllers;

use Yii;
use yii\filters\AccessControl;
use backend\modules\admin\components\Controller;
use common\modules\users\models\User;

/**
 * Основной контроллер backend-модуля [[Admin]]
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
		    'actions' => ['error'],
		    'roles' => ['?', '@']
		];
		return $behaviors;
	}

	/**
	 * @inheritdoc
	 */
	public function actions()
	{
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction'
			]
		];
	}

	/**
	 * Выводим главную страницу панель-управления.
	 */
	public function actionIndex()
	{
		return $this->render('index');
	}
}