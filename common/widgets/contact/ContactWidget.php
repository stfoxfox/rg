<?php
namespace common\widgets\contact;

use Yii;
use common\components\MyExtensions\MyWidget;
use common\widgets\contact\forms\ContactWidgetForm;
use common\models\PageBlock;

/**
 * Class ContactWidget
 * @package common\widgets\contact
 *
 * @inheritdoc
 */
class ContactWidget extends MyWidget
{
    public $icon = '<i class="fa fa-phone-square"></i>';

    /**
     * @return string
     */
    public static function getForm() {
        return ContactWidgetForm::className();
    }

    /**
     * @return string
     */
    public static function getBlockName() {
        return 'Блок контактов';
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
        $model_class = $this->form;
        $model = new $model_class();
        $model->page_id = $this->page_id;
        $model->widget_name = basename($this->className());
        $model->attributes = $this->params;

        return $this->render('index', [
            'model' => $model,
            'block' => PageBlock::findOne(['id' => $this->block_id]),
        ]);
    }

}