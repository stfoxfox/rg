<?php
namespace common\widgets\image;

use Yii;
use common\components\MyExtensions\MyWidget;
use common\widgets\image\forms\ImagePromoWidgetForm;

/**
 * Class ImagePromoWidget
 * @package common\widgets\image
 *
 * @inheritdoc
 */
class ImagePromoWidget extends MyWidget
{
    public $icon = '<i class="fa fa-file-image-o"></i>';

    public $show_in_root = false;

    /**
     * @return string
     */
    public static function getForm() {
        return ImagePromoWidgetForm::className();
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

        return $this->render('image_promo', [
            'model' => $model,
        ]);
    }
}