<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\helpers\Html;
use common\models\SiteSettings;

class BaseFeedbackForm extends Model
{
    /**
     * @param string $title
     * @param string $body_text
     */
    public function sendEmail($title = '', $body_text = '') {
        $feedback_email = SiteSettings::findOne(['text_key' => 'feedback_email']);
        $config = SiteSettings::getMailTransport();

        if ($feedback_email && $config) {
            Yii::$app->mailer->setTransport($config);
            $body = Html::tag('p', ($title) ? $title : 'Зарегистрировано новое обращение');
            $body .= Html::tag('p', $body_text ? $body_text : '');

            try {
                Yii::$app->mailer->compose()
                    ->setFrom([$config['username'] => 'Обработка заявок ЖК Раменский'])
                    ->setTo($feedback_email->string_value)
                    ->setSubject('Поступила новая заявка')
                    ->setHtmlBody($body)
                    ->send();
            } catch (\Swift_TransportException $e) { }
        }
    }

    /**
     * @param $to
     * @param string $title
     * @param string $body_text
     */
    public function sendEmailTo($to, $title = '', $body_text = '') {
        $config = SiteSettings::getMailTransport();

        if ($config) {
            Yii::$app->mailer->setTransport($config);
            $body = Html::tag('p', $body_text ? $body_text : '');

            try {
                Yii::$app->mailer->compose()
                    ->setFrom([$config['username'] => 'Техподдержка ЖК Раменский'])
                    ->setTo($to)
                    ->setSubject(($title) ? $title : 'Ответ на Вашу заявку')
                    ->setHtmlBody($body)
                    ->send();
            } catch (\Swift_TransportException $e) { }
        }
    }

}