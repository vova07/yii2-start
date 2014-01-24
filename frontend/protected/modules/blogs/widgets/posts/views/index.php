<?php
/**
 * Представление блока последних постов.
 * @var yii\base\View $this Представление
 * @var common\modules\blogs\models\Post $models Массив моделей
 */
?>
<div id="last-posts-widget">
    <h3><?= $title ?></h3>
    <?= $this->render('_index_loop', [
    	'models' => $models
    ]) ?>
</div>