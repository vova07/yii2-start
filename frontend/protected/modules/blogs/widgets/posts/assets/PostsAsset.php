<?php
namespace frontend\modules\blogs\widgets\posts\assets;

use yii\web\AssetBundle;

/**
 * Менеджер ресурсов виджета последних постов [[Posts]].
 */
class PostsAsset extends AssetBundle
{
	public $sourcePath = '@frontend/modules/blogs/widgets/posts/assets';
	public $css = [
	    'css/posts.css'
	];
}