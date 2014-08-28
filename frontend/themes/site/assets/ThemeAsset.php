<?php

namespace frontend\themes\site\assets;

use yii\web\AssetBundle;

/**
 * Theme main asset bundle.
 */
class ThemeAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@frontend/themes/site';

    /**
     * @inheritdoc
     */
    public $css = [
        'css/font-awesome.min.css',
        'css/main.css'
    ];

    public $js = [];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset'
    ];
}
