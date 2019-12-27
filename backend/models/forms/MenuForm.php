<?php
namespace backend\models\forms;

use Yii;
use yii\base\Model;
use common\models\Menu;

/**
 * Class MenuForm
 * @package backend\models\forms
 */
class MenuForm extends Model
{
    public $title;
    public $description;
    public $type;
    public $status;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['description'], 'string'],
            [['type', 'status'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'title' => 'Заголовок',
            'description' => 'Описание',
            'type' => 'Тип меню',
            'status' => 'Статус',
        ];
    }

    /**
     * @param Menu $item
     */
    public function loadFrom($item) {
        $this->title = $item->title;
        $this->description = $item->description;
        $this->type = $item->type;
        $this->status = $item->status;
    }

    /**
     * @inheritdoc
     * @var Menu $item
     */
    public function edit($item) {
        if (!$this->validate()) {
            return null;
        }

        $item->title = $this->title;
        $item->description = $this->description;
        $item->type = $this->type;
        $item->status = $this->status;
    
        if ($item->save()) {
            return true;
        }

        return null;
    }

    public function create() {
        if (!$this->validate()) {
            return null;
        }

        $item = new Menu();

        $item->title = $this->title;
        $item->description = $this->description;
        $item->type = $this->type;
        $item->status = $this->status;
    
        if ($item->save()) {
            return $item;
        }

        return null;
    }
}
