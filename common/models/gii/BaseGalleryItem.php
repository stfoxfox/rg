<?php
namespace common\models\gii;

use Yii;
use common\components\MyExtensions\MyActiveRecord;
use common\models\File;
use common\models\Gallery;
use common\models\Complex;

/**
 * Class BaseGalleryItem
 * @package common\models\gii
 *
 * @property integer $id
 * @property integer $file_id
 * @property integer $gallery_id
 * @property integer $sort
 * @property string $photo_date
 * @property integer $complex_id
 * @property integer $corpus_num
 * @property string $created_at
 * @property string $updated_at
 *
 * @property File $file
 * @property Gallery $gallery
 * @property Complex $complex
 */
class BaseGalleryItem extends MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'gallery_item';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['file_id', 'gallery_id', 'sort', 'complex_id', 'corpus_num'], 'integer'],
            [['created_at', 'updated_at', 'photo_date'], 'safe'],
            [['complex_id'], 'exist', 'skipOnError' => true, 'targetClass' => Complex::className(), 'targetAttribute' => ['complex_id' => 'id']],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['file_id' => 'id']],
            [['gallery_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gallery::className(), 'targetAttribute' => ['gallery_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'file_id' => 'Файл',
            'gallery_id' => 'Галерея',
            'sort' => 'Sort',
            'photo_date' => 'Дата фото',
            'complex_id' => 'Комплекс',
            'corpus_num' => '№ корпуса',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComplex() {
        return $this->hasOne(Complex::className(), ['id' => 'complex_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile() {
        return $this->hasOne(File::className(), ['id' => 'file_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGallery() {
        return $this->hasOne(Gallery::className(), ['id' => 'gallery_id']);
    }
}
