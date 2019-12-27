<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 03/07/2017
 * Time: 02:06
 */

namespace common\SharedAssets;


use yii\web\AssetBundle;

class DeleteAsset extends AssetBundle
{


    public $sourcePath = '@common/assets/custom/common/delete';



    public $js = [
        'delete.js'



    ];
    public $depends = [
        'backend\assets\MainAsset',
        'common\SharedAssets\SweetAllertAsset',

    ];
}