<?php
namespace common\widgets\callback;

use Yii;
use common\components\MyExtensions\MyWidget;
use common\widgets\callback\forms\CallbackWidgetForm;
use common\models\SiteSettings;

/**
 * Class CallbackWidget
 * @package common\widgets\contact
 */
class CallbackWidget extends MyWidget
{
    public $icon = '<i class="fa fa-phone-square"></i>';

    public $times = [
        '7-11' => 'с 7 до 11',
        '11-15' => 'с 11 до 15',
        '15-19' => 'с 15 до 19',
        '19-21' => 'с 19 до 21',
        '21-00' => 'с 21 до 00',
    ];

    /**
     * @return string
     */
    public static function getForm() {
        return CallbackWidgetForm::className();
    }

    /**
     * @return string
     */
    public static function getBlockName() {
        return 'Запрос звонка';
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

        $tel = SiteSettings::findOne(['text_key' => 'phone']);

        return $this->render('index', [
            'model' => $model,
            'phone' => ($tel) ? $tel->string_value : '',
        ]);
    }

}