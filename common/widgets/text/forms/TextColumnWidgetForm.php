<?php
namespace common\widgets\text\forms;

use Yii;
use common\components\MyExtensions\WidgetModel;

/**
 * Class TextColumnWidgetForm
 * @package common\widgets\text\forms
 *
 * @inheritdoc
 */
class TextColumnWidgetForm extends WidgetModel
{
    const COLUMNS = [
        '1' => 'Колонка №1',
        '2' => 'Колонка №2',
        '3' => 'Колонка №3',
    ];

    public $title;
    public $text;
    public $column_num;

    /**
     * @inheritdoc
     */
    public function init() {
        $this->dropDownData = [
            'column_num' => static::COLUMNS
        ];

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['title', 'string', 'max' => 255],
            [['text'], 'string'],
            [['column_num'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'title' => 'Заголовок',
            'text' => 'Текст',
            'column_num' => 'Номер колонки',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function types() {
        return [
            'title' => 'textInput',
            'text' => 'textArea',
            'column_num' => 'select2Single',
        ];
    }

    /**
     * @return array
     */
    public function related() {
        return [
            'column_num' => [
                'static_source' => static::COLUMNS,
            ]
        ];
    }
}