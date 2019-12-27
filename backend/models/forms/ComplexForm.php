<?php

namespace backend\models\forms;

use Yii;
use yii\base\Model;
use common\models\Complex;

/**
 * Class ComplexForm
 * @package backend\models\forms
 */
class ComplexForm extends Model
{
    public $title;
    public $min_price;
    public $max_price;
    public $max_area;
    public $external_id;
    public $min_area;
    public $is_active;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['title'], 'required'],
            [['min_price', 'max_price', 'max_area', 'min_area'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['is_active'], 'integer'],
            [['title', 'external_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return (new Complex())->attributeLabels();
    }

    /**
     * @param Complex $item
     */
    public function loadFrom($item) {
        $this->title = $item->title;
        $this->min_price = $item->min_price;
        $this->max_price = $item->max_price;
        $this->max_area = $item->max_area;
        $this->external_id = $item->external_id;
        $this->min_area = $item->min_area;
        $this->is_active = $item->is_active;
    }

    /**
     * @inheritdoc
     * @var Complex $item
     */
    public function edit($item) {
        if (!$this->validate()) {
            return null;
        }

        $item->title = $this->title;
        $item->min_price = $this->min_price;
        $item->max_price = $this->max_price;
        $item->max_area = $this->max_area;
        $item->external_id = $this->external_id;
        $item->min_area = $this->min_area;
        $item->is_active = $this->is_active;
    
        if ($item->save()) {
            return true;
        }

        return null;
    }

    public function create() {
        if (!$this->validate()) {
            return null;
        }

        $item = new Complex();

        $item->title = $this->title;
        $item->min_price = $this->min_price;
        $item->max_price = $this->max_price;
        $item->max_area = $this->max_area;
        $item->external_id = $this->external_id;
        $item->min_area = $this->min_area;
        $item->is_active = $this->is_active;
    
        if ($item->save()) {
            return $item;
        }

        return null;
    }
}
