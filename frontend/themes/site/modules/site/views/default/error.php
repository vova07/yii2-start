<?php

/**
 * Errors page view.
 *
 * @var yii\web\View $this View
 * @var string $name Name
 * @var string $message Message
 * @var Exception $exception Exception
 */

use yii\helpers\Html;

$this->title = $name;
$this->params['contentId'] = 'error'; ?>
<h3><?php echo nl2br(Html::encode($message)); ?></h3>
<a class="btn btn-success" href="<?= Yii::$app->homeUrl ?>">
    <?= Yii::t('themes', 'GO BACK TO THE HOMEPAGE') ?>
</a>