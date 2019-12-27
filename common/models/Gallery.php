<?php
namespace common\models;

use Yii;
use common\models\gii\BaseGallery;
use yii\helpers\ArrayHelper;

/**
 * Class Gallery
 * @package common\models
 *
 * @inheritdoc
 * @property File[] $files
 */
class Gallery extends BaseGallery
{
    const TYPE_ENABLED = 1;
    const TYPE_DISABLED = 0;

    /**
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return array
     */
    public static function getList() {
        return ArrayHelper::map(self::find()->all(), 'id', 'title');
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'description' => 'Описание',
            'type' => 'Тип',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFiles() {
        return $this->hasMany(File::className(), ['id' => 'file_id'])
            ->via('galleryItems')->orderBy('sort');
    }
}
