<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 06.11.15
 * Time: 11:41
 */

namespace common\SharedAssets;


use yii\web\AssetBundle;

class ColorPickerAsset extends AssetBundle
{

    public $sourcePath = '@bower/bootstrap-colorpicker';


    public $css = [
        'dist/css/bootstrap-colorpicker.css',

    ];
    public $js = [
        'dist/js/bootstrap-colorpicker.js',
    ];

    public $publishOptions = [
        'only' => [
            "dist/css/*",
            "dist/js/*",
            "dist/img/*",
            "dist/img/bootstrap-colorpicker/*",
        ]
    ];

}