<?php
namespace common\widgets\flat;

use Yii;
use common\components\MyExtensions\MyWidget;
use common\widgets\flat\forms\FlatSelectionWidgetForm;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use common\models\Complex;
use common\models\Flat;

/**
 * Class FlatSelectionWidget
 * @package common\widgets\flat
 *
 * @inheritdoc
 */
class FlatSelectionWidget extends MyWidget
{
    public $icon = '<i class="fa fa-building"></i>';
    public $complex_id;

    /**
     * @return string
     */
    public static function getForm() {
        return FlatSelectionWidgetForm::className();
    }

    /**
     * @return string
     */
    public static function getBlockName() {
        return 'Подборка квартир';
    }

    /**
     * @return bool
     * @throws InvalidConfigException
     */
    public function init() {
        if($this->page_id == null)
            return false;

        $cookies = Yii::$app->request->cookies;
        if ($cookies->has('complex_id')) {
            $this->complex_id = $cookies->getValue('complex_id');
        } else {
            throw new InvalidConfigException('Complex must be set');
        }

        parent::init();
    }


    /**
     * @return string
     */
    public function run() {
        $model_class = $this->form;

        /** @var FlatSelectionWidgetForm $model */
        $model = new $model_class();
        $model->page_id = $this->page_id;
        $model->widget_name = basename($this->className());
        $model->attributes = $this->params;

        $flats = null;
        $flats_without_complex = null;
        switch ($model->selection) {
            case '1rooms_2floor':
                $query  = Flat::find()->joinWith('floorPlan')
                    ->innerJoinWith(['section sec' => function($query) use ($model) {
                        /** @var ActiveQuery $query */
                        $query->andWhere(['sec.corpus_num' => $model->corpus]);
                    }])->andWhere(['floor.number' => 2])->andWhere(['flat.rooms_count' => 1]);

                $flats_without_complex = clone $query;
                $flats = $query->andWhere(['sec.complex_id' => $this->complex_id]);
                $flats_without_complex->andWhere(['<>', 'sec.complex_id', $this->complex_id]);
                break;

            default:
                break;
        }

        return $this->render('index', [
            'model' => $model,
            'flats' => $flats,
            'flats_without_complex' => $flats_without_complex,
            'complex' => Complex::findOne($this->complex_id)
        ]);
    }
}