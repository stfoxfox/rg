<?php
namespace backend\assets\custom;
use yii\web\AssetBundle;

/**
 * Class NewsEditAsset
 * @package backend\assets\custom
 */
class NewsEditAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets_files/custom/news';

    public $css = [
        'news.css'
    ];

    public $js = [
        'news_edit.js'
    ];

    public $depends = [
        'backend\assets\MainAsset',
        'common\SharedAssets\SweetAllertAsset',
        'common\SharedAssets\JqueryUIAsset',
    ];

}