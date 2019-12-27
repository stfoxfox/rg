<?php
namespace common\widgets\map;

use Yii;
use common\components\MyExtensions\MyWidget;
use common\widgets\map\forms\MapWidgetForm;

/**
 * Class MapWidget
 * @package common\widgets\mortgage
 *
 * @inheritdoc
 */
class MapWidget extends MyWidget
{
    public $icon = '<i class="fa fa-map-o"></i>';

    /**
     * @return string
     */
    public static function getForm() {
        return MapWidgetForm::className();
    }

    /**
     * @return string
     */
    public static function getBlockName() {
        return '3D карта';
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
        ]);
    }
}