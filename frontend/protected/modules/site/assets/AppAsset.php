<?php
namespace frontend\modules\site\assets;

use yii\web\AssetBundle;

/**
 * Менеджер ресурсов модуля [[Site]].
 */
class AppAsset extends AssetBundle
{
	public $sourcePath = '@frontend/modules/site/assets';
	public $css = [
		'css/main.css'
	];
	public $depends = [
		'yii\bootstrap\BootstrapAsset'
	];
}