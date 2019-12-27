<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use common\components\controllers\BackendController;
use common\models\Promo;
use common\models\PromoSearch;
use backend\models\forms\PromoForm;
use backend\widgets\editable\EditableAction;
use common\components\actions\Delete;
use common\components\actions\Sortable;

/**
 * Class PromoController
 * @package backend\controllers
 */
class PromoController extends BackendController
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
                'modelClass' => Promo::className(),
                'formClass' => PromoForm::className(),
            ],
            'item-delete' => [
                'class' => Delete::className(),
                'modelClass' => Promo::className(),
            ],
            'item-sort' => [
                'class' => Sortable::className(),
                'modelClass' => Promo::className(),
            ],
        ]);
    }

    /**
     * @return string
     */
    public function actionIndex() {
        $promos = (new PromoSearch())->search(Yii::$app->request->queryParams);
        $this->setTitleAndBreadcrumbs('Акции и промо', [
            'label' => 'Список'
        ]);

        return $this->render('index', ['promos' => $promos]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionEditPromo($id) {
        $promo = $this->findModel($id);
        $form = new PromoForm();
        $this->setTitleAndBreadcrumbs($promo->title, [
            ['label' => 'Акции и промо', 'url' => ['index']],
            ['label' => 'Редактировать'],
        ]);

        if (Yii::$app->request->isPost && $form->load(Yii::$app->request->post())) {
            if ($form->edit($promo)) {
                return $this->redirect(['index']);
            }
        }

        $form->loadFrom($promo);
        return $this->render('edit', ['edit_form' => $form, 'model' => $promo]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionAddPromo() {
        $form = new PromoForm();
        $this->setTitleAndBreadcrumbs('Новая акция', [
            ['label' => 'Акции и промо', 'url' => ['index']],
            ['label' => 'Создать'],
        ]);

        if (Yii::$app->request->isPost && $form->load(Yii::$app->request->post())) {
            $promo = $form->create();
            if ($promo) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('edit', ['edit_form' => $form, 'model' => null]);
    }

    /**
     * @param $id
     * @return Promo
     * @throws NotFoundHttpException
     */
    protected function findModel($id) {
        $model = Promo::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('Акция не найдена');
        }

        return $model;
    }

}