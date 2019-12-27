<?php
namespace common\models\gii;

use Yii;
use common\models\Doc;
use common\models\FloorPlan;
use common\models\GalleryItem;
use common\models\Section;

/**
 * This is the model class for table "complex".
 * Class BaseComplex
 * @package common\models\gii
 *
 * @property integer $id
 * @property string $title
 * @property double $min_price
 * @property double $max_price
 * @property double $max_area
 * @property string $external_id
 * @property string $created_at
 * @property string $updated_at
 * @property double $min_area
 * @property integer $is_active
 *
 * @property Doc[] $docs
 * @property FloorPlan[] $floorPlans
 * @property GalleryItem[] $galleryItems
 * @property Section[] $sections
 */
class BaseComplex extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'complex';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['min_price', 'max_price', 'max_area', 'min_area'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['is_active'], 'integer'],
            [['title', 'external_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'min_price' => 'Min Price',
            'max_price' => 'Max Price',
            'max_area' => 'Max Area',
            'external_id' => 'External ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'min_area' => 'Min Area',
            'is_active' => 'Is Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocs()
    {
        return $this->hasMany(Doc::className(), ['complex_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFloorPlans()
    {
        return $this->hasMany(FloorPlan::className(), ['complex_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGalleryItems()
    {
        return $this->hasMany(GalleryItem::className(), ['complex_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSections()
    {
        return $this->hasMany(Section::className(), ['complex_id' => 'id']);
    }
}
