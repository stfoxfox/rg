<?php
namespace common\widgets\gallery;

use Yii;
use common\models\File;
use common\models\PageBlock;
use common\components\MyExtensions\MyWidget;
use common\widgets\gallery\forms\GalleryWidgetForm;

/**
 * Class GalleryWidget
 * @package common\widgets\gallery
 *
 * @inheritdoc
 */
class GalleryWidget extends MyWidget
{
    public $icon = '<i class="fa fa-picture-o"></i>';

    /**
     * @return string
     */
    public static function getForm() {
        return GalleryWidgetForm::className();
    }

    /**
     * @return string
     */
    public static function getBlockName() {
        return 'Блок галереи';
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
     * @return File[]
     */
    public function getImages() {
        return PageBlock::findOne(['id' => $this->block_id])->getFiles()->orderBy('sort')->all();
    }

    /**
     * @return string
     */
    public function run() {
        $images = $this->getImages();
        return $this->render('index', [
            'images' => $images
        ]);
    }
}