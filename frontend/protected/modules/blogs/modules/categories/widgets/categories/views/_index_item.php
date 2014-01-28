<?php
/**
 * Представление одного путка с категорией.
 * @var yii\base\View $this Представление
 * @var common\modules\blogs\modules\categories\models\Category $model Модель
 */

use yii\helpers\Html;

$class = 'list-group-item';
if ($model['alias'] === Yii::$app->request->getQueryParams('category')) {
	$class .= ' active';
}
echo Html::a($model['title'], ['/blogs/default/index', 'category' => $model['alias']], ['class' => $class]);