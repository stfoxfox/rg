<?php

namespace backend\models\forms;

use common\models\FloorPlan;
use Yii;
use yii\base\Model;
use common\models\Flat;
use common\models\Floor;

/**
 * Class FlatForm
 * @package backend\models\forms
 */
class FlatForm extends Model
{
    public $type;
    public $number;
    public $rooms_count;
    public $total_area;
    public $live_area;
    public $kitchen_area;
    public $currency;
    public $price;
    public $sale_price;
    public $total_price;
    public $status;
    public $number_on_floor;
    public $binding;
    public $garage;
    public $decoration;
    public $furniture;
    public $features;
    public $object_id;
    public $external_id;
    public $floor_id;
    public $floor_plan_id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'rooms_count', 'currency', 'status', 'number_on_floor', 'floor_id', 'floor_plan_id'], 'integer'],
            [['total_area', 'live_area', 'kitchen_area', 'price', 'sale_price', 'total_price'], 'number'],
            [['garage', 'furniture'], 'boolean'],
            [['floor_id'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['number'], 'string', 'max' => 50],
            [['binding', 'object_id', 'external_id'], 'string', 'max' => 255],
            [['decoration', 'features'], 'string'],
            [['floor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Floor::className(), 'targetAttribute' => ['floor_id' => 'id']],
            [['floor_plan_id'], 'exist', 'skipOnError' => true, 'targetClass' => FloorPlan::className(), 'targetAttribute' => ['floor_plan_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return (new Flat())->attributeLabels();
    }

    /**
     * @param Flat $item
     */
    public function loadFrom($item) {
        $this->type = $item->type;
        $this->number = $item->number;
        $this->rooms_count = $item->rooms_count;
        $this->total_area = $item->total_area;
        $this->live_area = $item->live_area;
        $this->kitchen_area = $item->kitchen_area;
        $this->currency = $item->currency;
        $this->price = $item->price;
        $this->sale_price = $item->sale_price;
        $this->total_price = $item->total_price;
        $this->status = $item->status;
        $this->number_on_floor = $item->number_on_floor;
        $this->binding = $item->binding;
        $this->garage = $item->garage;
        $this->decoration = $item->decoration;
        $this->furniture = $item->furniture;
        $this->features = $item->features;
        $this->object_id = $item->object_id;
        $this->external_id = $item->external_id;
        $this->floor_id = $item->floor_id;
        $this->floor_plan_id = $item->floor_plan_id;
    }

    /**
     * @inheritdoc
     * @var Flat $item
     */
    public function edit($item)
    {
        if (!$this->validate()) {
            return null;
        }

        $item->type = $this->type;
        $item->number = $this->number;
        $item->rooms_count = $this->rooms_count;
        $item->total_area = $this->total_area;
        $item->live_area = $this->live_area;
        $item->kitchen_area = $this->kitchen_area;
        $item->currency = $this->currency;
        $item->price = $this->price;
        $item->sale_price = $this->sale_price;
        $item->total_price = $this->total_price;
        $item->status = $this->status;
        $item->number_on_floor = $this->number_on_floor;
        $item->binding = $this->binding;
        $item->garage = $this->garage;
        $item->decoration = $this->decoration;
        $item->furniture = $this->furniture;
        $item->features = $this->features;
        $item->object_id = $this->object_id;
        $item->external_id = $this->external_id;
        $item->floor_id = $this->floor_id;
        $item->floor_plan_id = $this->floor_plan_id;

        if ($item->save()) {
            return true;
        }

        return null;
    }

    public function create()
    {
        if (!$this->validate()) {
            return null;
        }

        $item = new Flat();

        $item->type = $this->type;
        $item->number = $this->number;
        $item->rooms_count = $this->rooms_count;
        $item->total_area = $this->total_area;
        $item->live_area = $this->live_area;
        $item->kitchen_area = $this->kitchen_area;
        $item->currency = $this->currency;
        $item->price = $this->price;
        $item->sale_price = $this->sale_price;
        $item->total_price = $this->total_price;
        $item->status = $this->status;
        $item->number_on_floor = $this->number_on_floor;
        $item->binding = $this->binding;
        $item->garage = $this->garage;
        $item->decoration = $this->decoration;
        $item->furniture = $this->furniture;
        $item->features = $this->features;
        $item->object_id = $this->object_id;
        $item->external_id = $this->external_id;
        $item->floor_id = $this->floor_id;
        $item->floor_plan_id = $this->floor_plan_id;

        if ($item->save()) {
            return $item;
        }

        return null;
    }

}
