<?php
namespace common\SharedAssets;
use yii\web\AssetBundle;

/**
 * Class JsTreeAsset
 * @package common\SharedAssets
 */
class JsTreeAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets_files/template';

    public $css = [
        'css/plugins/jsTree/style.css'
    ];

    public $js = [
        'js/plugins/jsTree/jstree.min.js'
    ];

    public $depends = [
        'backend\assets\MainAsset'
    ];
}