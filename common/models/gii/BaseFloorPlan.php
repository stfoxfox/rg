<?php
namespace common\models\gii;

use Yii;
use common\models\Complex;
use common\models\File;

/**
 * This is the model class for table "floor_plan".
 * Class BaseFloorPlan
 * @package common\models\gii
 *
 * @property integer $id
 * @property string $corpus_num
 * @property string $section_num
 * @property integer $floor_num_starts
 * @property integer $floor_num_ends
 * @property integer $number_on_floor
 * @property string $external_id
 * @property integer $file_id
 * @property integer $complex_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Complex $complex
 * @property File $file
 */
class BaseFloorPlan extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'floor_plan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['floor_num_starts', 'floor_num_ends', 'number_on_floor', 'file_id', 'complex_id'], 'integer'],
            [['complex_id'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['corpus_num', 'section_num'], 'string', 'max' => 50],
            [['external_id'], 'string', 'max' => 255],
            [['complex_id'], 'exist', 'skipOnError' => true, 'targetClass' => Complex::className(), 'targetAttribute' => ['complex_id' => 'id']],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['file_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'corpus_num' => 'Corpus Num',
            'section_num' => 'Section Num',
            'floor_num_starts' => 'Floor Num Starts',
            'floor_num_ends' => 'Floor Num Ends',
            'number_on_floor' => 'Number On Floor',
            'external_id' => 'External ID',
            'file_id' => 'File ID',
            'complex_id' => 'Complex ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComplex()
    {
        return $this->hasOne(Complex::className(), ['id' => 'complex_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(File::className(), ['id' => 'file_id']);
    }
}
