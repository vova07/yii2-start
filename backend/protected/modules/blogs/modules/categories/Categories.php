<?php
namespace backend\modules\blogs\modules\categories;

/**
 * Backend-модуль [[Categories]]
 */
class Categories extends \common\modules\blogs\modules\categories\Categories
{
	/**
	 * @inheritdoc
	 */
	public $controllerNamespace = 'backend\modules\blogs\modules\categories\controllers';
}