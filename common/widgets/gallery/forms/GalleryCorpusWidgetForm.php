<?php
namespace common\widgets\gallery\forms;

use Yii;
use common\components\MyExtensions\WidgetModel;
use common\models\Gallery;

/**
 * Class GalleryCorpusWidgetForm
 * @package common\widgets\gallery\forms
 *
 * @inheritdoc
 */
class GalleryCorpusWidgetForm extends WidgetModel
{
    public $title;
    public $gallery;

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
            [['gallery'], 'exist', 'skipOnError' => true, 'targetClass' => Gallery::className(), 'targetAttribute' => ['gallery' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'title' => 'Заголовок',
            'gallery' => 'Подключаемая галерея',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function types() {
        return [
            'title' => 'textInput',
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