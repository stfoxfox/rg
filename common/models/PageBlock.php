<?php

namespace common\models;

use common\components\MyExtensions\MyWidget;
use Yii;
use common\models\gii\BasePageBlock
;

/**
 * Class PageBlock
 * @package common\models
 *
 * @inheritdoc
 * @property PageBlock[] $childBlocks
 */
class PageBlock extends BasePageBlock
{
    const BLOCKS = [
        12 => [
            'widgetClass' => 'common\widgets\text\TextSimpleWidget'
        ],
        1 => [
            'widgetClass' => 'common\widgets\text\TextWidget'
        ],
        2 => [
            'widgetClass' => 'common\widgets\text\TextContainerWidget'
        ],
        27 => [
            'widgetClass' => 'common\widgets\text\TextColumnWidget'
        ],

        22 => [
            'widgetClass' => 'common\widgets\image\ImageWidget'
        ],
        26 => [
            'widgetClass' => 'common\widgets\image\ImageSimpleWidget'
        ],
        32 => [
            'widgetClass' => 'common\widgets\image\ImagePromoWidget'
        ],

        3 => [
            'widgetClass' => 'common\widgets\gallery\GalleryWidget'
        ],
        7 => [
            'widgetClass' => 'common\widgets\gallery\GalleryCorpusWidget'
        ],
        8 => [
            'widgetClass' => 'common\widgets\gallery\GalleryCorpusMonthWidget'
        ],

        4 => [
            'widgetClass' => 'common\widgets\promo\PromoWidget'
        ],
        5 => [
            'widgetClass' => 'common\widgets\contact\ContactWidget'
        ],
        6 => [
            'widgetClass' => 'common\widgets\news\NewsWidget'
        ],
        9 => [
            'widgetClass' => 'common\widgets\video\VideoWidget'
        ],
        10 => [
            'widgetClass' => 'common\widgets\mortgage\MortgageCalcWidget'
        ],
        11 => [
            'widgetClass' => 'common\widgets\banners\BannersWidget'
        ],
        13 => [
            'widgetClass' => 'common\widgets\statistics\StatisticsWidget'
        ],
        25 => [
            'widgetClass' => 'common\widgets\statistics\StatisticsEntryWidget'
        ],
        14 => [
            'widgetClass' => 'common\widgets\rewards\RewardsWidget'
        ],

        15 => [
            'widgetClass' => 'common\widgets\details\DetailsWidget'
        ],
        23 => [
            'widgetClass' => 'common\widgets\details\DetailWidget'
        ],

        16 => [
            'widgetClass' => 'common\widgets\workers\WorkerWidget'
        ],
        17 => [
            'widgetClass' => 'common\widgets\workers\WorkersContainerWidget'
        ],

        18 => [
            'widgetClass' => 'common\widgets\features\FeatureWidget'
        ],
        19 => [
            'widgetClass' => 'common\widgets\features\FeaturesContainerWidget'
        ],

        20 => [
            'widgetClass' => 'common\widgets\flat\FlatSelectionWidget'
        ],

        21 => [
            'widgetClass' => 'common\widgets\main_slider\MainSliderWidget'
        ],

        24 => [
            'widgetClass' => 'common\widgets\map\MapWidget'
        ],

        31 => [
            'widgetClass' => 'common\widgets\map\MapTagWidget'
        ],

        28 => [
            'widgetClass' => 'common\widgets\callback\CallbackWidget'
        ],

        29 => [
            'widgetClass' => 'common\widgets\building_progress\BuildingProgressWidget'
        ],

        30 => [
            'widgetClass' => 'common\widgets\contact\ContactContainerWidget'
        ],
    ];

    public function getBlockTemplateForBackend() {
        $blocks = self::BLOCKS;
        return $blocks[$this->type]['saveView'];
    }

    /**
     * @return string html code
     */
    public function getDataWidget(){
        $data = json_decode($this->data);
        $widget = $data->class_name;
        if(isset($data->params))
            return $widget::widget([
                'params' => get_object_vars($data->params),
                'page_id' => $this->page_id,
                'block_id' => $this->id,
                'parent_id' => $this->parent_id,
            ]);
        else
            return $widget();
    }

    public function getWidgetClassName(){
        $data = json_decode($this->data);
        $widget = $data->class_name;
        if(isset($widget))
            return $widget;
        else
            return false;
    }

    /**
     * @return MyWidget
     */
    public function getWidgetClass() {
        $data = json_decode($this->data);
        $widget = $data->class_name;
        if(isset($data->params))
            return new $widget([
                'params' => get_object_vars($data->params),
                'page_id' => $this->page_id,
                'block_id' => $this->id,
                'parent_id' => $this->parent_id,
            ]);
        else
            return new $widget();
    }

    public function getModelClassName(){
        $data = json_decode($this->data);
        $widget = $data->class_name;
        $modelClassName = $widget::getForm();
        if(isset($modelClassName))
            return $modelClassName;
        else
            return false;
    }

    public function getDataParams(){
        $data = json_decode($this->data);
        $params = $data->params;
        if(isset($params))
            return $params;
        else
            return false;
    }

    public function deleteBlockImageField($imageField){
        $data = json_decode($this->data);
        $params = $data->params;
        if(isset($params)){
            $widgetClass = $this->widgetClassName;
            $modelClass = $this->modelClassName;
            $model = new $modelClass();
            $photo_file = $model->uploadTo($imageField,$this->page_id,basename(str_replace('\\', '/', $widgetClass))).(empty($params->$imageField)?'':('/'.$params->$imageField));
            if(!empty($params->$imageField)){
                unlink($photo_file);
                unset($params->$imageField);
            }
            $this->data = \yii\helpers\Json::encode(['class_name' => $widgetClass, 'params' => $params]);
            return $this->save();
        }
        else
            return false;
    }

    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }
        $modelClass = $this->modelClassName;
        foreach ($modelClass::types() as $imageField => $inputType) {
            if($inputType == 'imageInput')
                $this->deleteBlockImageField($imageField);
        }
        return true;
    }

    /**
     * @param $widget_class
     * @return int|null|string
     */
    public static function getType($widget_class) {
        foreach (self::BLOCKS as $type_id => $block) {
            if ($block['widgetClass'] == $widget_class)
                return $type_id;
        }

        return null;
    }

    /**
     * @param $type_id
     * @return array
     */
    public static function getChildBlocksList($type_id) {
        $blocks = self::BLOCKS;
        if (isset($blocks[$type_id]) && isset($blocks[$type_id]['widgetClass'])) {
            /** @var MyWidget $widget */
            $widget = new $blocks[$type_id]['widgetClass'];
            return $widget->childs;
        }

        return [];
    }

    /**
     * @return array
     */
    public static function getRootBlocksList() {
        $menu = [];
        foreach (self::BLOCKS as $type_id => $item) {
            /** @var MyWidget $widget */
            $widget = new $item['widgetClass'];
            if ($widget->show_in_root) {
                $menu [$type_id]= $item;
            }
        }

        return $menu;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildBlocks() {
        return $this->getPageBlocks()->orderBy('sort');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildBlocksByType($type) {
        return $this->getPageBlocks()->andWhere(['type' => $type])->orderBy('sort');
    }

    /**
     * @param $type
     * @return static
     */
    public function getChildBlock($type) {
        return self::findOne(['type' => $type, 'parent_id' => $this->id]);
    }
    
}
