<?php
namespace common\widgets\rewards;

use Yii;
use common\components\MyExtensions\MyWidget;
use common\widgets\rewards\forms\RewardsWidgetForm;
use common\models\PageBlock;

/**
 * Class RewardsWidget
 * @package common\widgets\rewards
 *
 * @inheritdoc
 */
class RewardsWidget extends MyWidget
{
    public $icon = '<i class="fa fa-trophy"></i>';

    public $childs = [
        26 => [
            'widgetClass' => 'common\widgets\image\ImageSimpleWidget'
        ],
    ];

    /**
     * @return string
     */
    public static function getForm() {
        return RewardsWidgetForm::className();
    }

    /**
     * @return string
     */
    public static function getBlockName() {
        return 'Награды и рейтинги';
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