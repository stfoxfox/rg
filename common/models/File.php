<?php
namespace common\models;

use Yii;
use common\models\gii\BaseFile;
use yii\imagine\Image;
use yii\web\UploadedFile;
use common\components\MyExtensions\MyFileSystem;

/**
 * Class File
 * @package common\models
 *
 * @inheritdoc
 */
class File extends BaseFile
{
    public function uploadTo($related_model_path,$attribute){
        if($related_model_path && $this->$attribute)
            return \Yii::getAlias('@common') . "/uploads/{$related_model_path}/{$this->$attribute}";
        else
            return null;
    }


    /**
     * @param  UploadedFile $upload_data
     * @param $related_model_path
     * @param null $file_id
     * @param null $x
     * @param null $y
     * @param null $h
     * @param null $w
     * @param bool $is_image
     * @return int|null
     */
    public static function saveFile($upload_data,$related_model_path,$file_id=null,$x=null,$y=null,$h=null,$w=null,$is_image=true) {
        if (!$upload_data) {
            return null;
        }

        $file = null;
        $oldFileName = false;
        $cropImage = false;

        if (isset($file_id)) {
            $file = self::findOne($file_id);
        }

        if (!$file) {
            $file= new self();
        } else {
            $oldFileName = $file->uploadTo($related_model_path,'file_name');
        }

        $file->file_name = uniqid() . "_" . md5($upload_data->name) . "." . $upload_data->extension;
        $file->original_name = $upload_data->name;
        $file->type = $upload_data->type;
        $file->sort = -1;

        switch ($upload_data->type) {
            case 'image/jpeg':
            case 'image/jpg':
            case 'image/pjpeg':
            case 'image/png':
                $file->is_img = true;
                break;

            default:
                $file->is_img = null;
                break;
        }

        if (isset($x)&&isset($y)&&isset($w)&&isset($h)&& $x>=0&& $y>=0&& $h>0&& $w>0 && $file->is_img) {
            $cropImage = Image::crop($upload_data->tempName,intval($w),intval($h),[intval($x),intval($y)]);
        }

        if ($file->save()) {
            if ($oldFileName){
                unlink($oldFileName);
            }

            if ($cropImage) {
                $cropImage->save(MyFileSystem::makeDirs($file->uploadTo($related_model_path,'file_name')));
            } else {
                $upload_data->saveAs(MyFileSystem::makeDirs($file->uploadTo($related_model_path,'file_name')));
            }

            return $file->id;
        }

        return null;
    }
}
