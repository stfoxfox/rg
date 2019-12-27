<?php
namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * Class MenuSearch
 * @package common\models
 */
class MenuSearch extends Menu
{
    public $parentModelShortName = 'Menu';

    /**
     * @inheritdoc
     */
    public function scenarios() {
        return parent::scenarios();
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params) {
        $model=self::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->load($params);
        if(!$this->validate()) {
            return $dataProvider;
        }

        return $dataProvider;
    }

}