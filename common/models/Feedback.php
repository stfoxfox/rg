<?php
namespace common\models;

use Yii;
use common\models\gii\BaseFeedback;
use yii\helpers\ArrayHelper;

/**
* This is the model class for table "feedback".
* Class Feedback
* @package common\models
* @inheritdoc
*/
class Feedback extends BaseFeedback
{
    const STATUS_NEW = 0;
    const STATUS_IN_WORK = 1;
    const STATUS_DONE = 2;

    const TYPE_FLAT = 0;
    const TYPE_CALLBACK = 1;
    const TYPE_EMAIL = 2;
    const TYPE_CONTACT = 3;

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
            'type' => 'Тип запроса',
            'status' => 'Статус',
            'name' => 'Посетитель',
            'email' => 'Email',
            'phone' => 'Телефон',
            'message' => 'Сообщение',
            'extra' => 'Дополнительно',
            'flat_id' => 'Квартира',
            'user_id' => 'Пользователь',
        ];
    }


}
