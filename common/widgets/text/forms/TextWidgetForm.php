<?php

namespace common\widgets\text\forms;

use Yii;
use common\components\MyExtensions\WidgetModel;

class TextWidgetForm extends WidgetModel
{
	public $title;
    public $text;
    public $file_name;


    public function init() {
        parent::init();
    }

    public function rules()
    {
        return [
            [['title'], 'string'],
            [['text'], 'string'],
            [['file_name'], 'file', 'extensions' => ['jpg','jpeg','png'],'maxFiles'=>1],

        ];
    }

    public static function types()
    {
        return [
            'title' => 'textInput',
            'text' => 'textArea',
            'file_name' => 'imageInput',
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок',
            'text' => 'Текст',
             'file_name' => 'Изображение',
        ];
    }
}
?>