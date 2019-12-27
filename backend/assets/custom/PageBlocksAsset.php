<?php

namespace backend\assets\custom;

use yii\web\AssetBundle;

/**
 * @author Anatoliy Popov
 */
class PageBlocksAsset extends AssetBundle
{

    public $sourcePath = '@backend/assets_files/custom/page_blocks';
    public $css = [
        'page_blocks.css'
    ];
    public $js = [
        'page_blocks.js'
    ];
    public $depends = [
        'backend\assets\MainAsset',
        'common\SharedAssets\SweetAllertAsset',
        'common\SharedAssets\XEditableAsset',
        'common\SharedAssets\JqueryUIAsset',
        'common\SharedAssets\CroperAsset',
        'common\SharedAssets\JqueryFormAsset',
        'yii\widgets\ActiveFormAsset',
        'yii\validators\ValidationAsset',
    ];

}