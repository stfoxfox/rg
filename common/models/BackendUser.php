<?php

namespace common\models;

use Yii;
use common\models\gii\BaseBackendUser
;
use yii\base\NotSupportedException;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
* This is the model class for table "backend_user".
*/
class BackendUser extends BaseBackendUser implements IdentityInterface
{

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }



    public static function getItemsForSelect(){

        return ArrayHelper::map(self::find()->all(), 'id', 'name');

    }

    public function uploadTo($attribute){

        if($this->$attribute)
            return \Yii::getAlias('@common')."/uploads/backend_users/{$this->$attribute}";
        else
            return null;


    }



    public static function getRolesForCheckboxes(){

        return ArrayHelper::map( \Yii::$app->authManager->getRoles(), 'name', 'name');
    }


    public static function getFullRolesList(){


        $rolesArray = array();

        $array =  \Yii::$app->authManager->getRoles();


        foreach ($array as $item){

            $rolesArray[]='{value: "'.$item->name.'", text: "'.$item->name.'"}';
        }


        return "[".implode(', ',$rolesArray)."]";


    }


    public function getRolesNameArray(){

        $rolesArray = array();

        $array =  \Yii::$app->authManager->getRolesByUser($this->id);

        foreach ($array as $item){

            $rolesArray[]=$item->name;
        }


        return $rolesArray;
    }


    public function getRolesList(){

        $rolesArray = array();

        $array =  \Yii::$app->authManager->getRolesByUser($this->id);

        foreach ($array as $item){

            $rolesArray[]='"'.$item->name.'"';
        }


        return implode(', ',$rolesArray);
    }

    public function canBeDeleted(){

        return false;
    }


}
