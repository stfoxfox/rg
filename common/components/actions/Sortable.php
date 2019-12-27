<?php
namespace common\components\actions;

use Yii;
use yii\base\Action;
use common\components\MyExtensions\MyActiveRecord;

/**
 * Class Sortable
 * @package common\components\actions
 */
class Sortable extends Action
{
    /** @var MyActiveRecord */
    public $modelClass;

    /** @var string */
    public $sortField = 'sort';

    /**
     * @return mixed
     * @throws \yii\db\Exception
     */
    public function run() {
        if (!Yii::$app->request->isAjax || empty(Yii::$app->request->post('order'))) {
            return $this->controller->sendJSONResponse(['error' => true]);
        }

        $class = $this->modelClass;
        if (!$class && empty(Yii::$app->request->post('table'))) {
            return $this->controller->sendJSONResponse(['error' => true]);
        }

        $table = !empty(Yii::$app->request->post('table')) ? Yii::$app->request->post('table')
            : $class::tableName();
        $order = Yii::$app->request->post('order');
        if ($order) {
            $i = 1;
            foreach ($order as $id) {
                Yii::$app->db->createCommand()
                    ->update($table, [$this->sortField => $i], ['id' => $id])
                    ->execute();
                $i++;
            }
            return $this->controller->sendJSONResponse(['error' => false]);
        }
        return $this->controller->sendJSONResponse(['error' => true]);
    }
}