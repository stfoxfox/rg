<?php
/**
 * Created by PhpStorm.
 * User: abpopov
 * Date: 26.08.15
 * Time: 23:20
 */

namespace common\components\MyExtensions;


class MyError {

    const BAD_REQUEST= 10000;


    public static function getMsg($code){

        $class = new \ReflectionClass(__CLASS__);
        $constants = array_flip($class->getConstants());

        return \Yii::t('app/error',$constants[$code]);
    }
}