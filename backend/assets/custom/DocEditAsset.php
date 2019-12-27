<?php
namespace backend\assets\custom;
use yii\web\AssetBundle;

/**
 * Class DocEditAsset
 * @package backend\assets\custom
 */
class DocEditAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets_files/custom/doc';

    public $css = [
        'docs.css'
    ];

    public $js = [
        'doc_edit.js'
    ];

    public $depends = [
        'backend\assets\MainAsset',
        'common\SharedAssets\SweetAllertAsset',
        'common\SharedAssets\JqueryUIAsset',
        'common\SharedAssets\EditableAsset',
        'common\SharedAssets\LightboxAsset',
    ];
}