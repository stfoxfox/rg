<?php
namespace common\widgets\banners;

use Yii;
use common\components\MyExtensions\MyWidget;
use common\widgets\banners\forms\BannersWidgetForm;

/**
 * Class BannersWidget
 * @package common\widgets\banners
 *
 * @inheritdoc
 */
class BannersWidget extends MyWidget
{
    public $icon = '<i class="fa fa-picture-o"></i>';

    public $childs = [
        3 => [
            'widgetClass' => 'common\widgets\gallery\GalleryWidget'
        ],
    ];

    /**
     * @return string
     */
    public static function getForm() {
        return BannersWidgetForm::className();
    }

    /**
     * @return string
     */
    public static function getBlockName() {
        return 'Блок набор баннеров';
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
        ]);
    }

}