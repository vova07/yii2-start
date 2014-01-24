<?php
/**
 * Представление блока комментариев.
 * @var yii\base\View $this
 * @var common\modules\comments\models\Comment $model
 * @var common\modules\comments\models\Comment $models
 */
?>
<div id="categories-widget">
    <h3><?= $title ?></h3>
    <?= $this->render('_index_loop', [
    	'models' => $models
    ]) ?>
</div>