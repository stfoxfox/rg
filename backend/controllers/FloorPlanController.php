<?php
namespace backend\controllers;

use backend\models\forms\FloorPlanImportForm;
use common\models\Section;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use common\components\controllers\BackendController;
use common\models\FloorPlan;
use common\models\FloorPlanSearch;
use backend\models\forms\FloorPlanForm;
use backend\widgets\editable\EditableAction;
use common\components\actions\Delete;
use common\components\actions\Sortable;

/**
 * Class FloorPlanController
 * @package backend\controllers
 */
class FloorPlanController extends BackendController
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
                'modelClass' => FloorPlan::className(),
                'formClass' => FloorPlanForm::className(),
            ],
            'item-delete' => [
                'class' => Delete::className(),
                'modelClass' => FloorPlan::className(),
            ],
            'item-sort' => [
                'class' => Sortable::className(),
                'modelClass' => FloorPlan::className(),
            ],
        ]);
    }

    /**
     * @return string
     */
    public function actionIndex() {
        ini_set('post_max_size', '30M');
        ini_set('upload_max_filesize', '30M');
        $this->setTitleAndBreadcrumbs('Планировки квартир', [
            'label' => 'Список'
        ]);

        $form = new FloorPlanImportForm(['complex_id' => $this->complex_id]);
        return $this->render('index', ['import_form' => $form]);
    }

    /**
     * @return string
     */
    public function actionList() {
        if (!Yii::$app->request->isPjax)
            return $this->sendJSONResponse('Данных нет');

        $models = (new FloorPlanSearch(['complex_id' => $this->complex_id]))->search(Yii::$app->request->queryParams);
        return $this->renderAjax('_plan_grid', [
            'models' => $models,
            'complex_id' => $this->complex_id
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionEditPlan($id) {
        $model = $this->findModel($id);
        $form = new FloorPlanForm();
        $this->setTitleAndBreadcrumbs($model->external_id, [
            ['label' => 'Планировки квартир', 'url' => ['index']],
            ['label' => 'Редактировать'],
        ]);

        if (Yii::$app->request->isPost && $form->load(Yii::$app->request->post())) {
            if ($form->edit($model)) {
                return $this->redirect(['index']);
            }
        }

        $form->loadFrom($model);
        return $this->render('edit', ['edit_form' => $form, 'model' => $model, 'complex_id' => $model->complex_id]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionAddPlan() {
        $form = new FloorPlanForm(['complex_id' => $this->complex_id]);
        $this->setTitleAndBreadcrumbs('Новая планировка', [
            ['label' => 'Планировки квартир', 'url' => ['index']],
            ['label' => 'Создать'],
        ]);

        if (Yii::$app->request->isPost && $form->load(Yii::$app->request->post())) {
            $model = $form->create();
            if ($model) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('edit', ['edit_form' => $form, 'model' => null, 'complex_id' => $this->complex_id]);
    }

    /**
     * @return mixed
     */
    public function actionChangeCorpus() {
        if (!Yii::$app->request->isAjax || empty(Yii::$app->request->post('value'))
            || empty(Yii::$app->request->post('complex_id')))
            return $this->sendJSONResponse(['success' => false]);

        $tag_options = ['prompt' => 'Секция'];
        $complex_id = Yii::$app->request->post('complex_id');
        $corpus_num = Yii::$app->request->post('value');

        return $this->sendJSONResponse([
            'success' => true,
            'section' => Html::renderSelectOptions(null, Section::getSectionsNumList($complex_id, $corpus_num), $tag_options),
        ]);
    }

    /**
     * @return mixed
     */
    public function actionImport() {
        if (!Yii::$app->request->isAjax || empty(Yii::$app->request->post()))
            return $this->sendJSONResponse(['error' => true]);

        $form = new FloorPlanImportForm();
        if ($form->load(Yii::$app->request->post())) {
            if ($form->create()) {
                return $this->sendJSONResponse(['success' => true]);
            }
        }

        return $this->sendJSONResponse(['error' => false]);
    }

    /**
     * @param $id
     * @return FloorPlan
     * @throws NotFoundHttpException
     */
    protected function findModel($id) {
        $model = FloorPlan::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('Планировка не найдена');
        }

        return $model;
    }

}