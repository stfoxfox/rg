<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use common\components\controllers\BackendController;
use common\models\Contact;
use common\models\ContactSearch;
use backend\models\forms\ContactForm;
use backend\widgets\editable\EditableAction;
use common\components\actions\Delete;
use common\components\actions\Sortable;

/**
 * Class ContactController
 * @package backend\controllers
 */
class ContactController extends BackendController
{
    /** @inheritdoc */
    public function behaviors() {
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
    public function actions() {
        return ArrayHelper::merge(parent::actions(), [
            'editable' => [
                'class' => EditableAction::className(),
                'modelClass' => Contact::className(),
                'formClass' => ContactForm::className(),
            ],
            'delete' => [
                'class' => Delete::className(),
                'modelClass' => Contact::className(),
            ],
            'sort' => [
                'class' => Sortable::className(),
                'modelClass' => Contact::className(),
            ],
        ]);
    }

    /**
     * @return string
     */
    public function actionIndex() {
        $models = (new ContactSearch())->search(Yii::$app->request->queryParams);
        $this->setTitleAndBreadcrumbs('Контакты', [
            'label' => 'Список'
        ]);

        return $this->render('index', ['models' => $models]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionEdit($id) {
        $contact = $this->findModel($id);
        $form = new ContactForm();
        $this->setTitleAndBreadcrumbs($contact->title, [
            ['label' => 'Контакты', 'url' => ['index']],
            ['label' => 'Редактировать'],
        ]);

        if (Yii::$app->request->isPost && $form->load(Yii::$app->request->post())) {
            if ($form->edit($contact)) {
                return $this->redirect(['index']);
            }
        }

        $form->loadFrom($contact);
        return $this->render('edit', ['edit_form' => $form]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionAdd() {
        $form = new ContactForm();
        $this->setTitleAndBreadcrumbs('Новый контакт', [
            ['label' => 'Контакты', 'url' => ['index']],
            ['label' => 'Создать'],
        ]);

        if (Yii::$app->request->isPost && $form->load(Yii::$app->request->post())) {
            $contact = $form->create();
            if ($contact) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('edit', ['edit_form' => $form]);
    }

    /**
     * @param $id
     * @return Contact
     * @throws NotFoundHttpException
     */
    protected function findModel($id) {
        $model = Contact::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('Контакт не найден');
        }

        return $model;
    }
}