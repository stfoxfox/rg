<?php
namespace common\widgets\main_slider\forms;

use Yii;
use common\components\MyExtensions\WidgetModel;

/**
 * Class MainSliderWidgetForm
 * @package common\widgets\main_slider\forms
 *
 * @inheritdoc
 */
class MainSliderWidgetForm extends WidgetModel
{
    public $title;
    public $sub_title;
    public $promo_title;
    public $promo_text;

    public $first_num;
    public $first_num_text;
    public $second_num;
    public $second_num_text;
    public $third_num;
    public $third_num_text;

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
            [
                ['title', 'sub_title', 'promo_title', 'promo_text',
                    'first_num', 'first_num_text', 'second_num', 'second_num_text',
                    'third_num', 'third_num_text',
                ], 'string', 'max' => 255
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'title' => 'Заголовок',
            'sub_title' => 'Подзаголовок',
            'promo_title' => 'Промо заголовок',
            'promo_text' => 'Текст промо',
            'first_num' => 'Первое число',
            'first_num_text' => 'Текст для 1-го числа',
            'second_num' => 'Второе число',
            'second_num_text' => 'Текст для 2-го числа',
            'third_num' => 'Третье число',
            'third_num_text' => 'Текст для 3-го числа',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function types() {
        return [
            'title' => 'textInput',
            'sub_title' => 'textInput',
            'promo_title' => 'textInput',
            'promo_text' => 'textInput',
            'first_num' => 'textInput',
            'first_num_text' => 'textInput',
            'second_num' => 'textInput',
            'second_num_text' => 'textInput',
            'third_num' => 'textInput',
            'third_num_text' => 'textInput',
        ];
    }
}