<?php
namespace common\widgets\contact\forms;

use Yii;
use common\components\MyExtensions\WidgetModel;

/**
 * Class ContactContainerWidgetForm
 * @package common\widgets\contact\forms
 *
 * @inheritdoc
 */
class ContactContainerWidgetForm extends WidgetModel
{
    public $title;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['title', 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'title' => 'Заголовок',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function types() {
        return [
            'title' => 'textInput',
        ];
    }


}