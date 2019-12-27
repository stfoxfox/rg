<?php
namespace backend\assets\custom;
use yii\web\AssetBundle;

/**
 * Class PromoEditAsset
 * @package backend\assets\custom
 */
class PromoEditAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets_files/custom/promo';

    public $css = [
        'promo.css'
    ];

    public $js = [
        'promo_edit.js'
    ];

    public $depends = [
        'backend\assets\MainAsset',
        'common\SharedAssets\SweetAllertAsset',
        'common\SharedAssets\CroperAsset',
    ];

}