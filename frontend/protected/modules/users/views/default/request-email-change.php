<?php
/**
 * Страница смены email адреса.
 * @var yii\base\View $this
 * @var app\modules\users\models\User $model
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('users', 'Смена E-mail адреса');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?php echo Html::encode($this->title); ?></h1>

<?php $form = ActiveForm::begin();
    echo $form->field($model, 'oldemail')->textInput(['readonly' => true]) .
         $form->field($model, 'email') .
         Html::submitButton(Yii::t('users', 'Обновить'), ['class' => 'btn btn-primary pull-right']);
ActiveForm::end(); ?>