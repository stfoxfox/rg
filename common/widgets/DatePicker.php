<?php
namespace common\widgets;

use Yii;
use dosamigos\datepicker\DatePicker as DosDatePicker;
use common\SharedAssets\BootsrapDatePickerAsset;
use yii\base\InvalidParamException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * Class DatePicker
 * @package common\widgets
 */
class DatePicker extends DosDatePicker
{
    public $saveDateFormat = 'Y-m-d';

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();

        if ($this->hasModel()) {
            $model = $this->model;
            $attribute = $this->attribute;
            $value = $model->$attribute;
            $model->$attribute = Yii::$app->formatter->asDateTime($value ? $value : date($this->saveDateFormat), 'dd.MM.yyyy');
        }
    }

    /**
     * Registers required script for the plugin to work as DatePicker
     */
    public function registerClientScript() {
        $js = [];
        $view = $this->getView();
        BootsrapDatePickerAsset::register($view);

        $id = $this->options['id'];
        $selector = ";jQuery('#$id')";
//        $ids = "$('#$id')";
//        $beforeSubmit = "$ids.parent('form').on('beforeSubmit', function(e){
//            var d = new Date($ids.val()); console.log(d.toDateString());
//            $ids.val(d.toDateString());
//        });";

        if ($this->addon || $this->inline) {
            $selector .= ".parent()";
        }

//
//        $toDisplay = <<<JS
//    function (date, format, language) { var d = new Date(date); return d.toLocaleString("ru"); }
//JS;
//        $toValue = <<<JS
//    toValue = function (date, format, language) { var d = new Date(date); return d.toDateString(); }
//JS;

        $this->clientOptions = ArrayHelper::merge($this->clientOptions, [
            'language' => 'ru',
            'autoclose' => true,
            'format' => 'dd.mm.yyyy',
        ]);
        $options = Json::encode($this->clientOptions);

        if ($this->inline) {
            $this->clientEvents['changeDate'] = "function (e){ jQuery('#$id').val(e.format());}";
        }

        $js[] = "$selector.datepicker($options);";

        if (!empty($this->clientEvents)) {
            foreach ($this->clientEvents as $event => $handler) {
                $js[] = "$selector.on('$event', $handler);";
            }
        }
        $view->registerJs(implode("\n", $js));
//        $view->registerJs($beforeSubmit);
    }
}