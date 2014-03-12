<?php
/**
 * "Head" содержимое основного frontend-шаблона.
 * @var yii\base\View $this Представление
 * @var array $params Основные параметры представления
 */

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\modules\site\assets\AppAsset;
?>
<title><?php echo Html::encode($this->title); ?></title>
<?php $this->registerLinkTag(['rel' => 'canonical', 'href' => Url::canonical()]);
$this->registerMetaTag([
	'charset' => Yii::$app->charset
]);
$this->registerMetaTag([
	'http-equiv' => 'X-UA-Compatible',
	'content' => 'IE=edge'
]);
$this->registerMetaTag([
	'name' => 'viewport',
	'content' => 'width=device-width, initial-scale=1'
]);
$this->registerLinkTag([
	'href' => Yii::$app->getRequest()->baseUrl . '/favicon.ico',
	'rel' => 'icon',
	'type' => 'image/x-icon'
]);
$this->registerLinkTag([
	'href' => Yii::$app->getRequest()->baseUrl . '/favicon.ico',
	'rel' => 'shortcut icon',
	'type' => 'image/x-icon'
]);
$this->head();
AppAsset::register($this);