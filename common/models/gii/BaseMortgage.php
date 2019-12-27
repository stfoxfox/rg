<?php
namespace common\models\gii;

use Yii;
use common\components\MyExtensions\MyActiveRecord;
use common\models\Bank;

/**
 * Class BaseMortgage
 * @package common\models\gii
 *
 * @property integer $id
 * @property string $title
 * @property double $min_cash
 * @property double $percent_rate
 * @property integer $max_period
 * @property integer $max_amount
 * @property boolean $is_military
 * @property boolean $is_priority
 * @property integer $sort
 * @property integer $bank_id
 * @property string $external_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Bank $bank
 */
class BaseMortgage extends MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'mortgage';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['min_cash', 'percent_rate'], 'number'],
            [['max_period', 'max_amount', 'sort', 'bank_id'], 'integer'],
            [['is_military', 'is_priority'], 'boolean'],
            [['bank_id'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'external_id'], 'string', 'max' => 255],
            [['bank_id'], 'exist', 'skipOnError' => true, 'targetClass' => Bank::className(), 'targetAttribute' => ['bank_id' => 'id']],
        ];
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBank() {
        return $this->hasOne(Bank::className(), ['id' => 'bank_id']);
    }

}
