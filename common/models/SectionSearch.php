<?php
namespace common\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * Class SectionSearch
 * @package common\models
 */
class SectionSearch extends Section
{
    /** @var string */
    public $total_area_gte;
    /** @var string */
    public $total_area_lte;
    /** @var string */
    public $total_price_gte;
    /** @var string */
    public $total_price_lte;

    /**
     * @inheritdoc
     */
    public function scenarios() {
        return parent::scenarios();
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['total_area_lte', 'total_area_gte', 'total_price_lte', 'total_price_gte'], 'safe'],
        ];
    }

    /**
     * @param $params
     * @return ActiveQuery
     */
    public function searchForFront($params) {
        $this->complex_id = $params['complex-id'];
        $model = self::find()->distinct()->innerJoinWith('flats f')
            ->andWhere(['complex_id' => $this->complex_id]);

        $this->load($params);
        if(!$this->validate()) {
            return $model;
        }

        $model->andFilterWhere(['>=', 'f.total_area', $this->total_area_gte])
            ->andFilterWhere(['<=', 'f.total_area', $this->total_area_lte])
            ->andFilterWhere(['>=', 'f.total_price', $this->total_price_gte])
            ->andFilterWhere(['<=', 'f.total_price', $this->total_price_lte]);

        return $model;
    }

}