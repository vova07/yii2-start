<?php
/**
 * Основной шаблон frontend-приложения.
 * @var yii\base\View $this Представление
 * @var string $content Контент
 * @var array $params Основные параметры представления
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
    <body<?php if (isset($this->params['page-id'])) { echo ' id="page-' . $this->params['page-id'] . '"'; } ?>>
      <?php $this->beginBody(); ?>
        <!-- Supercontainer -->
        <div id="supercontainer">
          <!-- Header -->
          <?php NavBar::begin([
            'id' => 'header',
            'brandLabel' => Yii::t('site', 'Yii2 - Демо приложение'),
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
              'class' => 'navbar-inverse navbar-static-top',
            ]
          ]);
            echo $this->render('//layouts/top-menu');
          NavBar::end(); ?>
          <!--/ Header -->

          <!-- Content -->
          <div id="content" class="container">
            <?php if (isset($this->params['breadcrumbs'])) {
              echo Breadcrumbs::widget([
                'homeLink' => [
                  'label' => Yii::t('site', 'Главная'),
                  'url' => Yii::$app->getHomeUrl()
                ],
                'links' => $this->params['breadcrumbs']
              ]);
            } ?>
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
            <p class="pull-left">&copy; <?= date('Y') . ', ' . Yii::t('site', 'Все права защищены.') ?></p>
            <p class="pull-right"><?= Yii::t('site', 'Сайт работает на') ?> <a href="http://www.yiiframework.com/" rel="external" target="_blank">Yii Framework</a></p>
          </div>
        </footer>
        <!--/ Footer -->
      <?php $this->endBody(); ?>
    </body>
  </html>
<?php $this->endPage(); ?>