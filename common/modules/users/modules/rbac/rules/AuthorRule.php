<?php 

namespace common\modules\users\modules\rbac\rules;

use yii\rbac\Rule;

class AuthorRule extends Rule
{
    public function execute($params, $data)
    {
        return $params['userId'] === $data['model']['author_id'];
    }
}
