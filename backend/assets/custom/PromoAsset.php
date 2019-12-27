<?php
namespace backend\assets\custom;
use yii\web\AssetBundle;

/**
 * Class PromoAsset
 * @package backend\assets\custom
 */
class PromoAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets_files/custom/promo';

    public $css = [
        'promo.css'
    ];

    public $js = [
        'promo.js'
    ];

    public $depends = [
        'backend\assets\MainAsset',
        'common\SharedAssets\SweetAllertAsset',
        'common\SharedAssets\JqueryUIAsset',
        'common\SharedAssets\LightboxAsset',
    ];
}