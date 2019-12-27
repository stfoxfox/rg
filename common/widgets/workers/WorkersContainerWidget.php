<?php
namespace common\widgets\workers;

use common\models\PageBlock;
use Yii;
use common\components\MyExtensions\MyWidget;
use common\widgets\workers\forms\WorkersContainerWidgetForm;

/**
 * Class WorkersContainerWidget
 * @package common\widgets\workers
 *
 * @inheritdoc
 */
class WorkersContainerWidget extends MyWidget
{
    public $icon = '<i class="fa fa-folder-open"></i>';

    public $childs = [
        16 => [
            'widgetClass' => 'common\widgets\workers\WorkerWidget'
        ],
    ];

    /**
     * @return string
     */
    public static function getForm() {
        return WorkersContainerWidgetForm::className();
    }

    /**
     * @return string
     */
    public static function getBlockName() {
        return 'Список сотрудников';
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