<?php
namespace common\widgets\news\forms;

use Yii;
use common\components\MyExtensions\WidgetModel;
use common\models\NewsTag;

/**
 * Class NewsWidgetForm
 * @package common\widgets\news\forms
 *
 * @inheritdoc
 */
class NewsWidgetForm extends WidgetModel
{
    public $title;
    public $tag;
    public $link;
    public $link_title;
    public $anchor;
    public $anchor_title;

    /**
     * @inheritdoc
     */
    public function init() {
        $this->dropDownData = [
            'tag' => NewsTag::getList(),
        ];

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['title', 'link', 'link_title'], 'string', 'max' => 255],
            [['tag'], 'safe'],
            ['link', 'url'],
            [['anchor', 'anchor_title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'title' => 'Заголовок',
            'tag' => 'Категория новостей (тэг)',
            'link' => 'Ссылка',
            'link_title' => 'Заголовок для ссылки',
            'anchor' => 'Якорь',
            'anchor_title' => 'Заголовок якоря',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function types() {
        return [
            'title' => 'textInput',
            'tag' => 'select2',
            'link' => 'linkWithTitle',
            'link_title' => 'linkTitle',
            'anchor' => 'textInput',
            'anchor_title' => 'textInput',
        ];
    }

    /**
     * @return array
     */
    public function related() {
        return [
            'tag' => [
                'class' => NewsTag::className(),
                'from' => 'id',
                'to' =>  'title'
            ],
        ];
    }
}