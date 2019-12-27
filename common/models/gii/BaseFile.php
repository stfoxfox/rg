<?php
namespace common\models\gii;

use Yii;
use yii\helpers\Html;
use common\models\PageBlockImage;
use common\models\PageBlock;
use common\components\MyExtensions\MyImagePublisher;

/**
 * Class BaseFile
 * @package common\models\gii
 *
 * @property integer $id
 * @property string $file_name
 * @property boolean $is_img
 * @property string $title
 * @property string $description
 * @property string $type
 * @property string $original_name
 * @property integer $sort
 * @property string $created_at
 * @property string $updated_at
 *
 * @property PageBlockImage[] $pageBlockImages
 * @property PageBlock[] $parents
 */
class BaseFile extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'file';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['file_name'], 'required'],
            [['is_img'], 'boolean'],
            [['description'], 'string'],
            [['sort'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['file_name', 'title', 'type', 'original_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file_name' => 'File Name',
            'is_img' => 'Is Img',
            'title' => 'Title',
            'description' => 'Description',
            'sort' => 'Sort',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPageBlockImages()
    {
        return $this->hasMany(PageBlockImage::className(), ['file_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParents()
    {
        return $this->hasMany(PageBlock::className(), ['id' => 'parent_id'])->viaTable('page_block_image', ['file_id' => 'id']);
    }

    /**
     * @param $realated_model_path
     * @param int $w
     * @param int $h
     * @param bool|false $fillBox
     * @return string
     */
    public function getResize($realated_model_path, $w = 512, $h = 512, $fillBox = false) {

        switch ($this->type) {
            case 'image/jpeg':
            case 'image/jpg':
            case 'image/pjpeg':
            case 'image/png':
                return (new MyImagePublisher($this))->resizeInBox($w, $h, $fillBox, 'file_name', $realated_model_path);

            case 'application/pdf':
                return Html::tag('i', '', ['class' => 'fa fa-file-pdf-o', 'style' => 'font-size: 135px'])
                    . Html::tag('p', $this->original_name);

            default:
                return Html::tag('i', '', ['class' => 'fa fa-file-text-o', 'style' => 'font-size: 135px'])
                    . Html::tag('p', $this->original_name);
        }
    }

    /**
     * @param $realated_model_path
     * @return string
     */
    public function getOriginal($realated_model_path) {

        switch ($this->type) {
            case 'image/jpeg':
            case 'image/jpg':
            case 'image/pjpeg':
            case 'image/png':
                return (new MyImagePublisher($this))->getOriginalImage('file_name', $realated_model_path);

            default:
                return (new MyImagePublisher($this))->getFileUrl('file_name', $realated_model_path);
        }
    }

    /**
     * @param $realated_model_path
     * @param int $w
     * @param int $h
     * @return string
     */
    public function getThumb($realated_model_path, $w = 100, $h = 100) {

        switch ($this->type) {
            case 'image/jpeg':
            case 'image/jpg':
            case 'image/pjpeg':
            case 'image/png':
                return (new MyImagePublisher($this))->MyThumbnail($w, $h, 'file_name', $realated_model_path);

            case 'application/pdf':
                return Html::tag('i', '', ['class' => 'fa fa-file-pdf-o', 'style' => 'font-size: 75px']);

            default:
                return Html::tag('i', '', ['class' => 'fa fa-file-text-o', 'style' => 'font-size: 75px']);
        }
    }

    /**
     * @param $realated_model_path
     * @param int $w
     * @param int $h
     * @return string
     */
    public function getThumbForFront($realated_model_path, $w = 100, $h = 100) {

        switch ($this->type) {
            case 'image/jpeg':
            case 'image/jpg':
            case 'image/pjpeg':
            case 'image/png':
                return (new MyImagePublisher($this))->MyThumbnail($w, $h, 'file_name', $realated_model_path);

            case 'application/pdf':
                return '<svg class="icon__icon-pdf" width="84px" height="85px"><use xlink:href="#icon-pdf"></use></svg>';

            default:
                return '<svg class="icon__icon-doc" width="84px" height="85px"><use xlink:href="#icon-doc"></use></svg>';
        }
    }
}
