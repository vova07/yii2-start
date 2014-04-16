<?php
namespace common\modules\users\modules\rbac\components;

use Yii;
use yii\rbac\Role;

/**
 * Файловый компонент модуля [[RBAC]]
 */
class PhpManager extends \yii\rbac\PhpManager
{
	/**
	 * @inheritdoc
	 */
	public $authFile = '@common/modules/users/modules/rbac/data/rbac.php';

	/**
	 * @inheritdoc
	 */
    public function init()
    {
        parent::init();

        $user = Yii::$app->getUser();
        if (!$user->isGuest) {
            $identity = $user->getIdentity();
            if (!$this->getAssignment($identity->role_id, $identity->getId())) {
                $role = new Role([
                    'name' => $identity->role_id
                ]);
                $this->assign($role, $identity->getId());
            }
        }
    }
}