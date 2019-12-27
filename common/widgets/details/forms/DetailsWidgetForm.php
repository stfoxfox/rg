<?php
namespace common\widgets\details\forms;

use Yii;
use common\components\MyExtensions\WidgetModel;

/**
 * Class DetailsWidgetForm
 * @package common\widgets\details\forms
 *
 * @inheritdoc
 */
class DetailsWidgetForm extends WidgetModel
{
    public $title;

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