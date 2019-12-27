<?php
namespace frontend\models;

use Yii;
use yii\helpers\Html;
use common\models\Feedback;
use yii\helpers\Json;

/**
 * Class MailToForm
 * @package frontend\models
 */
class MailToForm extends BaseFeedbackForm
{
    public $name;
    public $email;
    public $link;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['link'], 'string'],
            [['name', 'email', 'link'], 'string', 'max' => 255],
            ['email', 'email'],
            [['name', 'email'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'name' => 'Ваше имя',
            'email' => 'E-mail',
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
        $item->type = Feedback::TYPE_EMAIL;
        $item->status = Feedback::STATUS_NEW;
        $item->name = $this->name;
        $item->email = $this->email;
        $item->message = 'Заявка по email ' . Html::a($this->email, 'mailto:' . $this->email);

        if (!Yii::$app->user->isGuest) {
            $item->user_id = Yii::$app->user->id;
        }

        $message = '';
        if ($this->link) {
            $item->extra = Json::encode(['Страница' => Html::a($this->link, $this->link)]);
            $message = '<br/>Страница: ' . Html::a($this->link, $this->link);
        }

        if ($item->save()) {
            $this->sendEmail('Зарегистрировано обращение от ' . $item->name, $item->message . $message);
            return $item;
        }

        return null;
    }
}
