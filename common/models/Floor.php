<?php
namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use common\models\gii\BaseFloor;

/**
 * Class Floor
 * @package common\models
 * @inheritdoc
 *
 * @property Complex $complex
 * @property FloorPlan[] $floorPlans
 */
class Floor extends BaseFloor
{
    /**
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return array
     */
    public static function getList() {
        return ArrayHelper::map(self::find()->all(), 'id', 'number');
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'number' => 'Номер',
            'flats_count' => 'Количество квартир',
            'section_id' => 'Секция',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComplex() {
        return $this->hasOne(Complex::className(), ['id' => 'complex_id'])->via('section');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFloorPlans() {
        return $this->hasMany(FloorPlan::className(), ['complex_id' => 'id'])->via('complex');
    }

    /**
     * @return array
     */
    public function getFloorPlanList() {
        return ArrayHelper::map($this->floorPlans, 'id', 'external_id');
    }
}
