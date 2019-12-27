<?php
namespace backend\assets\custom;
use yii\web\AssetBundle;

/**
 * Class DocAsset
 * @package backend\assets\custom
 */
class DocAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets_files/custom/doc';

    public $css = [
        'docs.css'
    ];

    public $js = [
        'docs.js'
    ];

    public $depends = [
        'backend\assets\MainAsset',
        'yii\widgets\PjaxAsset',
        'common\SharedAssets\SweetAllertAsset',
        'common\SharedAssets\JqueryUIAsset',
        'common\SharedAssets\EditableAsset',
    ];
}