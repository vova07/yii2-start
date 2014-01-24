<?php
namespace common\extensions\fileapi\assets;

use yii\web\AssetBundle;

/**
 * Пакет одиночной загрузки
 */
class FileAPISingleAsset extends AssetBundle
{
	public $sourcePath = '@common/extensions/fileapi/assets';
	public $css = [
	    'css/single.css'
	];
	public $depends = [
		'common\extensions\fileapi\assets\FileAPIAsset'
	];
}