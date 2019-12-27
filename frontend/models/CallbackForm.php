<?php
namespace frontend\models;

use Yii;
use yii\helpers\Html;
use common\models\Feedback;
use common\models\Complex;
use yii\helpers\Json;

/**
 * Class CallbackForm
 * @package frontend\models
 */
class CallbackForm extends BaseFeedbackForm
{
    public $phone;
    public $complex;
    public $time;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['complex'], 'integer'],
            [['phone', 'time'], 'string', 'max' => 255],
//            ['phone', 'match', 'pattern' => '/^[0-9]+$/', 'message' => 'Введите правильный номер'],
//            [['phone', 'complex', 'time'], 'required'],
            [['complex'], 'exist', 'skipOnError' => true, 'targetClass' => Complex::className(), 'targetAttribute' => ['complex' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'phone' => 'Телефон',
            'complex' => 'Жилой комплекс',
            'time' => 'Время',
        ];
    }

    /**
     * @return Feedback|null
     */
    public function create() {
        if (!$this->validate()) {
            return null;
        }

        $extra = [];
        $complex = null;
        if ($this->complex) {
            $complex = Complex::findOne($this->complex);
        }

        $item = new Feedback();
        $item->type = Feedback::TYPE_CALLBACK;
        $item->status = Feedback::STATUS_NEW;
        $item->message = 'Заявка по телефону ' . Html::a($this->phone, 'tel:' . $this->phone);

        $message = '';
        if ($complex) {
            $extra['Комплекс'] = $complex->title;
            $message = '<br/>Комплекс: ' . $complex->title;
        }

        if ($this->time) {
            $extra['Время'] = $this->time;
        }

        $item->extra = Json::encode($extra);

        if (!Yii::$app->user->isGuest) {
            $item->user_id = Yii::$app->user->id;
        }

    
        if ($item->save()) {
            $this->sendEmail('', $item->message . $message);
            return $item;
        }

        return null;
    }
}
