<?php
/**
 * @var yii\widgets\ActiveForm $form
 * @var app\modules\comments\models\Comment $models
 * @var app\modules\comments\models\Comment $model
 */

use yii\base\Formatter;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<hr />
<?php 
if (count($models)) {
	$Formatter = new Formatter();
?>
    <h3>Comments</h3>
    <?php foreach ($models as $key => $comment) { ?>
        <blockquote>
        	<small><?php echo $comment->author['username'] . ' on ' . $Formatter->asDate($comment['create_time'], 'M d, Y') . ' said:'; ?></small>
        	<p><?php echo $comment['content']; ?></p>
        	<em><?php if (Yii::$app->user->checkAccess('editOwnComment', array('comment' => $comment)) || Yii::$app->user->checkAccess('editComment')) {
                echo Html::a('Edit', array('comments/default/edit', 'id' => $comment['id'], 'returnUrl' => Yii::$app->request->url)) . ' ';
            }
            if (Yii::$app->user->checkAccess('deleteOwnComment', array('comment' => $comment)) || Yii::$app->user->checkAccess('deleteComment')) {
                echo Html::a('Delete', array('comments/default/delete', 'id' => $comment['id'], 'returnUrl' => Yii::$app->request->url)); 
            } ?></em>
        </blockquote>
    <?php }
}
if (!Yii::$app->user->isGuest)
    echo $this->render('_form', array('model' => $model)); 
?>