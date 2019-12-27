<?php
namespace backend\assets\custom;
use yii\web\AssetBundle;

/**
 * Class MenuAsset
 * @package backend\assets\custom
 */
class MenuAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets_files/custom/menu';

    public $css = [
        'menu.css'
    ];

    public $js = [
        'menu_delete.js'
    ];

    public $depends = [
        'backend\assets\MainAsset',
        'common\SharedAssets\SweetAllertAsset',
    ];
}