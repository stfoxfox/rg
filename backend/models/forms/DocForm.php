<?php
namespace backend\models\forms;

use Yii;
use yii\base\Model;
use common\models\Doc;
use common\models\Complex;
use common\models\DocCategory;
use common\models\Section;

/**
 * Class DocForm
 * @package backend\models\forms
 */
class DocForm extends Model
{
    public $title;
    public $category_id;
    public $complex_id;
    public $corpus_num;
    public $section_id;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['category_id', 'complex_id', 'corpus_num', 'section_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['complex_id'], 'exist', 'skipOnError' => true, 'targetClass' => Complex::className(), 'targetAttribute' => ['complex_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => DocCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['section_id'], 'exist', 'skipOnError' => true, 'targetClass' => Section::className(), 'targetAttribute' => ['section_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'title' => 'Заголовок',
            'complex_id' => 'Комплекс',
            'corpus_num' => 'Корпус',
            'section_id' => 'Секция',
        ];
    }

    /**
     * @param Doc $item
     */
    public function loadFrom($item) {
        $this->title = $item->title;
        $this->category_id = $item->category_id;
        $this->complex_id = $item->complex_id;
        $this->corpus_num = $item->corpus_num;
        $this->section_id = $item->section_id;
    }

    /**
     * @inheritdoc
     * @var Doc $item
     */
    public function edit($item) {
        if (!$this->validate()) {
            return null;
        }

        $item->title = $this->title;
        $item->category_id = $this->category_id;
        $item->complex_id = $this->complex_id;
        $item->corpus_num = $this->corpus_num;
        $item->section_id = $this->section_id;
    
        if ($item->save()) {
            return true;
        }

        return null;
    }

    public function create() {
        if (!$this->validate()) {
            return null;
        }

        $item = new Doc();

        $item->title = $this->title;
        $item->category_id = $this->category_id;
        $item->complex_id = $this->complex_id;
        $item->corpus_num = $this->corpus_num;
        $item->section_id = $this->section_id;
    
        if ($item->save()) {
            return $item;
        }

        return null;
    }
}
