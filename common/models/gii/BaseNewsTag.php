<?php
namespace common\models\gii;

use Yii;
use common\models\NewsTagItem;
use common\models\News;

/**
 * This is the model class for table "news_tag".
 * Class BaseNewsTag
 * @package common\models\gii
 *
 * @property integer $id
 * @property string $title
 * @property integer $sort
 * @property string $created_at
 * @property string $updated_at
 *
 * @property News[] $news
 */
class BaseNewsTag extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news_tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sort'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'sort' => 'Sort',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasMany(News::className(), ['id' => 'news_id'])->viaTable('news_tag_item', ['tag_id' => 'id']);
    }
}
