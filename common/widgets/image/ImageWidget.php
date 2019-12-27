<?php
namespace common\widgets\image;

use Yii;
use common\components\MyExtensions\MyWidget;
use common\widgets\image\forms\ImageWidgetForm;

/**
 * Class ImageWidget
 * @package common\widgets\image
 *
 * @inheritdoc
 */
class ImageWidget extends MyWidget
{
    public $icon = '<i class="fa fa-file-image-o"></i>';

    public $show_in_root = false;

    /**
     * @return string
     */
    public static function getForm() {
        return ImageWidgetForm::className();
    }

    /**
     * @return string
     */
    public static function getBlockName() {
        return 'Изображение';
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
        ]);
    }
}