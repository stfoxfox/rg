<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 03/07/2017
 * Time: 21:05
 */

namespace common\SharedAssets;


use yii\web\AssetBundle;

class FormColorPicker extends AssetBundle
{


    public $sourcePath = '@common/assets/custom/common/color_picker';



    public $js = [
        'color_picker.js'



    ];
    public $depends = [
        'backend\assets\MainAsset',
        'common\SharedAssets\ColorPickerAsset',

    ];


}