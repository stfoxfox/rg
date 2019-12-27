<?php
namespace common\models\gii;

use Yii;
use common\components\MyExtensions\MyActiveRecord;
use common\models\Doc;
use common\models\File;

/**
 * Class BaseDocVersion
 * @package common\models\gii
 *
 * @property integer $id
 * @property string $version
 * @property string $doc_date
 * @property integer $doc_id
 * @property integer $file_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Doc $doc
 * @property File $file
 */
class BaseDocVersion extends MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'doc_version';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['doc_date', 'created_at', 'updated_at'], 'safe'],
            [['doc_id', 'file_id'], 'integer'],
            [['version'], 'string', 'max' => 255],
            [['doc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Doc::className(), 'targetAttribute' => ['doc_id' => 'id']],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['file_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'version' => 'Версия',
            'doc_date' => 'Дата документа',
            'doc_id' => 'Документ',
            'file_id' => 'Файл',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDoc() {
        return $this->hasOne(Doc::className(), ['id' => 'doc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile() {
        return $this->hasOne(File::className(), ['id' => 'file_id']);
    }
}
