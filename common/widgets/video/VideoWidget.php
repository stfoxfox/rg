<?php
namespace common\widgets\video;

use Yii;
use common\components\MyExtensions\MyWidget;
use common\widgets\video\forms\VideoWidgetForm;

/**
 * Class VideoWidget
 * @package common\widgets\video
 *
 * @inheritdoc
 */
class VideoWidget extends MyWidget
{
    public $icon = '<i class="fa fa-video-camera"></i>';

    /**
     * @return string
     */
    public static function getForm() {
        return VideoWidgetForm::className();
    }

    /**
     * @return string
     */
    public static function getBlockName() {
        return 'Блок видео';
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