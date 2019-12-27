<?php
namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * Class MortgageSearch
 * @package common\models
 * @inheritdoc
 */
class MortgageSearch extends Mortgage
{
    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['bank_id'], 'safe'],
        ];
    }

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

        $this->setAttributes($params);
        if(!$this->validate()) {
            return $dataProvider;
        }

        $model->andWhere([
            'bank_id' => $this->bank_id,
        ])->addOrderBy(['sort' => SORT_ASC]);

        return $dataProvider;
    }
}