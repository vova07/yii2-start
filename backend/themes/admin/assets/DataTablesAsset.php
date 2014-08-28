<?php

namespace backend\themes\admin\assets;

use yii\web\AssetBundle;

/**
 * Theme data tables asset bundle.
 */
class DataTablesAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@backend/themes/admin';

    /**
     * @inheritdoc
     */
    public $css = [
        'css/datatables/dataTables.bootstrap.css'
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'backend\themes\admin\assets\ThemeAsset'
    ];
}
