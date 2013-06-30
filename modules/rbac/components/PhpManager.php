<?php 
namespace app\modules\rbac\components;

use Yii;

class PhpManager extends \yii\rbac\PhpManager
{
    public function init()
    {
        if ($this->authFile === NULL)
            $this->authFile = Yii::getAlias('@app/modules/rbac/components/rbac') . '.php';
 
        parent::init();
 
        if (!Yii::$app->user->isGuest)
            $this->assign(Yii::$app->user->identity->id, Yii::$app->user->identity->role);
    }
}