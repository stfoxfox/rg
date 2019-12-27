<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use backend\models\forms\ComplexForm;
use backend\widgets\editable\EditableAction;
use common\components\controllers\BackendController;
use common\models\Complex;
use common\models\ComplexSearch;

/**
 * Class ComplexController
 * @package backend\controllers
 */
class ComplexController extends BackendController
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
                'modelClass' => Complex::className(),
                'formClass' => ComplexForm::className(),
            ],
        ]);
    }

    /**
     * @return string
     */
    public function actionIndex() {
        $models = (new ComplexSearch())->search(Yii::$app->request->queryParams);
        $this->setTitleAndBreadcrumbs('Комплексы', [
            'label' => 'Список'
        ]);

        return $this->render('index', ['models' => $models]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionEditComplex($id) {
        $model = $this->findComplex($id);
        $form = new ComplexForm();
        $this->setTitleAndBreadcrumbs($model->title, [
            ['label' => 'Комплексы', 'url' => ['index']],
            ['label' => 'Редактировать'],
        ]);

        if (Yii::$app->request->isPost && $form->load(Yii::$app->request->post())) {
            if ($form->edit($model)) {
                return $this->redirect(['index']);
            }
        }

        $form->loadFrom($model);
        return $this->render('edit', ['edit_form' => $form]);
    }

    /**
     * @param $id
     * @return Complex
     * @throws NotFoundHttpException
     */
    protected function findComplex($id) {
        $model = Complex::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('Комплекс не найден');
        }

        return $model;
    }
}