<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 07/06/2017
 * Time: 00:29
 */

namespace console\controllers;


use common\models\Page;
use common\models\SiteSettings;
use yii\console\Controller;

class SettingsController extends Controller
{




    public function actionGenerateMainPage(){


        $page= new Page();
        $page->is_index_page=true;
        $page->title ="Главная страница";
        $page->slug ="index";

        $page->save();

        print_r($page->getErrors());

    }

    public function actionInitCreate(){



        $mainHeader = new SiteSettings();
        $mainHeader->title = "Email администратора";
        $mainHeader->text_key="adminEmail";
        $mainHeader->type=SiteSettings::SiteSettings_TypeString;
        $mainHeader->sort=1;
        $mainHeader->string_value= $mainHeader->title;
        $mainHeader->save();


        $mainHeader = new SiteSettings();
        $mainHeader->title = "Email администратора";
        $mainHeader->text_key="adminEmail";
        $mainHeader->type=SiteSettings::SiteSettings_TypeText;
        $mainHeader->sort=1;
        $mainHeader->string_value= $mainHeader->title;
        $mainHeader->save();

        $mainHeader = new SiteSettings();
        $mainHeader->title = "Email администратора";
        $mainHeader->text_key="adminEmail";
        $mainHeader->type=SiteSettings::SiteSettings_TypeImage;
        $mainHeader->sort=1;
        $mainHeader->string_value= $mainHeader->title;
        $mainHeader->save();

        $mainHeader = new SiteSettings();
        $mainHeader->title = "Email администратора";
        $mainHeader->text_key="adminEmail";
        $mainHeader->type=SiteSettings::SiteSettings_TypeNumber;
        $mainHeader->sort=1;
        $mainHeader->string_value= $mainHeader->title;
        $mainHeader->save();





    }


    public function actionList(){

        /**
         * @var SiteSettings[] $settings
         */
        $settings = SiteSettings::find()->where('parent_id is null')->all();

        foreach ($settings as $var){

            echo "ID: ".$var->id." | KEY: ".$var->text_key." | ".$var->title."\n";
        }



    }

    public function actionAdd(){


    }

    public  function actionDrop(){


        SiteSettings::deleteAll();

    }
}