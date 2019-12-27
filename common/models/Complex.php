<?php
namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use common\models\gii\BaseComplex;

/**
 * Class Complex
 * @package common\models
 *
 * @inheritdoc
 * @property Floor[] $floors
 */
class Complex extends BaseComplex
{
    const STATUS_DISABLED = 0;
    const STATUS_ENABLED = 1;

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
        return ArrayHelper::map(self::find()->all(), 'id', StringHelper::truncate('title', 70));
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'title' => 'Наименование',
            'min_price' => 'Мин цена',
            'max_price' => 'Макс цена',
            'min_area' => 'Мин площадь',
            'max_area' => 'Макс площадь',
            'external_id' => 'External ID',
            'is_active' => 'Статус',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFloors() {
        return $this->hasMany(Floor::className(), ['section_id' => 'id'])
            ->via('sections');
    }

    /**
     * @return array
     */
    public function getFloorList() {
        return ArrayHelper::map($this->getFloors()->distinct(['number'])
            ->where(['>', 'number', 0])
            ->orderBy(['number' => SORT_ASC])
            ->all(), 'number', 'number'
        );
    }
}
