<?php
namespace common\extensions\fileapi\assets;

use yii\web\AssetBundle;

/**
 * Пакет продвинутой загрузки.
 */
class FileAPIAdvancedAsset extends AssetBundle
{
	public $sourcePath = '@common/extensions/fileapi/assets';
	public $css = [
	    'css/advanced.css',
	];
	public $depends = [
	    'yii\web\YiiAsset',
	    'yii\bootstrap\BootstrapAsset',
		'common\extensions\fileapi\assets\FileAPIAsset'
	];
}