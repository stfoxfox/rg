<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use common\components\controllers\BackendController;
use backend\widgets\editable\EditableAction;
use common\components\actions\Delete;
use common\components\actions\Sortable;
use backend\models\forms\BankForm;
use backend\models\forms\MortgageForm;
use common\models\Bank;
use common\models\BankSearch;
use common\models\Mortgage;
use common\models\MortgageSearch;

/**
 * Class BankController
 * @package backend\controllers
 */
class BankController extends BackendController
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
                'modelClass' => Bank::className(),
                'formClass' => BankForm::className(),
            ],
            'editable-mortgage' => [
                'class' => EditableAction::className(),
                'modelClass' => Mortgage::className(),
                'formClass' => MortgageForm::className(),
            ],
            'delete-bank' => [
                'class' => Delete::className(),
                'modelClass' => Bank::className(),
            ],
            'delete-mortgage' => [
                'class' => Delete::className(),
                'modelClass' => Mortgage::className(),
            ],
            'sort-bank' => [
                'class' => Sortable::className(),
                'modelClass' => Bank::className(),
            ],
            'sort-mortgage' => [
                'class' => Sortable::className(),
                'modelClass' => Mortgage::className(),
            ],
        ]);
    }

    /**
     * @return string
     */
    public function actionIndex() {
        $models = (new BankSearch())->search(Yii::$app->request->queryParams);
        $this->setTitleAndBreadcrumbs('Банки', [
            'label' => 'Список'
        ]);

        return $this->render('index', ['models' => $models]);
    }

    /**
     * @return mixed|string
     */
    public function actionViewGrid() {
        if (!Yii::$app->request->isPjax || empty(Yii::$app->request->get('bank_id')))
            return $this->sendJSONResponse('Данных нет');

        $models = (new MortgageSearch())->search(Yii::$app->request->queryParams);
        return $this->renderAjax('_mortgages_grid', ['models' => $models]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionAddBank() {
        $form = new BankForm();
        $this->setTitleAndBreadcrumbs('Новый банк', [
            ['label' => 'Банки', 'url' => ['index']],
            ['label' => 'Создать'],
        ]);

        if (Yii::$app->request->isPost && $form->load(Yii::$app->request->post())) {
            $bank = $form->create();
            if ($bank) {
                return $this->redirect(['edit-bank', 'id' => $bank->id]);
            }
        }

        return $this->render('edit-bank', ['edit_form' => $form, 'model' => null]);
    }

    /**
     * @return mixed
     */
    public function actionAddMortgage() {
        if (!Yii::$app->request->isAjax || empty(Yii::$app->request->post('bank_id')))
            return $this->sendJSONResponse(['error' => true]);

        $form = new MortgageForm([
            'title' => Yii::$app->request->post('title'),
            'bank_id' => Yii::$app->request->post('bank_id'),
        ]);
        if ($form->create()) {
            return $this->sendJSONResponse(['success' => true]);
        }

        return $this->sendJSONResponse(['error' => true]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionEditMortgage($id) {
        $item = $this->findMortgage($id);
        $form = new MortgageForm();
        $this->setTitleAndBreadcrumbs($item->title, [
            ['label' => 'Банки', 'url' => ['index']],
            ['label' => $item->bank->title, 'url' => ['edit-bank', 'id' => $item->bank->id]],
            ['label' => 'Редактировать'],
        ]);

        if (Yii::$app->request->isPost && $form->load(Yii::$app->request->post())) {
            if ($form->edit($item)) {
                return $this->redirect(['edit-bank', 'id' => $item->bank->id]);
            }
        }

        $form->loadFrom($item);
        return $this->render('edit-mortgage', ['edit_form' => $form]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionEditBank($id) {
        $bank = $this->findBank($id);
        $form = new BankForm();
        $this->setTitleAndBreadcrumbs($bank->title, [
            ['label' => 'Банки', 'url' => ['index']],
            ['label' => 'Редактировать'],
        ]);

        if (Yii::$app->request->isPost && $form->load(Yii::$app->request->post())) {
            if ($form->edit($bank)) {
                return $this->redirect(['index']);
            }
        }

        $form->loadFrom($bank);
        return $this->render('edit-bank', ['edit_form' => $form, 'model' => $bank]);
    }

    /**
     * @param $id
     * @return Bank
     * @throws NotFoundHttpException
     */
    protected function findBank($id) {
        $model = Bank::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('Банк не найден');
        }

        return $model;
    }

    /**
     * @param $id
     * @return Mortgage
     * @throws NotFoundHttpException
     */
    protected function findMortgage($id) {
        $model = Mortgage::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('Ипотека не найдена');
        }

        return $model;
    }

}