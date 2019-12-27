<?php
namespace frontend\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use common\models\SiteSettings;

/**
 * Class SocialsWidget
 * @package frontend\widgets
 */
class SocialsWidget extends Widget
{
    /** @var string */
    public $title = 'Свяжитесь с нами в&nbsp;любимом мессенджере:';

    /**
     * @inheritdoc
     */
    public function run() {
        return $this->render('socials', ['title' => $this->title]);
    }

}