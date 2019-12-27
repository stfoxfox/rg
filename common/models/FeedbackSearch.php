<?php
namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * Class FeedbackSearch
 * @package common\models
 */
class FeedbackSearch extends Feedback
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

        $this->setAttributes($params);
        if(!$this->validate()) {
            return $dataProvider;
        }

        $model->addOrderBy(['created_at' => SORT_DESC]);

        return $dataProvider;
    }
}