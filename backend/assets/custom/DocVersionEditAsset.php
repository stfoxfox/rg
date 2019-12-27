<?php
namespace backend\assets\custom;
use yii\web\AssetBundle;

/**
 * Class DocVersionEditAsset
 * @package backend\assets\custom
 */
class DocVersionEditAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets_files/custom/doc';

    public $css = [
        'docs.css'
    ];

    public $js = [
        'doc_version_edit.js'
    ];

    public $depends = [
        'backend\assets\MainAsset',
        'common\SharedAssets\SweetAllertAsset',
        'common\SharedAssets\CroperAsset',
    ];
}