<?php
/**
 * Страница повторной отправки подвтерждения новому пользовтелю.
 * @var yii\base\View $this
 * @var yii\widgets\ActiveForm $form
 * @var common\modules\users\models\User $model
 */
 
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('users', 'Восстановление пароля');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?php echo Html::encode($this->title); ?></h1>
<?php $form = ActiveForm::begin();
    echo $form->field($model, 'email').
         Html::submitButton(Yii::t('users', 'Восстановить'), ['class' => 'btn btn-success pull-right']);
ActiveForm::end(); ?>