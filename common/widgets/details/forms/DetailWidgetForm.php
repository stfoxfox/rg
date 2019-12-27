<?php
namespace common\widgets\details\forms;

use Yii;
use common\components\MyExtensions\WidgetModel;

/**
 * Class DetailWidgetForm
 * @package common\widgets\details\forms
 *
 * @inheritdoc
 */
class DetailWidgetForm extends WidgetModel
{
    public $title;
    public $file_name;
    public $text;

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['title', 'string', 'max' => 255],
            [['text'], 'string'],
            [['file_name'], 'file', 'extensions' => ['jpg', 'jpeg', 'png'], 'maxFiles' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'title' => 'Заголовок',
            'text' => 'Описание',
            'file_name' => 'Изображение',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function types() {
        return [
            'title' => 'textInput',
            'text' => 'textArea',
            'file_name' => 'imageInput',
        ];
    }
}