<?php
namespace backend\assets\custom;
use yii\web\AssetBundle;

/**
 * Class ComplexAsset
 * @package backend\assets\custom
 */
class ComplexAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets_files/custom/complex';

    public $css = [
        'complex.css'
    ];

    public $js = [
        'complex.js'
    ];

    public $depends = [
        'backend\assets\MainAsset',
        'common\SharedAssets\SweetAllertAsset',
        'common\SharedAssets\EditableAsset',
    ];
}