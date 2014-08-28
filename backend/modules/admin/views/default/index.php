<?php

/**
 * Backend main page view.
 *
 * @var yii\base\View $this View
 */

use yii\helpers\Html;

$this->title = Yii::t('admin', 'INDEX_TITLE');
$this->params['subtitle'] = Yii::t('admin', 'INDEX_SUBTITLE'); ?>
<div class="jumbotron text-center">
  <h1><?php echo Html::encode($this->title); ?></h1>
  <p><?= Yii::t('admin', 'INDEX_JUMBOTRON_MSG') ?></p>
</div>