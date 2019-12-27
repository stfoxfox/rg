<?php
namespace backend\assets\custom;
use yii\web\AssetBundle;

/**
 * Class FlatsAsset
 * @package backend\assets\custom
 */
class FlatsAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets_files/custom/flats';

    public $css = [
        'flats.css'
    ];

    public $js = [
        'flats.js'
    ];

    public $depends = [
        'common\SharedAssets\JsTreeAsset',
        'common\SharedAssets\SweetAllertAsset',
    ];
}