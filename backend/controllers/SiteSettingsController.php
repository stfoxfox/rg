<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 08/06/2017
 * Time: 15:50
 */

namespace backend\controllers;


use common\components\controllers\BackendController;
use common\models\SiteSettings;

use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

class SiteSettingsController extends BackendController
{


//    public function behaviors()
//    {
//        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'rules' => [
//
//                    [
//
////                        'allow' => true,
////                        'roles' => ['admin'],
//                    ],
//                ],
//            ],
//        ];
//    }



    public function actions()
    {
        return array(


            'edit' => [


                'class' => 'common\components\actions\Edit',
                '_editForm' => 'backend\models\forms\SiteSettingsForm',
                '_model' => SiteSettings::className() ,



            ],

        );
    }

    public function actionIndex(){


        $this->setTitleAndBreadcrumbs("Настройки сайта");





        $settings = SiteSettings::find()->where('parent_id is null')->orderBy('id')->all();


        return $this->render('index',['settings'=>$settings]);
    }


    public function actionItemEdit(){





        $pk = \Yii::$app->request->post('pk');
        $value = \Yii::$app->request->post('value');

        if ($item = SiteSettings::findOne($pk)){


                switch ($item->type){

                    case SiteSettings::SiteSettings_TypeString:{

                        $item->string_value= $value;



                    }
                    break;
                    case SiteSettings::SiteSettings_TypeText:{

                        $item->text_value=$value;
                    }
                    break;
                    case SiteSettings::SiteSettings_TypeNumber:{

                        $item->number_value=$value;
                    }
                    break;
                    case SiteSettings::SiteSettings_TypeBool:
                    {

                    }
                    break;


                }


                $item->save();

                return $this->sendJSONResponse(['success'=>true]);

        }

        throw  new NotFoundHttpException('Элемент не найден');



    }
}