<?php
namespace console\controllers;

use common\models\BackendUser;
use Yii;
use yii\console\Controller;

class RbacController extends Controller
{



    public function actionInit()
    {

        $adminUser= new BackendUser();

        $adminUser->username = "admin";
        $adminUser->email = "admin@site.ru";
        $adminUser->setPassword("123123123");
        $adminUser->generateAuthKey();
        if ($adminUser->save()) {

            $auth = Yii::$app->authManager;
            $admin = $auth->createRole('admin');
            $auth->add($admin);
            $auth->assign($admin, $adminUser->id);
        }
        else
            print_r($adminUser->getErrors());

    }





}