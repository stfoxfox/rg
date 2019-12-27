<?php
namespace common\widgets\workers\forms;

use Yii;
use common\components\MyExtensions\WidgetModel;

/**
 * Class WorkerWidgetForm
 * @package common\widgets\workers\forms
 *
 * @inheritdoc
 */
class WorkerWidgetForm extends WidgetModel
{
    public $fio;
    public $duty;
    public $file_name;

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
            [['fio', 'duty'], 'string', 'max' => 255],
            [['fio'], 'required'],
            [['file_name'], 'file', 'extensions' => ['jpg', 'jpeg', 'png'],'maxFiles' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'fio' => 'Ф.И.О',
            'duty' => 'Должность',
            'file_name' => 'Фотография',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function types() {
        return [
            'fio' => 'textInput',
            'duty' => 'textInput',
            'file_name' => 'imageInput',
        ];
    }
}