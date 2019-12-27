<?php
namespace backend\assets\custom;
use yii\web\AssetBundle;

/**
 * Class MenuItemAsset
 * @package backend\assets\custom
 */
class MenuItemAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets_files/custom/menu';

    public $js = [
        'items.js'
    ];

    public $css = [
        'menu.css'
    ];

    public $depends = [
        'backend\assets\MainAsset',
        'yii\widgets\PjaxAsset',
        'common\SharedAssets\SweetAllertAsset',
        'common\SharedAssets\NestableAsset',
    ];

}