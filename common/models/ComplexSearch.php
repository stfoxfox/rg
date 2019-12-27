<?php
namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

/**
 * Class ComplexSearch
 * @package common\models
 * @inheritdoc
 */
class ComplexSearch extends Complex
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

        $model->orderBy(['sort' => SORT_ASC]);

        return $dataProvider;
    }

    /**
     * @param $params
     * @return ActiveQuery
     */
    public function searchForFront($params) {
        $page_size = $params['_limit'];
        $page = $params['_start'];
        $sort = isset($params['_sort']) ? $params['_sort'] : null;

        $direction = isset($params['_order']) ? $params['_order'] : null;

        $model = self::find()->offset($page)->limit($page_size);

        if ($sort && $direction) {
            $model->orderBy([$sort => ($direction == 'desc') ? SORT_DESC : SORT_ASC]);
        }

        $this->load($params);
        if(!$this->validate()) {
            return $model;
        }

        return $model;
    }

}