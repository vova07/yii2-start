<?php
/**
 * Представление обновления поста.
 * @var yii\base\View $this
 * @var common\modules\blogs\models\Post $model Модель
 */

use yii\helpers\Html;
use yii\widgets\Menu;

$this->title = 'Обновить категорию: ' . $model['title'];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('blogs', 'Категории блогов'),
    'url' => ['index']
];
$this->params['breadcrumbs'][] = [
    'label' => $model['title'],
    'url' => ['view', 'id' => $model['id']]
];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="navbar navbar-default">
    <div class="navbar-brand"><?= Html::encode($this->title); ?></div>
    <div class="navbar-right">
        <?= Menu::widget([
            'options' => ['class' => 'nav navbar-nav'],
            'activeCssClass' => 'active',
            'encodeLabels' => false,
            'activateParents' => true,
            'items' => [
                [
                    'label' => '<span class="glyphicon glyphicon-remove-sign"></span> ' . Yii::t('blogs', 'Отмена'),
                    'url' => ['index']
                ]
            ]
        ]); ?>
    </div>
</div>
<?php echo $this->render('_form', [
	'model' => $model,
    'userArray' => $userArray,
	'statusArray' => $statusArray,
    'categoryArray' => $categoryArray,
]); ?>