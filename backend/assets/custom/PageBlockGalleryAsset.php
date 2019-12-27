<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 30/06/2017
 * Time: 22:24
 */

namespace backend\assets\custom;


use yii\web\AssetBundle;

class PageBlockGalleryAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets_files/custom/page_block_gallery';




    public $css = [

        //   'blog.css'



    ];
    public $js = [
        'page_block_gallery.js'



    ];
    public $depends = [
        'backend\assets\MainAsset',
        'common\SharedAssets\SweetAllertAsset',
        'common\SharedAssets\JqueryUIAsset',
        'common\SharedAssets\XEditableAsset',
        'common\SharedAssets\CroperAsset',
        'common\SharedAssets\JqueryFormAsset',
        'common\SharedAssets\LightboxAsset',



    ];

}