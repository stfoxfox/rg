<?php
namespace common\widgets\banners\forms;

use Yii;
use common\components\MyExtensions\WidgetModel;

/**
 * Class BannersWidgetForm
 * @package common\widgets\banners\forms
 *
 * @inheritdoc
 */
class BannersWidgetForm extends WidgetModel
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