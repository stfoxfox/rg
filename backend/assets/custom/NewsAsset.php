<?php
namespace backend\assets\custom;
use yii\web\AssetBundle;

/**
 * Class NewsAsset
 * @package backend\assets\custom
 */
class NewsAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets_files/custom/news';

    public $css = [
        'news.css'
    ];

    public $js = [
        'news.js'
    ];

    public $depends = [
        'backend\assets\MainAsset',
        'common\SharedAssets\SweetAllertAsset',
        'common\SharedAssets\EditableAsset',
    ];
}