<?php
namespace common\models\gii;

use Yii;
use common\components\MyExtensions\MyActiveRecord;
use common\models\Complex;
use common\models\DocCategory;
use common\models\Section;
use common\models\DocVersion;

/**
 * Class BaseDoc
 * @package common\models\gii
 *
 * @property integer $id
 * @property string $title
 * @property integer $category_id
 * @property integer $complex_id
 * @property integer $corpus_num
 * @property integer $section_id
 * @property integer $sort
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Complex $complex
 * @property DocCategory $category
 * @property Section $section
 * @property DocVersion[] $docVersions
 */
class BaseDoc extends MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'doc';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['category_id', 'complex_id', 'corpus_num', 'section_id', 'sort'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['complex_id'], 'exist', 'skipOnError' => true, 'targetClass' => Complex::className(), 'targetAttribute' => ['complex_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => DocCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['section_id'], 'exist', 'skipOnError' => true, 'targetClass' => Section::className(), 'targetAttribute' => ['section_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'category_id' => 'Категория',
            'complex_id' => 'Комплекс',
            'corpus_num' => 'Корпус',
            'section_id' => 'Секция',
            'sort' => 'Sort',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComplex() {
        return $this->hasOne(Complex::className(), ['id' => 'complex_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory() {
        return $this->hasOne(DocCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSection() {
        return $this->hasOne(Section::className(), ['id' => 'section_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocVersions() {
        return $this->hasMany(DocVersion::className(), ['doc_id' => 'id']);
    }

}
