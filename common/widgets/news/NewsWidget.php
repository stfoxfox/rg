<?php
namespace common\widgets\news;

use Yii;
use common\components\MyExtensions\MyWidget;
use common\widgets\news\forms\NewsWidgetForm;
use common\models\PageBlock;

/**
 * Class NewsWidget
 * @package common\widgets\news
 *
 * @inheritdoc
 */
class NewsWidget extends MyWidget
{
    public $icon = '<i class="fa fa-newspaper-o"></i>';

    /**
     * @return string
     */
    public static function getForm() {
        return NewsWidgetForm::className();
    }

    /**
     * @return string
     */
    public static function getBlockName() {
        return 'Блок новостей';
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