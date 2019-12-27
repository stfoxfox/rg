<?php
namespace common\widgets\gallery\forms;

use Yii;
use common\components\MyExtensions\WidgetModel;
use common\models\Gallery;

/**
 * Class GalleryCorpusMonthWidgetForm
 * @package common\widgets\gallery\forms
 *
 * @inheritdoc
 */
class GalleryCorpusMonthWidgetForm extends WidgetModel
{
    public $title;
    public $gallery;
    public $in_row;

    /**
     * @inheritdoc
     */
    public function init() {
        $this->dropDownData = [
            'gallery' => Gallery::getList(),
        ];

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['title', 'string', 'max' => 255],
            ['in_row', 'integer'],
            [['gallery'], 'exist', 'skipOnError' => true, 'targetClass' => Gallery::className(), 'targetAttribute' => ['gallery' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'title' => 'Заголовок',
            'in_row' => 'Количество картинок в строке',
            'gallery' => 'Подключаемая галерея',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function types() {
        return [
            'title' => 'textInput',
            'in_row' => 'textInput',
            'gallery' => 'select2Single',
        ];
    }

    /**
     * @return array
     */
    public function related() {
        return [
            'gallery' => [
                'class' => Gallery::className(),
                'from' => 'id',
                'to' =>  'title'
            ]
        ];
    }

}