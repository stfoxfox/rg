<?php
namespace common\components\MyExtensions;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use common\components\behaviors\FileBehavior;

/**
 * Class MyActiveRecord
 * @package common\components\MyExtensions
 */
class MyActiveRecord extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'ts_behavior'=>[
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    self::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
            FileBehavior::className(),
        ];
    }

    /**
     * @param $attribute
     * @return array
     */
    public static function getAttributeEnums($attribute) {
        $return = array();

        $model_reflection = new \ReflectionClass(get_called_class());


        foreach($model_reflection->getConstants() as $constant=>$value) {
            if (preg_match('/^'.strtoupper($attribute).'.+/', $constant)) {


                $return[$value] =  \Yii::t('models/'.strtolower($model_reflection->getShortName()),$constant);;

            }
        }


        return $return;
    }

    public function isAttributeEnumerable($attribute) {
        $ret = false;

        $model_reflection = new \ReflectionClass($this);
        foreach(array_keys($model_reflection->getConstants()) as $constant) {
            if (preg_match('/^'.strtoupper($attribute).'.+/', $constant)) {
                $ret = true;
            }
        }

        return $ret;
    }

    /**
     * @param $attribute
     * @return array
     */
    public static function getAttributeSourceEnums($attribute) {
        $result = [];
        $enum = self::getAttributeEnums($attribute);
        if (!empty($enum)) {
            foreach ($enum as $key => $value) {
                $result []= ['value' => $key, 'text' => $value];
            }
        }

        return $result;
    }

}