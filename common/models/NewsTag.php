<?php
namespace common\models;

use Yii;
use common\models\gii\BaseNewsTag;
use yii\helpers\ArrayHelper;

/**
* This is the model class for table "news_tag".
* Class NewsTag
* @package common\models
* @inheritdoc
*/
class NewsTag extends BaseNewsTag
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
}
