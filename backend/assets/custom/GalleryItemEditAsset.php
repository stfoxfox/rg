<?php
namespace backend\assets\custom;
use yii\web\AssetBundle;

/**
 * Class GalleryItemEditAsset
 * @package backend\assets\custom
 */
class GalleryItemEditAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets_files/custom/gallery';

    public $css = [
        'gallery.css'
    ];

    public $js = [
        'item_edit.js'
    ];

    public $depends = [
        'backend\assets\MainAsset',
        'common\SharedAssets\SweetAllertAsset',
        'common\SharedAssets\CroperAsset',
    ];

}