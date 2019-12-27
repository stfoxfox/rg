<?php
namespace common\models;

use Yii;
use common\models\gii\BaseMortgage;
use yii\helpers\ArrayHelper;

/**
 * Class Mortgage
 * @package common\models
 * @inheritdoc
 */
class Mortgage extends BaseMortgage
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
            'title' => 'Название',
            'min_cash' => 'Минимальный первый взнос',
            'percent_rate' => 'Процентная ставка',
            'max_period' => 'Максимальный срок',
            'max_amount' => 'Максимальный размер',
            'is_military' => 'Военная ипотека',
            'is_priority' => 'Приоритетная',
            'sort' => 'Sort',
            'bank_id' => 'Банк',
            'external_id' => 'External ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
