<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 06.11.15
 * Time: 11:41
 */

namespace common\SharedAssets;


use yii\web\AssetBundle;

class NestableAsset extends AssetBundle
{

    public $sourcePath = '@bower/nestable2/dist';


    public $css = [
//        'jquery.nestable.min.css',
    ];
    public $js = [
        'jquery.nestable.min.js',
    ];



}