<?php
namespace common\widgets\video\forms;

use Yii;
use common\components\MyExtensions\WidgetModel;

/**
 * Class VideoWidgetForm
 * @package common\widgets\video\forms
 *
 * @inheritdoc
 */
class VideoWidgetForm extends WidgetModel
{
    public $title;
    public $link;

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
            [['title', 'link'], 'string', 'max' => 255],
            ['link', 'url'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'title' => 'Заголовок',
            'link' => 'Ссылка на видео',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function types() {
        return [
            'title' => 'textInput',
            'link' => 'link',
        ];
    }

}