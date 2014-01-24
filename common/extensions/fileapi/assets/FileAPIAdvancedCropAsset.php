<?php
namespace common\extensions\fileapi\assets;

use yii\web\AssetBundle;

/**
 * Пакет продвинутой загрузки файла с предварительной нарезкой.
 */
class FileAPIAdvancedCropAsset extends AssetBundle
{
	public $sourcePath = '@common/extensions/fileapi/assets';
	public $css = [
	    'vendor/jquery.fileapi/the-modal/the-modal.css',
	    'vendor/jquery.fileapi/jcrop/jquery.Jcrop.min.css'
	];
	public $js = [
	    'vendor/jquery.fileapi/jcrop/jquery.Jcrop.min.js',
	    'vendor/jquery.fileapi/the-modal/jquery.modal.js'
	];
	public $depends = [
		'common\extensions\fileapi\assets\FileAPIAdvancedAsset',
	];
}