<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 03/07/2017
 * Time: 21:00
 */

namespace common\SharedAssets;


use yii\web\AssetBundle;

class SortAsset extends AssetBundle
{

    public $sourcePath = '@common/assets/custom/common/sort';



    public $js = [
        'sort.js'



    ];
    public $depends = [
        'backend\assets\MainAsset',
        'common\SharedAssets\JqueryUIAsset',

    ];
}