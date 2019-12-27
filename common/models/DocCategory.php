<?php
namespace common\models;

use Yii;
use common\models\gii\BaseDocCategory;
use yii\helpers\ArrayHelper;

/**
 * Class DocCategory
 * @package common\models
 * @inheritdoc
 */
class DocCategory extends BaseDocCategory
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
            'id' => 'ID',
            'title' => 'Заголовок',
            'sort' => 'Sort',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
