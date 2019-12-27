<?php

namespace backend\models\forms;

use Yii;
use yii\base\Model;
use common\models\User;
/**
* This is the model class for User form.
*/
class UserForm extends Model
{
    public $username;
    public $auth_key;
    public $password_hash;
    public $password_reset_token;
    public $email;
    public $status;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email'], 'required'],
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['username'], 'unique'],
        ];
    }

    /**
     * @param User $item
     */
    public function loadFromItem($item)
    {
        $this->username = $item->username;
        $this->auth_key = $item->auth_key;
        $this->password_hash = $item->password_hash;
        $this->password_reset_token = $item->password_reset_token;
        $this->email = $item->email;
        $this->status = $item->status;
    }

    /**
     * @inheritdoc
     * @var User $item
     */
    public function edit($item)
    {
        if (!$this->validate()) {
            return null;
        }

        $item->username = $this->username;
        $item->auth_key = $this->auth_key;
        $item->password_hash = $this->password_hash;
        $item->password_reset_token = $this->password_reset_token;
        $item->email = $this->email;
        $item->status = $this->status;
    
        if ($item->save()) {
            return true;
        }

        return null;
    }

    public function create()
    {
        if (!$this->validate()) {
            return null;
        }

        $item = new User();

        $item->username = $this->username;
        $item->auth_key = $this->auth_key;
        $item->password_hash = $this->password_hash;
        $item->password_reset_token = $this->password_reset_token;
        $item->email = $this->email;
        $item->status = $this->status;
    
        if ($item->save()) {
            return $item;
        }

        return null;
    }
}
