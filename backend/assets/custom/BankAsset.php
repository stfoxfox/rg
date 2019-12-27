<?php
namespace backend\assets\custom;
use yii\web\AssetBundle;

/**
 * Class BankAsset
 * @package backend\assets\custom
 */
class BankAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets_files/custom/bank';

    public $css = [
        'bank.css'
    ];

    public $js = [
        'bank.js'
    ];

    public $depends = [
        'backend\assets\MainAsset',
        'common\SharedAssets\SweetAllertAsset',
        'common\SharedAssets\JqueryUIAsset',
        'common\SharedAssets\EditableAsset',
    ];
}