<?php
namespace backend\models\forms;

use Yii;
use yii\base\Model;
use common\models\Mortgage;
use common\models\Bank;

/**
 * Class MortgageForm
 * @package backend\models\forms
 */
class MortgageForm extends Model
{
    public $title;
    public $min_cash;
    public $percent_rate;
    public $max_period;
    public $max_amount;
    public $is_military;
    public $is_priority;
    public $bank_id;
    public $external_id;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['min_cash', 'percent_rate'], 'number'],
            [['max_period', 'max_amount', 'bank_id'], 'integer'],
            [['is_military', 'is_priority'], 'boolean'],
            [['bank_id', 'title'], 'required'],
            [['title', 'external_id'], 'string', 'max' => 255],
            [['bank_id'], 'exist', 'skipOnError' => true, 'targetClass' => Bank::className(), 'targetAttribute' => ['bank_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'title' => 'Название',
            'min_cash' => 'Минимальный первый взнос',
            'percent_rate' => 'Процентная ставка',
            'max_period' => 'Максимальный срок',
            'max_amount' => 'Максимальный размер',
            'is_military' => 'Военная ипотека',
            'is_priority' => 'Приоритетная',
        ];
    }

    /**
     * @param Mortgage $item
     */
    public function loadFrom($item) {
        $this->title = $item->title;
        $this->min_cash = $item->min_cash;
        $this->percent_rate = $item->percent_rate;
        $this->max_period = $item->max_period;
        $this->max_amount = $item->max_amount;
        $this->is_military = $item->is_military;
        $this->is_priority = $item->is_priority;
        $this->bank_id = $item->bank_id;
        $this->external_id = $item->external_id;
    }

    /**
     * @inheritdoc
     * @var Mortgage $item
     */
    public function edit($item) {
        if (!$this->validate()) {
            return null;
        }

        $item->title = $this->title;
        $item->min_cash = $this->min_cash;
        $item->percent_rate = $this->percent_rate;
        $item->max_period = $this->max_period;
        $item->max_amount = $this->max_amount;
        $item->is_military = $this->is_military;
        $item->is_priority = $this->is_priority;
        $item->external_id = $this->external_id;
    
        if ($item->save()) {
            return true;
        }

        return null;
    }

    public function create() {
        if (!$this->validate()) {
            return null;
        }

        $item = new Mortgage();

        $item->title = $this->title;
        $item->min_cash = $this->min_cash;
        $item->percent_rate = $this->percent_rate;
        $item->max_period = $this->max_period;
        $item->max_amount = $this->max_amount;
        $item->is_military = $this->is_military;
        $item->is_priority = $this->is_priority;
        $item->bank_id = $this->bank_id;
        $item->external_id = $this->external_id;
    
        if ($item->save()) {
            return $item;
        }

        return null;
    }
}
