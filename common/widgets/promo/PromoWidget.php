<?php
namespace common\widgets\promo;

use Yii;
use common\components\MyExtensions\MyWidget;
use common\widgets\promo\forms\PromoWidgetForm;
use common\models\PageBlock;

/**
 * Class PromoWidget
 * @package common\widgets\promo
 *
 * @inheritdoc
 */
class PromoWidget extends MyWidget
{
    public $icon = '<i class="fa fa-suitcase"></i>';

    public $childs = [
        32 => [
            'widgetClass' => 'common\widgets\image\ImagePromoWidget'
        ],
    ];

    /**
     * @return string
     */
    public static function getForm() {
        return PromoWidgetForm::className();
    }

    /**
     * @return string
     */
    public static function getBlockName() {
        return 'Блок акции';
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