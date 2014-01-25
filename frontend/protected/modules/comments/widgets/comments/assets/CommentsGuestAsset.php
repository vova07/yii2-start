<?php
namespace frontend\modules\comments\widgets\comments\assets;

use yii\web\AssetBundle;

/**
 * Менеджер ресурсов виджета комментариев [[Comments]].
 */
class CommentsGuestAsset extends AssetBundle
{
	public $sourcePath = '@frontend/modules/comments/widgets/comments/assets';
	public $css = [
	    'css/comments.css'
	];
}