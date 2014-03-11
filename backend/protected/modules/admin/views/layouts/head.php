<?php
/**
 * "Head" содержимое основного backend-шаблона.
 * @var yii\base\View $this Представление
 * @var array $params Основные параметры представления
 */

use yii\helpers\Html;
use yii\helpers\Url;
use backend\modules\admin\assets\AppAsset;
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
