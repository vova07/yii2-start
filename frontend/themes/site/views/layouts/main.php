<?php

/**
 * Theme main layout.
 *
 * @var \yii\web\View $this View
 * @var string $content Content
 */

use frontend\themes\site\widgets\Alert;
use yii\widgets\Breadcrumbs;

?>
<?php $this->beginPage(); ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <?= $this->render('//layouts/head') ?>
    </head>
    <body>
    <?php $this->beginBody(); ?>

    <header class="navbar navbar-inverse navbar-fixed-top wet-asphalt" role="banner">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only"><?= Yii::t('themes', 'Toggle navigation') ?></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?= Yii::$app->homeUrl ?>">
                    <?= Yii::$app->name ?>
                </a>
            </div>
            <div class="collapse navbar-collapse">
                <?= $this->render('//layouts/top-menu') ?>
            </div>
        </div>
    </header>
    <!--/header-->

    <?php if (!isset($this->params['noTitle'])) : ?>
        <section id="title" class="emerald">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <h1><?= $this->title ?></h1>
                        <?php if (isset($this->params['subtitle'])) : ?>
                            <p><?= $this->params['subtitle'] ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="col-sm-6">
                        <?=
                        Breadcrumbs::widget(
                            [
                                'options' => [
                                    'class' => 'breadcrumb pull-right'
                                ],
                                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []
                            ]
                        ) ?>
                    </div>
                </div>
            </div>
        </section><!--/#title-->
    <?php endif; ?>

    <?= Alert::widget(); ?>

    <section id="<?= isset($this->params['contentId']) ? $this->params['contentId'] : 'content' ?>" class="container">
        <?= $content ?>
    </section>
    <!--/#error-->

    <footer id="footer" class="midnight-blue">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    &copy; 2014 <?= Yii::$app->name ?>. <?= Yii::t('themes', 'All Rights Reserved') ?>.
                </div>
                <div class="col-sm-6">
                    <?= $this->render('//layouts/top-menu', ['footer' => true]) ?>
                </div>
            </div>
        </div>
    </footer>
    <!--/#footer-->

    <?php $this->endBody(); ?>
    </body>
    </html>
<?php $this->endPage(); ?>