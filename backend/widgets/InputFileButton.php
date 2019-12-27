<?php
namespace backend\widgets;

use yii\base\Model;
use yii\widgets\InputWidget;
use yii\helpers\Html;

/**
 * Class InputFileButton
 * @package backend\widgets
 */
class InputFileButton extends InputWidget
{
    /** @var Model */
    public $model;

    public $attribute = 'file';

    public $icon = '<i class="fa fa-folder-open"></i>';

    public $title = 'Открыть';

    public $showTitle = true;

    public $btnClass = 'btn btn-outline btn-xs btn-success fileinput-button';

    /**
     * @var array
     */
    public $options = ['accept' => 'image/*', 'class' => "hide"];

    /**
     * @inheritdoc
     */
    public function run() {
        $input = $this->hasModel()
            ? Html::activeFileInput($this->model, $this->attribute, $this->options)
            : Html::fileInput(Html::getInputName($this->model, $this->attribute), null, $this->options);

        return Html::tag('label', $this->icon . ' ' . Html::tag('span', $this->title) . $input, [
            'class' => $this->btnClass,
            'for' => Html::getInputId($this->model, $this->attribute),
        ]);
    }

}