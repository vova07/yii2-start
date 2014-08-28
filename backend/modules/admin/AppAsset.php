<?php

namespace backend\modules\admin;

use yii\web\AssetBundle;

/**
 * Backend app asset.
 */
class AppAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@backend/modules/admin/assets';

    /**
     * @inheritdoc
     */
	public $css = [
		'css/style.css'
	];

    /**
     * @inheritdoc
     */
	public $depends = [
		'yii\bootstrap\BootstrapAsset'
	];
}
