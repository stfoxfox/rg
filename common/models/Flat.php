<?php
namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use common\models\gii\BaseFlat;

/**
 * Class Flat
 * @package common\models
 * @inheritdoc
 *
 * @property Section $section
 * @property Complex $complex
 */
class Flat extends BaseFlat
{
    const STATUS_SOLD = 2;
    const STATUS_RESERVED = 1;
    const STATUS_ENABLED = 0;

    const FEATURE_EURO = 'Квартира европейского формата';
    const DECORATION_CLASSIC = 'Классика';

    /** @var array */
    static $flat_status_class = [
        self::STATUS_ENABLED => 'success-element',
        self::STATUS_RESERVED => 'warning-element',
        self::STATUS_SOLD => 'danger-element',
    ];

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
            'type' => 'Тип',
            'number' => 'Номер',
            'rooms_count' => 'Количество комнат',
            'total_area' => 'Общая площадь',
            'live_area' => 'Жилая площадь',
            'kitchen_area' => 'Площадь кухни',
            'currency' => 'Currency',
            'price' => 'Цена',
            'sale_price' => 'Цена со скидкой',
            'total_price' => 'Общая стоимость',
            'status' => 'Статус',
            'number_on_floor' => 'Номер на этаже',
            'binding' => 'Акция',
            'garage' => 'Гараж',
            'decoration' => 'Внутренняя отделка',
            'furniture' => 'Мебель',
            'features' => 'Особенности',
            'object_id' => 'Object ID',
            'external_id' => 'External ID',
            'floor_id' => 'Этаж',
            'floor_plan_id' => 'Планировка',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return string
     */
    public function getStatusLabelClass() {
        return self::$flat_status_class[$this->status];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSection() {
        return $this->hasOne(Section::className(), ['id' => 'section_id'])
            ->via('floor');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComplex() {
        return $this->hasOne(Complex::className(), ['id' => 'complex_id'])
            ->via('section');
    }

    /**
     * @param $complex_id
     * @return Flat[]
     */
    public static function getThree($complex_id) {
        return self::find()->innerJoinWith('section sec')->andWhere(['sec.complex_id' => $complex_id])
            ->andWhere(['flat.status' => self::STATUS_ENABLED])->with('floorPlan')->limit(3)->all();
    }
}
