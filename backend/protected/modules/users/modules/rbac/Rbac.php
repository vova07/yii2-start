<?php
namespace backend\modules\users\modules\rbac;

/**
 * Backend-модуль [[RBAC]]
 */
class Rbac extends \common\modules\users\modules\rbac\Rbac
{
	/**
	 * @inheritdoc
	 */
	public $controllerNamespace = 'backend\modules\users\modules\rbac\controllers';
}