<?php
namespace common\widgets\statistics\forms;

use Yii;
use common\components\MyExtensions\WidgetModel;

/**
 * Class StatisticsEntryWidgetForm
 * @package common\widgets\statistics\forms
 *
 * @inheritdoc
 */
class StatisticsEntryWidgetForm extends WidgetModel
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