<?php
namespace common\widgets\building_progress;

use Yii;
use common\components\MyExtensions\MyWidget;
use common\widgets\building_progress\forms\BuildingProgressWidgetForm;
use common\models\PageBlock;

/**
 * Class BuildingProgressWidget
 * @package common\widgets\building_progress
 *
 * @inheritdoc
 */
class BuildingProgressWidget extends MyWidget
{
    public $icon = '<i class="fa fa-map"></i>';

    public $childs = [
        22 => [
            'widgetClass' => 'common\widgets\image\ImageWidget'
        ],
    ];

    /**
     * @return string
     */
    public static function getForm() {
        return BuildingProgressWidgetForm::className();
    }

    /**
     * @return string
     */
    public static function getBlockName() {
        return 'Ход строительства';
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