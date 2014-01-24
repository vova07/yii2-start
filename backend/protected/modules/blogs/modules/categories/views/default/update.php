<?php
/**
 * Представление обновления категории.
 * @var yii\base\View $this Представление
 * @var common\modules\blogs\modules\category\models\Category $model Модель
 */

use yii\helpers\Html;
use yii\widgets\Menu;

$this->title = Yii::t('categories', 'Обновить категорию:') . ' ' . $model['title'];
$this->params['control'] = [
    'brandLabel' => Html::encode($this->title)
];

echo $this->render('_form', [
	'model' => $model,
	'statusArray' => $statusArray
]);