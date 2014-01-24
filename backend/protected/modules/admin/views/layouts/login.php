<?php
/**
 * Специальный шаблон страницы backend-авторизации.
 * @var $this \yii\base\View Предсталвение
 * @var $content string Контент
 * @var $params array Основные параметры предсталвения
 */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\widgets\Menu;
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<html>
<head>
  <?= $this->render('//layouts/head'); ?>
</head>
<body>
  <?php $this->beginBody(); ?>
  <!-- Wrapper -->
  <div id="wrapper">
    <!-- Content -->
    <div id="content" class="container">
      <div class="col-sm-4 col-sm-offset-4">
        <?= $content; ?>
      </div>
    </div>
    <!--/ Content -->
  </div>
  <!--/ Wrapper -->

  <?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>