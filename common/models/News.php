<?php
namespace common\models;

use Yii;
use common\models\gii\BaseNews;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
* This is the model class for table "news".
* Class News
* @package common\models
* @inheritdoc
*/
class News extends BaseNews
{
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
            'title' => 'Заголовок',
            'news_date' => 'Дата',
            'short_text' => 'Короткий текст',
            'full_text' => 'Полный текст',
            'page_id' => 'Страница',
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert) {
        $this->news_date && $this->news_date = Yii::$app->formatter->asDate($this->news_date, 'php:Y-m-d');
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete() {
        if ($page = $this->page) {
            $page->delete();
        }
        return true;
    }

    /**
     * @return array
     */
    public function getNewsTagsList() {
        return ArrayHelper::map($this->tags, 'id', 'title');
    }

    /**
     * @param $tags
     * @return News[]
     */
    public static function getByTags($tags) {
        return self::find()->innerJoinWith('tags t')->andWhere(['in', 't.id', $tags])->all();

    }
}
