<?php
namespace common\widgets\mortgage;

use Yii;
use common\components\MyExtensions\MyWidget;
use common\widgets\mortgage\forms\MortgageCalcWidgetForm;

/**
 * Class MortgageCalcWidget
 * @package common\widgets\mortgage
 *
 * @inheritdoc
 */
class MortgageCalcWidget extends MyWidget
{
    public $icon = '<i class="fa fa-university"></i>';

    /**
     * @return string
     */
    public static function getForm() {
        return MortgageCalcWidgetForm::className();
    }

    /**
     * @return string
     */
    public static function getBlockName() {
        return 'Блок калькулятор ипотеки';
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

        return $this->render('calc', [
            'model' => $model,
        ]);
    }
}