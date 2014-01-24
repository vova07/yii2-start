<?php
/**
 * Представление страницы авторизации пользователя.
 * @var yii\base\View $this Представление
 * @var yii\widgets\ActiveForm $form Форма
 * @var common\modules\users\models\LoginForm $model Модель
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('users', 'Авторизация');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?php echo Html::encode($this->title); ?></h1>

<?php $form = ActiveForm::begin([
	'enableClientValidation' => false,
	'enableAjaxValidation' => true,
	'validateOnChange' => false
]);
    echo $form->field($model, 'username').
         $form->field($model, 'password')->passwordInput().
         $form->field($model, 'rememberMe')->checkbox().
         Html::submitButton(Yii::t('users', 'Войти'), ['class' => 'btn btn-primary']);
ActiveForm::end(); ?>
