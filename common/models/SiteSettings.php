<?php

namespace common\models;

use Yii;
use common\models\gii\BaseSiteSettings
;

/**
* This is the model class for table "site_settings".
*/
class SiteSettings extends BaseSiteSettings
{


    const SiteSettings_TypeText=1;
    const SiteSettings_TypeBool=2;
    const SiteSettings_TypeNumber=3;
    const SiteSettings_TypeFile=4;
    const SiteSettings_TypeImage=5;
    const SiteSettings_TypeString=6;
    const SiteSettings_TypeArray=7;
    const SiteSettings_TypeModel=21;


    public function uploadTo($attribute){

        if($this->$attribute)
            return \Yii::getAlias('@common')."/uploads/settings/{$this->$attribute}";
        else
            return null;


    }

    public function getEditableType(){

        switch ($this->type){


            case  self::SiteSettings_TypeBool:{

                return "boolean";
            }
            case self::SiteSettings_TypeString:
            {
                return "text";
            }
            case self::SiteSettings_TypeText:
            {
                return "textarea";
            }
                break;
            case self::SiteSettings_TypeNumber:
            {
                return "number";
            }
                break;
            default:
                return false;






        }



    }

    public function isBaseType(){


        switch ($this->type){


            case  self::SiteSettings_TypeBool:
            case self::SiteSettings_TypeString:
            case self::SiteSettings_TypeText:
            case self::SiteSettings_TypeNumber:
            {
                return true;
            }
                break;
            default:
                return false;






        }


    }

    public function getValue(){



        switch ($this->type){

            case self::SiteSettings_TypeArray:{

                return "Набор элементов, для просмотра перейдите в режим редактирования";
            }
                break;
            case  self::SiteSettings_TypeBool:{

                if ($this->bool_value){
                    return "Да";
                }else{

                    return "Нет";
                }
            }
                break;
            case self::SiteSettings_TypeString:
            {
                return $this->string_value;
            }
                break;
            case self::SiteSettings_TypeText:
            {
                return $this->text_value;
            }
                break;
            case self::SiteSettings_TypeNumber:
            {
                return $this->number_value;
            }
                break;
        }




    }

    /**
     * @return array|null
     */
    public static function getMailTransport(){
        $host = self::findOne(['text_key' => 'smtp_host']);
        if (!$host || !$host->string_value) {
            return null;
        }

        $username = self::findOne(['text_key' => 'smtp_username']);
        if (!$username || !$username->string_value) {
            return null;
        }

        $password = self::findOne(['text_key' => 'smtp_password']);
        if (!$password || !$password->string_value) {
            return null;
        }

        $port = self::findOne(['text_key' => 'smtp_port']);
        if (!$port || !$port->string_value) {
            return null;
        }

        $encryption = self::findOne(['text_key' => 'smtp_encryption']);
        if (!$encryption || !$encryption->string_value) {
            return null;
        }

        return [
            'class' => 'Swift_SmtpTransport',
            'host' => $host->string_value,
            'username' => $username->string_value,
            'password' => $password->string_value,
            'port' => $port->string_value,
            'encryption' => $encryption->string_value,
        ];
    }


}
