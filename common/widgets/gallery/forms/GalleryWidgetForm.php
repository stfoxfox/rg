<?php

namespace common\widgets\gallery\forms;

use Yii;
use common\components\MyExtensions\WidgetModel;

class GalleryWidgetForm extends WidgetModel
{
	public $title;
    public $description;
    public $select;

    public function init() {
        parent::init();
    }

    public function rules()
    {
        return [
            [['title'], 'required'],
            [['description'], 'string'],
            [['select'], 'integer'],
        ];
    }

    public static function types()
    {
        return [
            'title' => 'textInput',
            'description' => 'textArea',
            'select' => 'gallery',
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок блока',
            'description' => 'Описание блока'
        ];
    }
}
?>