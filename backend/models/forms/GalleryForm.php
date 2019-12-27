<?php
namespace backend\models\forms;

use Yii;
use yii\base\Model;
use common\models\Gallery;

/**
 * Class GalleryForm
 * @package backend\models\forms
 */
class GalleryForm extends Model
{
    public $title;
    public $description;
    public $type;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['description'], 'string'],
            [['type'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @param Gallery $item
     */
    public function loadFrom($item) {
        $this->title = $item->title;
        $this->description = $item->description;
        $this->type = $item->type;
    }

    /**
     * @inheritdoc
     * @var Gallery $item
     */
    public function edit($item) {
        if (!$this->validate()) {
            return null;
        }

        $item->title = $this->title;
        $item->description = $this->description;
        $item->type = $this->type;
    
        if ($item->save()) {
            return true;
        }

        return null;
    }

    public function create() {
        if (!$this->validate()) {
            return null;
        }

        $item = new Gallery();

        $item->title = $this->title;
        $item->description = $this->description;
        $item->type = $this->type;
    
        if ($item->save()) {
            return $item;
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'title' => 'Заголовок',
            'description' => 'Описание',
            'type' => 'Тип',
        ];
    }
}
