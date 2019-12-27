<?php
namespace common\widgets\statistics;

use Yii;
use common\components\MyExtensions\MyWidget;
use common\widgets\statistics\forms\StatisticsWidgetForm;
use common\models\PageBlock;

/**
 * Class StatisticsWidget
 * @package common\widgets\statistics
 *
 * @inheritdoc
 */
class StatisticsWidget extends MyWidget
{
    public $icon = '<i class="fa fa-bar-chart"></i>';

    public $childs = [
        12 => [
            'widgetClass' => 'common\widgets\text\TextSimpleWidget'
        ],
        25 => [
            'widgetClass' => 'common\widgets\statistics\StatisticsEntryWidget'
        ],
    ];

    /**
     * @return string
     */
    public static function getForm() {
        return StatisticsWidgetForm::className();
    }

    /**
     * @return string
     */
    public static function getBlockName() {
        return 'Блок статистика';
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