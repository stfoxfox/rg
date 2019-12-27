<?php
namespace common\widgets\map\forms;

use Yii;
use common\components\MyExtensions\WidgetModel;

/**
 * Class MapWidgetForm
 * @package common\widgets\mortgage\forms
 *
 * @inheritdoc
 */
class MapWidgetForm extends WidgetModel
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
            [['title'], 'string', 'max' => 255],
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