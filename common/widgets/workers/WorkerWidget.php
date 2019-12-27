<?php
namespace common\widgets\workers;

use Yii;
use common\components\MyExtensions\MyWidget;
use common\widgets\workers\forms\WorkerWidgetForm;

/**
 * Class WorkerWidget
 * @package common\widgets\workers
 *
 * @inheritdoc
 */
class WorkerWidget extends MyWidget
{
    public $icon = '<i class="fa fa-user"></i>';

    public $show_in_root = false;

    /**
     * @return string
     */
    public static function getForm() {
        return WorkerWidgetForm::className();
    }

    /**
     * @return string
     */
    public static function getBlockName() {
        return 'Сотрудник';
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

        return $this->render('worker', [
            'model' => $model,
        ]);
    }
}