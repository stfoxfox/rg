<?php
namespace common\components\actions;

use Yii;
use yii\base\Action;
use common\components\MyExtensions\MyActiveRecord;
use yii\web\NotFoundHttpException;

/**
 * Class Delete
 * @package common\components\actions
 */
class Delete extends Action
{
    /** @var MyActiveRecord */
    public $modelClass;

    /**
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \Throwable
     */
    public function run() {
        if (!Yii::$app->request->isAjax || empty(Yii::$app->request->post('id')))
            return $this->controller->sendJSONResponse(['error' => true]);

        $model = $this->findModel(Yii::$app->request->post('id'));
        if ($model->delete()) {
            return $this->controller->sendJSONResponse(['error' => false]);
        }

        return $this->controller->sendJSONResponse(['error' => true]);
    }

    /**
     * @param $id
     * @return MyActiveRecord
     * @throws NotFoundHttpException
     */
    protected function findModel($id) {
        $static = $this->modelClass;
        $model = $static::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('Страница не найдена');
        }

        return $model;
    }
}