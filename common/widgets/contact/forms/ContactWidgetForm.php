<?php
namespace common\widgets\contact\forms;

use Yii;
use common\components\MyExtensions\WidgetModel;
use common\models\Contact;

/**
 * Class ContactWidgetForm
 * @package common\widgets\contact\forms
 *
 * @inheritdoc
 */
class ContactWidgetForm extends WidgetModel
{
    public $title;
    public $contact_left;
    public $contact_right;
    public $anchor;
    public $anchor_title;

    /**
     * @inheritdoc
     */
    public function init() {
        $this->dropDownData = [
            'contact_left' => Contact::getList(),
            'contact_right' => Contact::getList(),
        ];

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['title', 'string', 'max' => 255],
            [['contact_left', 'contact_right'], 'safe'],
            [['anchor', 'anchor_title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'title' => 'Заголовок',
            'contact_left' => 'Контакты для левой колонки',
            'contact_right' => 'Контакты для правкой колонки',
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
            'contact_left' => 'select2',
            'contact_right' => 'select2',
            'anchor' => 'textInput',
            'anchor_title' => 'textInput',
        ];
    }

    /**
     * @return array
     */
    public function related() {
        return [
            'contact_left' => [
                'class' => Contact::className(),
                'from' => 'id',
                'to' =>  'title'
            ],
            'contact_right' => [
                'class' => Contact::className(),
                'from' => 'id',
                'to' =>  'title'
            ]
        ];
    }

}