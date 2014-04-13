<?php
/**
 * Представление одной статьи.
 * @var yii\base\View $this
 * @var common\modules\blogs\models\Post $model
 */

use yii\bootstrap\Modal;
use yii\helpers\Html;
use frontend\modules\comments\widgets\comments\Comments;

$this->title = $model['title'];
$this->params['breadcrumbs'][] = $this->title;
$this->params['page-id'] = 'blog';
?>
<div class="page-header clearfix">
	<h1 class="pull-left"><?php echo Html::encode($this->title); ?></h1>
    <?php if (Yii::$app->user->can('updateOwnPost', ['model' => $model])) {
        Modal::begin([
            'header' => '<h2>' . Yii::t('blogs', 'Редактировать статью') . '</h2>',
            'toggleButton' => [
                'label' => Yii::t('blogs', 'Редактировать статью'),
                'class' => 'btn btn-primary pull-right'
            ]
        ]);
            echo $this->render('_form', [
                'model' => $model,
                'categoryArray' => $categoryArray,
                'method' => 'PUT'
            ]);
        Modal::end();
    } ?>
</div>

<ul class="info">
    <li><span class="glyphicon glyphicon-user"></span> <?= $model->author->fio ?></li>
    <li><span class="glyphicon glyphicon-eye-open"></span> <?= $model['views'] ?></li>
    <li class="last"><span  class="glyphicon glyphicon-calendar"></span> <time pubdate datetime="<?= $model->createTime ?>"><?= $model->createTime ?></time></li>
</ul>

<?php if ($model->image) {
    echo Html::img($model->image, [
        'title' => $model['title'],
        'alt' => $model['title'],
        'class' => 'image'
    ]);
}

echo $model['content'];

if (Yii::$app->user->can('viewComment')) {
    echo Comments::widget([
        'model' => $model,
        'maxLevel' => Yii::$app->getModule('comments')->maxLevel
    ]);
}