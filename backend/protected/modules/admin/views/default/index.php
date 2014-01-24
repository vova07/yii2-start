<?php
/**
 * Представление главной старницы панели управления.
 * @var yii\base\View $this
 */

use yii\helpers\Html;

$this->title = Yii::t('app', 'Панель управления'); ?>
<div class="jumbotron text-center">
  <h1><?php echo Html::encode($this->title); ?></h1>
  <p><?= Yii::t('admin', 'В будущем тут возможно будут добавлены удобные фичи.') ?></p>
</div>