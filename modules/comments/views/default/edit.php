<?php
/**
 * @var yii\base\View $this
 * @var app\modules\comments\models\Comment $model
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Edit comment';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-header">
	<h1><?php echo Html::encode($this->title); ?></h1>
</div>

<?php echo $this->render('@app/modules/comments/widgets/comments/views/_form', array('model' => $model)); ?>