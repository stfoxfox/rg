<?php
namespace common\widgets\features;

use common\models\PageBlock;
use Yii;
use common\components\MyExtensions\MyWidget;
use common\widgets\features\forms\FeaturesContainerWidgetForm;

/**
 * Class FeaturesContainerWidget
 * @package common\widgets\features
 *
 * @inheritdoc
 */
class FeaturesContainerWidget extends MyWidget
{
    public $icon = '<i class="fa fa-folder-open"></i>';

    public $childs = [
        18 => [
            'widgetClass' => 'common\widgets\features\FeatureWidget'
        ],
    ];

    /**
     * @return string
     */
    public static function getForm() {
        return FeaturesContainerWidgetForm::className();
    }

    /**
     * @return string
     */
    public static function getBlockName() {
        return 'Список особенностей';
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