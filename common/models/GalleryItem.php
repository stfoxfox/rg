<?php
namespace common\models;

use Yii;
use common\models\gii\BaseGalleryItem;

/**
 * Class GalleryItem
 * @package common\models
 *
 * @inheritdoc
 * @property Section $corpus
 */
class GalleryItem extends BaseGalleryItem
{
    /**
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'file_id' => 'Файл',
            'gallery_id' => 'Галерея',
            'sort' => 'Sort',
            'photo_date' => 'Дата фото',
            'complex_id' => 'Комплекс',
            'corpus_num' => '№ корпуса',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert) {
        $this->photo_date && $this->photo_date = Yii::$app->formatter->asDate($this->photo_date, 'php:Y-m-d');
        return parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCorpus() {
        return $this->hasOne(Section::className(), ['corpus_num' => 'gi.corpus_num'])
            ->from(['gi' => GalleryItem::tableName()])->via('complex');
    }
}
