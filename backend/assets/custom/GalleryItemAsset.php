<?php
namespace backend\assets\custom;
use yii\web\AssetBundle;

/**
 * Class GalleryItemAsset
 * @package backend\assets\custom
 */
class GalleryItemAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets_files/custom/gallery';

    public $css = [
        'gallery.css'
    ];

    public $js = [
        'gallery_item.js'
    ];

    public $depends = [
        'backend\assets\MainAsset',
        'yii\widgets\PjaxAsset',
        'common\SharedAssets\SweetAllertAsset',
        'common\SharedAssets\JqueryUIAsset',
        'common\SharedAssets\CroperAsset',
        'common\SharedAssets\EditableAsset',
        'common\SharedAssets\LightboxAsset',
    ];
}