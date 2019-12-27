<?php
namespace common\widgets\building_progress\forms;

use Yii;
use common\components\MyExtensions\WidgetModel;

/**
 * Class BuildingProgressWidgetForm
 * @package common\widgets\building_progress\forms
 *
 * @inheritdoc
 */
class BuildingProgressWidgetForm extends WidgetModel
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
            ['title', 'required'],
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