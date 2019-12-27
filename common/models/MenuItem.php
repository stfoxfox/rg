<?php
namespace common\models;

use Yii;
use common\models\gii\BaseMenuItem;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;

/**
 * Class MenuItem
 * @package common\models
 *
 * @inheritdoc
 * @property MenuItem[] $childs
 * @property $fullUrl
 */
class MenuItem extends BaseMenuItem
{
    const STATUS_DISABLED = 0;
    const STATUS_ENABLED = 1;

    /**
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return array
     */
    public static function getList() {
        return ArrayHelper::map(self::find()->orderBy('sort')->all(), 'id', 'title');
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'icon' => 'Иконка',
            'url' => 'URL',
            'controller' => 'Controller',
            'action' => 'Action',
            'params' => 'Params',
            'status' => 'Статус',
            'sort' => 'Sort',
            'parent_id' => 'Родитель',
            'menu_id' => 'Menu ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @param null $id
     * @return array
     */
    public static function getParentList($id = null) {
        $query = self::find()->orderBy('sort');
        if (!empty($id)) {
            $query->andWhere(['<>', 'id', $id]);
        }
        return ArrayHelper::map($query->all(), 'id', 'title');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChilds() {
        return $this->hasMany(self::className(), ['parent_id' => 'id'])
            ->andWhere(['menu_id' => $this->menu_id])
            ->orderBy('sort');
    }

    /**
     * @return array
     */
    public static function getControllersList() {
        $result = [];
        foreach (Yii::$app->params['siteMap'] as $id => $name) {
            $result[$id] = $name['name'];
        }
        return $result;
    }

    /**
     * @param $controller
     * @return array
     */
    public static function getActionsList($controller) {
        $result = [];
        $actions = ArrayHelper::getValue(Yii::$app->params['siteMap'], $controller . '.actions');
        if (!empty($actions)) {
            foreach ($actions as $id => $name) {
                $result[$id] = $name['name'];
            }
        }
        return $result;
    }

    /**
     * @param $controller
     * @param $action
     * @return array
     */
    public static function getParamsList($controller, $action) {
        $result = [];
        $params = ArrayHelper::getValue(Yii::$app->params['siteMap'], $controller . '.actions.' . $action . '.params');
        if (!empty($params)) {
            foreach ($params as $id => $name) {
                $result[$id] = $name['name'];
            }
        }
        return $result;
    }

    /**
     * @return string
     */
    public function getFullUrl() {
        if ($this->url)
            return Url::toRoute($this->url);

        $url = '/' . $this->controller . '/' . $this->action;
        $params = ($this->params && $this->params <> 'null') ? Json::decode($this->params) : [];

        return Url::to(ArrayHelper::merge([$url], $params));
    }
}
