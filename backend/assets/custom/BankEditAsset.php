<?php
namespace backend\assets\custom;
use yii\web\AssetBundle;

/**
 * Class BankEditAsset
 * @package backend\assets\custom
 */
class BankEditAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets_files/custom/bank';

    public $css = [
        'bank.css'
    ];

    public $js = [
        'bank_edit.js'
    ];

    public $depends = [
        'backend\assets\MainAsset',
        'yii\widgets\PjaxAsset',
        'common\SharedAssets\SweetAllertAsset',
        'common\SharedAssets\JqueryUIAsset',
        'common\SharedAssets\EditableAsset',
    ];
}