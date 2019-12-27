<?php
namespace frontend\models;

use Yii;
use common\models\Feedback;

/**
 * Class ContactForm
 * @package frontend\models
 */
class ContactForm extends BaseFeedbackForm
{
    public $name;
    public $email;
    public $phone;
    public $message;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['message'], 'string'],
            [['name', 'email'], 'string', 'max' => 255],
            ['email', 'email'],
            [['phone'], 'string', 'max' => 50],
//            ['phone', 'match', 'pattern' => '/^[0-9]+$/', 'message' => 'Введите правильный номер'],
//            [['message', 'name', 'email', 'phone', 'flat_id'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'name' => 'Ваше имя',
            'email' => 'E-mail',
            'phone' => 'Телефон',
            'message' => 'Особые пожелания',
        ];
    }

    /**
     * @return Feedback|null
     */
    public function create() {
        if (!$this->validate()) {
            return null;
        }

        $item = new Feedback();

        $item->type = Feedback::TYPE_CONTACT;
        $item->status = Feedback::STATUS_NEW;
        $item->name = $this->name;
        $item->email = $this->email;
        $item->phone = $this->phone;
        $item->message = $this->message;

        if (!Yii::$app->user->isGuest) {
            $item->user_id = Yii::$app->user->id;
        }

        if ($item->save()) {
            $this->sendEmail('Зарегистрировано обращение от ' . $item->name, $item->message);
            return $item;
        }

        return null;
    }
}
