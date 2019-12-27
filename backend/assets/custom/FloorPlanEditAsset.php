<?php
namespace backend\assets\custom;
use yii\web\AssetBundle;

/**
 * Class FloorPlanEditAsset
 * @package backend\assets\custom
 */
class FloorPlanEditAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets_files/custom/floor_plan';

    public $css = [
        'floor_plan.css'
    ];

    public $js = [
        'floor_plan_edit.js'
    ];

    public $depends = [
        'backend\assets\MainAsset',
        'common\SharedAssets\SweetAllertAsset',
    ];

}