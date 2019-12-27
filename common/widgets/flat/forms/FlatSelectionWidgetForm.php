<?php
namespace common\widgets\flat\forms;

use Yii;
use common\components\MyExtensions\WidgetModel;
use yii\base\InvalidConfigException;
use common\models\Section;

/**
 * Class FlatSelectionWidgetForm
 * @package common\widgets\flat\forms
 *
 * @inheritdoc
 */
class FlatSelectionWidgetForm extends WidgetModel
{
    const SELECTION = [
        '1rooms_2floor' => '1-а комнатные на 2-м этаже',
    ];

    public $title;
    public $corpus;
    public $selection;
    public $complex_id;

    /**
     * @inheritdoc
     */
    public function init() {
        $cookies = Yii::$app->request->cookies;

        if ($cookies->has('complex_id')) {
            $this->complex_id = $cookies->getValue('complex_id');
        } else {
            throw new InvalidConfigException('Complex must be set');
        }

        $this->dropDownData = [
            'selection' => static::SELECTION,
            'corpus' => Section::getCorpusesList($this->complex_id)
        ];

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['title', 'selection', 'corpus'], 'string', 'max' => 255],
            [['title', 'selection', 'corpus'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'title' => 'Заголовок',
            'corpus' => 'Корпус',
            'selection' => 'Подборка',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function types() {
        return [
            'title' => 'textInput',
            'corpus' => 'select2Single',
            'selection' => 'select2Single',
        ];
    }

    /**
     * @return array
     */
    public function related() {
        return [
            'selection' => [
                'static_source' => static::SELECTION,
            ],
            'corpus' => [
                'static_source' => Section::getCorpusesList($this->complex_id)
            ]
        ];
    }

}