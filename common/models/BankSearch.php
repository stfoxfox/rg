<?php
namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * Class BankSearch
 * @package common\models
 * @inheritdoc
 */
class BankSearch extends Bank
{
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

        $model->addOrderBy(['sort' => SORT_ASC]);

        return $dataProvider;
    }
}