<?php
/**
 * @var yii\base\View $this
 * @var app\modules\blogs\models\Blog $model
 */
 
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin(array('options' => array('class' => 'form-vertical')));
echo $form->field($model, 'title')->textInput(array('class' => 'span12'));
echo $form->field($model, 'content')->textArea(array('class' => 'span12', 'rows' => 7));
?>

<div class="form-actions">
	<?php echo Html::submitButton($model->isNewRecord ? 'Save' : 'Update', array('class' => 'btn btn-primary')); ?>
</div>

<?php ActiveForm::end(); ?>
