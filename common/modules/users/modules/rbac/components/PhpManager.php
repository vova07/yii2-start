<?php 
namespace common\modules\users\modules\rbac\components;

use Yii;

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
        if (!Yii::$app->user->isGuest) {
            $this->assign(Yii::$app->user->identity->id, Yii::$app->user->identity->role_id);
        }
    }
}