<?php
namespace common\models;
use yii\data\ActiveDataProvider;

/**
 * Class GalleryItemSearch
 * @package common\models
 * @inheritdoc
 */
class GalleryItemSearch extends GalleryItem
{
    public $parentModelShortName = 'GalleryItem';

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['gallery_id'], 'safe'],
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
                'pageSize' => 5,
            ],
        ]);

        $this->setAttributes($params);
        if(!$this->validate()) {
            return $dataProvider;
        }

        $model->andWhere([
            'gallery_id' => $this->gallery_id,
        ])->addOrderBy(['sort' => SORT_ASC]);

        return $dataProvider;
    }
}