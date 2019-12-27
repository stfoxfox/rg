<?php
namespace common\widgets\promo\forms;

use Yii;
use common\components\MyExtensions\WidgetModel;
use common\models\Promo;

/**
 * Class PromoWidgetForm
 * @package common\widgets\promo\forms
 *
 * @inheritdoc
 */
class PromoWidgetForm extends WidgetModel
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
            ['text', 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'title' => 'Заголовок',
            'text' => 'Описание',
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