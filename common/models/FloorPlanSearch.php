<?php
namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * Class FloorPlanSearch
 * @package common\models
 * @inheritdoc
 */
class FloorPlanSearch extends FloorPlan
{
    public $parentModelShortName = 'FloorPlan';

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

        $model->andWhere(['complex_id' => $this->complex_id]);

        return $dataProvider;
    }

}