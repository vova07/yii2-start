<?php
namespace frontend\modules\users\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\HttpException;
use yii\helpers\Url;
use common\modules\users\models\User;
use common\modules\users\models\LoginForm;
use common\modules\users\models\UserEmail;
use common\extensions\fileapi\actions\UploadAction;
use common\extensions\fileapi\actions\DeleteAction;
use frontend\modules\site\components\Controller;

/**
 * Основной контроллер frontend-модуля [[Users]].
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
				    // Разрешаем доступ нужным пользователям.
					[
						'allow' => true,
						'actions' => ['login', 'signup', 'resend', 'activation', 'recovery'],
						'roles' => ['?']
					],
					[
						'allow' => true,
						'actions' => ['logout', 'request-email-change', 'password', 'update'],
						'roles' => ['@']
					],
					[
						'allow' => true,
						'actions' => ['index', 'view', 'email'],
						'roles' => ['?', '@']
					],
					[
						'allow' => true,
						'actions' => ['uploadTempAvatar'],
						'verbs' => ['POST'],
						'roles' => ['?', '@']
					],
					[
						'allow' => true,
						'actions' => ['delete-avatar', 'deleteTempAvatar'],
						'verbs' => ['DELETE'],
						'roles' => ['@']
					],
					[
						'allow' => true,
						'actions' => ['delete'],
						'verbs' => ['DELETE'],
						'roles' => ['@']
					]
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
	function actionIndex()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => User::find()->active(),
			'pagination' => [
			    'pageSize' => $this->module->recordsPerPage
			]
		]);
		// Рендерим представление
		return $this->render('index', [
			'dataProvider' => $dataProvider
		]);
	}

	/**
	 * Выводим одну запись.
	 * @param string $username.
	 */
	public function actionView($username)
	{
		if ($model = User::findActiveByUsername($username)) {
			// Рендерим представление.
			return $this->render('view', [
				'model' => $model
			]);
		} else {
			throw new HttpException(404);
		}
	}

	/**
	 * Создаём новую запись.
	 * В случае успеха, пользователь будет перенаправлен на view метод.
	 */
	public function actionSignup()
	{
		$model = new User(['scenario' => 'signup']);
		// Добавляем обработчик события который отправляет сообщение с клюом активации на e-mail адрес что был указан при регистрации.
		if ($this->module->activeAfterRegistration === false) {
			$model->on(User::EVENT_AFTER_INSERT, [$this->module, 'onSignup']);
		}

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			// Если после регистрации нужно подтвердить почтовый адрес, вызываем функцию отправки кода активации на почту.
			if ($this->module->activeAfterRegistration === false) {
				// Сообщаем пользователю что регистрация прошла успешно, и что на его e-mail был отправлен ключ активации аккаунта.
				Yii::$app->session->setFlash('success', Yii::t('users', 'Учётная запись была успешно создана. Через несколько секунд вам на почту будет отправлен код для активации аккаунта. В случае если письмо не пришло в течении 15 минут, вы можете заново запросить отправку ключа по данной <a href="{url}">ссылке</a>. Спасибо!', ['url' => Url::toRoute('resend')]));
			} else {
				// Авторизуем сразу пользователя.
				Yii::$app->getUser()->login($model);
				// Сообщаем пользователю что регистрация прошла успешно.
				Yii::$app->session->setFlash('success', Yii::t('users', 'Учётная запись была успешно создана!'));
			}
			// Возвращаем пользователя на главную.
			return $this->goHome();
		}
		// Рендерим представление.
		return $this->render('signup', [
			'model' => $model
		]);
	}

	/**
	 * Повторно отправляем ключ активации по запросу.
	 */
	public function actionResend()
	{
		$model = new User(['scenario' => 'resend']);
		// Добавляем обработчик события который отправляет сообщение с клюом активации на e-mail адрес что был указан при запросе его повторной отправке.
		$model->on(User::EVENT_AFTER_VALIDATE_SUCCESS, [$this->module, 'onResend']);

		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			// Сообщаем пользователю что ключ активации был повторно отправлен на его электронный адрес.
			Yii::$app->session->setFlash('success', Yii::t('users', 'На указанный почтовый адрес был отправлен новый код для активации учётной записи. Спасибо!'));
			// Перенаправляем пользователя на главную страницу сайта.
			return $this->goHome();
		}
		// Рендерим представление.
		return $this->render('resend', [
			'model' => $model
		]);
	}

	/**
	 * Авторизуем пользователя.
	 */
	public function actionLogin()
	{
		// В случае если пользователь не гость, то мы перенаправляем его на главную страницу. В противном случае он бы увидел 403-ю ошибку.
		if (!Yii::$app->user->isGuest) {
			$this->goHome();
		}
		$model = new LoginForm;
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			// В случае успешной авторизации, перенаправляем пользователя обратно на предыдущию страницу.
			return $this->goBack();
		}
		// Рендерим представление.
		return $this->render('login', [
			'model' => $model
		]);
	}

	/**
	 * Деавторизуем пользователя.
	 */
	public function actionLogout()
	{
		Yii::$app->user->logout();
		// Перенаправляем пользователя на указанную в настройках модуля страницу.
		return $this->redirect($this->module->afterLogoutRedirectUrl);
	}

	/**
	 * Активируем новую учётную запись.
	 * @param string $email E-mail адрес который нужно подтвердить.
	 * @param string $key Ключ активации.
	 */
	public function actionActivation($email, $key)
	{
		if ($model = User::find()->where(['and', 'email = :email', 'auth_key = :auth_key'], [':email' => $email, ':auth_key' => $key])->inactive()->one()) {
			$model->setScenario('activation');
			// В случае если запись с введеным e-mail-ом и ключом была найдена, обновляем её и оповещаем пользователя об успешной активации.
			if ($model->save(false)) {
				Yii::$app->session->setFlash('success', Yii::t('users', 'Ваша учётная запись была успешно активирована. Теперь вы можете авторизоватся, и полноценно использовать услуги сайта. Спасибо!'));
			}
		} else {
			// В случае если запись с введеным e-mail-ом и ключом не был найден, оповещаем пользователя об неудачной активации.
			Yii::$app->session->setFlash('danger', Yii::t('users', 'Неверный код активации или возмоможно аккаунт был уже ранее активирован. Проверьте пожалуйста правильность ссылки, или напишите администратору.'));
		}
		// Перенаправляем пользователя на главную страницу сайта.
		return $this->goHome();
	}

	/**
	 * Восстановливаем пароль.
	 * @param string $email E-mail адрес для которого нужно восстановить пароль.
	 * @param string $key Ключь подтверждения.
	 */
	public function actionRecovery($email = false, $key = false)
	{
		// В случае когда $email и $key заданы, прорабатывается сценарий подтверждения восстановления пароля.
		if ($email && $key) {
			// Проверяем сущесвтования пользователя с переданым e-mail адресом, и ключом восстановления.
			if ($model = User::find()->where(['and', 'email = :email', 'auth_key = :auth_key'], [':email' => $email, ':auth_key' => $key])->active()->one()) {
				$model->setScenario('recovery');
				// Добавляем обработчик события который отправляет сообщение с новым паролем на e-mail адрес пользователя.
				$model->on(User::EVENT_AFTER_UPDATE, [$this->module, 'onRecoveryPassword']);

				if ($model->save(false)) {
					// В случае успешного восстановления пароля, перенаправляем пользователя на главную страницу, и оповещаем пользователя об успешном завершении процесса восстановления.
					Yii::$app->session->setFlash('success', Yii::t('users', 'Пароль был успешно восстановлен и отправлен на указанный электронный адрес. Проверьте пожалуйста почту!'));
				}
			} else {
				// В случае когда пользователь с передаными аргументами не существует в базе данных, оповещаем пользователя об ошибке.
				Yii::$app->session->setFlash('danger', Yii::t('users', 'Неправильный запрос подтверждения смены пароля. Пожалуйста попробуйте ещё раз!'));
			}
			// Перенаправляем пользователя на главную страницу сайта.
			return $this->goHome();

		// В случае когда $email и $key не заданы, прорабатывается сценарий непосредственного запроса восстановления пароля.
		} else {
			$model = new User(['scenario' => 'recovery']);
			// Добавляем обработчик события который отправляет сообщение с ключом подтверждения смены пароля на e-mail адрес пользователя.
			$model->on(User::EVENT_AFTER_VALIDATE_SUCCESS, [$this->module, 'onRecoveryConfirm']);

			if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			    // Перенаправляем пользователя на главную страницу, и оповещаем его об успешном завершении запроса восставновления пароля.
			    Yii::$app->session->setFlash('success', Yii::t('users', 'Ссылка для восстановления пароля, была отправлена на указанный вами электронный адрес.'));
			    return $this->goHome();
			}
			// Рендерим представление.
			return $this->render('recovery', [
				'model' => $model
			]);
		}
	}

	/**
	 * Обновляем пользователя.
	 */
	public function actionUpdate()
	{
		// Выбираем текущего пользователя.
		if ($model = User::findOne(Yii::$app->user->id)) {
			$model->setScenario('update');

			if ($model->load(Yii::$app->request->post()) && $model->save()) {
				// В случае успешного обновления данных, оповещаем пользователя об этом, и перенаправляем его на страницу профиля.
				Yii::$app->session->setFlash('success', Yii::t('users', 'Данные профиля были успешно обновлены!'));
				return $this->redirect(['view', 'username' => $model->username]);
			}
			// Рендерим представление.
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Удаляем пользователя.
	 */
	public function actionDelete()
	{
		// Выбираем текущего пользователя.
		if ($model = User::findOne(Yii::$app->user->id)) {
			$model->setScenario('delete');
			if ($model->save(false)) {
				// В случае успешного удаления данных, оповещаем пользователя об этом, и перенаправляем его на главную страницу.
				Yii::$app->session->setFlash('success', Yii::t('users', 'Профиль был успешно удален!'));
				return $this->goHome();
			}
		}
	}

	/**
	 * Меняем пароль.
	 */
	public function actionPassword()
	{
		// Выбираем текущего пользователя.
		if ($model = User::findOne(Yii::$app->user->id)) {
			$model->setScenario('password');

			if ($model->load(Yii::$app->request->post()) && $model->save()) {
				// В случае успешного обновления пароля, оповещаем пользователя об этом, и перенаправляем его на страницу профиля.
				Yii::$app->session->setFlash('success', Yii::t('users', 'Пароль был успешно обновлён!'));
				return $this->redirect(['view', 'username' => $model->username]);
			}
			// Рендерим представление.
			return $this->render('password', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Запрашиваем смену e-mail адреса.
	 */
	public function actionRequestEmailChange()
	{
		$model = new UserEmail(['scenario' => 'create']);
		// Присваиваем значение старого e-mail адреса из сессии текущего пользователя.
		$model->oldemail = Yii::$app->user->identity->email;
		// Добавляем обработчик события который отправляет сообщение с клюом активации на новый e-mail адрес.
		$model->on(UserEmail::EVENT_AFTER_INSERT, [$this->module, 'onEmailChange']);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			// В случае успешного запроса смены e-mail адреса, оповещаем пользователя об этом, и перенаправляем его на страницу профиля.
			Yii::$app->session->setFlash('success', Yii::t('users', 'На ваш новый e-mail адрес был успешно отправлен ключ для его подтверждения.'));
			return $this->redirect(['view', 'username' => Yii::$app->user->identity->username]);
		}
		// Рендерим представление.
		return $this->render('request-email-change', [
			'model' => $model
		]);
	}

	/**
	 * Подтверждаем новый e-mail адрес.
	 * @param string $email.
	 * @param string $key.
	 */
	public function actionEmail($email, $key)
	{
		if ($model = UserEmail::find()->where(['and', 'email = :email', 'token = :token', 'valide_time >= :time'], [':email' => $email, ':token' => $key, ':time' => time()])->one()) {
			$model->user->email = $model->email;
			if ($model->user->save(false) && $model->delete()) {
				// В случае успешной смены e-mail адреса, оповещаем пользователя об этом.
				Yii::$app->session->setFlash('success', Yii::t('users', 'E-mail адрес был успешно обновлён!'));
			}
		} else {
			// В случае ошибки смены e-mail адреса, оповещаем пользователя об этом.
			Yii::$app->session->setFlash('danger', Yii::t('users', 'Неправильный запрос подтверждения смены e-mail адреса. Пожалуста попробуйте ещё раз!'));
		}
		// Перенаправляем пользователя на главную страницу сайта.
		return $this->goHome();
	}

	/**
	 * Удаляем аватар.
	 */
	function actionDeleteAvatar()
	{
		$model = User::findOne(Yii::$app->user->id);
		$model->setScenario('delete-avatar');
		$model->save(false);
	}
}