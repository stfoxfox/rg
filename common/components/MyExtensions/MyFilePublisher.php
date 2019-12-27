<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 06/07/2017
 * Time: 15:32
 */

namespace common\components\MyExtensions;


class MyFilePublisher extends MyImagePublisher
{


    public function publishFile($file_atr=null){


        $filename = $this->getFilePath($file_atr);

        if(file_exists($filename)) {
            $image_path = $this->getPublishFolder();

            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $f_name = pathinfo($filename, PATHINFO_FILENAME);

            $newFileName = md5($f_name)."." . $ext;



            $file_path = \Yii::getAlias('@images_path' . $image_path . '/' . $newFileName);
            if (!file_exists($file_path)) {
                copy($filename,$file_path);
            }

            return  \Yii::$app->params['images_url'].$image_path.'/'.$newFileName;

        }


        return "";

    }



}