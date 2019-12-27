<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 03.11.15
 * Time: 20:53
 */

namespace common\SharedAssets;


use yii\web\AssetBundle;

class BlueImpUploadAsset extends AssetBundle
{

    public $sourcePath = '@bower/blueimp-file-upload';


    public $css = [
        'css/jquery.fileupload.css',
        'css/jquery.fileupload-ui.css',

    ];
    public $js = [
        '//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js',
        '//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js',
        'js/jquery.fileupload.js',
        'js/jquery.fileupload-process.js',
        'js/jquery.fileupload-ui.js',
        'js/jquery.fileupload-image.js',
        'js/jquery.fileupload-jquery-ui.js',
    ];

    public $publishOptions = [
        'only' => [
            'css/*',
            'img/*',
            'js/*',


        ]
    ];

}