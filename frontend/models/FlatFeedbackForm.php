<?php
namespace frontend\models;

use Yii;
use yii\helpers\Json;
use common\models\Feedback;
use common\models\Flat;

/**
 * Class FlatFeedbackForm
 * @package frontend\models
 */
class FlatFeedbackForm extends BaseFeedbackForm
{
    public $name;
    public $email;
    public $phone;
    public $message;
    public $flat_id;
    public $promo;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['message', 'flat_id', 'promo'], 'string'],
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
            'promo' => 'Введите промо-код (если есть)',
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

        $item->type = Feedback::TYPE_FLAT;
        $item->status = Feedback::STATUS_NEW;
        $item->name = $this->name;
        $item->email = $this->email;
        $item->phone = $this->phone;
        $item->message = $this->message;

        if (!Yii::$app->user->isGuest) {
            $item->user_id = Yii::$app->user->id;
        }

        /** @var Flat $flat */
        $flat = null;
        if ($this->flat_id) {
            $item->flat_id = $this->flat_id;
            $flat = Flat::findOne($this->flat_id);
        }

        $extra = [];
        if ($this->promo) {
            $extra ['Промо']= $this->promo;
        }

        if ($flat) {
            $extra ['Квартира']= 'Кваритра №' . $flat->number;
        }

        $item->extra = Json::encode($extra);
    
        if ($item->save()) {
            $this->sendEmail('Зарегистрировано обращение от ' . $item->name, $item->message);
            return $item;
        }

        return null;
    }
}
