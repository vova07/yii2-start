<?php
/**
 * Представление виджета категорий.
 * @var yii\base\View $this Представление
 * @var common\modules\blogs\modules\categories\models\Category $models Масив моделей
 * @var string $title Заголовок виджета
 */
?>
<div id="categories-widget">
    <h3><?= $title ?></h3>
    <?= $this->render('_index_loop', [
    	'models' => $models
    ]) ?>
</div>