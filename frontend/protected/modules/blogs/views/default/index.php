<?php
/**
 * Представление страницы блогов.
 * @var yii\base\View $this
 * @var frontend\modules\blogs\models\Post $models
 * @var frontend\modules\blogs\models\Post $model
 */

use yii\bootstrap\Modal;
use yii\helpers\Html;
use frontend\modules\blogs\modules\categories\widgets\categories\Categories;

$this->title = Yii::t('blogs', 'Блоги');
$this->params['breadcrumbs'][] = $this->title;
$this->params['page-id'] = 'blogs';
?>
<div class="page-header clearfix">
    <h1 class="pull-left"><?php echo Html::encode($this->title); ?></h1>
    <?php if (Yii::$app->user->can('createPost')) {
        Modal::begin([
            'header' => '<h2>' . Yii::t('blogs', 'Добавить статью') . '</h2>',
            'toggleButton' => [
                'label' => Yii::t('blogs', 'Добавить статью'),
                'class' => 'btn btn-primary pull-right'
            ]
        ]);
            echo $this->render('_form', [
                'model' => $model,
                'categoryArray' => $categoryArray
            ]);
        Modal::end();
    } ?>
</div>
<div class="row">
    <div class="col-sm-9">
        <?= $this->render('_index_loop', [
        	'dataProvider' => $dataProvider
        ]); ?>
    </div>
    <div class="col-sm-3">
        <?= Categories::widget() ?>
    </div>
</div>