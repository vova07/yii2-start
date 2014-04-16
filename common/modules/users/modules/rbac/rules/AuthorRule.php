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
    public function execute($item, $params)
    {
        return $params['user'] === $params['model']['author_id'];
    }
}
