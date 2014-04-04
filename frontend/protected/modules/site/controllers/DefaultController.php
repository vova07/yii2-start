<?php 
namespace frontend\modules\site\controllers;

use Yii;
use frontend\modules\site\components\Controller;
use frontend\modules\site\models\ContactForm;

/**
 * Основной контроллер frontend-модуля [[Site]]
 */
class DefaultController extends Controller
{
	/**
	 * @inheritdoc
	 */
	public function actions()
	{
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
			'captcha' => [
			    'class' => 'yii\captcha\CaptchaAction',
			    'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			    'height' => 34
			]
		];
	}

	/**
	 * Главная страница сайта.
	 */
	public function actionIndex()
	{
		return $this->render('index');
	}

	/**
	 * Страница обратной связи.
	 */
	public function actionContact()
	{
		$model = new ContactForm;
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
        	Yii::$app->session->setFlash('success', Yii::t('site', 'Спасибо что написали нам! Мы постараемся ответить как можно быстрее.'));
        	return $this->refresh();
        } else {
        	return $this->render('contact', [
        		'model' => $model
        	]);
        }
	}

	/**
	 * Страница "О нас".
	 */
	public function actionAbout()
	{
		return $this->render('about');
	}
}