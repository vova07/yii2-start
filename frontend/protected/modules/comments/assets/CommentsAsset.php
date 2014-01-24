<?php
namespace frontend\modules\comments\assets;

use yii\web\AssetBundle;

/**
 * Менеджер ресурсов модуля [[Comments]]
 */
class CommentsAsset extends AssetBundle
{
	public $sourcePath = '@frontend/modules/comments/assets';
	public $js = [
		'js/comments.js'
	];
}