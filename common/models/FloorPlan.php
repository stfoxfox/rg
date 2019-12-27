<?php
namespace common\models;

use Yii;
use common\models\gii\BaseFloorPlan;
use yii\helpers\ArrayHelper;

/**
* This is the model class for table "floor_plan".
* Class FloorPlan
* @package common\models
* @inheritdoc
*/
class FloorPlan extends BaseFloorPlan
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
        return ArrayHelper::map(self::find()->all(), 'id', 'external_id');
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'corpus_num' => 'Номер корпуса',
            'section_num' => 'Номер секции',
            'floor_num_starts' => 'Этаж от',
            'floor_num_ends' => 'Этаж до',
            'number_on_floor' => 'Номер на этаже',
            'external_id' => 'External ID',
            'file_id' => 'Планировка',
            'complex_id' => 'Комплекс',
        ];
    }
}
