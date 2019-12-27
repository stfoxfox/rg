<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 03/07/2017
 * Time: 01:45
 */

namespace common\SharedAssets;


use yii\web\AssetBundle;

class SquareCroperAsset extends AssetBundle
{


    public $sourcePath = '@common/assets/custom/common/square_croper';



    public $js = [
        'square_croper.js'



    ];
    public $depends = [
        'backend\assets\MainAsset',

        'common\SharedAssets\CroperAsset',









    ];


}