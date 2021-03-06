<?php
namespace common\widgets\text;

use Yii;
use common\components\MyExtensions\MyWidget;
use common\widgets\text\forms\TextSimpleWidgetForm;

/**
 * Class TextSimpleWidget
 * @package common\widgets\text
 *
 * @inheritdoc
 */
class TextSimpleWidget extends MyWidget
{
    /**
     * @return string
     */
    public static function getForm() {
        return TextSimpleWidgetForm::className();
    }

    /**
     * @return string
     */
    public static function getBlockName() {
        return 'Простой текстовый блок';
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

        return $this->render('text_simple', [
            'model' => $model,
        ]);
    }
}