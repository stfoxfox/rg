<?php
namespace common\models;

use Yii;
use common\models\gii\BaseDoc;
use yii\helpers\ArrayHelper;

/**
 * Class Doc
 * @package common\models
 * @inheritdoc
 *
 * @property DocVersion $latestDocVersion
 */
class Doc extends BaseDoc
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
            'category_id' => 'Категория',
            'complex_id' => 'Комплекс',
            'corpus_num' => 'Корпус',
            'section_id' => 'Секция',
            'sort' => 'Sort',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return DocVersion
     */
    public function getLatestDocVersion() {
        return $this->getDocVersions()->orderBy(['version' => SORT_DESC])->one();
    }
}
