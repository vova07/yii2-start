<?php

namespace common\modules\users\modules\rbac\rules;

use yii\rbac\Rule;

class AuthorRule extends Rule
{
	/**
	 * @inheritdoc
	 */
	public $name = 'author';

	/**
	 * @inheritdoc
	 */
    public function execute($user, $item, $params)
    {
        return isset($params['model']) ? $params['model']['author_id'] == $user : false;
    }
}
