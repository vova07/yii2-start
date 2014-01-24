<?php
namespace common\extensions\fileapi\assets;

use yii\web\AssetBundle;

/**
 * Основной пакет виджета
 */
class FileAPIAsset extends AssetBundle
{
	public $sourcePath = '@common/extensions/fileapi/assets';
	public $js = [
	    'vendor/jquery.fileapi/FileAPI/FileAPI.min.js',
	    'vendor/jquery.fileapi/jquery.fileapi.min.js'
	];
	public $depends = [
		'yii\web\JqueryAsset',
	];
}