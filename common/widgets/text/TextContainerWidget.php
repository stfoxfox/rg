<?php
namespace common\widgets\text;

use Yii;
use common\components\MyExtensions\MyWidget;
use common\widgets\text\forms\TextContainerWidgetForm;
use common\models\PageBlock;

/**
 * Class TextContainerWidget
 * @package common\widgets\text
 *
 * @inheritdoc
 */
class TextContainerWidget extends MyWidget
{
    public $icon = '<i class="fa fa-folder-open"></i>';

    public $childs = [
        27 => [
            'widgetClass' => 'common\widgets\text\TextColumnWidget'
        ],
    ];

    /**
     * @return string
     */
    public static function getForm() {
        return TextContainerWidgetForm::className();
    }

    /**
     * @return string
     */
    public static function getBlockName() {
        return 'Блок с набором текстов';
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

        return $this->render('text_container', [
            'model' => $model,
            'block' => PageBlock::findOne(['id' => $this->block_id]),
        ]);
    }
}