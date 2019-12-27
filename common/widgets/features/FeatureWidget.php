<?php
namespace common\widgets\features;

use Yii;
use common\components\MyExtensions\MyWidget;
use common\widgets\features\forms\FeatureWidgetForm;

/**
 * Class FeatureWidget
 * @package common\widgets\features
 *
 * @inheritdoc
 */
class FeatureWidget extends MyWidget
{
    public $show_in_root = false;

    /**
     * @return string
     */
    public static function getForm() {
        return FeatureWidgetForm::className();
    }

    /**
     * @return string
     */
    public static function getBlockName() {
        return 'Особенность';
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

        return $this->render('feature', [
            'model' => $model,
        ]);
    }
}