<?php
namespace backend\modules\admin\assets;

use yii\web\AssetBundle;

/**
 * Менеджер ресурсов backend-модуля [[Admin]]
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
}