<?php
namespace frontend\modules\comments\widgets\comments\assets;

use yii\web\AssetBundle;

/**
 * Менеджер ресурсов виджета комментариев [[Comments]].
 */
class CommentsAsset extends AssetBundle
{
	public $sourcePath = '@frontend/modules/comments/widgets/comments/assets';
	public $js = [
		'js/comments.js'
	];
	public $depends = [
	    'frontend\modules\comments\widgets\comments\assets\CommentsGuestAsset',
		'yii\web\JqueryAsset'
	];
}