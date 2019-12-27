<?php
namespace common\widgets\mortgage\forms;

use Yii;
use common\components\MyExtensions\WidgetModel;

/**
 * Class MortgageCalcWidgetForm
 * @package common\widgets\mortgage\forms
 *
 * @inheritdoc
 */
class MortgageCalcWidgetForm extends WidgetModel
{
    public $title;
    public $text;
    public $link;
    public $link_title;

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
            [['title', 'link', 'link_title'], 'string', 'max' => 255],
            ['link', 'url'],
            ['text', 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'title' => 'Заголовок',
            'link' => 'Ссылка',
            'link_title' => 'Заголовок для ссылки',
            'text' => 'Описание',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function types() {
        return [
            'title' => 'textInput',
            'link' => 'linkWithTitle',
            'link_title' => 'linkTitle',
            'text' => 'textArea',
        ];
    }

}