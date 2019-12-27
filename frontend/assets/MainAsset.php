<?php
namespace frontend\assets;
use yii\web\AssetBundle;

/**
 * Class MainAsset
 * @package frontend\assets
 */
class MainAsset extends AssetBundle
{
    public $sourcePath = '@frontend/assets/app';

    public $css = [
        'static/css/main.css',
    ];

    public $js = [
        'static/js/separate-js/config.js',
        'static/js/vendor.js',
        'static/js/main.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
    ];

    public $publishOptions=[

        'except' => [
            "docs/",
            "/*.html",
            //"*.less",    // css file ins't generated any more...
        ],
        "forceCopy" => YII_DEBUG,

    ];
}