<?php
namespace common\widgets\gallery;

use Yii;
use common\components\MyExtensions\MyWidget;
use common\widgets\gallery\forms\GalleryCorpusWidgetForm;
use common\models\Gallery;

/**
 * Class GalleryCorpusWidget
 * @package common\widgets\gallery
 *
 * @inheritdoc
 */
class GalleryCorpusWidget extends MyWidget
{
    public $icon = '<i class="fa fa-picture-o"></i>';

    /**
     * @return string
     */
    public static function getForm() {
        return GalleryCorpusWidgetForm::className();
    }

    /**
     * @return string
     */
    public static function getBlockName() {
        return 'Блок подключаемой галереи';
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
        /** @var GalleryCorpusWidgetForm $model */
        $model_class = $this->form;
        $model = new $model_class();
        $model->page_id = $this->page_id;
        $model->widget_name = basename($this->className());
        $model->attributes = $this->params;

        $gallery = Gallery::findOne(['id' => $model->gallery]);
        if (!$gallery->getFiles()->exists()) {
            return '';
        }

        return $this->render('gallery_corpus', [
            'model' => $model,
            'images' => $gallery->files,
        ]);
    }

}