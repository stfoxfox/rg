<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 20/06/2017
 * Time: 23:31
 */

namespace backend\controllers;

use common\models\BackendUser;
use backend\models\forms\BackendUserForm;
use backend\widgets\editable\EditableAction;
use common\components\controllers\BackendController;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\validators\EmailValidator;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class BackendUsersController extends BackendController
{


    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [

                    [

                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'editable' => [
                'class' => EditableAction::className(),
                'modelClass' => BackendUser::className(),
                'formClass' => BackendUserForm::className(),
            ],
        ]);
    }

    public function actionIndex(){



        $this->setTitleAndBreadcrumbs("Администраторы");

        $users = BackendUser::find()
            ->where(['status'=>BackendUser::STATUS_ACTIVE])
            ->orderBy('id')
            ->all();

        return $this->render('index',['users'=>$users]);

    }


    public function actionEdit($id){



        $this->pageHeader = "Изменение администратора";

        if ($user = BackendUser::findOne($id)){


        $userForm = new BackendUserForm(['scenario' => BackendUserForm::SCENARIO_EDIT]);

            $userForm->loadFromUser($user);


        if ($userForm->load(Yii::$app->request->post()) && $userForm->edit($user)){

            return $this->redirect(Url::toRoute(['index']));
        }

            $this->setTitleAndBreadcrumbs("Изменение администратора:{$user->name}",[['label' => 'Администраторы', 'url' => ['backend-users/index']]]);

        return $this->render('edit',['addForm'=>$userForm,'item'=>$user]);

        }

        throw  new  NotFoundHttpException("Пользователь не найден");
    }


    public function actionItemEditRoles(){

        $pk = Yii::$app->request->post('pk');
        $value = Yii::$app->request->post('value');

        if ($item = BackendUser::findOne($pk)){

            $auth = Yii::$app->authManager;
            $auth->revokeAll($item->id);


            foreach ($value as $role_item){

                $auth = Yii::$app->authManager;

                $role = $auth->getRole($role_item);




                $auth->assign($role, $item->id);
            }

            return $this->sendJSONResponse(['success'=>true]);

        }

        throw  new NotFoundHttpException('Элемент не найден');




    }


    public function actionDell(){

        $user_id = Yii::$app->request->post('item_id');

        if($user_id){

            /** @var BackendUser $user */
            if($user = BackendUser::findOne($user_id)){

                if($user->canBeDeleted()){

                    $user->delete();

                }else{

                    $user->status=BackendUser::STATUS_DELETED;
                    $user->save();
                }

                return $this->sendJSONResponse(array('error'=>false,'item_id'=>$user_id));
            }
        }



        return $this->sendJSONResponse(array('error'=>true));
    }
    public function actionItemEditName(){

        $pk = Yii::$app->request->post('pk');
        $value = Yii::$app->request->post('value');

        if ($item = BackendUser::findOne($pk)){


            $item->name=$value;


            $item->save();

            return $this->sendJSONResponse(['success'=>true]);

        }

        throw  new NotFoundHttpException('Элемент не найден');




    }

    public function actionItemEditEmail(){

        $pk = Yii::$app->request->post('pk');
        $value = Yii::$app->request->post('value');

        if ($item = BackendUser::findOne($pk)){

            $validator = new  EmailValidator();

            if ($validator->validate($value, $error)) {
                $item->email=$value;


                $item->save();

                return $this->sendJSONResponse(['success'=>true]);

            } else {
                throw new BadRequestHttpException("Не правильный формат E-mail");
            }

        }

        throw  new NotFoundHttpException('Элемент не найден');




    }

    public function actionAddItem(){


        $this->setTitleAndBreadcrumbs("Добавление администратора",[['label' => 'Администраторы', 'url' => ['backend-users/index']]]);


        $userForm = new BackendUserForm(['scenario' => BackendUserForm::SCENARIO_ADD]);



        if ($userForm->load(Yii::$app->request->post()) && $user = $userForm->signup()){

            return $this->redirect(Url::toRoute(['index']));
        }


        return $this->render('add',['addForm'=>$userForm]);

    }


}