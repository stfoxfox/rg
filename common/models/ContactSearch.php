<?php
namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * Class ContactSearch
 * @package common\models
 */
class ContactSearch extends Contact
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

        return $dataProvider;
    }
}