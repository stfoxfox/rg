<?php
namespace common\models\gii;

use Yii;
use common\components\MyExtensions\MyActiveRecord;
use common\models\Section;
use common\models\Flat;

/**
 * This is the model class for table "floor".
 *
 * @property integer $id
 * @property string $number
 * @property integer $flats_count
 * @property integer $section_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Flat[] $flats
 * @property Section $section
 */
class BaseFloor extends MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'floor';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['flats_count', 'section_id', 'number'], 'integer'],
            [['section_id'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['section_id'], 'exist', 'skipOnError' => true, 'targetClass' => Section::className(), 'targetAttribute' => ['section_id' => 'id']],
        ];
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
    public function getFlats() {
        return $this->hasMany(Flat::className(), ['floor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSection() {
        return $this->hasOne(Section::className(), ['id' => 'section_id']);
    }
}
