<?php
namespace backend\modules\comments;

/**
 * Backend-модуль [[Comments]]
 */
class Comments extends \common\modules\comments\Comments
{
	/**
	 * @inheritdoc
	 */
	public $controllerNamespace = 'backend\modules\comments\controllers';
}