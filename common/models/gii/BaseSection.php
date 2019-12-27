<?php
namespace common\models\gii;

use Yii;
use common\components\MyExtensions\MyActiveRecord;
use common\models\Complex;
use common\models\Floor;

/**
 * Class BaseSection
 * @package common\models\gii
 *
 * @property integer $id
 * @property string $number
 * @property string $corpus_num
 * @property integer $floors_count
 * @property string $quarter
 * @property integer $status
 * @property string $series
 * @property string $decoration
 * @property integer $complex_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Floor[] $floors
 * @property Complex $complex
 */
class BaseSection extends MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'section';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['floors_count', 'status', 'complex_id'], 'integer'],
            ['number', 'string', 'max' => 50],
            [['complex_id'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['quarter', 'series', 'decoration', 'corpus_num'], 'string', 'max' => 255],
            [['complex_id'], 'exist', 'skipOnError' => true, 'targetClass' => Complex::className(), 'targetAttribute' => ['complex_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'number' => 'Номер',
            'corpus_num' => '№ корпуса',
            'floors_count' => 'Количесвто этажей',
            'quarter' => 'Квартал',
            'status' => 'Статус',
            'series' => 'Серия',
            'decoration' => 'Оформление',
            'complex_id' => 'Комплекс',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFloors() {
        return $this->hasMany(Floor::className(), ['section_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComplex() {
        return $this->hasOne(Complex::className(), ['id' => 'complex_id']);
    }
}
