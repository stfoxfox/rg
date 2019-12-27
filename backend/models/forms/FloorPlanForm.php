<?php

namespace backend\models\forms;

use common\models\File;
use Yii;
use yii\base\Model;
use common\models\FloorPlan;
use yii\web\UploadedFile;

/**
* This is the model class for FloorPlan form.
*/
class FloorPlanForm extends Model
{
    public $corpus_num;
    public $section_num;
    public $floor_num_starts;
    public $floor_num_ends;
    public $number_on_floor;
    public $external_id;
    public $complex_id;
    public $file_id;

    public $file;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['floor_num_starts', 'floor_num_ends', 'number_on_floor', 'file_id', 'complex_id'], 'integer'],
            [['corpus_num', 'section_num'], 'string', 'max' => 50],
            [['corpus_num', 'section_num', 'floor_num_starts', 'floor_num_ends', 'number_on_floor'], 'required'],
            [['external_id'], 'string', 'max' => 255],
            [['file'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return (new FloorPlan())->attributeLabels();
    }

    /**
     * @param FloorPlan $item
     */
    public function loadFrom($item) {
        $this->corpus_num = $item->corpus_num;
        $this->section_num = $item->section_num;
        $this->floor_num_starts = $item->floor_num_starts;
        $this->floor_num_ends = $item->floor_num_ends;
        $this->number_on_floor = $item->number_on_floor;
        $this->external_id = $item->external_id;
        $this->complex_id = $item->complex_id;
        $this->file_id = $item->file_id;
    }

    /**
     * @inheritdoc
     * @var FloorPlan $item
     */
    public function edit($item) {
        if (!$this->validate()) {
            return null;
        }

        $item->corpus_num = $this->corpus_num;
        $item->section_num = $this->section_num;
        $item->floor_num_starts = $this->floor_num_starts;
        $item->floor_num_ends = $this->floor_num_ends;
        $item->number_on_floor = $this->number_on_floor;
        $item->external_id = $this->external_id;

        $file_id = null;
        $file = $item->file ? $item->file : new File();
        if ($picture = UploadedFile::getInstance($this, 'file')) {
            $file_id = File::saveFile($picture, (new \ReflectionClass($item))->getShortName(), $file->id);
        }

        if ($item->save()) {
            if ($file_id) {
                $item->link('file', File::findOne($file_id));
            }

            return true;
        }

        return null;
    }

    /**
     * @return bool|null
     */
    public function create() {
        if (!$this->validate()) {
            return null;
        }

        $item = new FloorPlan();

        $item->corpus_num = $this->corpus_num;
        $item->section_num = $this->section_num;
        $item->floor_num_starts = $this->floor_num_starts;
        $item->floor_num_ends = $this->floor_num_ends;
        $item->number_on_floor = $this->number_on_floor;
        $item->external_id = $this->external_id;
        $item->complex_id = $this->complex_id;

        $file_id = null;
        $file = new File();
        if ($picture = UploadedFile::getInstance($this, 'file')) {
            $file_id = File::saveFile($picture, (new \ReflectionClass($item))->getShortName(), $file->id);
        }

        if ($item->save()) {
            if ($file_id > 0) {
                $item->link('file', File::findOne($file_id));
            }

            return true;
        }

        return null;
    }
}
