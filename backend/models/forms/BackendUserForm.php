<?php

namespace backend\models\forms;

use common\components\MyExtensions\MyFileSystem;
use Yii;
use yii\base\Model;
use common\models\BackendUser;
use yii\imagine\Image;
use yii\web\UploadedFile;

/**
* This is the model class for BackendUser form.
*/
class BackendUserForm extends Model
{

    const SCENARIO_ADD = 'add';
    const SCENARIO_EDIT = 'edit';

    public $username;
    public $email;
    public $password;
    public $roles;
    public $name;
    public $x;
    public $y;
    public $w;
    public $h;
    public $file_name;

    /**
     * BackendUserForm constructor.
     * @param BackendUser $user_model
     */
    public function loadFromUser($user_model = null)
    {





        if ($user_model) {

            $this->username = $user_model->username;



            $this->email = $user_model->email;
            $this->name = $user_model->name;

            $this->roles = $user_model->getRolesNameArray();
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

            'username' => 'Логин',
            'email' => 'E-mail',
            'file_name' => 'Фото',
            'password' => 'Пароль',
            'roles' => 'Уровни доступа',
            'name' => 'Имя',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\BackendUser', 'message' => 'Этот логин уже занят.', 'on' => self::SCENARIO_ADD],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['name', 'required'],
            ['name', 'trim'],
            ['roles', 'required'],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\BackendUser', 'message' => 'Этот адрес почты уже занят.', 'on' => self::SCENARIO_ADD],
            ['password', 'required', 'on' => self::SCENARIO_ADD],
            ['password', 'safe', 'on' => self::SCENARIO_EDIT],
            ['password', 'string', 'min' => 6],
            [['x', 'y', 'w', 'h'], 'safe'],
            [['file_name'], 'string', 'max' => 255],
            [['file_name'], 'file', 'extensions' => ['jpg', 'png'], 'maxFiles' => 1],
        ];
    }

    /**
     * Signs user up.
     *
     * @return BackendUser|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new BackendUser();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->name = $this->name;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        $cropImage = false;
        if ($picture = UploadedFile::getInstance($this, 'file_name')) {

            $user->file_name = uniqid() . "_" . md5($picture->name) . "." . $picture->extension;




            $cropImage = Image::crop($picture->tempName, intval($this->w), intval($this->h), [intval($this->x), intval($this->y)]);
        }


        if ($user->save()) {

            if ($this->roles) {

                foreach ($this->roles as $role_item) {

                    $auth = \Yii::$app->authManager;


                    // add "admin" role and give this role the "updatePost" permission
                    // as well as the permissions of the "author" role
                    $role = $auth->getRole($role_item);



                    // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
                    // usually implemented in your User model.
                    $auth->assign($role, $user->id);
                }
            }

            if ($cropImage) {

                $cropImage->save(MyFileSystem::makeDirs($user->uploadTo('file_name')));
            }

            return $user;
        }

        return null;
    }

    /**
     * @param BackendUser $user
     * @return BackendUser|null
     */
    public function edit( $user)
    {
        if (!$this->validate()) {
            return null;
        }


        $user->username = $this->username;
        $user->email = $this->email;
        $user->name = $this->name;

        if ($this->password) {
            $user->setPassword($this->password);
            $user->generateAuthKey();
        }
        $cropImage = false;
        if ($picture = UploadedFile::getInstance($this, 'file_name')) {

            $user->file_name = uniqid() . "_" . md5($picture->name) . "." . $picture->extension;




            $cropImage = Image::crop($picture->tempName, intval($this->w), intval($this->h), [intval($this->x), intval($this->y)]);
        }


        if ($user->save()) {

            $auth = \Yii::$app->authManager;
            $auth->revokeAll($user->id);

            if ($this->roles) {



                foreach ($this->roles as $role_item) {

                    $auth = \Yii::$app->authManager;


                    // add "admin" role and give this role the "updatePost" permission
                    // as well as the permissions of the "author" role
                    $role = $auth->getRole($role_item);



                    // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
                    // usually implemented in your User model.
                    $auth->assign($role, $user->id);
                }
            }

            if ($cropImage) {

                $cropImage->save(MyFileSystem::makeDirs($user->uploadTo('file_name')));
            }

            return $user;
        }

        return null;
    }

    public function loadFrom($model)
    {
        $this->loadFromUser($model);
    }

    public function create()
    {
        throw new \yii\base\NotSupportedException();
    }
}
