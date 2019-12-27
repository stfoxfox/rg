<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use yii\helpers\ArrayHelper;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $email;
    public $password;
    public $password_repeat;
    public $first_name;
    public $last_name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Email уже занят'],

            [['password', 'password_repeat'], 'required'],
            [['password', 'password_repeat'], 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Неверно повторно введен пароль'],

            [['first_name', 'last_name'], 'required'],
            [['first_name', 'last_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return ArrayHelper::merge((new User())->attributeLabels(), [
            'password_repeat' => 'Подтверждение пароля',
        ]);
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup() {
        if ($this->validate()) {
            $user = new User();

            $user->first_name = $this->first_name;
            $user->last_name = $this->last_name;
            $user->email = $this->email;
            $user->username = $this->email;

            $user->status = User::STATUS_ACTIVE;
            $user->setPassword($this->password);
            $user->generateAuthKey();

            if ($user->save(false)) {
                $auth = Yii::$app->authManager;
                $role = $auth->getRole('user');
                if (!$role) {
                    $role = $auth->createRole('user');
                    $auth->add($role);
                }
                $auth->assign($role, $user->id);

                return $user;
            }
        }

        return null;
    }
}
