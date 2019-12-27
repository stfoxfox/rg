<?php
namespace common\SharedAssets;
use yii\web\AssetBundle;

/**
 * Class BootsrapDatePickerAsset
 * @package common\SharedAssets
 */
class BootsrapDatePickerAsset extends AssetBundle
{
    public $sourcePath = '@bower/bootstrap-datepicker/dist';

    public $css = [
        'css/bootstrap-datepicker3.min.css',
    ];

    public $js = [
        'js/bootstrap-datepicker.min.js',
        'locales/bootstrap-datepicker.ru.min.js',
    ];
}