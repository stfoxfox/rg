<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 06.11.15
 * Time: 11:41
 */

namespace common\SharedAssets;


use yii\web\AssetBundle;

class DropzoneAsset extends AssetBundle
{

    public $sourcePath = '@bower/dropzone';


    public $css = [
        'dist/min/dropzone.min.css',

    ];
    public $js = [
        'dist/min/dropzone.min.js',
    ];

    public $publishOptions = [
        'only' => [
            'dist/min/*',
        ]
    ];

}