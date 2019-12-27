<?php
namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\helpers\VarDumper;

/**
 * Class FlatSearch
 * @package common\models
 * @inheritdoc
 */
class FlatSearch extends Flat
{
    const SEARCH_WITH_CORPUS = 'corpus';
    const SEARCH_WITH_SECTION = 'section';
    const SEARCH_WITH_FLOOR = 'floor';

    /** @var integer */
    public $data_id;
    /** @var string */
    public $data_type;
    /** @var integer */
    public $complex_id;

    /** @var string */
    public $total_area_starts;
    /** @var string */
    public $total_area_ends;
    /** @var string */
    public $price_starts;
    /** @var string */
    public $price_ends;
    /** @var array */
    public $floor_num;
    /** @var bool */
    public $is_euro;
    /** @var bool */
    public $is_classic;
    /** @var bool */
    public $is_decoration;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['data_id', 'data_type', 'complex_id'], 'safe'],
            [['total_area_starts', 'total_area_ends', 'price_starts', 'price_ends'], 'number'],
            [['rooms_count', 'floor_num', ], 'safe'],
            [['is_euro', 'is_classic', 'is_decoration'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'rooms_count' => 'Количество комнат',
            'total_area' => 'Общая площадь',
            'total_area_starts' => 'от',
            'total_area_ends' => 'до',
            'live_area' => 'Жилая площадь',
            'price' => 'Цена',
            'price_starts' => 'от',
            'price_ends' => 'до',
            'floor_num' => 'Этажи',
            'is_euro' => 'Евро',
            'is_classic' => 'Классика',
            'is_decoration' => 'С отделкой',
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

        $this->complex_id = $params['complex-id'];
        $model->innerJoinWith(['section sec' => function($query) {
            /** @var $query ActiveQuery */
            $query->andWhere(['sec.complex_id' => $this->complex_id]);
        }])->addOrderBy(['flat.number' => SORT_ASC]);

        if(!isset($params['data-id']) || !isset($params['data-type'])) {
            $dataProvider->totalCount = 5;
            return $dataProvider;
        }
        $this->data_id = $params['data-id'];
        $this->data_type = $params['data-type'];

        switch ($this->data_type) {
            case self::SEARCH_WITH_CORPUS:
//                $model->innerJoinWith(['section sec' => function($query) {
//                    /** @var $query ActiveQuery */
//                    $query->andWhere(['sec.corpus_num' => $this->data_id]);
//                }]);
                $model->andFilterWhere(['sec.corpus_num' => $this->data_id]);
                break;

            case self::SEARCH_WITH_SECTION:
//                $model->innerJoinWith(['section sec' => function($query) {
//                    /** @var $query ActiveQuery */
//                    $query->andWhere(['sec.id' => $this->data_id]);
//                }]);
                $model->andFilterWhere(['sec.id' => $this->data_id]);
                break;

            case self::SEARCH_WITH_FLOOR:
//                $model->innerJoinWith(['floor' => function($query) {
//                    /** @var $query ActiveQuery */
//                    $query->andWhere(['floor.id' => $this->data_id]);
//                }]);
                $model->andFilterWhere(['floor.id' => $this->data_id]);
                break;

            default:
                break;
        }

        return $dataProvider;
    }

    /**
     * @param $params
     * @return \yii\db\ActiveQuery
     */
    public function searchForFront($params) {
        $this->complex_id = $params['complex-id'];
        $page_size = $params['_limit'];
        $page = $params['_start'];
        $sort = isset($params['_sort']) ? $params['_sort'] : null;
        if ($sort && $sort == 'number_on_floor') {
            $sort = 'floor.number';
        }

        $direction = isset($params['_order']) ? $params['_order'] : null;

        $model = Flat::find()->andWhere(['flat.status' => Flat::STATUS_ENABLED])
            ->innerJoinWith(['section sec' => function($query) {
            /** @var $query ActiveQuery */
            $query->andWhere(['sec.complex_id' => $this->complex_id]);
        }])->offset($page)->limit($page_size);

        if ($sort && $direction) {
            $model->orderBy([$sort => ($direction == 'desc') ? SORT_DESC : SORT_ASC]);
        }

        $this->load($params);
        if(!$this->validate()) {
            return $model;
        }

        $model->andFilterWhere(['>=', 'total_price', $this->price_starts])
            ->andFilterWhere(['<=', 'total_price', $this->price_ends])
            ->andFilterWhere(['>=', 'total_area', $this->total_area_starts])
            ->andFilterWhere(['<=', 'total_area', $this->total_area_ends])
            ->andFilterWhere(['in', 'rooms_count', $this->rooms_count]);

        if ($this->floor_num) {
            $model->andWhere(['in', 'floor.number', $this->floor_num]);
        }

        if ($this->is_decoration) {
            $model->andWhere(['<>', 'flat.decoration', '']);
        }

        if ($this->is_euro) {
            $model->andFilterWhere(['like', 'flat.features', '%' . Flat::FEATURE_EURO . '%']);
        }

        if ($this->is_classic) {
            $model->andFilterWhere(['like', 'flat.decoration', '%' . Flat::DECORATION_CLASSIC . '%']);
        }

        return $model;
    }

}