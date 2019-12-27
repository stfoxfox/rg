<?php
namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * Class PromoSearch
 * @package common\models
 * @inheritdoc
 */
class PromoSearch extends Promo
{
    public $parentModelShortName = 'Promo';

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

        $model->orderBy(['sort' => SORT_ASC]);

        return $dataProvider;
    }

}