<?php
namespace common\extensions\fileapi\assets;

use yii\web\AssetBundle;

/**
 * Пакет загрузки аватар-а
 */
class FileAPIAvatarAsset extends AssetBundle
{
	public $sourcePath = '@common/extensions/fileapi/assets';
	public $css = [
	    'css/avatar.css',
	    'vendor/jquery.fileapi/the-modal/the-modal.css',
	    'vendor/jquery.fileapi/jcrop/jquery.Jcrop.min.css'
	];
	public $js = [
	    'vendor/jquery.fileapi/jcrop/jquery.Jcrop.min.js',
	    'vendor/jquery.fileapi/the-modal/jquery.modal.js'
	];
	public $depends = [
		'common\extensions\fileapi\assets\FileAPIAsset',
		'yii\bootstrap\BootstrapAsset'
	];
}