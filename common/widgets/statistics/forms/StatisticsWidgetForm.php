<?php
namespace common\widgets\statistics\forms;

use Yii;
use common\components\MyExtensions\WidgetModel;

/**
 * Class StatisticsWidgetForm
 * @package common\widgets\statistics\forms
 *
 * @inheritdoc
 */
class StatisticsWidgetForm extends WidgetModel
{
    public $title;
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
            [['anchor', 'anchor_title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'title' => 'Заголовок',
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
            'anchor' => 'textInput',
            'anchor_title' => 'textInput',
        ];
    }
}