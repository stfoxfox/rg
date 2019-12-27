<?php
namespace common\widgets\gallery;

use Yii;
use common\components\MyExtensions\MyWidget;
use common\widgets\gallery\forms\GalleryCorpusMonthWidgetForm;

/**
 * Class GalleryCorpusMonthWidget
 * @package common\widgets\gallery
 *
 * @inheritdoc
 */
class GalleryCorpusMonthWidget extends MyWidget
{
    public $icon = '<i class="fa fa-picture-o"></i>';

    /**
     * @return string
     */
    public static function getForm() {
        return GalleryCorpusMonthWidgetForm::className();
    }

    /**
     * @return string
     */
    public static function getBlockName() {
        return 'Блок подключаемой галереи по месяцам';
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

        return $this->render('gallery_corpus_month', [
            'model' => $model,
        ]);
    }

}