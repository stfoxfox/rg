<?php
namespace common\widgets\details;

use Yii;
use common\components\MyExtensions\MyWidget;
use common\widgets\details\forms\DetailsWidgetForm;
use common\models\PageBlock;

/**
 * Class DetailsWidget
 * @package common\widgets\details
 *
 * @inheritdoc
 */
class DetailsWidget extends MyWidget
{
    public $childs = [
        23 => [
            'widgetClass' => 'common\widgets\details\DetailWidget'
        ],
    ];

    /**
     * @return string
     */
    public static function getForm() {
        return DetailsWidgetForm::className();
    }

    /**
     * @return string
     */
    public static function getBlockName() {
        return 'Детали';
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