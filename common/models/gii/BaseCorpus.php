<?php
namespace common\models\gii;

use Yii;
use common\models\Page;

/**
 * This is the model class for table "corpus".
 * Class BaseCorpus
 * @package common\models\gii
 *
 * @property integer $id
 * @property string $corpus_num
 * @property integer $page_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Page $page
 */
class BaseCorpus extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'corpus';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['corpus_num', 'page_id'], 'required'],
            [['page_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['corpus_num'], 'string', 'max' => 255],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => Page::className(), 'targetAttribute' => ['page_id' => 'id']],
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
            'page_id' => 'Page ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Page::className(), ['id' => 'page_id']);
    }
}
