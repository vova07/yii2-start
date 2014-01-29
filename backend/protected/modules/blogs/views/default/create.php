<?php
/**
 * Представление создания поста.
 * @var yii\base\View $this Представление
 * @var common\modules\blogs\models\Post $model Модель
 */

use yii\helpers\Html;
use yii\widgets\Menu;

$this->title = Yii::t('blogs', 'Новый пост');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('blogs', 'Блоги'),
    'url' => ['index']
];
$this->params['breadcrumbs'][] = $this->title;
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
    'categoryArray' => $categoryArray
]); ?>