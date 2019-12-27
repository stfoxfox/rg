<?php
namespace common\models\gii;

use Yii;
use common\models\Page;
use common\models\PageBlock;
use common\models\PageBlockImage;
use common\models\File;

/**
 * This is the model class for table "page_block".
 * Class BasePageBlock
 * @package common\models\gii
 *
 * @property integer $id
 * @property integer $page_id
 * @property string $block_name
 * @property integer $type
 * @property integer $sort
 * @property string $data
 * @property string $created_at
 * @property string $updated_at
 * @property integer $parent_id
 *
 * @property Page $page
 * @property PageBlock $parent
 * @property PageBlock[] $pageBlocks
 * @property PageBlockImage[] $pageBlockImages
 * @property File[] $files
 */
class BasePageBlock extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page_block';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['page_id', 'type', 'sort', 'parent_id'], 'integer'],
            [['data'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['block_name'], 'string', 'max' => 255],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => Page::className(), 'targetAttribute' => ['page_id' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => PageBlock::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'page_id' => 'Page ID',
            'block_name' => 'Block Name',
            'type' => 'Type',
            'sort' => 'Sort',
            'data' => 'Data',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'parent_id' => 'Parent ID',
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
    public function getParent()
    {
        return $this->hasOne(PageBlock::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPageBlocks()
    {
        return $this->hasMany(PageBlock::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPageBlockImages()
    {
        return $this->hasMany(PageBlockImage::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::className(), ['id' => 'file_id'])->viaTable('page_block_image', ['parent_id' => 'id']);
    }
}
