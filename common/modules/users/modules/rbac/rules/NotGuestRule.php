<?php

namespace common\modules\users\modules\rbac\rules;

use Yii;
use yii\rbac\Rule;

class NotGuestRule extends Rule
{
	/**
	 * @inheritdoc
	 */
	public $name = 'notGuestRule';

	/**
	 * @inheritdoc
	 */
    public function execute($user, $item, $params)
    {
        return !Yii::$app->user->isGuest;
    }
}
