<?php
namespace common\models\gii;

use Yii;
use common\models\Feedback;
use common\models\Floor;
use common\models\FloorPlan;

/**
 * This is the model class for table "flat".
 * Class BaseFlat
 * @package common\models\gii
 *
 * @property integer $id
 * @property integer $type
 * @property string $number
 * @property integer $rooms_count
 * @property double $total_area
 * @property double $live_area
 * @property double $kitchen_area
 * @property integer $currency
 * @property double $price
 * @property double $sale_price
 * @property double $total_price
 * @property integer $status
 * @property integer $number_on_floor
 * @property string $binding
 * @property boolean $garage
 * @property boolean $furniture
 * @property string $object_id
 * @property string $external_id
 * @property integer $floor_id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $floor_plan_id
 * @property string $decoration
 * @property string $features
 *
 * @property Feedback[] $feedbacks
 * @property Floor $floor
 * @property FloorPlan $floorPlan
 */
class BaseFlat extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'flat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'rooms_count', 'currency', 'status', 'number_on_floor', 'floor_id', 'floor_plan_id'], 'integer'],
            [['total_area', 'live_area', 'kitchen_area', 'price', 'sale_price', 'total_price'], 'number'],
            [['garage', 'furniture'], 'boolean'],
            [['floor_id'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['decoration', 'features'], 'string'],
            [['number'], 'string', 'max' => 50],
            [['binding', 'object_id', 'external_id'], 'string', 'max' => 255],
            [['floor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Floor::className(), 'targetAttribute' => ['floor_id' => 'id']],
            [['floor_plan_id'], 'exist', 'skipOnError' => true, 'targetClass' => FloorPlan::className(), 'targetAttribute' => ['floor_plan_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'number' => 'Number',
            'rooms_count' => 'Rooms Count',
            'total_area' => 'Total Area',
            'live_area' => 'Live Area',
            'kitchen_area' => 'Kitchen Area',
            'currency' => 'Currency',
            'price' => 'Price',
            'sale_price' => 'Sale Price',
            'total_price' => 'Total Price',
            'status' => 'Status',
            'number_on_floor' => 'Number On Floor',
            'binding' => 'Binding',
            'garage' => 'Garage',
            'furniture' => 'Furniture',
            'object_id' => 'Object ID',
            'external_id' => 'External ID',
            'floor_id' => 'Floor ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'floor_plan_id' => 'Floor Plan ID',
            'decoration' => 'Decoration',
            'features' => 'Features',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeedbacks()
    {
        return $this->hasMany(Feedback::className(), ['flat_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFloor()
    {
        return $this->hasOne(Floor::className(), ['id' => 'floor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFloorPlan()
    {
        return $this->hasOne(FloorPlan::className(), ['id' => 'floor_plan_id']);
    }
}
