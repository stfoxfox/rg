<?php
namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use common\models\gii\BaseSection;

/**
 * Class Section
 * @package common\models
 * @inheritdoc
 *
 * @property Corpus $corpus
 * @property Page $page
 * @property FloorPlan[] $floorPlans
 * @property Floor[] $floorsOrdered
 */
class Section extends BaseSection
{
    const STATUS_NOT_READY = 0;
    const STATUS_IN_PROGRESS = 1;
    const STATUS_IS_READY = 2;

    /**
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return array
     */
    public static function getList() {
        return ArrayHelper::map(self::find()->all(), 'id', 'number');
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'number' => 'Номер',
            'corpus_num' => '№ корпуса',
            'floors_count' => 'Количесвто этажей',
            'quarter' => 'Квартал',
            'status' => 'Статус',
            'series' => 'Серия',
            'decoration' => 'Оформление',
            'complex_id' => 'Комплекс',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @param $complex_id
     * @return array
     */
    public static function getCorpuses($complex_id) {
        return self::find()->select('corpus_num')->distinct()
            ->where(['complex_id' => $complex_id])
            ->andWhere(['is not', 'corpus_num', null])->orderBy('corpus_num')->all();
    }

    /**
     * @param $complex_id
     * @return array
     */
    public static function getCorpusesList($complex_id) {
        return ArrayHelper::map(self::getCorpuses($complex_id), 'corpus_num', function($corpus) {
            /** @var $corpus self */
            return 'Корпус ' . $corpus->corpus_num;
        });
    }

    /**
     * @param $complex_id
     * @param $corpus_num
     * @return array
     */
    public static function getSectionsList($complex_id, $corpus_num) {
        $sections = self::find()
            ->andWhere(['complex_id' => $complex_id, 'corpus_num' => $corpus_num])->all();
        return ArrayHelper::map($sections, 'id', function($section) {
            /** @var $section self */
            return 'Номер ' . $section->number;
        });
    }

    /**
     * @param $complex_id
     * @param $corpus_num
     * @return array
     */
    public static function getSectionsNumList($complex_id, $corpus_num) {
        $sections = self::find()
            ->andWhere(['complex_id' => $complex_id, 'corpus_num' => $corpus_num])->all();
        return ArrayHelper::map($sections, 'number', function($section) {
            /** @var $section self */
            return 'Номер ' . $section->number;
        });
    }

    /**
     * @param $id
     * @param $complex_id
     * @return Section[]
     */
    public static function getOtherCorpusesInComplex($id, $complex_id) {
        return self::find()->select('corpus_num')->distinct()->andWhere(['complex_id' => $complex_id])
            ->andWhere(['<>', 'id', $id])->orderBy('corpus_num')->all();
    }

    /**
     * @return array
     */
    public function getFloorList() {
        return ArrayHelper::map($this->getFloors()->distinct(['number'])
            ->where(['>', 'number', 0])
            ->orderBy(['number' => SORT_ASC])
            ->all(), 'number', 'number'
        );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCorpus() {
        return $this->hasOne(Corpus::className(), ['corpus_num' => 'corpus_num']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage() {
        return $this->hasOne(Page::className(), ['id' => 'page_id'])->via('corpus');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFloorPlans() {
        return $this->hasMany(FloorPlan::className(), ['complex_id' => 'id'])->via('complex')
            ->andWhere(['floor_plan.corpus_num' => $this->corpus_num])
            ->andWhere(['floor_plan.section_num' => $this->number]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFloorsOrdered() {
        return $this->getFloors()->addOrderBy('floor.number');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFlats() {
        return $this->hasMany(Flat::className(), ['floor_id' => 'id'])->via('floors');
    }
}
