<?php
namespace backend\modules\admin\assets;

use yii\web\AssetBundle;

/**
 * Менеджер ресурсов
 */
class AppAsset extends AssetBundle
{
	public $sourcePath = '@backend/modules/admin/assets';
	public $css = [
		'css/style.css'
	];
	public $depends = [
		'yii\bootstrap\BootstrapAsset'
	];
	public $publishOptions = [
	    'forceCopy' => true
	];
}