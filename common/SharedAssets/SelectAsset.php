<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 03/07/2017
 * Time: 21:00
 */

namespace common\SharedAssets;


use yii\web\AssetBundle;

class SelectAsset extends AssetBundle
{

    public $sourcePath = '@common/assets/custom/common/select';



    public $js = [
        'select.js'



    ];
    public $depends = [
        'backend\assets\MainAsset',
        'common\SharedAssets\Select2Asset',

    ];
}