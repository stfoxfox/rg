<?php
namespace frontend\assets;
use yii\web\AssetBundle;

/**
 * Class ValidateAsset
 * @package frontend\assets
 */
class ValidateAsset extends AssetBundle
{
    public $sourcePath = '@frontend/assets/custom/validate';

    public $css = [];

    public $js = [
        'validate.js',
    ];

    public $depends = [
        'frontend\assets\MainAsset'
    ];

}