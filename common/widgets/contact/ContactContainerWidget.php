<?php
namespace common\widgets\contact;

use Yii;
use common\components\MyExtensions\MyWidget;
use common\widgets\contact\forms\ContactContainerWidgetForm;
use common\models\PageBlock;

/**
 * Class ContactContainerWidget
 * @package common\widgets\contact
 *
 * @inheritdoc
 */
class ContactContainerWidget extends MyWidget
{
    public $childs = [
        12 => [
            'widgetClass' => 'common\widgets\text\TextSimpleWidget'
        ],
    ];

    /**
     * @return string
     */
    public static function getForm() {
        return ContactContainerWidgetForm::className();
    }

    /**
     * @return string
     */
    public static function getBlockName() {
        return 'Контейнер блока контактов';
    }

    /**
     * @return bool
     */
    public function init() {
        parent::init();
        if($this->page_id == null)
            return false;
    }


    /**
     * @return string
     */
    public function run() {
        return $this->render('container', [
            'block' => PageBlock::findOne(['id' => $this->block_id]),
        ]);
    }

}