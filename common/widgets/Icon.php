<?php
namespace common\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use common\widgets\assets\IconAsset;

/**
 * Class Icon
 * @package common\widgets
 */
class Icon extends Widget
{
    public $name = '';

    public $color = '';

    public $stroke = '';

    public $class;

    public $modalOptions = false;

    /**
     * @inheritdoc
     */
    public function run() {
        $this->registerClientScript();
        $path = $this->view->assetManager->getPublishedUrl('@common/widgets/assets/source/icon') . '/';

        $style = '';
        if(isset($this->color)) {
            $style .= "fill: {$this->color}; color: {$this->color}; ";
        }
        if(isset($this->stroke)) {
            $style .= "stroke: {$this->stroke};";
        }

        $class = ($this->class) ? ' ' . $this->class : '';

        $options = [
            'style' => $style,
            'class' => "pink-{$this->name}" . $class,
//            'width' => $this->width,
//            'height' => $this->height,
        ];
        if ($this->modalOptions && isset($this->modalOptions['target'])) {
            $options['data-toggle'] = 'modal';
            $options['data-target'] = $this->modalOptions['target'];
        }

        return Html::tag('svg', "<use xlink:href='{$path}icons.svg#pink-{$this->name}'></use>", $options);
    }

    /**
     * @param $name
     * @param null $class
     * @param null $color
     * @param null $stroke
     * @return mixed
     */
    public static function i($name, $class = null, $color = null, $stroke = null) {
        return (new static(['name' => $name, 'class' => $class, 'color' => $color, 'stroke' => $stroke]))->run();
    }

    /**
     * @inheritdoc
     */
    public function registerClientScript() {
        IconAsset::register($this->view);
    }
}