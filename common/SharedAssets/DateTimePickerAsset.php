<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 23/06/2017
 * Time: 01:28
 */

namespace common\SharedAssets;


use yii\web\AssetBundle;

class DateTimePickerAsset extends AssetBundle
{
    public $sourcePath = '@bower/eonasdan-bootstrap-datetimepicker';


    public $css = [
        'build/css/bootstrap-datetimepicker.min.css',

    ];
    public $js = [
        'build/js/bootstrap-datetimepicker.min.js',
    ];

    public $publishOptions = [
        'only' => [
            'build/css/*',
            'build/js/*',

        ]
    ];

    public $depends = [


        'common\SharedAssets\MomentAsset'


    ];

}