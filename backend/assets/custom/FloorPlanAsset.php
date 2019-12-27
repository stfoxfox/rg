<?php
namespace backend\assets\custom;
use yii\web\AssetBundle;

/**
 * Class FloorPlanAsset
 * @package backend\assets\custom
 */
class FloorPlanAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets_files/custom/floor_plan';

    public $css = [
        'floor_plan.css'
    ];

    public $js = [
        'floor_plan.js'
    ];

    public $depends = [
        'backend\assets\MainAsset',
        'yii\widgets\PjaxAsset',
        'common\SharedAssets\SweetAllertAsset',
        'common\SharedAssets\LightboxAsset',
    ];
}