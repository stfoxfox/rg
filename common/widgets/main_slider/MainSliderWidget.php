<?php
namespace common\widgets\main_slider;

use common\models\PageBlock;
use Yii;
use common\components\MyExtensions\MyWidget;
use common\widgets\main_slider\forms\MainSliderWidgetForm;

/**
 * Class MainSliderWidget
 * @package common\widgets\main_slider
 *
 * @inheritdoc
 */
class MainSliderWidget extends MyWidget
{
    public $icon = '<i class="fa fa-picture-o"></i>';

    public $childs = [
        22 => [
            'widgetClass' => 'common\widgets\image\ImageWidget'
        ],
    ];

    /**
     * @return string
     */
    public static function getForm() {
        return MainSliderWidgetForm::className();
    }

    /**
     * @return string
     */
    public static function getBlockName() {
        return 'Титульный слайдер на главной';
    }

    /**
     * @return bool
     */
    public function init() {
        parent::init();
        if ($this->page_id == null)
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