<?php
/**
 * Created by PhpStorm.
 * User: abpopov
 * Date: 01.08.15
 * Time: 20:00
 */

namespace common\components\MyExtensions;

use Imagine\Image\Box;
use Imagine\Image\Point;
use yii\helpers\FileHelper;
use yii\imagine\Image;


use yii\helpers\Url;
use Imagine\Image\Color;

class MyImagePublisher{


    const BY_SIDE_WIDTH=0;
    const BY_SIDE_HEIGHT=1;
    const BY_SIDE_WO=2;


    const BOX_TYPE_FILL=0;
    const BOX_TYPE_INSIDE=1;
    const BOX_TYPE_WO=2;
    const BOX_TYPE_OUTSIDE=3;

    public $model;


    /**
     * @param null $model
     */
    function __construct($model=null) {

        if(isset($model))
         $this->model=$model;
    }


    public function getPublishFolder(){



        try{

           if($folder=  $this->model->getFileFolder())
               return $folder;
            else
                return '/files/temporary';

        }
        catch(\Exception $e){

            return '/files/temporary';
        }





    }

    public function getFilePath($file_atr=null, $realated_model_path = null){

        if(isset($file_atr))
        {
            if(!empty($realated_model_path)){
                return $this->model->uploadTo($realated_model_path,$file_atr);
            }
            return $this->model->uploadTo($file_atr);
        }

        else
            return $this->model->uploadTo('file_name');


    }



    public function thumbnail( $width, $height,$file_atr=null,$related_model_path = null){


        $filename = $this->getFilePath($file_atr,$related_model_path);

        if(file_exists($filename)) {
            $image_path = $this->getPublishFolder();

            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $f_name = pathinfo($filename, PATHINFO_FILENAME);

            $newFileName = md5($f_name) . "_thumb_" . $width . "_" . $height . "." . $ext;
            if (!file_exists(\Yii::getAlias('@images_path' . $image_path . '/' . $newFileName))) {
                Image::thumbnail($filename, $width, $height)
                    ->save(MyFileSystem::makeDirs(\Yii::getAlias('@images_path' . $image_path . '/' . $newFileName)), ['quality' => 70]);
            }

            return  \Yii::$app->params['images_url'].$image_path.'/'.$newFileName;

        }


            return "";
    }


    public function flushCache(){

        $image_path = $this->getPublishFolder();


        self::deleteDir(\Yii::getAlias('@images_path' . $image_path));
        self::deleteDir(\Yii::getAlias('@original_images_path' . $image_path));


    }

    public function MyThumbnail( $width, $height,$file_atr=null,$realated_model_path = null){


        $filename = $this->getFilePath($file_atr, $realated_model_path);

        if(file_exists($filename)) {
            $image_path = $this->getPublishFolder();

            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $f_name = pathinfo($filename, PATHINFO_FILENAME);

            $newFileName = md5($f_name) . "_thumb_" . $width . "_" . $height . "." . $ext;
            if (!file_exists(\Yii::getAlias('@images_path' . $image_path . '/' . $newFileName))) {
                self::thumb($filename, $width, $height)
                    ->save(MyFileSystem::makeDirs(\Yii::getAlias('@images_path' . $image_path . '/' . $newFileName)), ['quality' => 70]);
            }

            return  \Yii::$app->params['images_url'].$image_path.'/'.$newFileName;

        }


        return '';
    }

    public function getOriginalImage($file_atr=null,$realated_model_path = null){


        $filename = $this->getFilePath($file_atr,$realated_model_path);

        $image_path = $this->getPublishFolder();

        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $f_name = pathinfo($filename, PATHINFO_FILENAME);


        $imagine = Image::getImagine();


        $img = $imagine->open(\Yii::getAlias($filename));

        $img_width=$img->getSize()->getWidth();
        $img_height=$img->getSize()->getHeight();


        $box= new Box(ceil($img_width),ceil($img_height));


        $newFileName = md5( $f_name )."_resize_".$box->getWidth()."_".$box->getHeight().".".$ext;
        if ( !file_exists( \Yii::getAlias('@original_images_path' . $image_path . '/' . $newFileName) ) ) {
            $img->resize($box)
                ->save(MyFileSystem::makeDirs(\Yii::getAlias('@original_images_path' . $image_path . '/' . $newFileName)), ['quality' => 70]);

        }
        return  \Yii::$app->params['original_images_url'].$image_path.'/'.$newFileName;



    }

    public function resizeInBox($width,$height,$fillBox=false,$file_atr=null,$related_model_path = null){

        $filename = $this->getFilePath($file_atr,$related_model_path);
        if (!file_exists($filename))
            return '';

        $image_path = $this->getPublishFolder();

        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $f_name = pathinfo($filename, PATHINFO_FILENAME);

        $newFileName = md5( $f_name )."_resize_in_box_".$width."_".$height.".".$ext;




        if ( !file_exists( \Yii::getAlias('@images_path' . $image_path . '/' . $newFileName) ) ) {

            $imagine = Image::getImagine();
            $img = $imagine->open(\Yii::getAlias($filename));
            
            if($fillBox){

                $box= static::getBoxInBox($img,$width,$height,self::BOX_TYPE_FILL);

            }
            else{

                $box= static::getBoxInBox($img,$width,$height);

            }



            $img->resize($box)
                ->save(MyFileSystem::makeDirs(\Yii::getAlias('@images_path' . $image_path . '/' . $newFileName)), ['quality' => 70]);




        }







        return  \Yii::$app->params['images_url'].$image_path.'/'.$newFileName;


    }

    /**
     * @param null $file_atr
     * @param null $realated_model_path
     * @return string
     */
    public function getFileUrl($file_atr=null, $realated_model_path = null) {

        $filename = $this->getFilePath($file_atr,$realated_model_path);
        $path = $this->getPublishFolder();

        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $f_name = pathinfo($filename, PATHINFO_FILENAME);

        $newFileName = md5( $f_name ).".".$ext;
        $newPath = \Yii::getAlias('@images_path' . $path . '/' . $newFileName);
        if ( !file_exists($newPath) ) {
            copy($filename, $newPath);
        }

        return  \Yii::$app->params['images_url'].$path.'/'.$newFileName;
    }

    /** @param \Imagine\Image\ImageInterface  $img*/

    protected static function  getImgBox($img,$width,$height,$bySide,$boxType){
        $img_width=$img->getSize()->getWidth();
        $img_height=$img->getSize()->getHeight();
        $newWidth =0;
        $newHeight=0;

        switch($boxType){
            case self::BOX_TYPE_FILL:
            {
                $newWidth=$width;
                $newHeight=$height;
            }
                break;
            case self::BOX_TYPE_WO:{

                if($bySide==self::BY_SIDE_WIDTH) {

                    $newWidth = $width;
                    $newHeight = $img_height * $newWidth / $img_width;
                }

                if($bySide==self::BY_SIDE_HEIGHT){
                    $newHeight=$height;
                    $newWidth = $img_width*$newHeight/$img_height;
                }


            }
                break;

            case self::BOX_TYPE_INSIDE:{

                $newWidth = $width;
                $newHeight = $img_height * $newWidth / $img_width;

                if($newHeight>=$height){
                    $newHeight=$height;
                    $newWidth = $img_width*$newHeight/$img_height;
                }

            }
            break;

            case self::BOX_TYPE_OUTSIDE:{

                $newWidth = $width;
                $newHeight = $img_height * $newWidth / $img_width;

                if($newHeight<=$height){
                    $newHeight=$height;
                    $newWidth = $img_width*$newHeight/$img_height;
                }

            }

        }


        if($newHeight!=0 && $newWidth!=0){
            return new Box(ceil($newWidth),ceil($newHeight));

        }
        else
            return null;

    }

    protected static function getBoxByWidth($img,$width){

        return static::getImgBox($img,$width,10,self::BY_SIDE_WIDTH,self::BOX_TYPE_WO);
    }

    protected  static function getBoxByHeight($img,$height){
        return static::getImgBox($img,10,$height,self::BY_SIDE_HEIGHT,self::BOX_TYPE_WO);
    }

    protected static function  getBoxInBox($img,$width,$height,$fillBox=self::BOX_TYPE_INSIDE){

        return static::getImgBox($img,$width,$height,self::BY_SIDE_WO,$fillBox);

    }

    protected static function deleteDir($dirPath) {
        if (! is_dir($dirPath)) {
           // throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }

    protected static function thumb($filename, $width, $height)
    {
        $thumbBox = new Box($width, $height);
        $img = Image::getImagine()->open(\Yii::getAlias($filename));

        $box= self::getImgBox($img,$width,$height,self::BY_SIDE_WO,self::BOX_TYPE_OUTSIDE);
        $img->resize($box);


        // calculate points
        $size = $img->getSize();

        $startX = 0;
        $startY = 0;
        if ($size->getWidth() > $width) {
            $startX = ceil($size->getWidth() - $width ) / 2;
        }
        if ($size->getHeight() > $height) {
            $startY = ceil($size->getHeight() - $height) / 2;
        }

        $img->crop(new Point($startX, $startY),$thumbBox );

        return $img;
    }



} 