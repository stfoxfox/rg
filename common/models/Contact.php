<?php
namespace common\models;

use Yii;
use common\models\gii\BaseContact;
use yii\helpers\ArrayHelper;

/**
* This is the model class for table "contact".
* Class Contact
* @package common\models
* @inheritdoc
*/
class Contact extends BaseContact
{
    /**
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return array
     */
    public static function getList() {
        return ArrayHelper::map(self::find()->all(), 'id', 'title');
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'address' => 'Адрес',
            'hours' => 'Часы работы',
            'phones' => 'Телефоны',
            'email' => 'Email',
        ];
    }
}
