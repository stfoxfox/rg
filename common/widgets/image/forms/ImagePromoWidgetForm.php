<?php
namespace common\widgets\image\forms;

use Yii;
use common\components\MyExtensions\WidgetModel;

/**
 * Class ImagePromoWidgetForm
 * @package common\widgets\image\forms
 *
 * @inheritdoc
 */
class ImagePromoWidgetForm extends WidgetModel
{
    public $text;
    public $file_name;
    public $width;
    public $height;

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
            [['text'], 'string'],
            [['file_name'], 'file', 'extensions' => ['jpg', 'jpeg', 'png'], 'maxFiles' => 1],
            [['width', 'height'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'text' => 'Описание',
            'file_name' => 'Изображение',
            'width' => 'Предполагаемая ширина',
            'height' => 'Предполагаемая высота',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function types() {
        return [
            'text' => 'textArea',
            'file_name' => 'imageInput',
            'width' => 'textInput',
            'height' => 'textInput',
        ];
    }
}