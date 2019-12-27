<?php
namespace common\components\MyExtensions;

use Yii;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveField;

/**
 * Class MyActiveField
 * @package common\components\MyExtensions
 *
 * @inheritdoc
 */
class MyActiveField extends ActiveField
{
    public $template = "<div class='field__container'>{input}\n{error}</div>";

    public $inputOptions = [
        'tag' => false,
        'class' => '',
    ];

    public $errorOptions = [
        'tag' => 'span',
        'class' => 'field__error'
    ];

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();
        $this->options = ArrayHelper::merge($this->options, ['class' => 'field field__text']);
    }

    /**
     * @param array $options
     * @return $this
     */
    public function textInput($options = []) {
        if (empty($options['placeholder'])) {
            $options['placeholder'] = $this->model->getAttributeLabel($this->attribute);
        }
        return parent::textInput($options);
    }

    /**
     * @param array $options
     * @return $this
     */
    public function passwordInput($options = []) {
        if (empty($options['placeholder'])) {
            $options['placeholder'] = $this->model->getAttributeLabel($this->attribute);
        }
        return parent::passwordInput($options);
    }
}