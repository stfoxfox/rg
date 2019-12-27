<?php
namespace common\widgets\text\forms;

use Yii;
use common\components\MyExtensions\WidgetModel;

/**
 * Class TextSimpleWidgetForm
 * @package common\widgets\text\forms
 *
 * @inheritdoc
 */
class TextSimpleWidgetForm extends WidgetModel
{
    public $title;
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
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'title' => 'Заголовок',
            'text' => 'Текст',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function types() {
        return [
            'title' => 'textInput',
            'text' => 'textArea',
        ];
    }
}