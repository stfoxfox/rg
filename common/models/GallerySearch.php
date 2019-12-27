<?php
namespace common\models;
use yii\data\ActiveDataProvider;

/**
 * Class GallerySearch
 * @package common\models
 * @inheritdoc
 */
class GallerySearch extends Gallery
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
                'pageSize' => 5,
            ],
        ]);

        $this->load($params);
        if(!$this->validate()) {
            return $dataProvider;
        }

        return $dataProvider;
    }
}