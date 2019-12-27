<?php
namespace frontend\models;

use Yii;
use common\models\User;

/**
 * Class PasswordResetRequestForm
 * @package frontend\models
 *
 * @inheritdoc
 */
class PasswordResetRequestForm extends BaseFeedbackForm
{
    public $email;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'Такого адреса у нас нет'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return (new User())->attributeLabels();
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function create() {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if (!$user) {
            return false;
        }
        
        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }

        $resetLink = Yii::$app->urlManager->createAbsoluteUrl([
            '/site/reset-password',
            'token' => $user->password_reset_token
        ]);
        $body = 'ЖК Новый Раменский, приветсвует Вас, ' . $user->name . '. Для сброса пароля проследуйте по ссылке: ' . $resetLink;

        $this->sendEmailTo($user->email, '', $body);
        return true;
    }
}
