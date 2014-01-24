<?php
/**
 * Основной шаблон backend-приложения.
 * @var yii\base\View $this Предсталвение
 * @var string $content Контент
 * @var array $params Основные параметры предсталвения
 */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\NavBar;
use frontend\modules\site\widgets\alert\Alert;

$this->beginPage(); ?>
  <!DOCTYPE html>
  <html lang="<?= Yii::$app->language ?>">
  <html>
    <head>
      <?= $this->render('//layouts/head'); ?>
    </head>
    <body>
      <?php $this->beginBody(); ?>
        <!-- Supercontainer -->
        <div id="supercontainer">
          <!-- Header -->
          <?php NavBar::begin([
            'id' => 'header',
            'brandLabel' => Yii::t('admin', 'Yii2 - Демо админ панель'),
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
              'class' => 'navbar-default navbar-static-top',
            ]
          ]);
            echo $this->render('//layouts/top-menu');
          NavBar::end(); ?>
          <!--/ Header -->

          <!-- Content -->
          <div id="content" class="container">
            <!-- Control bar -->
            <?php if (isset($this->params['control'])) {
              echo $this->render('//layouts/control-bar');
            } ?>
            <!--/ Control bar -->
            <?= Alert::widget() ?>
            <section>
              <?= $content; ?>
            </section>
          </div>
          <!--/ Content -->
        </div>
        <!--/ Supercontainer -->

        <!-- Footer -->
        <footer id="footer">
          <div class="container">
            <p class="pull-left"><?= Yii::t('admin', 'Версия framework-а:') . ' '  . Yii::getVersion() ?></p>
            <p class="pull-right"><?= Yii::t('admin', 'Сайт работает на') ?> <a href="http://www.yiiframework.com/" rel="external" target="_blank">Yii Framework</a></p>
          </div>
        </footer>
        <!--/ Footer -->
      <?php $this->endBody(); ?>
    </body>
  </html>
<?php $this->endPage(); ?>