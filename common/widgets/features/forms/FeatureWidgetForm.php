<?php
namespace common\widgets\features\forms;

use Yii;
use common\components\MyExtensions\WidgetModel;

/**
 * Class FeatureWidgetForm
 * @package common\widgets\features\forms
 *
 * @inheritdoc
 */
class FeatureWidgetForm extends WidgetModel
{
    public $title;
    public $title_left;
    public $text1;
    public $text2;
    public $text3;
    public $link;
    public $link_title;
    public $file_name;

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
            [['title', 'title_left', 'link', 'link_title'], 'string', 'max' => 255],
            [['title', 'title_left'], 'required'],
            ['link', 'url'],
            [['text1', 'text2', 'text3'], 'string'],
            [['file_name'], 'file', 'extensions' => ['jpg', 'jpeg', 'png'],'maxFiles' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'title' => 'Заголовок',
            'title_left' => 'Заголовок слева',
            'text1' => 'Описание',
            'text2' => 'Текст',
            'text3' => 'Текст дополнительно',
            'link' => 'Кнопка',
            'link_title' => 'Текст на кнопке',
            'file_name' => 'Изображение фона',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function types() {
        return [
            'title' => 'textInput',
            'title_left' => 'textInput',
            'text1' => 'textArea',
            'text2' => 'textArea',
            'text3' => 'textArea',
            'link' => 'linkWithTitle',
            'link_title' => 'linkTitle',
            'file_name' => 'imageInput',
        ];
    }
}