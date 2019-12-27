<?php
namespace backend\assets\custom;
use yii\web\AssetBundle;

/**
 * Class GalleryAsset
 * @package backend\assets\custom
 */
class GalleryAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets_files/custom/gallery';

    public $css = [
        'gallery.css'
    ];

    public $js = [
        'gallery.js'
    ];

    public $depends = [
        'backend\assets\MainAsset',
        'common\SharedAssets\SweetAllertAsset',
    ];
}