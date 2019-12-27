<?php
namespace common\components\MyExtensions;

use Yii;
use common\models\PageBlock;

/**
 * Class MyWidget
 * @package common\components\MyExtensions
 *
 * @inheritdoc
 */
abstract class MyWidget extends \yii\base\Widget implements MyWidgetInterface
{
    public $added_id;
    public $page_id;
    public $block_id;
    public $parent_id;
    public $params;

    public $childs = [];
    public $icon = '<i class="fa fa-file-text-o"></i>';
    public $show_in_root = true;

    abstract public static function getForm();

    /**
     * @return string
     */
    public function backendCreate() {
        $model_class = $this->form;
        $model = new $model_class();

        return Yii::$app->controller->renderAjax('@backend/views/page/add_widget',[
            'model' => $model,
            'added_id' => $this->added_id,
            'page_id' => $this->page_id,
            'parent_id' => $this->parent_id,
            'class_name' => $this->className(),
        ]);
    }

    /**
     * @param PageBlock $page_block
     * @return string
     */
    public function backendView($page_block) {
        $model_class = $this->form;
        $model = new $model_class();
        $model->page_id = $page_block->page_id;
        $model->widget_name = basename($this->className());
        $model->attributes = get_object_vars($this->params);

        return $this->render('@backend/views/page/view_widget',[
            'model' => $model,
            'class_name' => $this->className(),
            'page_block' => $page_block,
        ]);
    }
}