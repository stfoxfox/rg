<?php
namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * Class DocSearch
 * @package common\models
 * @inheritdoc
 */
class DocSearch extends Doc
{
    public $parentModelShortName = 'Doc';

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
        ]);

        $this->setAttributes($params);
        if(!$this->validate()) {
            return $dataProvider;
        }

        $model->andWhere([
            'category_id' => $this->category_id,
        ])->addOrderBy(['sort' => SORT_ASC]);

        return $dataProvider;
    }
}