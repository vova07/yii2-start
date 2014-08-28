<?php

/**
 * Theme layout for guests.
 *
 * @var \yii\web\View $this View
 * @var string $content Content
 */

?>
<?php $this->beginPage(); ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <?= $this->render('//layouts/head') ?>
    </head>
    <body class="bg-black">
    <?php $this->beginBody(); ?>
    <?= $content ?>
    <?php $this->endBody(); ?>
    </body>
    </html>
<?php $this->endPage(); ?>