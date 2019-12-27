<?php
namespace backend\assets\custom;
use yii\web\AssetBundle;

/**
 * Class ContactAsset
 * @package backend\assets\custom
 */
class ContactAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets_files/custom/contact';

    public $css = [
        'contact.css'
    ];

    public $js = [
        'contact.js'
    ];

    public $depends = [
        'backend\assets\MainAsset',
        'common\SharedAssets\SweetAllertAsset',
        'common\SharedAssets\JqueryUIAsset',
    ];
}