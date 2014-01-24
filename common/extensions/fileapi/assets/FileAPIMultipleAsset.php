<?php
namespace common\extensions\fileapi\assets;

use yii\web\AssetBundle;

/**
 * Пакет мульти-загрузки
 */
class FileAPIMultipleAsset extends AssetBundle
{
	public $sourcePath = '@common/extensions/fileapi/assets';
	public $css = [
	    'css/multiple.css'
	];
	public $depends = [
		'common\extensions\fileapi\assets\FileAPIAsset'
	];
}