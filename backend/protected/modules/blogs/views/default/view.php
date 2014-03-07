<?php
/**
 * Представление страницы поста.
 * @var yii\base\View $this Представление
 * @var common\modules\blogs\models\Post $model Модель
 */

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model['title'];
$this->params['control'] = [
    'brandLabel' => Html::encode($this->title),
    'modelId' => $model['id']
];

// Собираем список категорий
$categories = '';
foreach ($model->categories as $key => $category) {
    if ($key !== 0) {
        $categories .= '<br />';
    }
    $categories .= Html::a($category['title'], ['/categories/default/index', 'id' => $category['id']]);
}
// Определяем изображение
$image = $model->image !== null ? Html::img($model->image) : '';
// Определяем мини-изображение
$preview = $model->preview !== null ? Html::img($model->preview) : '';

echo DetailView::widget([
	'model' => $model,
	'attributes' => [
	    'id',
	    'title',
        'alias',
        [
            'attribute' => 'author_id',
            'value' => $model->author->getFio(true)
        ],
        [
            'attribute' => 'categoryIds',
            'format' => 'html',
            'value' => $categories
        ],
	    [
            'attribute' => 'status_id',
            'value' => $model->status
        ],
        'snippet:html',
        'content:html',
        [
            'attribute' => 'preview_url',
            'format' => 'html',
            'value' => $preview
        ],
        [
            'attribute' => 'image_url',
            'format' => 'html',
            'value' => $image
        ]
	]
]);