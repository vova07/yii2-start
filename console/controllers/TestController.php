<?php

namespace console\controllers;

class TestController extends \yii\console\Controller
{
    public function actionIndex()
    {
        // echo "work \n";
        // mail('test@test.com', 'Subject', 'Message');
        \Module::warning('Work send');
    }
}
