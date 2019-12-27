<?php
namespace backend\assets\custom;
use yii\web\AssetBundle;

/**
 * Class FeedbackAsset
 * @package backend\assets\custom
 */
class FeedbackAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets_files/custom/feedback';

    public $js = [
        'feedback.js'
    ];

    public $depends = [
        'backend\assets\MainAsset',
        'common\SharedAssets\SweetAllertAsset',
        'common\SharedAssets\EditableAsset',
    ];
}