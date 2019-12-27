<?php
namespace backend\models\forms;

use Yii;
use yii\base\Model;
use common\models\Bank;

/**
 * Class BankForm
 * @package backend\models\forms
 */
class BankForm extends Model
{
    public $id;
    public $title;
    public $license;
    public $date_license;
    public $external_id;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['date_license', 'created_at', 'updated_at'], 'safe'],
            [['title', 'license', 'external_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'title' => 'Название',
            'license' => 'Номер лицензии банка',
            'date_license' => 'Дата лицензии банка',
        ];
    }

    /**
     * @param Bank $item
     */
    public function loadFrom($item) {
        $this->id = $item->id;
        $this->title = $item->title;
        $this->license = $item->license;
        $this->date_license = $item->date_license;
        $this->external_id = $item->external_id;
    }

    /**
     * @inheritdoc
     * @var Bank $item
     */
    public function edit($item) {
        if (!$this->validate()) {
            return null;
        }

        $item->title = $this->title;
        $item->license = $this->license;
        $item->date_license = $this->date_license;
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

        $item = new Bank();

        $item->title = $this->title;
        $item->license = $this->license;
        $item->date_license = $this->date_license;
        $item->external_id = $this->external_id;
    
        if ($item->save()) {
            return $item;
        }

        return null;
    }
}
