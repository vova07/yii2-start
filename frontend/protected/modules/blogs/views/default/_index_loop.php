<?php
/**
 * Представление цикла блогов.
 * @var yii\base\View $this
 * @var common\modules\blogs\models\Post $dataProvider
 */

use yii\widgets\ListView;

echo ListView::widget([
	'dataProvider' => $dataProvider,
	'layout' => '{items}{pager}',
	'itemView' => '_index_item',
	'itemOptions' => [
	    'class' => 'blog row',
	    'tag' => 'article'
	]
]);