<?php
namespace common\widgets\workers\forms;

use Yii;
use common\components\MyExtensions\WidgetModel;

/**
 * Class WorkersContainerWidgetForm
 * @package common\widgets\workers\forms
 *
 * @inheritdoc
 */
class WorkersContainerWidgetForm extends WidgetModel
{
    public $title;
    public $show_line;
    public $anchor;
    public $anchor_title;

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
            ['show_line', 'boolean'],
            [['anchor', 'anchor_title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'title' => 'Заголовок',
            'show_line' => 'Показать линию',
            'anchor' => 'Якорь',
            'anchor_title' => 'Заголовок якоря',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function types() {
        return [
            'title' => 'textInput',
            'show_line' => 'checkbox',
            'anchor' => 'textInput',
            'anchor_title' => 'textInput',
        ];
    }
}