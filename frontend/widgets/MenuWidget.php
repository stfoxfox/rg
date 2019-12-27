<?php
namespace frontend\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use common\models\Menu;
use common\models\MenuItem;

/**
 * Class MenuWidget
 * @package frontend\widgets
 */
class MenuWidget extends Widget
{
    /** @var array */
    static $locations = [
        Menu::TYPE_MAIN => 'main',
        Menu::TYPE_FOOTER => 'footer',
        Menu::TYPE_PAGE => 'page',
    ];

    /** @var Menu */
    public $model;

    /** @var string */
    public $pathView;

    /**
     * @inheritdoc
     */
    public function init() {
        if (!$this->model || !$this->model instanceof Menu) {
            throw new InvalidConfigException('The model must be set properly');
        }

        $this->pathView = static::$locations[$this->model->type];
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run() {
        $items = [];
        switch ($this->model->type) {

            case Menu::TYPE_MAIN:
            case Menu::TYPE_FOOTER:
                $items = $this->model->enabledMenuItemRoots;
                break;

            default:
                break;
        }

        return $this->render($this->pathView, ['items' => $items]);
    }

}