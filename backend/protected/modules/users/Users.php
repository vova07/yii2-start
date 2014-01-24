<?php
namespace backend\modules\users;

/**
 * Backend-модуль [[Users]]
 */
class Users extends \common\modules\users\Users
{
	/**
	 * @inheritdoc
	 */
	public $controllerNamespace = 'backend\modules\users\controllers';
}