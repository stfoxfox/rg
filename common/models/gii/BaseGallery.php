<?php
namespace common\models\gii;

use Yii;
use common\components\MyExtensions\MyActiveRecord;
use common\models\GalleryItem;

/**
 * Class BaseGallery
 * @package common\models\gii
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $type
 * @property string $created_at
 * @property string $updated_at
 *
 * @property GalleryItem[] $galleryItems
 */
class BaseGallery extends MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'gallery';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['description'], 'string'],
            [['type'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'description' => 'Описание',
            'type' => 'Тип',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGalleryItems() {
        return $this->hasMany(GalleryItem::className(), ['gallery_id' => 'id']);
    }
}
