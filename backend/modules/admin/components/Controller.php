<?php

namespace backend\modules\admin\components;

use yii\filters\AccessControl;

/**
 * Main backend controller.
 */
class Controller extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['superadmin', 'admin']
                    ]
                ]
            ]
        ];
    }
}
