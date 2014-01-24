<?php
namespace backend\modules\blogs;

/**
 * Backend-модуль [[Blogs]]
 */
class Blogs extends \common\modules\blogs\Blogs
{
	/**
	 * @inheritdoc
	 */
	public $controllerNamespace = 'backend\modules\blogs\controllers';
}