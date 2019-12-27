<?php
namespace backend\models\forms;

use common\components\MyExtensions\MyActiveRecord;
use Yii;
use yii\base\Model;
use common\models\MenuItem;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Class MenuItemForm
 * @package backend\models\forms
 */
class MenuItemForm extends Model
{
    public $id;
    public $title;
    public $icon;
    public $url;
    public $controller;
    public $action;
    public $params;
    public $json_params;
    public $status;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['title'], 'required'],
            [['status', 'id'], 'integer'],
            [['title', 'icon', 'url', 'controller', 'action'], 'string', 'max' => 255],
            ['url', 'url'],
            [['params', 'json_params'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'title' => 'Заголовок',
            'icon' => 'Иконка',
            'url' => 'URL',
            'controller' => 'Контроллер',
            'action' => 'Действие',
            'status' => 'Статус',
        ];
    }

    /**
     * @param MenuItem $item
     */
    public function loadFrom($item) {
        $this->id = $item->id;
        $this->title = $item->title;
        $this->icon = $item->icon;
        $this->url = $item->url;
        $this->controller = $item->controller;
        $this->action = $item->action;
        $this->status = $item->status;

        if ($item->params && $item->params <> 'null') {
            $this->json_params = Json::decode($item->params);
        }

        if (!empty($item->action)) {
            $this->params = $this->getParams();

        } else {
            $this->params = [];
        }
    }

    /**
     * @inheritdoc
     * @var MenuItem $item
     */
    public function edit($item) {
        if (!$this->validate()) {
            return null;
        }

        $item->title = $this->title;
        $item->icon = $this->icon;
        $item->url = $this->url;
        $item->controller = $this->controller;
        $item->action = $this->action;
        $item->params = Json::encode($this->json_params);
        $item->status = $this->status;
    
        if ($item->save()) {
            return true;
        }

        return null;
    }

    public function create() {
        if (!$this->validate()) {
            return null;
        }

        $item = new MenuItem();

        $item->title = $this->title;
        $item->icon = $this->icon;
        $item->url = $this->url;
        $item->controller = $this->controller;
        $item->action = $this->action;
        $item->params = Json::encode($this->json_params);
        $item->status = $this->status;
    
        if ($item->save()) {
            return $item;
        }

        return null;
    }

    /**
     * @return array
     */
    public function getParams() {
        return ArrayHelper::getValue(Yii::$app->params['siteMap'], $this->controller . '.actions.' . $this->action . '.params');
    }

    /**
     * @param $param
     * @return string
     */
    public function getParamName($param) {
        return ArrayHelper::getValue(Yii::$app->params['siteMap'], $this->controller . '.actions.' . $this->action . '.params.' . $param);
    }

    /**
     * @param $param
     * @return array
     */
    public function getParamList($param) {
        if (!isset($param['class'])) return [];

        /** @var MyActiveRecord $model */
        $model = $param['class'];
        $title = isset($param['title_attr']) ? $param['title_attr'] : 'title';

        return ArrayHelper::map($model::find()->limit(300)->all(), 'id', $title);
    }
}
