<?php
/**
 * Страница смены пароля.
 * @var yii\base\View $this
 * @var common\modules\users\models\User $model
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('users', 'Смена пароля');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?php echo Html::encode($this->title); ?></h1>
<?php $form = ActiveForm::begin();
    echo $form->field($model, 'oldpassword')->passwordInput() .
         $form->field($model, 'password')->passwordInput() .
         $form->field($model, 'repassword')->passwordInput() .
         Html::submitButton(Yii::t('users', 'Обновить'), ['class' => 'btn btn-primary pull-right']);
ActiveForm::end(); ?>