<?php
/**
 * Цикл всех пользователей.
 * @var yii\base\View $this
 * @var common\modules\users\models\User $dataProvider
 */

use yii\widgets\ListView;

echo ListView::widget([
	'dataProvider' => $dataProvider,
	'layout' => '<div class="row">{items}</div><div class="row">{pager}</div>',
	'itemView' => '_index_item',
	'itemOptions' => [
	    'class' => 'user col-sm-2',
	    'tag' => 'article',
	    'itemscope' => true,
	    'itemtype' => 'http://schema.org/Person'
	]
]);