<?php
namespace common\widgets\image\forms;

use Yii;
use common\components\MyExtensions\WidgetModel;

/**
 * Class ImageWidgetForm
 * @package common\widgets\image\forms
 *
 * @inheritdoc
 */
class ImageWidgetForm extends WidgetModel
{
    public $title;
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
            [['title'], 'string'],
            [['file_name'], 'file', 'extensions' => ['jpg', 'jpeg', 'png'], 'maxFiles' => 1],
            [['width', 'height'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'title' => 'Заголовок',
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
            'title' => 'textInput',
            'file_name' => 'imageInput',
            'width' => 'textInput',
            'height' => 'textInput',
        ];
    }
}