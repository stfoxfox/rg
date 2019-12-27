<?php
namespace common\widgets\callback\forms;

use Yii;
use common\components\MyExtensions\WidgetModel;
use common\models\Contact;

/**
 * Class CallbackWidgetForm
 * @package common\widgets\contact\forms
 *
 * @inheritdoc
 */
class CallbackWidgetForm extends WidgetModel
{
    public $title;
    public $subtitle;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['title', 'string', 'max' => 255],
            ['subtitle', 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'title' => 'Заголовок',
            'subtitle' => 'Подзаголовок',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function types() {
        return [
            'title' => 'textInput',
            'subtitle' => 'textInput',
        ];
    }

}