<?php
/**
 * @var yii\base\View $this
 * @var app\modules\users\models\User $model
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\modules\users\models\User;

$form = ActiveForm::begin(array('options' => array('class' => 'form-horizontal')));
echo $form->field($model, 'username')->textInput($model->isNewRecord ? array() : array('readonly' => true));
echo $form->field($model, 'email')->textInput();
if (!$model->isNewRecord) {
    if (Yii::$app->user->checkAccess('editProfile')) {
        echo $form->field($model, 'status')->dropDownList(array(
        	User::STATUS_ACTIVE => 'Active',
        	User::STATUS_INACTIVE => 'Inactive',
        	User::STATUS_DELETED => 'Deleted'
        ));
        echo $form->field($model, 'role')->dropDownList(array(
        	User::ROLE_USER => 'User',
        	User::ROLE_ADMIN => 'Admin'
        ));
    }
	echo $form->field($model, 'oldpassword')->passwordInput();
}
echo $form->field($model, 'password')->passwordInput();
echo $form->field($model, 'repassword')->passwordInput();
?>

<div class="form-actions">
	<?php echo Html::submitButton($model->isNewRecord ? 'Register' : 'Update', array('class' => 'btn btn-primary')); ?>
</div>

<?php ActiveForm::end(); ?>
