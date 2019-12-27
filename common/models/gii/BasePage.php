<?php
namespace common\models\gii;

use Yii;
use common\models\Corpus;
use common\models\News;
use common\models\PageBlock;

/**
 * This is the model class for table "page".
 * Class BasePage
 * @package common\models\gii
 *
 * @property integer $id
 * @property string $slug
 * @property string $title
 * @property string $description
 * @property string $html_text
 * @property boolean $is_internal
 * @property string $created_at
 * @property string $updated_at
 * @property integer $type
 * @property boolean $show_anchors
 *
 * @property Corpus[] $corpuses
 * @property News[] $news
 * @property PageBlock[] $pageBlocks
 */
class BasePage extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slug', 'title'], 'required'],
            [['html_text'], 'string'],
            [['is_internal', 'show_anchors'], 'boolean'],
            [['created_at', 'updated_at'], 'safe'],
            [['type'], 'integer'],
            [['slug', 'title', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' => 'Slug',
            'title' => 'Title',
            'description' => 'Description',
            'html_text' => 'Html Text',
            'is_internal' => 'Is Internal',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'type' => 'Type',
            'show_anchors' => 'Show Anchors',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCorpuses()
    {
        return $this->hasMany(Corpus::className(), ['page_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasMany(News::className(), ['page_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPageBlocks()
    {
        return $this->hasMany(PageBlock::className(), ['page_id' => 'id']);
    }
}
