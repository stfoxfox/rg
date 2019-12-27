<?php
namespace common\models\gii;

use Yii;
use common\models\File;
use common\models\Page;

/**
 * This is the model class for table "promo".
 * Class BasePromo
 * @package common\models\gii
 *
 * @property integer $id
 * @property string $title
 * @property integer $file_id
 * @property string $description
 * @property string $external_id
 * @property string $date_to
 * @property integer $status
 * @property integer $sort
 * @property string $created_at
 * @property string $updated_at
 * @property integer $type
 * @property integer $avatar_id
 * @property string $manager
 * @property string $manager_phone
 * @property string $button_text
 * @property string $button_link
 * @property integer $page_id
 *
 * @property File $file
 * @property File $avatar
 * @property Page $page
 */
class BasePromo extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'promo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file_id', 'status', 'sort', 'type', 'avatar_id', 'page_id'], 'integer'],
            [['description'], 'string'],
            [['date_to', 'created_at', 'updated_at'], 'safe'],
            [['title', 'external_id', 'manager', 'button_text', 'button_link'], 'string', 'max' => 255],
            [['manager_phone'], 'string', 'max' => 50],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['file_id' => 'id']],
            [['avatar_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['avatar_id' => 'id']],
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
            'file_id' => 'File ID',
            'description' => 'Description',
            'external_id' => 'External ID',
            'date_to' => 'Date To',
            'status' => 'Status',
            'sort' => 'Sort',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'type' => 'Type',
            'avatar_id' => 'Avatar ID',
            'manager' => 'Manager',
            'manager_phone' => 'Manager Phone',
            'button_text' => 'Button Text',
            'button_link' => 'Button Link',
            'page_id' => 'Page ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(File::className(), ['id' => 'file_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAvatar()
    {
        return $this->hasOne(File::className(), ['id' => 'avatar_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Page::className(), ['id' => 'page_id']);
    }
}
