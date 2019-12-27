<?php
namespace common\widgets\details;

use Yii;
use common\components\MyExtensions\MyWidget;
use common\widgets\details\forms\DetailWidgetForm;

/**
 * Class DetailWidget
 * @package common\widgets\details
 */
class DetailWidget extends MyWidget
{
    public $show_in_root = false;

    /**
     * @return string
     */
    public static function getForm() {
        return DetailWidgetForm::className();
    }

    /**
     * @return string
     */
    public static function getBlockName() {
        return 'Элемент детали';
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

        return $this->render('detail', [
            'model' => $model,
        ]);
    }
}