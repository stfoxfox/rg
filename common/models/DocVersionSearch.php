<?php
namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * Class DocVersionSearch
 * @package common\models
 */
class DocVersionSearch extends DocVersion
{
    public $parentModelShortName = 'DocVersion';

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['doc_id'], 'safe'],
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
            'doc_id' => $this->doc_id,
        ]);

        return $dataProvider;
    }
}