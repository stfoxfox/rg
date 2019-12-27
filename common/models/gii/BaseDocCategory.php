<?php
namespace common\models\gii;

use Yii;
use common\components\MyExtensions\MyActiveRecord;
use common\models\Doc;

/**
 * Class BaseDocCategory
 * @package common\models\gii
 *
 * @property integer $id
 * @property string $title
 * @property integer $sort
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Doc[] $docs
 */
class BaseDocCategory extends MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'doc_category';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['sort'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'sort' => 'Sort',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocs() {
        return $this->hasMany(Doc::className(), ['category_id' => 'id']);
    }
}
