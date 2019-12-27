<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use common\components\controllers\BackendController;
use backend\widgets\editable\EditableAction;
use common\components\actions\Delete;
use backend\models\forms\FeedbackForm;
use common\models\Feedback;
use common\models\FeedbackSearch;

/**
 * Class FeedbackController
 * @package backend\controllers
 */
class FeedbackController extends BackendController
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
                'modelClass' => Feedback::className(),
                'formClass' => FeedbackForm::className(),
            ],
            'delete-item' => [
                'class' => Delete::className(),
                'modelClass' => Feedback::className(),
            ],
        ]);
    }

    /**
     * @return string
     */
    public function actionIndex() {
        $models = (new FeedbackSearch())->search(Yii::$app->request->queryParams);
        $this->setTitleAndBreadcrumbs('Запросы от посетителей', [
            'label' => 'Список'
        ]);

        return $this->render('index', ['models' => $models]);
    }

    /**
     * @param $id
     * @return Feedback
     * @throws NotFoundHttpException
     */
    protected function findFeedback($id) {
        $model = Feedback::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('Запрос не найден');
        }

        return $model;
    }
}