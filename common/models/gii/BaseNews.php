<?php
namespace common\models\gii;

use Yii;
use common\models\Page;
use common\models\NewsTag;

/**
 * This is the model class for table "news".
 * Class BaseNews
 * @package common\models\gii
 *
 * @property integer $id
 * @property string $title
 * @property string $news_date
 * @property string $short_text
 * @property string $full_text
 * @property integer $page_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Page $page
 * @property NewsTag[] $tags
 */
class BaseNews extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['news_date', 'created_at', 'updated_at'], 'safe'],
            [['full_text'], 'string'],
            [['page_id'], 'required'],
            [['page_id'], 'integer'],
            [['title', 'short_text'], 'string', 'max' => 255],
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
            'title' => 'Title',
            'news_date' => 'News Date',
            'short_text' => 'Short Text',
            'full_text' => 'Full Text',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(NewsTag::className(), ['id' => 'tag_id'])->viaTable('news_tag_item', ['news_id' => 'id']);
    }
}
